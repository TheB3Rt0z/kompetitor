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
	
	static $defaults = array(
		'postrun_stretching' => array(
			'grade' => 11,
		),
		'exercises_for_the_arms' => array(
			'grade' => 25,
	    ),
		'daily_diet_proposal' => array(
			'grade' => 20, // should be bound with BMR extimations..
		),
	);

	private $_dbat = 'pjv6hedPbCEAAAAAAAARWxUKv1D1fZf2HxPeyzI7Ca4P-eZI3p1nCmuqbo1tORJN', // dropbox access token
			$_dbcl = null,
			$_post = null;

	private static $_logs = array();


	function __construct() {

		$this->is_mobile = (!empty($_POST['width']) && ($_POST['width'] <= 667));

		if (!$this->isLogged())
			$this->_checkLogin();

		if (isset($_GET['q']) && $_GET['q'] == 'logout')
			unset($_SESSION['status'], $_SESSION['username'], $_SESSION['id']);

		if ($this->isLogged()) {
			$this->_dbcl = new dbx\Client($this->_dbat, 'PHP-Example/1.0');

			$this->_post = $this->_retrieveData();
			if (!isset($_SESSION['post']))
				$_SESSION['post'] = $this->_post;

			$this->_process();

			$this->_updateData();
		}
	}


	private function _checkLogin() {

		if (!empty($_POST['username']) && !empty($_POST['password'])) {
			$username = htmlspecialchars(stripslashes(trim($_POST['username'])));
			$password = md5(htmlspecialchars(stripslashes(trim($_POST['password']))));
			foreach (file(USERS_FILE) as $user) {
				$user_array = explode("|", $user);
				if (($user_array[1] == $username) && (trim($user_array[2]) == $password)) {
					$_SESSION['status'] = $user_array[0];
					$_SESSION['username'] = ucfirst($username);
					$_SESSION['id'] = md5($user);
				}
			}
		}
	}
	
	
	private function _processHeight() {
		
		if ($this->_post['personal_data']['height'] != BOH)
			return $this->_setPost(number_format(str_replace(',', '.', $this->_post['personal_data']['height']), 1),
					               'personal_data', 'height');
	}
	
	
	private function _processAge($single = null) { // days, months or years allowed
		
		if ($this->_post['personal_data']['date_of_birth'] != BOH) {
			$date_of_birth = new DateTime(date('Y-m-d', strtotime($this->_post['personal_data']['date_of_birth'])));
			$now = new DateTime(date('Y-m-d'));
			$interval = $date_of_birth->diff($now);
			$age = array(
				'days' => $interval->d,
				'months' => $interval->m,
				'years' => $interval->y,
			);
			
			if ($single)
				return $this->_setPost($age[$single],
					                   'processed_physiological_data', 'age', $single);
			return $this->_setPost($age['years'] . 'y' . $age['months'] . 'm' . $age['days'] . 'd',
					               'processed_physiological_data', 'age');
		}
	}
	
	
	private function _processWeight() {
		
		if (!empty($this->_post['personal_data']['daily_weighing'])) {
			$daily_weighing = array_filter($this->_post['personal_data']['daily_weighing'], function(&$value) {
				return $value != BOH
				       ? $value = number_format(str_replace(',', '.', $value), 1)
				       : false;
			});
			
			if (!empty($daily_weighing)) { // if at least one element is available
				if ($mediated_weekly_weight = array_sum($daily_weighing) / count($daily_weighing))
					return $this->_setPost(number_format($mediated_weekly_weight, 3),
						                   'processed_physiological_data', 'mediated_weekly_weight');
			}
		}
	}
	

	private function _process() { // internal variables returning null if processing was not successful

		$this->height = $this->_processHeight();
		$this->age['years'] = $this->_processAge('years');
		$this->mediated_weekly_weight = $this->_processWeight();
		
		// metabolism calculation
		if (!empty($this->age['years']) && !empty($this->mediated_weekly_weight)) { // only male coefficients
			if ($this->age['years'] >= 18 && $this->age['years'] <= 29)
				$bm = 15.3 * $this->mediated_weekly_weight + 679;
			elseif ($this->age['years'] >= 30 && $this->age['years'] <= 59)
				$bm = 11.6 * $this->mediated_weekly_weight + 879;
			elseif ($this->age['years'] >= 60 && $this->age['years'] <= 74)
				$bm = 11.9 * $this->mediated_weekly_weight + 700;
			elseif ($this->age['years'] >= 75)
				$bm = 8.4 * $this->mediated_weekly_weight + 819;
			
			$this->bm = $this->_setPost(!empty($bm)
										? round($bm)
										: BOH,
										'processed_physiological_data', 'bm');
			$this->cn = $this->_setPost(!empty($bm)
				                        ? round($bm * 1.74) // average activity for male between 18 and 59
				                        : BOH,
							            'processed_physiological_data', 'cn');
			
			if (!empty($this->height)) { // BMR calculation with Harris-Benedict's equation
				$bmr = (66.5 + 13.75 * $this->mediated_weekly_weight
				             + 5.003 * $this->height
				             - 6.775 * $this->age['years']) * 1.3; // average activity (1.2-1.4)
				$this->bmr = $this->_setPost(round($bmr), 'processed_physiological_data', 'bmr');
				
				/*$bmr = (9.99 * $this->mediated_weekly_weight // with Mifflin-St. Jeor equation
				     + 6.25 * $this->height
					 - 4.92 * $this->age['years']) * 1.3; // average activity (1.2-1.4)
				$this->bmr = $this->_setPost(round($bmr), 'processed_physiological_data', 'bmr');*/
			}

		}
			
		// bmi and ideal-weight (averaged) calculation
		if (!empty($this->height) && $this->height > 0 && isset($this->mediated_weekly_weight)) {
			$bmi_quartelet = $this->mediated_weekly_weight / POW($this->height / 100, 2);
			$this->bmi = $this->_setPost($bmi_quartelet
					                     ? number_format($bmi_quartelet, 3)
					                     : BOH,
					                     'processed_physiological_data', 'bmi');

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
		if (!empty($this->_post['personal_data']['foot_length']) && $this->_post['personal_data']['foot_length'] > 0) {
			$this->foot_length = $this->_setPost(number_format(str_replace(',', '.', $this->_post['personal_data']['foot_length']), 2),
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
		else
			$this->foot_length = $this->_setPost(BOH, 'personal_data', 'foot_length');

		// providing distances and records calculations
		if (!empty($this->_post['distances_and_records'])) {
			foreach ($this->_post['distances_and_records'] as $key => $values) {
				$distance = $values['distance'];

				if (!empty($values['pb']) && ($values['pb'] != BOH)) {
					$pb = new DateTime(date('1970-01-01\TH:i:s+00:00', strtotime($values['pb'])));
					$step = round($pb->format('U') / $distance);
					$speed = $distance * 3600 / $pb->format('U');
					$this->_setPost(ltrim(date('i:s', $step), "0"),
							        'distances_and_records', $key, 'step');
					$this->_setPost(number_format($speed, 3),
							        'distances_and_records', $key, 'speed');
				}

				if (!empty($values['last_pb']) && ($values['last_pb'] != BOH)) {
					$last_pb = new DateTime(date('1970-01-01\TH:i:s+00:00', strtotime($values['last_pb'])));
					$this->distances_and_records[$key] = $last_step = round($last_pb->format('U') / $distance);
					$last_speed = $distance * 3600 / $last_pb->format('U');
					$this->_setPost(ltrim(date('i:s', $last_step), "0"),
							        'distances_and_records', $key, 'last_step');
					$this->_setPost(number_format($last_speed, 3),
							        'distances_and_records', $key, 'last_speed');
				}
			}
		}

		// reference speed calculation + some speed expectations
		if (!empty($this->distances_and_records['10km'])
				&& !empty($this->distances_and_records['10++'])
				&& !empty($this->distances_and_records['1/3M'])
				&& !empty($this->distances_and_records['15km'])) {
			$rs = ($this->distances_and_records['10km']
				+ $this->distances_and_records['10++']
			    + $this->distances_and_records['1/3M']
			    + $this->distances_and_records['15km']) / 4;
			$this->_setPost(date('i:s', round($rs)),
					        'processed_physiological_data', 'rs');

			$this->speed_expectations['5km'] = $this->_setPost(ltrim(date('i:s', round($rs - 11)), "0"),
					                                           'processed_physiological_data', 'speed_expectations', '5km'); // based on personals
			$this->speed_expectations['7,5km'] = $this->_setPost(ltrim(date('i:s', round($rs - 6)), "0"),
					                                             'processed_physiological_data', 'speed_expectations', '7,5km'); // based on personals
			$this->speed_expectations['10km'] = $this->_setPost(ltrim(date('i:s', round($rs - 2)), "0"),
					                                           'processed_physiological_data', 'speed_expectations', '10km'); // based on personals
			$this->speed_expectations['10mi'] = $this->_setPost(ltrim(date('i:s', round($rs + 1)), "0"),
					                                            'processed_physiological_data', 'speed_expectations', '10mi'); // 8-D
			$this->speed_expectations['HM'] = $this->_setPost(ltrim(date('i:s', round($rs + 2.5)), "0"),
					                                          'processed_physiological_data', 'speed_expectations', 'hm'); // from Fulvio Massini
			$this->speed_expectations['M'] = $this->_setPost(ltrim(date('i:s', round($rs * 1.075)), "0"),
					                                         'processed_physiological_data', 'speed_expectations', 'm'); // from corroergosum.it
			$this->speed_expectations['CM'] = $this->_setPost(ltrim(date('i:s', round($rs * 1.125)), "0"),
					                                          'processed_physiological_data', 'speed_expectations', 'cm'); // from corroergosum.it
			$this->speed_expectations['CL'] = $this->_setPost(ltrim(date('i:s', round($rs * 1.175)), "0"),
					                                          'processed_physiological_data', 'speed_expectations', 'cl'); // from corroergosum.it
			$this->speed_expectations['LL'] = $this->_setPost(ltrim(date('i:s', round($rs * 1.225)), "0"),
					                                          'processed_physiological_data', 'speed_expectations', 'll'); // from corroergosum.it
		}

		// fingerprint generation
		if (!empty($this->_post['distances_and_records'])) {
			foreach ($this->_post['distances_and_records'] as $key => $values) {
				$last_step = strtotime("00:" . $this->getPost('distances_and_records', $key, 'last_step'));
				$step = strtotime("00:" . $this->getPost('distances_and_records', $key, 'step'));
				$middler = isset($this->speed_expectations[$key])
				           ? $this->speed_expectations[$key]
				           : ((($this->getPost('distances_and_records', $key, 'last_step') == BOH)
				                 || ($this->getPost('distances_and_records', $key, 'step') == BOH))
				             ? BOH
				             : ltrim(date('i:s', $step + ($last_step - $step) / 2), "0"));
				$fingerprint = $this->getPost('distances_and_records', $key, 'last_step')
				             . "|" . $middler . "|"
				             . $this->getPost('distances_and_records', $key, 'step');
				$this->_setPost($fingerprint,
						        'distances_and_records', $key, 'fingerprint');
			}
		}

		// heart rates calculation
		if ($this->age['years'] > 0) {
			$this->karvonen_cooper_fcmax = 220 - $this->age['years'];
			$this->tanaka_mohanan_seals_fcmax = 208 - 0.7 * $this->age['years'];
			$this->ballstate_university_fcmax = 214 - 0.8 * $this->age['years'];
			$this->real_fcmax = ($this->karvonen_cooper_fcmax
						      + $this->tanaka_mohanan_seals_fcmax
						      + $this->ballstate_university_fcmax) / 3;
			if ($this->_post['personal_data']['fcmax'] != BOH) {
				$this->real_fcmax = !empty($this->_post['personal_data']['fcmax_override'])
						            ? $this->_post['personal_data']['fcmax']
						            : ($this->real_fcmax + $this->_post['personal_data']['fcmax']) / 2;
			}
			$this->_setPost(number_format($this->real_fcmax, 1),
					        'processed_physiological_data', 'fcmax');

			if ($this->_post['personal_data']['fcmin'] != BOH) {
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

		// bertoz calculator procedures
		if (($_SESSION['status'] <= 1)
				&& (!empty($this->_post['bertoz_calculator']['time']) && $this->_post['bertoz_calculator']['time'] != BOH)
				&& (!empty($this->_post['bertoz_calculator']['distance']) && $this->_post['bertoz_calculator']['distance'] != BOH)) {
			$time = new DateTime(date('1970-01-01\TH:i:s+00:00', strtotime($this->_post['bertoz_calculator']['time'])));
			$distance = $_POST['bertoz_calculator']['distance'] = $this->_setPost(str_replace(',', '.', $this->_post['bertoz_calculator']['distance']),
					                                                              'bertoz_calculator', 'distance');
			$speed = round($time->format('U') / $distance);
			$this->bertoz_calculator['speed'] = $this->_setPost(date('i:s', $speed),
					                                            'bertoz_calculator', 'speed');
		}

		// riegel calculator procedures
		if (($_SESSION['status'] <= 1)
				&& ((!empty($this->_post['riegel_calculator']['distance']) && $this->_post['riegel_calculator']['distance'] != BOH)
				&& (!empty($this->_post['riegel_calculator']['time']) && $this->_post['riegel_calculator']['time'] != BOH))
				|| !empty($this->_post['riegel_calculator']['performance_override'])) {

			if (!empty($this->_post['riegel_calculator']['performance_override'])) {
				$base_distance = 10;
				$time = new DateTime(date('1970-01-01\TH:i:s+0:00', strtotime($this->getPost('distances_and_records', '10km', 'last_pb'))));
			}
			else
				$time = new DateTime(date('1970-01-01\TH:i:s+0:00', strtotime($this->_post['riegel_calculator']['time'])));

			$speed = round($time->format('U') / (isset($base_distance) ? $base_distance : $this->_post['riegel_calculator']['distance']));
			$this->riegel_calculator['speed'] = $this->_setPost(date('i:s', $speed),
					                                            'riegel_calculator', 'speed');
			
			foreach ($this->_post['riegel_calculator']['distances'] as $key => $distance) {

				$forecast = round($time->format('U') * pow($distance / (isset($base_distance) ? $base_distance : $this->_post['riegel_calculator']['distance']), 1.06)) - 3600;

				$this->_setPost(ltrim(date('H:i:s', $forecast), "0:"),
						        'riegel_calculator', 'forecasts', $key);
				
				$speed_time = new DateTime(date('1970-01-01\TH:i:s+0:00', $forecast));
				$this->_setPost(ltrim(date('i:s', ($speed_time->format('U') / $distance)), "0"),
						        'riegel_calculator', 'forespeed', $key);
			}
		}
	}


	private function _retrieveData() {

		if (!file_exists(DATA_FILE . "-" . $_SESSION['id'])) {
			$data = fopen(DATA_FILE . "-" . $_SESSION['id'], 'w+b');
			try {
				$response = $this->_dbcl->getFile('/data-' . $_SESSION['id'], $data);
				Main::addLog("Profile data was loaded from Dropbox API", 'info');
			}
			catch (Exception $e) {
				Main::addLog($e, 'warning');
			}
			fclose($data);
		}

		$data = file_get_contents(DATA_FILE . "-" . $_SESSION['id']);

		array_walk_recursive($_POST, function(&$value) { // assurance from input empty values
			if (empty($value))
				$value = BOH;
		});

		return !empty($_POST['personal_data'])
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

		unset($post['width'], $post['v-pos'], $post['exercises_for_the_arms']['exercises']); // excluding from synchronization

		if ($_SESSION['post'] != $post) {
			file_put_contents(DATA_FILE . "-" . $_SESSION['id'], base64_encode(serialize($post)));

			$data = fopen(DATA_FILE . "-" . $_SESSION['id'], 'rb'); // read only binary
			if (!empty($post)) { // not saving in dropbox if file was inexplicably truncated
				try {
					$response = $this->_dbcl->uploadFile('/data-' . $_SESSION['id'], dbx\WriteMode::update(null), $data);
					Main::addLog("Profile data was saved to Dropbox API", 'info');
				}
				catch (Exception $e) {
	                Main::addLog($e, 'warning');
				}
			}
			fclose($data);
		}

		$_SESSION['post'] = $post;
	}


	function isLogged() {

		return (isset($_SESSION['status'])
			    && !empty($_SESSION['username'])
		        && !empty($_SESSION['id']));
	}


	function getPost($fieldset = null, $field = null, $option = null) {

		return ($option
			   ? (!empty($_POST[$fieldset][$field][$option])
			     ? $_POST[$fieldset][$field][$option]
			     : (!empty($this->_post[$fieldset][$field][$option])
			       ? $this->_post[$fieldset][$field][$option]
			       : (isset(self::$defaults[$fieldset][$field][$option])
			       	 ? self::$defaults[$fieldset][$field][$option]
			       	 : BOH)))
			   : ($field
			   	 ? (!empty($_POST[$fieldset][$field])
			       ? $_POST[$fieldset][$field]
			       : (!empty($this->_post[$fieldset][$field])
			         ? $this->_post[$fieldset][$field]
			         : (isset(self::$defaults[$fieldset][$field])
			       	   ? self::$defaults[$fieldset][$field]
			       	   : BOH)))
			   	 : (!empty($_POST[$fieldset])
			   	   ? $_POST[$fieldset]
			       : (!empty($this->_post[$fieldset])
			         ? $this->_post[$fieldset]
			         : (isset(self::$defaults[$fieldset])
			       	   ? self::$defaults[$fieldset]
			       	   : BOH)))));
	}
	
	
	function renderBlock($width, $class, $title = null) {
		
		$switcher = $this->getPost('blocks', $class) == BOH ? '' : 'closed';
		
		?>
		<div class="content width-<?=$width?> icon <?=$class?> <?=$switcher?>">
			<input type="hidden" name="blocks[<?=$class?>]" value="<?=$this->getPost('blocks', $class)?>" />
			<?php
			if ($title) {
				?>
				<span class="icon"></span>
				<div class="header">
					<?=$title?>
					<span>&#8679;</span>
				</div>
				<br />
				<br />
				<?php
			}
			?>
			<div class="body">
				<br />
				<?php
				switch ($class) {
					case 'personal-data': {
						include 'tables/personal-data.php';
						echo '<br />';
						include 'tables/daily-weighing.php';
						echo '<br />';
						include 'tables/distances-records.php';
						break;
					}
					case 'processed-physiological-data': {
						include 'tables/physiological-data.php';
						break;
					}
					case 'running-trainings': {
						echo '01.07.2016 | 76,3 kg | 22.2° | 14 kph | 61% | 162/178 bpm | 7,36 km | 33:27 | 4:33 | 551 kcal | 14 m Δ';
						break;	
					}
					//case 'stretching exercises': {
					//case 'core exercises': {
					case 'post-run exercises': {
						include 'tables/postrun-stretching.php';
						break;
					}
					//case 'ton-stab exercises': {
					case 'morning exercises': {
						include 'tables/morning-serie.php';
						break;
					}
					case 'arms-exercises': {
						include 'tables/arms-2x5kg.php';
						break;
					}
					case 'bertoz-calculator': {
						include 'tables/bertoz-calculator.php';
						break;
					}
					case 'riegel-calculator': {
						include 'tables/riegel-calculator.php';
						break;
					}
					case 'foods-table': {
						include 'tables/foods-table.php';
						break;
					}
					case 'bibliography': {
						echo str_replace('\n', '<br />', APPLICATION_BIBLIOGRAPHY);
						break;
					}
					case 'definitions-list': {
						include 'tables/definitions-list.php';
						break;	
					}
					default: echo '(!) IN-PROGRESS';
				}
				?>
			</div>
		</div>
		<?php
	}


	static function getVersion($base = 6666) { // base should be set on first release

		if (function_exists('popen')) {
			$dir = popen('/usr/bin/du -sk .', 'r');
			$size = $status = fgets($dir, 4096);
			$size = substr($size, 0, strpos($size, "\t"));
			$size = ($size - ($base ? $base : $status)) / 1024; // 100
			pclose($dir);

			return number_format($size, 2)
			     . ($size < 0 ? ' (Build' . (int)$status . ')' : ''); // to be commented on release
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
	
	
	static function addIdea($message) {
		
		self::addLog($message, 'idea');
	}
	
	
	static function addTodo($message) {
	
		self::addLog($message, 'todo');
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

		if (in_array($_SERVER['REMOTE_ADDR'],  array('127.0.0.1', '::1'))
				&& in_array($_SERVER['SERVER_ADDR'], array('127.0.0.1', '::1')))
			file_put_contents('README.md', $data);
	}
}

Main::addIdea("add a translations 'extractor' for google translate");
function trnslt($string, $uses_shorts = true) {

	global $intl, $shorts, $links;

	if (isset($intl[$string]))
		$string = $intl[$string];

	if ($uses_shorts) {
		foreach ($shorts as $short => $def) {
			if (isset($links[$short]))
				$string = str_replace($short, '<a href="' . $links[$short] . '" title="' . $def . '" target="_blank">' . $short . '</a>', $string);
			else
				$string = str_replace($short, '<span class="short" title="' . $def . '">' . $short . '</span>', $string);
		}
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
			$href = "Javascript:alert('" . $data . "');";
			break;
		}
		case 'logout'; {
			$label = strtoupper(trnslt($type));
			$href = "./?q=logout";
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


function dump() {
	
	echo '<pre>';
	
	foreach (func_get_args() as $arg) {
		var_dump($arg);
		echo '<br />';
	}
		
	echo '</pre>';
}