<?php

define('FILES_FILTER', serialize(['.', '..', '.git', '.gitignore', '.project']));
define('HTML_EOL', "<br />");
define('PATH_PREFIX', "./");
define('SCAN_DEEP', !empty($_GET['deep']) ? $_GET['deep'] : 0);

function getFileType($path) { // http://www.techrepublic.com/article/obtain-important-file-information-with-these-php-file-functions/
	return filetype($path);
}

function scanPath($path = PATH_PREFIX, $deep = 1, $data = []) {
	$files = scandir($path);
	foreach ($files as $file) {
		if (in_array($file, unserialize(FILES_FILTER)))
			continue;
		$realpath = $path . $file;
		$attributes = [
			'name' => $file,
			'type' => getFileType($realpath),
			'size' => ceil(filesize($realpath) / 1024) . " KB",
		];
		if (is_dir($realpath)) {
			$deeper = $deep + 1;
			$attributes['sub'] = scanPath($realpath . "/", $deeper);
			$attributes['size'] = count($attributes['sub']) . " #";
			if (SCAN_DEEP && $deeper > SCAN_DEEP)
				unset($attributes['sub']);
		}
		$data[$realpath] = $attributes;
	}
	uasort($data, function($a, $b) {
		return $a['type'] . $a['name'] > $b['type'] . $b['name'];
	});
	return $data;
}

function renderTree($data, $rel = null, $deep = 0) {
	$last = end($data);
	foreach ($data as $file => $attributes) {
		$driver = '';
		if ($deep) {
			if ($attributes == $last)
				$driver = '┗';
			else
				$driver = '┣';
		}
		?>
		<tr<?=($rel?' class="'.$rel.' invisible"':'')?>>
			<?php $subrel = trim(str_replace(["/", "."], '', $file)) ?>
			<td><?=str_repeat('&nbsp;&nbsp;&nbsp;',$deep?$deep-1:$deep).$driver.'&nbsp;'.$attributes['name']?>
			    <?=(isset($attributes['sub'])?'<span class="toggler" rel="'.$subrel.'"></span>':'')?>
			</td>
			<!--<td><?=$attributes['type']?></td>-->
			<td class="right"><?=$attributes['size']?></td>
		</tr>
		<?php
		if (isset($attributes['sub']))
			renderTree($attributes['sub'], $subrel, $deep + 1);
	}
}

$data = scanPath();//echo'<pre>';var_dump($data);echo'</pre>';DIE

?><!DOCTYPE html>
<html>
	<head>
		<title>PHP Analyzer v<?=number_format(filesize(__FILE__)/1024/100, 2)?></title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<style type="text/css">
		    body {
		        border: 0;
		        font-family: Arial, Helvetica, sans-serif;
		        font-size: .75em;
		        padding: 0;
		    }
		    table {
		    
		    }
		    table tr:hover td {
		    	opacity: .5;
		    }
		    table tr td {
		        border-bottom: 1px dashed;
		        margin: 0;
		        padding: 2px 7px 3px 0;
		    }
		    .invisible {
		        display: none;
		    }
		    .right {
		        text-align: right;
		    }
		    .toggler {
		    	border: 1px solid;
		    	box-shadow: 0 0 3px rgba(0, 0, 0, .5);
			    cursor: pointer;
			    float: right;
			    padding: 0 3px 0 4px;
		    }
		    .toggler:hover {
		        opacity: .5;
		    }
		    .toggler::after {
		    	content: "+";
		    }
		    .toggler.active::after {
		    	content: "−";
		    }
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script type="text/javascript">
			jQuery(function() {
				jQuery('.toggler').on('click', function() {
					var rel = jQuery(this).attr('rel');
					jQuery(this).toggleClass('active');
					jQuery('.' + rel).toggle(333);
					if (!jQuery(this).hasClass('active'))
						jQuery('.invisible[class^="' + rel + '"]').hide(333);
					else
						jQuery(window).scrollTop(jQuery(this).parent().offset().top);
				});
			});
		</script>
	</head>

	<body>
		<table>
			<thead>
				<tr>
					<th>FILE</th>
					<!--<th>TYPE</th>-->
					<th>SIZE</th>
				</tr>
			</thead>
			<tbody>
				<?php renderTree($data) ?>
			</tbody>
		</table>
	</body>
</html>