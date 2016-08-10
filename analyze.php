<?php

define('APP_TITLE', 'PHP Analyzer v' . number_format(filesize(__FILE__) / 1024 / 100, 2));
define('FILES_FILTER', serialize(['.', '..', '.git', '.DS_Store', '.project']));
define('HTML_EOL', "<br />");
define('NEGATIVE_MODE', isset($_GET['negative']));
define('PATH_PREFIX', "./");
define('SCAN_DEEP', !empty($_GET['deep']) ? $_GET['deep'] : 0);
define('SIDEBAR_WIDTH', 480);
define('TABLE_HEADERS', serialize(['type','size'] + (!isset($_GET['filesystem']) ? ['permissions','owner','group','modified', 'realpath'] : [])));

function getFileType($path) { // http://www.techrepublic.com/article/obtain-important-file-information-with-these-php-file-functions/
	$type = '';
	if (($filetype = filetype($path)) != 'dir') {
		$file = explode(".", $path);
		$end = end($file);
		switch ($end) {
			case 'gitignore': $type = 'Git'; break; // git Framework helper
			case 'html': case 'htm': $type = 'HTML'; break; // HyperText Markup Language
			case 'md': $type = 'MD'; break; // MarkDown syntax PlainText
			case 'php': $type = 'PHP'; break; // Hypertext Preprocessor
			case 'yaml': case 'yml': $type = 'YAML'; break; // YAML Ain't a Markup Language
		}
	}
	else
		$filetype = 'directory';
	return $filetype . ' ' . $type;
}

function formatPermissions($permissions) {
	switch ($permissions & 0xF000) {
		case 0xC000: $output = 's'; break; // socket
		case 0xA000: $output = 'l'; break; // symbolic link
		case 0x8000: $output = 'r'; break; // regular
		case 0x6000: $output = 'b'; break; // special block
		case 0x4000: $output = 'd'; break; // directory
		case 0x2000: $output = 'c'; break; // special character
		case 0x1000: $output = 'p'; break; // FIFO pipe
		default:     $output = 'u'; // unknown
	}
	$output .= (($permissions & 0x0100) ? 'r' : '-')
	         . (($permissions & 0x0080) ? 'w' : '-')
	         . (($permissions & 0x0040)
	         ? (($permissions & 0x0800) ? 's' : 'x' )
	         : (($permissions & 0x0800) ? 'S' : '-')); // owner
	$output .= (($permissions & 0x0020) ? 'r' : '-')
	         . (($permissions & 0x0010) ? 'w' : '-')
	         . (($permissions & 0x0008)
	         ? (($permissions & 0x0400) ? 's' : 'x' )
	         : (($permissions & 0x0400) ? 'S' : '-')); // group
	$output .= (($permissions & 0x0004) ? 'r' : '-')
	         . (($permissions & 0x0002) ? 'w' : '-')
	         . (($permissions & 0x0001)
	         ? (($permissions & 0x0200) ? 't' : 'x' )
	         : (($permissions & 0x0200) ? 'T' : '-')); // world
	return $output;
}

