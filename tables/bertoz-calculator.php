<?php include_once 'head.php' ?>

<?php

if (ob_start()) {
	?>
	<fieldset>
		<legend><?php echo ucfirst(trnslt('average speed calculation')) ?> (in min/km)</legend>
		<table>
			<td class="a-left"><?php echo ucfirst(trnslt('time')) ?>:</td>
			<td class="a-right"><input type="text" name="bertoz_calculator[time]" value="<?php echo $this->getPost('bertoz_calculator', 'time') ?>" title="<?php echo trnslt('format: (h)h:mm:ss') ?>" /></td>
			<td class="a-left"><?php echo ucfirst(trnslt('distance')) ?>:</td>
			<td class="a-right"><input type="text" name="bertoz_calculator[distance]" value="<?php echo $this->getPost('bertoz_calculator', 'distance') ?>" title="<?php echo trnslt('format: ?(.?) (in km)') ?>" /></td>
			<td class="a-left"><?php echo ucfirst(trnslt('speed')) ?>:</td>
			<td class="a-right"><input type="text" name="bertoz_calculator[speed]" value="<?php echo $this->getPost('bertoz_calculator', 'speed') ?>" readonly disabled /></td>
		</table>
	</fieldset>
	<?php
	if (!$this->is_mobile)
		file_put_contents('./tables/bertoz-calculator.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}