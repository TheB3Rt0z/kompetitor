<?php require_once 'init.php' ?><!DOCTYPE html>
<html>
	<head>
		<title><?php echo APPLICATION_TITLE ?></title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script type="text/javascript" src="includes/jquery.min.js" charset="UTF-8"></script>
		<script type="text/javascript" src="scripts.js" charset="UTF-8"></script>
	</head>
	<body>
		<header>
			<div>
				<table>
					<thead>
						<tr>
							<th class="a-left"><?php echo APPLICATION_TITLE ?></th>
							<th class="a-right">TOOLBAR</th>
						</tr>
						<tr>
							<th colspan="2"><hr /></th>
						</tr>
					</thead>
				</table>
			</div>
		</header>
		<nav></nav>
		<section>
			<article></article>
			<aside></aside>
		</section>
		<footer>
			<div>
				<table>
					<tfoot>
						<tr>
							<td colspan="2"><hr /></td>
						</tr>
						<tr>
							<td class="a-left">REPORT</td>
							<td class="a-right">EXPORT</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</footer>
	</body>
</html>