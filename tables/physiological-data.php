<?php include('header.php') ?>

<?php
if (ob_start()) {
	?>
	<fieldset>
		<table>
			<tr>
				<td class="a-left"><?php echo ucfirst(trnslt('age')) ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[age]" value="<?php echo $main->getPost('processed_physiological_data', 'age') ?>" readonly disabled /></td>
				<td class="a-left" colspan="2"><?php echo ucfirst(trnslt('mediated weekly weight')) ?> (in kg):</td>
				<td class="a-right" colspan="2"><input type="text" name="processed_physiological_data[mediated_weekly_weight]" value="<?php echo $main->getPost('processed_physiological_data', 'mediated_weekly_weight') ?>" readonly disabled /></td>
			</tr>
			<tr>
				<td class="a-left"><?php echo trnslt('BMI') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[bmi]" value="<?php echo $main->getPost('processed_physiological_data', 'bmi') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo ucfirst(trnslt('ideal weight')) ?> (in kg):</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[ideal_weight]" value="<?php echo $main->getPost('processed_physiological_data', 'ideal_weight') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('RS') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[rs]" value="<?php echo $main->getPost('processed_physiological_data', 'rs') ?>" readonly disabled /></td>
			</tr>
			<tr>
				<td class="a-left"><?php echo trnslt('FCmax') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[fcmax]" value="<?php echo $main->getPost('processed_physiological_data', 'fcmax') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo ucfirst(trnslt('backup FC')) ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[backup_fc]" value="<?php echo $main->getPost('processed_physiological_data', 'backup_fc') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('FCtr') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[training_fcmin]" value="<?php echo $main->getPost('processed_physiological_data', 'training_fcmin') ?>" readonly disabled /></td>
			</tr>
		</table>
	</fieldset>
	<br />
	<fieldset>
		<legend><?php echo ucfirst(trnslt('speed expectations')) ?> (min/km)</legend>
		<table>
			<tr>
				<td class="a-left"><?php echo trnslt('10mi') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][10mi]" value="<?php echo $main->getPost('processed_physiological_data', 'speed_expectations', '10mi') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('HM') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][hm]" value="<?php echo $main->getPost('processed_physiological_data', 'speed_expectations', 'hm') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('M') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][m]" value="<?php echo $main->getPost('processed_physiological_data', 'speed_expectations', 'm') ?>" readonly disabled /></td>
			</tr>
			<tr>
				<td class="a-left"><?php echo trnslt('CM') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][cm]" value="<?php echo $main->getPost('processed_physiological_data', 'speed_expectations', 'cm') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('CL') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][cl]" value="<?php echo $main->getPost('processed_physiological_data', 'speed_expectations', 'cl') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('LL') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][ll]" value="<?php echo $main->getPost('processed_physiological_data', 'speed_expectations', 'll') ?>" readonly disabled /></td>
			</tr>
		</table>
	</fieldset>
	<br />
	<fieldset>
		<legend><?php echo ucfirst(trnslt('shoes size')) ?></legend>
		<table>
			<tr>
				<td class="a-left"><?php echo strtoupper(trnslt('usa')) ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[shoes_size][usa]" value="<?php echo $main->getPost('processed_physiological_data', 'shoes_size', 'usa') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo strtoupper(trnslt('uk')) ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[shoes_size][uk]" value="<?php echo $main->getPost('processed_physiological_data', 'shoes_size', 'uk') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo strtoupper(trnslt('eu')) ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[shoes_size][eu]" value="<?php echo $main->getPost('processed_physiological_data', 'shoes_size', 'eu') ?>" readonly disabled /></td>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$main->is_mobile)
		file_put_contents('tables/physiological-data.htm', file_get_contents('header.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}
?>