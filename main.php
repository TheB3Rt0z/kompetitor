<?php session_start(); define('BOH', "???");

ini_set('display_startup_errors', 1); ini_set('display_errors', 1); error_reporting(E_ALL);

require_once 'includes/symphony.yaml/Parser.php';
require_once 'includes/symphony.yaml/Unescaper.php';
require_once 'includes/symphony.yaml/Inline.php';
require_once 'includes/symphony.yaml/Yaml.php';
require_once 'includes/symphony.yaml/Exception/ExceptionInterface.php';
require_once 'includes/symphony.yaml/Exception/RuntimeException.php';
require_once 'includes/symphony.yaml/Exception/ParseException.php';
use Symfony\Component\Yaml as yaml; // https://symfony.com/doc/current/components/yaml/yaml_format.html, https://en.wikipedia.org/wiki/YAML
$yaml_parser = new yaml\Parser; // https://symfony.com/doc/current/components/yaml/index.html

require_once "includes/dropbox.php/autoload.php"; // https://www.dropbox.com/developers-v1/core/sdks/php
use Dropbox as dbx;


class Main {

	const LOG_INFO = -2,
		  LOG_TODO = -1,
	      LOG_DEBUG = 0,
	      LOG_NOTICE = 1,
	      LOG_WARNING = 2,
	      LOG_ERROR = 3;

	const INCH_TO_CM = 2.54,
	      CM_TO_INCH = .3937,
	      FP_TO_CM = .666,
	      CM_TO_FP = 1.5;

	private $_dbat = 'pjv6hedPbCEAAAAAAAARWxUKv1D1fZf2HxPeyzI7Ca4P-eZI3p1nCmuqbo1tORJN', // dropbox access token
			$_dbcl = null,
			$_data = null;

	private static $_logs = array();


	function __construct() {

		$this->_dbcl = new dbx\Client($this->_dbat, 'PHP-Example/1.0');

		$this->post = $this->_retrieveData();
		if (!isset($_SESSION['post']))
			$_SESSION['post'] = $this->post;

		$this->is_mobile = (!empty($this->post['width']) && ($this->post['width'] < 667));

		$this->_process();

		$this->_updateData();
	}


	private function _process() {

		if (!empty($_POST['personal_data']['height']))
			$_POST['personal_data']['height'] = $this->height = number_format((double)str_replace(',', '.', $this->post['personal_data']['height']), 1);

		// age (not only years anyway)
		if (!empty($this->post['personal_data']['date_of_birth'])) {
			$date_of_birth = new DateTime(date('Y-m-d', strtotime($this->post['personal_data']['date_of_birth'])));
			$now = new DateTime(date('Y-m-d'));

			$interval = $date_of_birth->diff($now);

			$this->age['years'] = $interval->y;
			$this->age['months'] = $interval->m;
			$this->age['days'] = $interval->d;
		}
		else
			$this->age['years'] = $this->age['months'] = $this->age['days'] = BOH;

		$this->post['processed_physiological_data']['age'] = $this->age['years'];

		// mediated-weekly-weight
		$this->mediated_weekly_weight = BOH;
		if (!empty($this->post['personal_data']['daily_weighing'])) {
			if ($daily_weighing = array_filter($this->post['personal_data']['daily_weighing'], function(&$value) {
				return $value = $value ? number_format((double)str_replace(',', '.', $value), 1) : false;
			}))
				$this->mediated_weekly_weight = number_format(array_sum($daily_weighing) / count($daily_weighing), 3);
		}

		$this->post['processed_physiological_data']['mediated_weekly_weight'] = $this->mediated_weekly_weight;

		// bmi and ideal-weight (averaged) calculation
		if (!empty($this->height) && $this->mediated_weekly_weight != BOH) {
			$bmi_quartelet = $this->mediated_weekly_weight / POW($this->height / 100, 2);
			$this->post['processed_physiological_data']['bmi'] = number_format($bmi_quartelet, 3);
		}
		else
			$this->post['processed_physiological_data']['bmi'] = BOH;
		Main::addLog("average ideal weight calculation and correspondent elaborated fields should be added", 'todo');

		// shoes sizes calculation (ATM adult male only)
		if (!empty($this->post['personal_data']['foot_length'])) {
			$foot_length = $this->post['personal_data']['foot_length'] = number_format((double)str_replace(',', '.', $this->post['personal_data']['foot_length']), 1);
			$base_usa_cnd_uk = 3 * $foot_length * self::CM_TO_INCH;
			$base_usa_cnd_uk = floor($base_usa_cnd_uk * 2) / 2;
			$this->post['processed_physiological_data']['shoes_size']['usa'] = $this->shoes_size['usa'] = $base_usa_cnd_uk - 24;
			$this->post['processed_physiological_data']['shoes_size']['uk'] = $this->shoes_size['uk'] = $base_usa_cnd_uk - 25;
			$this->post['processed_physiological_data']['shoes_size']['eu'] = $this->shoes_size['eu'] = round(($foot_length + 1.5) * self::CM_TO_FP, 1);
		}
		else {
			$this->post['processed_physiological_data']['shoes_size']['usa'] = BOH;
			$this->post['processed_physiological_data']['shoes_size']['uk'] = BOH;
			$this->post['processed_physiological_data']['shoes_size']['eu'] = BOH;
		}
	}


	private function _retrieveData() {

		if (!isset($_SESSION['post'])) {
			$data = fopen(DATA_FILE, 'w+b');
			$this->_data = $this->_dbcl->getFile('/data', $data);
			fclose($data);

			Main::addLog("Profile data was loaded from Dropbox API", 'info');
		}

		if (!file_exists(DATA_FILE))
			fopen(DATA_FILE, 'w+b');
		$data = file_get_contents(DATA_FILE);

		return !empty($_POST)
			   ? $_POST
		       : unserialize(base64_decode($data));
	}


	private function _updateData() {

		$post = (array)$this->post + $_POST; // casting necessary to avoid errors on NULL

		unset($post['width'], $post['exercises_for_the_arms']); // excluding from synchronization

		if ($post != $_SESSION['post']) {
			file_put_contents(DATA_FILE, base64_encode(serialize($post)));

			$data = fopen(DATA_FILE, 'rb'); // read only binary
			if (!empty($post)) // not saving in dropbox if file was inexplicably truncated
				$response = $this->_dbcl->uploadFile('/data', dbx\WriteMode::update($this->_data['rev']), $data);
			fclose($data);

			Main::addLog("Profile data was saved to Dropbox API", 'info');

			$_SESSION['post'] = $post;
		}
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
			'info' => self::LOG_INFO,
			'todo' => self::LOG_TODO,
			'debug' => self::LOG_DEBUG,
			'notice' => self::LOG_NOTICE,
			'warning' => self::LOG_WARNING,
			'error' => self::LOG_ERROR,
		);

		$code = $codes[$type];

		switch ($code) {
			case self::LOG_TODO:
			case self::LOG_NOTICE:
			case self::LOG_WARNING:
			case self::LOG_ERROR: {
				$message = '<span class="log ' . $type . '">' . strtoupper($type) . ': ' . $message . '</span>';
				break;
			}
			case self::LOG_INFO: {
				$message = '<span class="log">' . $message . '</span>';
				break;
			}
			default: {
				$message = strtoupper($type) . ": " . $message;
			}
		}

		self::$_logs[$code][] = $message;
	}


	static function getLogs($list = array()) {

		krsort(self::$_logs);

		foreach (self::$_logs as $type => $logs)
			$list = array_merge($list, $logs);

		return $list;
	}


	static function hasLogs() {

		return count(self::$_logs);
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