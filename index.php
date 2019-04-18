<?php require_once 'init.php'; include_once 'head.php' ?>

		<form id="main" method="post" action="/">
			<input type="hidden" name="width" id="width" />
			<input type="hidden" name="v-pos" id="v-pos" value="<?=(isset($_POST['v-pos'])?$_POST['v-pos']:'')?>" />
			<?php
			include_once 'header.php';
			if ($main->isLogged()) {
				include_once 'section.php';
			} else {
				include_once 'login.php';
			}
			?>
		</form>

<?php include_once 'footer.php'; include_once 'finish.php' ?>