function scanPath($path = PATH_PREFIX, $deep = 1, $data = []) {
	$files = scandir($path);
	foreach ($files as $file) {
		if (in_array($file, unserialize(FILES_FILTER)))
			continue;
		$realpath = $path . $file;
		$permissions = fileperms($realpath);
		$attributes = [
			'name' => $file,
			'type' => getFileType($realpath),
			'size' => ceil(filesize($realpath) / 1024) . " KB",
		];
		if (!isset($_GET['filesystem']))
			$attributes += [
				'permissions' => substr(sprintf('%o', $permissions), -4) . " " . formatPermissions($permissions),
				'owner' => posix_getpwuid(fileowner($realpath)),
				'group' => posix_getgrgid(filegroup($realpath)),
				'lastmod' => date('Y-m-d', filemtime($realpath)),
				'realpath' => realpath($realpath),
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

function renderHeaders($headers) {
	foreach ($headers as $header) {
		?>
		<th>
			<label class="<?=$header?>s">
				<?=strtoupper($header)?>&nbsp;
			</label>
			<span rel="<?=$header?>s" class="toggler active" title="<?=strtoupper($header)?>"></span>
		</th>
		<?php
	}
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
			    <?=(isset($attributes['sub'])?'<span class="toggler" rel="'.$subrel.'" title="/'.$subrel.'/*"></span>':'')?>
			</td>
			<td><span class="types"><?=$attributes['type']?></span></td>
			<td class="right"><span class="sizes"><?=$attributes['size']?></span></td>
			<?php
			if (!isset($_GET['filesystem'])) {
				?>
				<td><span class="permissionss"><?=$attributes['permissions']?></span></td>
				<td><span class="owners"><?=$attributes['owner']['name']?></span></td>
				<td><span class="groups"><?=$attributes['group']['name']?></span></td>
				<td><span class="modifieds"><?=$attributes['lastmod']?></span></td>
				<td><span class="realpaths"><?=$attributes['realpath']?></span></td>
				<?php
			}
			?>
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
		<title><?=APP_TITLE?></title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<style type="text/css">
		    body {
		        border: 0;
		        font-family: Arial, Helvetica, sans-serif;
		        font-size: .75em;
		        padding: 0;
		    }
		    table tr:hover td {
		    	opacity: .5;
		    }
		    table tr th {
		    	text-align: left;
		    }
		    table tr td {
		        border-bottom: 1px dashed;
		        margin: 0;
		        padding: 2px 4px 3px 0;
		    }
		    .invisible {
		        display: none;
		    }
		    .right {
		        text-align: right;
		    }
		    .float-right {
		        float: right;
		    }
		    sidebar {
			    background-color: rgba(255, 255, 255, .93875);
			    border-bottom-right-radius: 3px;	
			    box-shadow: 0 0 10px rgba(0, 0, 0, .5);
			    left: -<?=SIDEBAR_WIDTH?>px;
			    opacity: .125;
			    padding: 10px;
			    position: absolute;
			    top: 0;
			    transition: .25s;
			    width: <?=SIDEBAR_WIDTH-20?>px;
			}
			sidebar.active {
				left: 0;
				opacity: 1;
			}
			sidebar > i {
				border-color: black transparent transparent transparent;
				border-style: solid;
				border-width: 20px 20px 0 0;
				float: right;
				height: 0;
				position: relative;
				right: -30px;
				top: -10px;
				transition: .25s;
				width: 0;
			}
			sidebar.active > i {
				opacity: 0;
			}
		    .toggler {
		    	border: 1px solid;
		    	border-radius: 1px;
		    	box-shadow: 0 0 3px rgba(0, 0, 0, .5);
			    cursor: pointer;
			    float: right;
			    font-size: .75em;
			    font-weight: normal;
			    padding: 1px 3px 0;
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
		    <?php
		    if (NEGATIVE_MODE) {
		    	?>
		    	body {
		    		background-color: black;
		    		color: white;
		    	}
		    	sidebar {
			    	background-color: rgba(0, 0, 0, .875);
			    }
			    sidebar > i {
					border-color: white transparent transparent transparent;
				}
		    	.toggler {
		    		box-shadow: 0 0 3px white inset;
		    	}
		    	<?php
		    }
		    ?>
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script type="text/javascript">
			jQuery(function() {
				jQuery('sidebar').on('mouseover', function() {
					jQuery(this).addClass('active');
				});
				jQuery('sidebar').on('mouseout', function() {
					jQuery(this).removeClass('active');
				});
				jQuery('sidebar input').on('change', function() {
					var href = '<?=$_SERVER['SCRIPT_NAME']?>?';
					jQuery('sidebar input:checked').each(function() {
						href = href + jQuery(this).attr('name') + '&';
					});
					jQuery('sidebar > a').attr('href', href);
				});
				
				jQuery('.toggler').on('click', function() {
					var rel = jQuery(this).attr('rel');
					jQuery(this).toggleClass('active');
					jQuery('.' + rel).toggle();
					if (!jQuery(this).hasClass('active'))
						jQuery('.invisible[class^="' + rel + '"]').hide();
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
					<th>
						FILENAME
					</th>
					<?php renderHeaders(unserialize(TABLE_HEADERS)) ?>
				</tr>
			</thead>
			<tbody>
				<?php renderTree($data) ?>
			</tbody>
		</table>
		<sidebar>
			<i></i>
			<?=APP_TITLE?><br />
			<br />
			ANALYSIS<br />
			<input type="checkbox" id="filesystem" name="filesystem"<?=isset($_GET['filesystem'])?' checked':''?> /> <label for="filesystem">HIDE FILESYSTEM INFORMATION</label><br />
			<br />
			INTERFACE<br />
			<input type="checkbox" id="negative" name="negative"<?=isset($_GET['negative'])?' checked':''?> /> <label for="negative">USE NEGATIVE TEMPLATE</label><br />
			<br />
			<a class="float-right">RELOAD</a>
		</sidebar>
	</body>
</html>