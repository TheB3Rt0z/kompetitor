<?php require_once 'main.php';

define('APPLICATION_NAME', "Kompetitor");
define('APPLICATION_TITLE', trnslt(APPLICATION_NAME) . " v" . Main::getVersion());

Main::updateReadme("# " . APPLICATION_TITLE);