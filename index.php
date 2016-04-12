<?php require_once 'init.php' ?><!DOCTYPE html>
<html>
	<head>
		<title><?php echo APPLICATION_TITLE ?></title>
		<meta charset="UTF-8" />
		<link rel="icon" href="statics/icon-32x32.png" type="image/x-icon" />
        <link rel="shortcut icon" href="statics/icon-32x32.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" type="text/css" href="rwd.css" />
		<script type="text/javascript" src="includes/jquery.min.js" charset="UTF-8"></script>
		<script type="text/javascript" src="scripts.js" charset="UTF-8"></script>
	</head>
	<body>
		<header>
			<div>
				<table>
					<thead>
						<tr>
							<th class="a-left title">
								<img src="statics/icon-32x32.png" alt="<?php echo APPLICATION_NAME ?>" class="logo" />
								&nbsp;<?php echo APPLICATION_TITLE ?>&nbsp;
							</th>
							<th class="a-right">
								<?php button() ?>
								<nav class="invisible-on-mobile">
									<?php button('print') ?>
									<?php button('print') ?>
									<?php button('print') ?>
									<?php button('print') ?>
									<?php button('print') ?>
								</nav>
							</th>
						</tr>
						<tr>
							<th colspan="2"><hr /></th>
						</tr>
					</thead>
				</table>
			</div>
		</header>
		<section>
			<article>
				<div>
					<div class="content width-50">
						<p class="title"><?php echo ucfirst(trnslt('personal data')) ?></p>
						<p><?php echo trnslt('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus a ipsum hendrerit eros tincidunt molestie lacinia eu nunc. Curabitur quis imperdiet lorem. Phasellus mi nisl, iaculis nec justo nec, dictum ultricies erat. Morbi ornare massa sollicitudin mauris tempor ornare. Sed fringilla, est non accumsan scelerisque, sapien est ullamcorper lacus, a tempus ligula sem eu turpis. Quisque et sem feugiat, iaculis metus ut, tempor urna. Suspendisse sodales luctus vulputate. Mauris nibh urna, interdum sed ante nec, aliquet lobortis lorem. Aenean maximus viverra felis at gravida. Nulla egestas diam mi, sit amet egestas elit rhoncus posuere. Sed urna neque, pulvinar sed ornare nec, egestas non mauris.

	Nulla ut iaculis dolor, sed tristique nisl. Mauris lacinia dolor id ligula dignissim egestas. Nullam ac varius nisl, tristique auctor diam. Cras sed leo nec nisl vestibulum sodales. Curabitur sit amet nunc ligula. Vestibulum rutrum sollicitudin pulvinar. VR In id eleifend mi. Nam fringilla molestie est, in aliquet justo dignissim id. Cras sed odio libero. Ut hendrerit nec sapien id semper. Ut tempor sem leo, a venenatis ante dictum at. Proin luctus ut lorem non placerat. Donec cursus, est at facilisis fringilla, metus arcu pulvinar arcu, id hendrerit nisl odio non ante. Suspendisse potenti.') ?></p>
					</div>
					<div class="content width-50">
						<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus a ipsum hendrerit eros tincidunt molestie lacinia eu nunc. Curabitur quis imperdiet lorem. Phasellus mi nisl, iaculis nec justo nec, dictum ultricies erat. Morbi ornare massa sollicitudin mauris tempor ornare. Sed fringilla, est non accumsan scelerisque, sapien est ullamcorper lacus, a tempus ligula sem eu turpis. Quisque et sem feugiat, iaculis metus ut, tempor urna. Suspendisse sodales luctus vulputate. Mauris nibh urna, interdum sed ante nec, aliquet lobortis lorem. Aenean maximus viverra felis at gravida. Nulla egestas diam mi, sit amet egestas elit rhoncus posuere. Sed urna neque, pulvinar sed ornare nec, egestas non mauris.

	Nulla ut iaculis dolor, sed tristique nisl. Mauris lacinia dolor id ligula dignissim egestas. Nullam ac varius nisl, tristique auctor diam. Cras sed leo nec nisl vestibulum sodales. Curabitur sit amet nunc ligula. Vestibulum rutrum sollicitudin pulvinar. In id eleifend mi. Nam fringilla molestie est, in aliquet justo dignissim id. Cras sed odio libero. Ut hendrerit nec sapien id semper. Ut tempor sem leo, a venenatis ante dictum at. Proin luctus ut lorem non placerat. Donec cursus, est at facilisis fringilla, metus arcu pulvinar arcu, id hendrerit nisl odio non ante. Suspendisse potenti. </p>
					</div>
				</div>
			</article>
			<aside></aside>
		</section>
		<footer>
			<div>
				<table>
					<tfoot>
						<tr>
							<td colspan="3"><hr /></td>
						</tr>
						<tr>
							<td class="a-left">REPORT</td>
							<td class="a-left debug">
								<pre>POST: <?php var_dump($_POST) ?></pre>
							</td>
							<td class="a-right">EXPORT</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</footer>
	</body>
</html>