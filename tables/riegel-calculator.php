<?php include_once 'head.php' ?>

<?php

$distances = array(
	'5km' => 5,
	'7.5km' => 7.5,
	'10km' => 10,
	'1/3M' => 14.065,
	'15km' => 15,
	//'10mi' => 16093.44,
	'HM' => 21.0975,
	'25km' => 25,
	//'2/3M' => 28.13,
	'3/4M' => 31.6463,
	'M' => 42.195,
	//'VM' => 43.308,
    '50km' => 50,
	'100km' => 100,
    '100mi' => 161.76,
);

if (ob_start()) {
	?>
	<fieldset>
		<table>
			<tr>
				<td class="a-left"><?php echo ucfirst(trnslt('recent run')) ?>:</td>
				<td class="a-right"><input type="text" name="riegel_calculator[distance]" value="<?php echo $this->getPost('riegel_calculator', 'distance') ?>" title="<?php echo trnslt('format: ?(.?) (in km)') ?>" /></td>
				<td class="a-right">in</td>
				<td class="a-left"><input type="text" name="riegel_calculator[time]" value="<?php echo $this->getPost('riegel_calculator', 'time') ?>" title="<?php echo trnslt('format: (h)h:mm:ss') ?>" /></td>
				<td class="a-left">&#8656; <input type="checkbox" name="riegel_calculator[performance_override]" title="<?php echo trnslt('overrides distance/time processing and forces usage of most recent 10.000 meters', false) ?>" <?php if ($this->getPost('riegel_calculator', 'performance_override') != BOH) echo 'checked' ?> /></td>
				<td class="a-left"><?php echo ucfirst(trnslt('speed')) ?>:</td>
				<td class="a-right"><input type="text" name="riegel_calculator[speed]" value="<?php echo $this->getPost('riegel_calculator', 'speed') ?>" readonly disabled /></td>
				<td class="a-right"><?php if (!$this->is_mobile) echo submit() ?></td>
			</tr>
		</table>
	</fieldset>
	<br />
	<fieldset>
		<table>
			<tr>
				<?php
				$count = 0;
				foreach ($distances as $key => $distance) {
					?>
					<td class="a-left"><?php echo trnslt($key) ?>:<input type="hidden" name="riegel_calculator[distances][<?php echo $key ?>]" value="<?php echo $distance ?>" /></td>
					<td class="a-right"><input type="text" name="riegel_calculator[forecasts][<?php echo $key ?>]" value="<?php echo $this->getPost('riegel_calculator', 'forecasts', $key) ?>" readonly disabled /></td>
					<td class="a-right"><input type="text" name="riegel_calculator[forespeed][<?php echo $key ?>]" value="<?php echo $this->getPost('riegel_calculator', 'forespeed', $key) ?>" readonly disabled /></td>
					<?php
					if (is_int((++$count) / 3))
						echo '</tr><tr>';
				}
				?>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$this->is_mobile)
		file_put_contents('./tables/riegel-calculator.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}