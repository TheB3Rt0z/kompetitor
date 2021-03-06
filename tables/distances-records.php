<?php include_once 'head.php' ?>

<?php

$distances = array(
	'5km' => 5,
	'7.5km' => 7.5,
	'10km' => 10,
	'10++' => 11,
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
		<legend><?php echo ucwords(trnslt('distances & records')) ?></legend>
		<table>
			<thead>
				<tr>
					<th class="a-left"><?php echo ucfirst(trnslt("distance")) ?></th>
					<th><?php echo ucwords(trnslt("fingerprint")) ?></th>
					<th><?php echo ucwords(trnslt("personal best")) ?></th>
					<th><?php echo ucfirst(trnslt("step")) ?> (min/km)</th>
					<th><?php echo ucfirst(trnslt("speed")) ?> (km/h)</th>
					<?php
					if (!$this->is_mobile) {
						?>
						<th><?php echo ucwords(trnslt("most recent personal")) ?></th>
						<th><?php echo ucfirst(trnslt("step")) ?> (min/km)</th>
						<th><?php echo ucfirst(trnslt("speed")) ?> (km/h)</th>
						<?php
					}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($distances as $key => $distance) {
					?>
					<tr>
						<td class="a-left"><?php echo trnslt($key) ?>:<input type="hidden" name="distances_and_records[<?php echo $key ?>][distance]" value="<?php echo $distance ?>" /></td>
						<td class="a-center" <?php if ($this->is_mobile) echo 'rowspan="2"' ?>><?php echo $this->is_mobile ? str_replace("|", '<br />', $this->getPost('distances_and_records', $key, 'fingerprint')) : $this->getPost('distances_and_records', $key, 'fingerprint') ?></td>
						<td class="a-right"><input type="text" name="distances_and_records[<?php echo $key ?>][pb]" value="<?php echo $this->getPost('distances_and_records', $key, 'pb') ?>" title="<?php echo trnslt('format: (h)h:mm:ss') ?>" /></td>
						<td class="a-right"><input type="text" name="distances_and_records[<?php echo $key ?>][step]" value="<?php echo $this->getPost('distances_and_records', $key, 'step') ?>" readonly disabled /></td>
						<td class="a-right"><input type="text" name="distances_and_records[<?php echo $key ?>][speed]" value="<?php echo $this->getPost('distances_and_records', $key, 'speed') ?>" readonly disabled /></td>
						<?php if ($this->is_mobile) echo '</tr><tr><td colspan="2">' . trnslt('MRP') . '-' . trnslt($key) . ':</td>' ?>
						<td class="a-right <?php if (in_array($key, array('10km', '10++', '1/3M', '15km'))) echo 'rs' ?>"><input type="text" name="distances_and_records[<?php echo $key ?>][last_pb]" value="<?php echo $this->getPost('distances_and_records', $key, 'last_pb') ?>" title="<?php echo trnslt('format: (h)h:mm:ss') ?>" /></td>
						<td class="a-right"><input type="text" name="distances_and_records[<?php echo $key ?>][last_step]" value="<?php echo $this->getPost('distances_and_records', $key, 'last_step') ?>" readonly disabled /></td>
						<td class="a-right"><input type="text" name="distances_and_records[<?php echo $key ?>][last_speed]" value="<?php echo $this->getPost('distances_and_records', $key, 'last_speed') ?>" readonly disabled /></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</fieldset>
	<?php
	if (!$this->is_mobile)
		@file_put_contents('./tables/distances-records.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}
