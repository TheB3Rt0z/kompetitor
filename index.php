<?php require_once 'init.php'; include_once 'head.php' ?>

	<body>
		<form id="main" method="post">
		<input type="hidden" name="width" id="width" />
		<?php
		include_once 'header.php';
		if ($main->is_logged)
			include_once 'section.php';
		else
			include_once 'login.php';
		?>
		</form>

<?php include_once 'footer.php'; include_once 'finish.php' ?>