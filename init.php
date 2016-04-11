<?php require_once 'main.php';

define('DEFAULT_LANGUAGE', "IT");

global $intl, $shorts;
foreach ($yaml->parse(file_get_contents('strings.yml')) as $key => $langs) {
	foreach ($langs as $lang => $values) {
		if ($lang == DEFAULT_LANGUAGE) {
			$intl[$key] = $values['string'];
			if (!empty($values['short']) && !empty($values['def'])) {
				$shorts[$values['short']] = $values['def'];
			}
		}
	}
}

define('APPLICATION_NAME', "Kompetitor");
define('APPLICATION_TITLE', trnslt(APPLICATION_NAME) . " v" . Main::getVersion());

Main::updateReadme("# " . APPLICATION_TITLE);