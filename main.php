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

	public static function getVersion($base = false) { // base should be set on first release

		$dir = popen('/usr/bin/du -sk .', 'r');
		$size = $status = fgets($dir, 4096);
		$size = substr($size, 0, strpos($size, "\t"));
		$size = ($size - ($base ? $base : $status)) / 100;
		pclose($dir);

		return number_format($size, 2)
		     . ' (Build' . (int)$status . ')';
	}


	public static function updateReadme($data) {

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