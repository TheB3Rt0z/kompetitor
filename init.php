<?php require_once 'main.php';

define('DEFAULT_LANGUAGE', "IT");

global $intl, $shorts;
foreach ($yaml->parse(file_get_contents('strings.yml')) as $key => $langs) {
	foreach ($langs as $lang => $values) {
		if ($lang == DEFAULT_LANGUAGE) {
			$string = is_string($values) ? $values : $values['string'];
			$intl[$key] = $string ? $string : "[" . strtoupper($key) . "]";
			if (!empty($values['short']) && !empty($values['def'])) {
				$shorts[$values['short']] = $values['def'];
			}
		}
	}
}

define('APPLICATION_NAME', "Kompetitor");
define('APPLICATION_TITLE', trnslt(APPLICATION_NAME) . " v" . Main::getVersion());
define('APPLICATION_COPYRIGHT', APPLICATION_TITLE . " © " . date('Y') . " Bertozzi Matteo");
define('APPLICATION_BIBLIOGRAPHY', "Andiamo a Correre (Fulvio Massini, 2012)");
define('APPLICATION_CREDITS', APPLICATION_COPYRIGHT . "\n\n" . APPLICATION_BIBLIOGRAPHY);

Main::updateReadme("# " . APPLICATION_TITLE);