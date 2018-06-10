<?php require_once 'main.php';

setlocale(LC_TIME, 'ita', 'it_IT.utf8'); // only for dates

define('DEFAULT_LANGUAGE', "IT"); Main::addTodo('check if it is really possibile to change language, and to save its setting..');
define('DATA_FILE', '.data');
define('USERS_FILE', '.users');

define('BERTOZ_COEFFICIENT', 1.07654321); // kommt die Polizei

$main = new Main;

$current_language = $main->getPost('settings', 'language');

if (($current_language == BOH) && isset($_SESSION['language']))
    $current_language = $_SESSION['language'];

define('CURRENT_LANGUAGE', $current_language != BOH
                           ? $current_language
                           : DEFAULT_LANGUAGE);

global $intl, $shorts, $shorts_refs, $links; // translation engine
$shorts = $shorts_refs = array();
$keys = $yaml_parser->parse(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/statics/strings.yml'));

if (Main::getVersion() != 'LIVE')
    $language = fopen(CURRENT_LANGUAGE. '.txt', 'w+b');

foreach ($keys as $key => $langs) {

    if (!empty($langs)) {

        foreach ($langs as $lang => $values) {

            if (isset($languages[$lang]))
                $languages[$lang]++;
            else
                $languages[$lang] = 1;

            $string = is_string($values) ? $values : $values['string'];

            if ($lang == CURRENT_LANGUAGE) {

                $intl[$key] = $string ? $string : "[" . strtoupper(str_replace(" ", "_", $key)) . "]";

                if (empty($string)) {
                    Main::addNotice("translation for '" . $key . "' not found");
                    $languages[$lang]--;
                    if (Main::getVersion() != 'LIVE')
                        fwrite($language, $key . "\n");
                }

                if (!empty($values['short']) && isset($values['def'])) {

                    if (empty($values['def'])) {
                        $values['def'] = BOH;
                        Main::addNotice("definition for short '" . $values['short'] . "' not found");
                    }

                    elseif (strpos($values['def'], BOH) !== false)
                        Main::addLog("incomplete definition for short '" . $values['short'] . "'", 'warning');

                    $shorts[$values['short']] = $values['def'];
                    $shorts_refs[$values['short']] = $intl[$key];

                    if (!empty($values['link']))
                        $links[$values['short']] = $values['link'];
                }
            }
            elseif (empty($string)) {
                $languages[$lang]--;
                if (Main::getVersion() != 'LIVE') {
                    $language_pointer = fopen($lang. '.txt', 'a+b');
                    fwrite($language_pointer, $key . "\n");
                    fclose($language_pointer);
                }
            }
        }
    }
    if (!isset($intl[$key]) && (Main::getVersion() != 'LIVE'))
        fwrite($language, $key . "\n");
}

if (Main::getVersion() != 'LIVE')
    fclose($language);

natcasesort($shorts_refs); // for definition list

function trnslt($string, $uses_shorts = true) {

    global $intl, $shorts, $links;

    if (isset($intl[$string]))
        $string = $intl[$string];
    elseif (CURRENT_LANGUAGE != 'MN')
        $string = "[" . str_replace(" ", "_", $string) . "]";

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

define('TRNSLT_KEYS', count($keys));
define('APPLICATION_NAME', "[K]ompetitor");
define('APPLICATION_TITLE', APPLICATION_NAME . " v" . Main::getVersion());
define('APPLICATION_COPYRIGHT', APPLICATION_TITLE . ", Copyright © " . date('Y') . " Bertozzi Matteo");
define('APPLICATION_BIBLIOGRAPHY', "- Andiamo a Correre (Fulvio Massini, 2012)" . "\\n"
                                 . "- La Perfezione del Corpo (Bruce & Linda Lee, 1998)" . "\\n"
                                 . "- Voglio Correre (Enrico Arcelli, 2014)" . "\\n"
                                 . "\\n"
                                 . "- http://therunningpitt.com (Gianmarco Pitteri, " . date('Y') . ")");
define('APPLICATION_CREDITS', APPLICATION_COPYRIGHT . "\\n\\n" . ucfirst(trnslt('bibliography')) . ":\\n\\n" . APPLICATION_BIBLIOGRAPHY);

Main::updateReadme("# " . APPLICATION_TITLE);
