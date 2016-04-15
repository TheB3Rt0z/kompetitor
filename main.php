<?php ini_set('display_startup_errors', 1); ini_set('display_errors', 1); error_reporting(E_ALL);

require_once 'includes/symphony.yaml/Parser.php';
require_once 'includes/symphony.yaml/Unescaper.php';
require_once 'includes/symphony.yaml/Inline.php';
require_once 'includes/symphony.yaml/Yaml.php';
require_once 'includes/symphony.yaml/Exception/ExceptionInterface.php';
require_once 'includes/symphony.yaml/Exception/RuntimeException.php';
require_once 'includes/symphony.yaml/Exception/ParseException.php';
use Symfony\Component\Yaml\Parser; // https://symfony.com/doc/current/components/yaml/yaml_format.html
$yaml = new Parser(); // https://symfony.com/doc/current/components/yaml/index.html
// https://en.wikipedia.org/wiki/YAML


class Main {

	const LOG_DEBUG = 0,
	      LOG_NOTICE = 1,
	      LOG_WARNING = 2,
	      LOG_ERROR = 3;


	private static $logs = array();


	function __construct() {

		$this->post = $this->_retrieveData();

		$this->_process();

		$this->_updateData();
	}


	private function _process() {

		// age
		if ($this->post['personal_data']['date_of_birth']) {
			$date_of_birth = new DateTime(date('Y-m-d', strtotime($this->post['personal_data']['date_of_birth'])));
			$now = new DateTime(date('Y-m-d'));

			$interval = $date_of_birth->diff($now);

			$this->age['years'] = $_POST['processed_physiological_data']['age'] = $interval->y;
			$this->age['months'] = $interval->m;
			$this->age['days'] = $interval->d;
		}
		else
			$this->age['years'] = $this->age['months'] = $this->age['days'] = '???';

		$_POST['processed_physiological_data']['age'] = $this->age['years'];

		// mediated-weekly-weight
		$daily_weighing = array_filter($this->post['personal_data']['daily_weighing'], function(&$value) {
			return $value = str_replace(',', '.', $value);
		});
		if (!empty($daily_weighing))
			$this->mediated_weekly_weight = number_format(array_sum($daily_weighing) / count($daily_weighing), 3);
		else
			$this->mediated_weekly_weight = '???';

		$_POST['processed_physiological_data']['mediated_weekly_weight'] = $this->mediated_weekly_weight;
	}


	private function _retrieveData() {

		return !empty($_POST)
			   ? $_POST
		       : unserialize(base64_decode(file_get_contents('data.b64')));
	}


	private function _updateData() {

		file_put_contents('data.b64', base64_encode(serialize($_POST + (array)$this->post))); // to avoid errors on NULL
	}


	function getPost($fieldset, $field, $option = null) {

		return ($option
			   ? (!empty($_POST[$fieldset][$field][$option])
			     ? $_POST[$fieldset][$field][$option]
			     : (!empty($this->post[$fieldset][$field][$option])
			       ? $this->post[$fieldset][$field][$option]
			       : ''))
			   : (!empty($_POST[$fieldset][$field])
			     ? $_POST[$fieldset][$field]
			     : (!empty($this->post[$fieldset][$field])
			       ? $this->post[$fieldset][$field]
			       : '')));
	}


	static function getVersion($base = false) { // base should be set on first release

		$dir = popen('/usr/bin/du -sk .', 'r');
		$size = $status = fgets($dir, 4096);
		$size = substr($size, 0, strpos($size, "\t"));
		$size = ($size - ($base ? $base : $status)) / 100;
		pclose($dir);

		return number_format($size, 2)
		     . ' (Build' . (int)$status . ')'; // to be commented on release
	}


	static function addLog($message, $type = 'debug') {

		$codes = array(
			'debug' => self::LOG_DEBUG,
			'notice' => self::LOG_NOTICE,
			'warning' => self::LOG_WARNING,
			'error' => self::LOG_ERROR,
		);

		$code = $codes[$type];

		switch ($code) {
			case self::LOG_NOTICE:
			case self::LOG_WARNING:
			case self::LOG_ERROR: {
				$message = '<span class="log ' . $type . '">' . strtoupper($type) . ": " . $message . '';
				break;
			}
			default: {
				$message = strtoupper($type) . ": " . $message;
			}
		}

		self::$logs[$code][] = $message;
	}


	static function getLogs($list = array()) {

		krsort(self::$logs);

		foreach (self::$logs as $type => $logs)
			$list = array_merge($list, $logs);

		return $list;
	}


	static function hasLogs() {

		return count(self::$logs);
	}


	static function updateReadme($data) {

		file_put_contents('README.md', $data);
	}
}


function trnslt($string) {

	global $intl, $shorts, $links;

	if (isset($intl[$string]))
		$string = $intl[$string];

	foreach ($shorts as $short => $def) {
		if (isset($links[$short]))
			$string = str_replace($short, '<a href="' . $links[$short] . '" title="' . $def . '" target="_blank">' . $short . '</a>', $string);
		else
			$string = str_replace($short, '<span class="short" title="' . $def . '">' . $short . '</span>', $string);
	}

	return $string;
}


function button($type = null, $data = null) {

	switch ($type) {
		case 'close': {
			$label = false;
			break;
		}
		case 'credits': {
			$label = strtoupper(trnslt('information'));
			$href = "javascript:alert('" . $data . "');";
			break;
		}
		case 'print': {
			$label = strtoupper(trnslt($type));
			break;
		}
		case 'settings': {
			$label = strtoupper(trnslt($type));
			break;
		}
		default: {
			$type = 'nav';
			$label = false;
			break;
		}
	}

	if (isset($label))
		echo '<a class="button ' . $type . (!$label ? ' invisible-on-desktop' : '') . '" ' . (isset($href) ? 'href="' . $href . '"' : '') . '><span class="icon"></span> ' . $label . '</a>';
}


function submit() {

	echo '<span class="button"><input type="submit" value="&#9775;" title="' . strtoupper(trnslt("update")) . '" /></span>';
}