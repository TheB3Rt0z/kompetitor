<?php include_once 'head.php' ?>

<?php

if (ob_start()) {
	?>
	<fieldset>
		<table>
			<tr>
				<td class="a-left"><?php echo ucfirst(trnslt('first name')) ?>:</td>
				<td class="a-right"><input type="text" name="personal_data[first_name]" value="<?php echo $this->getPost('personal_data', 'first_name') ?>" /></td>
				<?php if ($this->is_mobile) echo '</tr><tr>' ?>
				<td class="a-left"><?php echo ucfirst(trnslt('last name')) ?>:</td>
				<td class="a-right"><input type="text" name="personal_data[last_name]" value="<?php echo $this->getPost('personal_data', 'last_name') ?>" /></td>
				<?php if ($this->is_mobile) echo '</tr><tr>' ?>
				<td class="a-left"><?php echo ucfirst(trnslt('date of birth')) ?>:</td>
				<td class="a-right" colspan="<?php echo $this->is_mobile ? 1 : 2 ?>"><input type="text" name="personal_data[date_of_birth]" value="<?php echo $this->getPost('personal_data', 'date_of_birth') ?>" title="<?php echo trnslt('format: dd mm yyyy') ?>" /></td>
			</tr>
			<tr>
				<td class="a-left"><?php echo ucfirst(trnslt('height')) ?> (in cm):</td>
				<td class="a-right"><input type="text" name="personal_data[height]" value="<?php echo $this->getPost('personal_data', 'height') ?>" title="<?php echo trnslt('format: ###.#') ?>" /></td>
				<?php if ($this->is_mobile) echo '</tr><tr>' ?>
				<td class="a-left"><?php echo ucfirst(trnslt('foot length FL')) ?> (in cm):</td>
				<td class="a-right"><input type="text" name="personal_data[foot_length]" value="<?php echo $this->getPost('personal_data', 'foot_length') ?>" title="<?php echo trnslt('format: ##.##') ?>" /></td>
				<?php if ($this->is_mobile) echo '</tr><tr>' ?>
				<td class="a-left"><?php echo trnslt('FCmax/min values') ?>:</td>
				<td class="a-right">
					<input type="checkbox" name="personal_data[fcmax_override]" title="<?php echo trnslt('overrides FCmax processing, forces the use of this value only', false) ?>" <?php if ($this->getPost('personal_data', 'fcmax_override') != BOH) echo 'checked' ?> />
					&#8688;
					<input type="text" name="personal_data[fcmax]" value="<?php echo $this->getPost('personal_data', 'fcmax') ?>" class="mini" />
					/
					<input type="text" name="personal_data[fcmin]" value="<?php echo $this->getPost('personal_data', 'fcmin') ?>" class="mini" />
				</td>
				<?php
				if (!$this->is_mobile)
					echo '<td class="a-right">' . submit() . '</td>';
				?>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$this->is_mobile)
		@file_put_contents('./tables/personal-data.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}
