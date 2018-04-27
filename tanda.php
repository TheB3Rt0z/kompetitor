<?php

$test = require_once 'init.php';

include_once 'head.php';

if (!isset($main))
    $main = $this;

?>

<?php
if ($test === 1) {
    ?>
    <style type="text/css">
        body {
            padding: 1%;
        }
    </style>
    <?php
}
?>

<ul class="list tables-and-appendices">
    <?php
    foreach (glob('texts/' . CURRENT_LANGUAGE . ' *.md') as $md_file) {
        ?>
        <li>
            <a href="Javascript:;" rel="<?php echo $md_file ?>">
                <?php echo str_replace(array('texts/' . CURRENT_LANGUAGE, '.md'), '', $md_file) ?>
            </a>
            <span>
                <?php echo $main->parseDown(file_get_contents($md_file)) ?>
                <a href="Javascript:;"><?php echo trnslt('index') ?></a>
            </span>
        </li>
        <?php
    }
    ?>
</ul>

<script type="text/javascript">
    var links = jQuery('.list.tables-and-appendices li > a'),
        bodys = jQuery('.list.tables-and-appendices li > span'),
        index = jQuery('.list.tables-and-appendices li > span > a');
    links.on('click ', function() {
        var ths = jQuery(this);
        ths.siblings('span').show(delay);
        links.hide(delay);
    });
    index.on('click ', function() {
        bodys.hide(delay);
        links.show(delay);
    });
</script>

