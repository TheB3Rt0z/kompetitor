<?php require_once 'main.php';

setlocale(LC_TIME, 'ita', 'it_IT.utf8'); // only for dates
define('DEFAULT_LANGUAGE', "IT"); Main::addLog('..how about the language switcher? with german translation too', 'todo');
define('DATA_FILE', '.data');
define('USERS_FILE', '.users');

global $intl, $shorts, $shorts_refs, $links;
foreach ($yaml_parser->parse(file_get_contents('statics/strings.yml')) as $key => $langs) {
	foreach ($langs as $lang => $values) {
		if ($lang == DEFAULT_LANGUAGE) {
			$string = is_string($values) ? $values : $values['string'];
			$intl[$key] = $string ? $string : "[" . strtoupper(str_replace(" ", "_", $key)) . "]";
			if (!empty($values['short']) && isset($values['def'])) {
				if (empty($values['def'])) {
					$values['def'] = BOH;
					Main::addLog("definition for short '" . $values['short'] . "' not found", 'notice');
				}
				elseif (strpos($values['def'], BOH) !== false)
					Main::addLog("incomplete definition for short '" . $values['short'] . "'", 'warning');
				$shorts[$values['short']] = $values['def'];
				$shorts_refs[$values['short']] = $intl[$key];
				if (!empty($values['link'])) {
					$links[$values['short']] = $values['link'];
				}
			}
		}
	}
}
natcasesort($shorts_refs);

define('APPLICATION_NAME', "Kompetitor");
define('APPLICATION_TITLE', trnslt(APPLICATION_NAME) . " v" . Main::getVersion());
define('APPLICATION_COPYRIGHT', APPLICATION_TITLE . ", Copyright © " . date('Y') . " Bertozzi Matteo");
define('APPLICATION_BIBLIOGRAPHY', "- Andiamo a Correre (Fulvio Massini, 2012)" . "\\n"
		                         . "- La Perfezione del Corpo (Bruce & Linda Lee, 1998)" . "\\n"
		                         . "- Voglio Correre (Enrico Arcelli, 2014)");
define('APPLICATION_CREDITS', APPLICATION_COPYRIGHT . "\\n\\n" . ucfirst(trnslt('bibliography')) . ":\\n\\n" . APPLICATION_BIBLIOGRAPHY);

Main::updateReadme("# " . APPLICATION_TITLE);

$main = new Main;