<?php include_once 'head.php' ?>

<?php $rate_steps = array(.5, .55, .6, .65, .7, .75, .8, .85, .9, .95) ?>

<?php $distances = array('5km', '7.5km', '10km', '10++', '1/3M', '15km', 'HM', '25km', '3/4M', 'M', '50km', '100km', '100mi') ?>

<?php $weight_diff = $this->getPost('processed_physiological_data', 'mediated_weekly_weight') - $this->getPost('processed_physiological_data', 'ideal_weight') ?>

<?php

if (ob_start()) {
	?>
	<fieldset>
		<table>
			<tr>
				<td class="a-left"><?php echo ucfirst(trnslt('age')) ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[age][years]" value="<?php echo $this->getPost('processed_physiological_data', 'age', 'years') ?>" readonly disabled /></td>
				<td class="a-left" colspan="2"><?php echo ucfirst(trnslt('average weight')) ?> (in kg, ATM <strong><?=($weight_diff>=0?'<font color="#a00">+':'<font color="#0a0">').number_format($weight_diff, 3).'</font>'?></strong>):</td>
				<td class="a-right" colspan="2"><input type="text" name="processed_physiological_data[mediated_weekly_weight]" value="<?php echo number_format($this->getPost('processed_physiological_data', 'mediated_weekly_weight'), 3) ?>" readonly disabled /></td>
			</tr>

			<tr>
				<td class="a-left"><?php echo trnslt('BM') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[bm]" value="<?php echo $this->getPost('processed_physiological_data', 'bm') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo ucfirst(trnslt('caloric needs')) ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[cn]" value="<?php echo $this->getPost('processed_physiological_data', 'cn') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('BMR') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[bmr]" value="<?php echo $this->getPost('processed_physiological_data', 'bmr') ?>" readonly disabled /></td>
			</tr>

			<tr>
				<td class="a-left"><?php echo trnslt('BMI') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[bmi]" value="<?php echo $this->getPost('processed_physiological_data', 'bmi') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo ucfirst(trnslt('ideal weight')) ?> (in kg):</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[ideal_weight]" value="<?php echo $this->getPost('processed_physiological_data', 'ideal_weight') ?>" readonly disabled /></td>
				<td class="a-left rs"><?php echo trnslt('RS') ?>:</td>
				<td class="a-right rs"><input type="text" name="processed_physiological_data[rs]" value="<?php echo $this->getPost('processed_physiological_data', 'rs') ?>" readonly disabled /></td>
			</tr>
			<tr>
				<td class="a-left"><?php echo trnslt('FCmax') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[fcmax]" value="<?php echo $this->getPost('processed_physiological_data', 'fcmax') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo ucfirst(trnslt('backup FC')) ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[backup_fc]" value="<?php echo $this->getPost('processed_physiological_data', 'backup_fc') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('FCtr') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[training_fcmin]" value="<?php echo $this->getPost('processed_physiological_data', 'training_fcmin') ?>" readonly disabled /></td>
			</tr>
			<tr>
				<td class="a-left" colspan="2"><?php echo ucfirst(trnslt('aerobic threshold')) ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[aerobic_threshold]" value="<?php echo $this->getPost('processed_physiological_data', 'aerobic_threshold') ?>" readonly disabled /></td>
				<td class="a-left" colspan="2"><?php echo ucfirst(trnslt('lactate threshold')) ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[lactate_threshold]" value="<?php echo $this->getPost('processed_physiological_data', 'lactate_threshold') ?>" readonly disabled /></td>
			</tr>
		</table>
	</fieldset>
	<?php
	if ($this->getPost('processed_physiological_data', 'fcmax') != BOH) {
		$fcmax = $this->getPost('processed_physiological_data', 'fcmax');
		?>
		<br />
		<fieldset>
			<legend><?php echo ucfirst(trnslt('rate expectations')) ?> (<?php echo trnslt('BPM') ?>)</legend>
			<table>
				<thead>
					<tr>
						<?php
						foreach ($rate_steps as $step) {
							?>
							<th style="background-color:rgb(<?php echo round(255 * $step) ?>, <?php echo round(351 - 255 * $step) ?>, 0)"><?php echo $step * 100 ?>%</th>
							<?php
						}
						?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
						foreach ($rate_steps as $step) {
							?>
							<td><small><?php echo number_format($fcmax * $step, 1) ?></small></td>
							<?php
						}
						?>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"><?php echo trnslt('moderate activity') ?></td>
						<td colspan="2"><?php echo trnslt('slimming') ?></td>
						<td colspan="2"><?php echo trnslt('aerobic activity') ?></td>
						<td colspan="2"><?php echo trnslt('threshold activity') ?></td>
						<td><?php echo trnslt('AA') ?></td>
					</tr>
				</tfoot>
			</table>
		</fieldset>
		<?php
	}
	?>
	<br />
	<fieldset>
		<legend><?php echo ucfirst(trnslt('speed expectations')) ?> (min/km)</legend>
		<table>
			<tr>
				<td class="a-left"><?php echo trnslt('5km') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][5km]" value="<?php echo $this->getPost('processed_physiological_data', 'speed_expectations', '5km') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('7.5km') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][7.5km]" value="<?php echo $this->getPost('processed_physiological_data', 'speed_expectations', '7.5km') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('10km') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][10km]" value="<?php echo $this->getPost('processed_physiological_data', 'speed_expectations', '10km') ?>" readonly disabled /></td>
			</tr>
			<tr>
				<td class="a-left"><?php echo trnslt('10mi') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][10mi]" value="<?php echo $this->getPost('processed_physiological_data', 'speed_expectations', '10mi') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('HM') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][hm]" value="<?php echo $this->getPost('processed_physiological_data', 'speed_expectations', 'hm') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('M') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][m]" value="<?php echo $this->getPost('processed_physiological_data', 'speed_expectations', 'm') ?>" readonly disabled /></td>
			</tr>
			<tr>
				<td class="a-left"><?php echo trnslt('MR') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][cm]" value="<?php echo $this->getPost('processed_physiological_data', 'speed_expectations', 'cm') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('LR') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][cl]" value="<?php echo $this->getPost('processed_physiological_data', 'speed_expectations', 'cl') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('ELR') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[speed_expectations][ll]" value="<?php echo $this->getPost('processed_physiological_data', 'speed_expectations', 'll') ?>" readonly disabled /></td>
			</tr>
		</table>
		<br />&nbsp;<br />
		<table class="graph"><tr><td colspan="<?php echo count($distances) ?>">&nbsp;<?php echo ucfirst(trnslt('actual speed\'s profile')) ?> (record + overhead):</td></tr>
			<tr>
				<?php
				foreach ($distances as $key => $distance) {
					$speed = $this->getPost('distances_and_records', $distance, 'speed');
					$last_speed = $this->getPost('distances_and_records', $distance, 'last_speed');
					$overhead = $speed - $last_speed;
					if (($this->getPost('distances_and_records', $distances[$key], 'speed') != BOH)) {
						?>
						<td>
							<span style="border-top:solid <?php echo round($overhead * 10) ?>px black; height: <?php echo round(($speed - 11) * 10) ?>px<?php if ($speed <= $this->getPost('distances_and_records', $distances[$key + 1], 'speed')) echo '; background-color: crimson' ?><?php if ($this->getPost('distances_and_records', $distances[$key], 'speed') == BOH) echo '; background-color: black' ?>">
								<?php echo trnslt($distance) ?>
							</span>
						</td>
						<?php
					}
				}
				?>
			</tr>
		</table>
	</fieldset>
	<br />
	<fieldset>
		<legend><?php echo ucfirst(trnslt('shoes size')) ?></legend>
		<table>
			<tr>
				<td class="a-left"><?php echo trnslt('cm') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[shoes_size][cm]" value="<?php echo $this->getPost('processed_physiological_data', 'shoes_size', 'cm') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('USA') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[shoes_size][usa]" value="<?php echo $this->getPost('processed_physiological_data', 'shoes_size', 'usa') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('UK') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[shoes_size][uk]" value="<?php echo $this->getPost('processed_physiological_data', 'shoes_size', 'uk') ?>" readonly disabled /></td>
				<td class="a-left"><?php echo trnslt('EU') ?>:</td>
				<td class="a-right"><input type="text" name="processed_physiological_data[shoes_size][eu]" value="<?php echo $this->getPost('processed_physiological_data', 'shoes_size', 'eu') ?>" readonly disabled /></td>
				<td class="a-right">
					ISO/Techfit:
					<?php echo $this->getPost('processed_physiological_data', 'shoes_size', 'usa') + 0.5 ?>/<?php echo $this->getPost('processed_physiological_data', 'shoes_size', 'uk') + 0.5 ?>/<?php echo round($this->getPost('processed_physiological_data', 'shoes_size', 'eu') * 2) / 2 + 0.5 ?>
				</td>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$this->is_mobile)
		@file_put_contents('./tables/physiological-data.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}
