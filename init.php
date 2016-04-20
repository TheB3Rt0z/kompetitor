<?php require_once 'main.php';

define('DEFAULT_LANGUAGE', "IT");

global $intl, $shorts, $links;
foreach ($yaml_parser->parse(file_get_contents('statics/strings.yml')) as $key => $langs) {
	foreach ($langs as $lang => $values) {
		if ($lang == DEFAULT_LANGUAGE) {
			$string = is_string($values) ? $values : $values['string'];
			$intl[$key] = $string ? $string : "[" . strtoupper($key) . "]";
			if (!empty($values['short']) && isset($values['def'])) {
				if (empty($values['def'])) {
					$values['def'] = '???';
					Main::addLog("definition for short '" . $values['short'] . "' not found", 'notice');
				}
				elseif (strpos($values['def'], '???') !== false)
					Main::addLog("incomplete definition for short '" . $values['short'] . "'", 'warning');
				$shorts[$values['short']] = $values['def'];
				if (!empty($values['link'])) {
					$links[$values['short']] = $values['link'];
				}
			}
		}
	}
}

define('APPLICATION_NAME', "Kompetitor");
define('APPLICATION_TITLE', trnslt(APPLICATION_NAME) . " v" . Main::getVersion());
define('APPLICATION_COPYRIGHT', APPLICATION_TITLE . " © " . date('Y') . " Bertozzi Matteo");
define('APPLICATION_BIBLIOGRAPHY', "- Andiamo a Correre (Fulvio Massini, 2012)" . "\\n"
		                         . "- Voglio Correre (Enrico Arcelli, 2014)");
define('APPLICATION_CREDITS', APPLICATION_COPYRIGHT . "\\n\\n" . ucfirst(trnslt('bibliography')) . "\\n" . APPLICATION_BIBLIOGRAPHY);

Main::updateReadme("# " . APPLICATION_TITLE);

$main = new Main;