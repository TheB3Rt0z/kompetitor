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

	const LOG_INFO = -3,
	      LOG_IDEA = -2,
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
			$_post = null;

	private static $_logs = array();


	function __construct() {

		$this->_dbcl = new dbx\Client($this->_dbat, 'PHP-Example/1.0');

		$this->_post = $this->_retrieveData();
		if (!isset($_SESSION['post']))
			$_SESSION['post'] = $this->_post;

		$this->is_mobile = (!empty($this->_post['width']) && ($this->_post['width'] < 667));

		$this->_process();

		$this->_updateData();
	}


	private function _process() {

		if (!empty($this->_post['personal_data']['height']))
			$this->height = $this->_setPost(number_format((double)str_replace(',', '.', $this->_post['personal_data']['height']), 1),
					                        'personal_data', 'height');

		// age (not only years anyway)
		if (!empty($this->_post['personal_data']['date_of_birth'])) {
			$date_of_birth = new DateTime(date('Y-m-d', strtotime($this->_post['personal_data']['date_of_birth'])));
			$now = new DateTime(date('Y-m-d'));

			$interval = $date_of_birth->diff($now);

			$this->age['years'] = $this->_setPost($interval->y,
					                              'processed_physiological_data', 'age');
			$this->age['months'] = $interval->m;
			$this->age['days'] = $interval->d;
		}

		// mediated-weekly-weight
		if (!empty($this->_post['personal_data']['daily_weighing'])) {
			$daily_weighing = array_filter($this->_post['personal_data']['daily_weighing'], function(&$value) {
				return $value = $value ? number_format((double)str_replace(',', '.', $value), 1) : false;
			});
			$mediated_weekly_weight = array_sum($daily_weighing) / count($daily_weighing);
			$this->mediated_weekly_weight = $mediated_weekly_weight
			                                ? $this->_setPost(number_format($mediated_weekly_weight, 3),
						                                      'processed_physiological_data', 'mediated_weekly_weight')
			                                : BOH;
		}

		// bmi and ideal-weight (averaged) calculation
		if (!empty($this->height) && isset($this->mediated_weekly_weight)) {
			$bmi_quartelet = $this->mediated_weekly_weight / POW($this->height / 100, 2);
			$this->bmi = $bmi_quartelet
			             ? $this->_setPost(number_format($bmi_quartelet, 3),
					                       'processed_physiological_data', 'bmi')
		                 : BOH;

			if (isset($this->age['years'])) {
				$this->broca_ideal_weight = $this->height - 100;
				$this->lorentz_ideal_weight = $this->height - 100 + (($this->height - 150) / 100);
				$this->perrault_ideal_weight = $this->height - 100 - (($this->age['years'] - 20) / 4);
				$ideal_weight = ($this->broca_ideal_weight
						      + $this->lorentz_ideal_weight
						      + $this->perrault_ideal_weight) / 3;
				$this->ideal_weight = $this->_setPost(number_format($ideal_weight, 3),
						                              'processed_physiological_data', 'ideal_weight');
			}
		}

		// shoes sizes calculation (ATM adult male only)
		if (!empty($this->_post['personal_data']['foot_length'])) {
			$this->foot_length = $this->_setPost(number_format((float)str_replace(',', '.', $this->_post['personal_data']['foot_length']), 2),
					                             'personal_data', 'foot_length');
			$this->shoes_size['cm'] = $this->_setPost($this->foot_length + 1.5,
					                                  'processed_physiological_data', 'shoes_size', 'cm'); // foot to shoe modifier https://it.wikipedia.org/wiki/Misura_delle_scarpe#Tabelle_di_conversione
			$base_usa_cnd_uk = 3 * $this->shoes_size['cm'] * self::CM_TO_INCH;
			$base_usa_cnd_uk = floor($base_usa_cnd_uk * 2) / 2;
			$this->shoes_size['usa'] = $this->_setPost($base_usa_cnd_uk - 24,
					                                   'processed_physiological_data', 'shoes_size', 'usa');
			$this->shoes_size['uk'] = $this->_setPost($base_usa_cnd_uk - 25,
					                                  'processed_physiological_data', 'shoes_size', 'uk');
			$this->shoes_size['eu'] = $this->_setPost(round(($this->foot_length + 1.5) * self::CM_TO_FP, 1),
					                                  'processed_physiological_data', 'shoes_size', 'eu');
		}

		// providing distances and records calculations
		if (!empty($this->_post['distances_and_records'])) {
			foreach ($this->_post['distances_and_records'] as $key => $values) {
				$distance = $values['distance'];

				if (!empty($values['pb']) && ($values['pb'] != BOH)) {
					$pb = new DateTime(date('1970-01-01\TH:i:s+00:00', strtotime($values['pb'])));
					$step = round($pb->format('U') / $distance);
					$speed = $distance * 3600 / $pb->format('U');
					$this->_setPost(date('i:s', $step),
							        'distances_and_records', $key, 'step');
					$this->_setPost(number_format($speed, 3),
							        'distances_and_records', $key, 'speed');
				}

				if (!empty($values['last_pb']) && ($values['last_pb'] != BOH)) {
					$last_pb = new DateTime(date('1970-01-01\TH:i:s+00:00', strtotime($values['last_pb'])));
					$this->distances_and_records[$key] = $last_step = round($last_pb->format('U') / $distance);
					$last_speed = $distance * 3600 / $last_pb->format('U');
					$this->_setPost(date('i:s', $last_step),
							        'distances_and_records', $key, 'last_step');
					$this->_setPost(number_format($last_speed, 3),
							        'distances_and_records', $key, 'last_speed');
				}
			}
		}

		// reference speed calculation + some speed expectations
		if (!empty($this->distances_and_records['10km'])
				&& !empty($this->distances_and_records['1/3M'])
				&& !empty($this->distances_and_records['15km'])) {
			$rs = ($this->distances_and_records['10km']
			    + $this->distances_and_records['1/3M']
			    + $this->distances_and_records['15km']) / 3;
			$this->_setPost(date('i:s', round($rs)),
					        'processed_physiological_data', 'rs');

			$this->speed_expectations['10mi'] = $this->_setPost(date('i:s', round($rs + 1)),
					                                            'processed_physiological_data', 'speed_expectations', '10mi'); // 8-D
			$this->speed_expectations['hm'] = $this->_setPost(date('i:s', round($rs + 2.5)),
					                                          'processed_physiological_data', 'speed_expectations', 'hm'); // from Fulvio Massini
			$this->speed_expectations['m'] = $this->_setPost(date('i:s', round($rs * 1.075)),
					                                         'processed_physiological_data', 'speed_expectations', 'm'); // from corroergosum.it
			$this->speed_expectations['cm'] = $this->_setPost(date('i:s', round($rs * 1.125)),
					                                          'processed_physiological_data', 'speed_expectations', 'cm'); // from corroergosum.it
			$this->speed_expectations['cl'] = $this->_setPost(date('i:s', round($rs * 1.175)),
					                                          'processed_physiological_data', 'speed_expectations', 'cl'); // from corroergosum.it
			$this->speed_expectations['ll'] = $this->_setPost(date('i:s', round($rs * 1.225)),
					                                          'processed_physiological_data', 'speed_expectations', 'll'); // from corroergosum.it
		}

		// heart rates calculation
		if (isset($this->age['years'])) {
			$this->karvonen_cooper_fcmax = 220 - $this->age['years'];
			$this->tanaka_mohanan_seals_fcmax = 208 - 0.7 * $this->age['years'];
			$this->ballstate_university_fcmax = 214 - 0.8 * $this->age['years'];
			$this->real_fcmax = ($this->karvonen_cooper_fcmax
						      + $this->tanaka_mohanan_seals_fcmax
						      + $this->ballstate_university_fcmax) / 3;
			if (!empty($this->_post['personal_data']['fcmax']))
				$this->real_fcmax = ($this->real_fcmax + $this->_post['personal_data']['fcmax']) / 2;
			$this->_setPost(number_format($this->real_fcmax, 1),
					        'processed_physiological_data', 'fcmax');

			if (!empty($this->_post['personal_data']['fcmin'])) {
				$this->fcmin = $this->_post['personal_data']['fcmin'];
				$this->backup_fc = $this->real_fcmax - $this->_post['personal_data']['fcmin'];
				$this->training_fcmin = $this->fcmin + 0.6 * ($this->real_fcmax - $this->fcmin);
			}

			if (isset($this->backup_fc))
				$this->_setPost(number_format($this->backup_fc, 1),
						        'processed_physiological_data', 'backup_fc');
			if (isset($this->training_fcmin))
				$this->_setPost(number_format($this->training_fcmin, 1),
						        'processed_physiological_data', 'training_fcmin');

			$this->_setPost(number_format($this->real_fcmax * 0.625, 1),
					        'processed_physiological_data', 'aerobic_threshold');
			$this->_setPost(number_format($this->real_fcmax * 0.925, 1),
					        'processed_physiological_data', 'lactate_threshold');
		}
	}


	private function _retrieveData() {

		if (!file_exists(DATA_FILE) || empty($_SESSION['post'])) {
			$data = fopen(DATA_FILE, 'w+b');
			$this->_dbcl->getFile('/data', $data);
			fclose($data);

			Main::addLog("Profile data was loaded from Dropbox API", 'info');
		}

		$data = file_get_contents(DATA_FILE);

		return !empty($_POST)
			   ? $_POST
		       : unserialize(base64_decode($data));
	}


	private function _setPost($value, $fieldset, $field = null, $option = null) {

		if ($option)
			$this->_post[$fieldset][$field][$option] = $value;
		elseif ($field)
			$this->_post[$fieldset][$field] = $value;
	    else
	    	$this->_post[$fieldset] = $value;

		return $value;
	}


	private function _updateData() {

		$post = (array)$this->_post + $_POST; // casting necessary to avoid errors on NULL

		unset($post['width'], $post['exercises_for_the_arms']['exercises']); // excluding from synchronization

		if ($_SESSION['post'] != $post) {
			file_put_contents(DATA_FILE, base64_encode(serialize($post)));

			$data = fopen(DATA_FILE, 'rb'); // read only binary
			if (!empty($post)) { // not saving in dropbox if file was inexplicably truncated
				try {
					$response = $this->_dbcl->uploadFile('/data', dbx\WriteMode::update(null), $data);
					Main::addLog("Profile data was saved to Dropbox API", 'info');
				}
				catch (Exception $e) {
	                Main::addLog($e, 'warning');
				}
			}
			fclose($data);
		}
Main::addLog("Saved profile data should be packed (b64 and human-readable formats) and emailed to profile's (???) email..", 'todo');
		$_SESSION['post'] = $post;
	}


	function getPost($fieldset, $field = null, $option = null) { // this should be better written..

		return ($option
			   ? (!empty($_POST[$fieldset][$field][$option])
			     ? $_POST[$fieldset][$field][$option]
			     : (!empty($this->_post[$fieldset][$field][$option])
			       ? $this->_post[$fieldset][$field][$option]
			       : BOH))
			   : ($field
			   	 ? (!empty($_POST[$fieldset][$field])
			       ? $_POST[$fieldset][$field]
			       : (!empty($this->_post[$fieldset][$field])
			         ? $this->_post[$fieldset][$field]
			         : BOH))
			   	 : (!empty($_POST[$fieldset])
			   	   ? $_POST[$fieldset]
			       : (!empty($this->_post[$fieldset])
			         ? $this->_post[$fieldset]
			         : BOH))));
	}


	static function getVersion($base = false) { // base should be set on first release

		if (function_exists('popen')) {
			$dir = popen('/usr/bin/du -sk .', 'r');
			$size = $status = fgets($dir, 4096);
			$size = substr($size, 0, strpos($size, "\t"));
			$size = ($size - ($base ? $base : $status)) / 100;
			pclose($dir);

			return number_format($size, 2)
			     . ' (Build' . (int)$status . ')'; // to be commented on release
		}
		else
			return 'LIVE';
	}


	static function addLog($message, $type = 'debug') {

		$codes = array(
			'info' => self::LOG_INFO,
			'idea' => self::LOG_IDEA,
			'todo' => self::LOG_TODO,
			'debug' => self::LOG_DEBUG,
			'notice' => self::LOG_NOTICE,
			'warning' => self::LOG_WARNING,
			'error' => self::LOG_ERROR,
		);

		$code = $codes[$type];

		switch ($code) {
			case self::LOG_IDEA:
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
			default: { // ATM only debug
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


function submit($mobile_value = false) {

	return '<span class="button ' . ($mobile_value ? "mobile" : '') . '">'
		 . '<input type="submit" value="' . ($mobile_value ? strtoupper(trnslt($mobile_value)) : "&#9775;")
		 . '" title="' . strtoupper(trnslt($mobile_value ? $mobile_value : "update")) . '" />'
		 . '</span>';
}