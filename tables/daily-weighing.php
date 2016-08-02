<?php include_once 'head.php' ?>

<?php

if (ob_start()) {
	?>
	<fieldset>
		<legend><?php echo ucfirst(trnslt('daily weighing')) ?> (in kg)</legend>
		<table>
			<tr>
				<td class="a-left"><?php echo ucfirst(trnslt('mon')) ?>:</td>
				<td class="a-right"><input type="text" name="personal_data[daily_weighing][mon]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'mon') ?>" title="<?php echo trnslt('format: ##.#') ?>" /></td>
				<td class="a-left"><?php echo ucfirst(trnslt('tue')) ?>:</td>
				<td class="a-right"><input type="text" name="personal_data[daily_weighing][tue]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'tue') ?>" title="<?php echo trnslt('format: ##.#') ?>" /></td>
				<td class="a-left"><?php echo ucfirst(trnslt('wed')) ?>:</td>
				<td class="a-right"><input type="text" name="personal_data[daily_weighing][wed]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'wed') ?>" title="<?php echo trnslt('format: ##.#') ?>" /></td>
			    <?php if ($main->is_mobile) echo '</tr><tr>' ?>
				<td class="a-left"><?php echo ucfirst(trnslt('thu')) ?>:</td>
				<td class="a-right"><input type="text" name="personal_data[daily_weighing][thu]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'thu') ?>" title="<?php echo trnslt('format: ##.#') ?>" /></td>
				<td class="a-left"><?php echo ucfirst(trnslt('fri')) ?>:</td>
				<td class="a-right"><input type="text" name="personal_data[daily_weighing][fri]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'fri') ?>" title="<?php echo trnslt('format: ##.#') ?>" /></td>
				<td class="a-left"><?php echo ucfirst(trnslt('sat')) ?>:</td>
				<td class="a-right"><input type="text" name="personal_data[daily_weighing][sat]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'sat') ?>" title="<?php echo trnslt('format: ##.#') ?>" /></td>
				<?php if ($main->is_mobile) echo '</tr><tr>' ?>
				<td class="a-left"><?php echo ucfirst(trnslt('sun')) ?>:</td>
				<td class="a-right"><input type="text" name="personal_data[daily_weighing][sun]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'sun') ?>" title="<?php echo trnslt('format: ##.#') ?>" /></td>
				<td class="a-right" colspan="4"><?php echo submit($main->is_mobile ? 'update data' : false) ?></td>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$main->is_mobile)
		@file_put_contents('./tables/daily-weighing.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}