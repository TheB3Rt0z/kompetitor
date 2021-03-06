<?php include_once 'head.php' ?>

<?php $grade = $this->getPost('exercises_for_the_arms', 'grade') // default value 25 ?>

<?php

$exercises = array(
	"rapid-fire punches|" . $grade * 2, "biceps|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "vertical pulls|" . round($grade * 1.333),

	"rapid-fire punches|" . $grade * 2, "rear handles|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "90°-openings|" . round($grade * 1.333),

	"rapid-fire punches|" . $grade * 2, "hammer-curls|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "90°-pulls|" . round($grade * 1.333),

	"rapid-fire punches|" . $grade * 2, "death wings|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "dolby rolls|" . round($grade * 1.333),

	"rapid-fire punches|" . $grade * 2, "straight punches|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "hump-launches|" . round($grade * 2),

	"rapid-fire punches|" . $grade * 2, "async pulls|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "double wings|" . round($grade * 1.333),

	"rapid-fire punches|" . $grade * 2, "clawings|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "lateral slows|" . round($grade * 1.333),

	"rapid-fire punches|" . $grade * 2, "frontal raises|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "double curls|" . round($grade * 1.333),

	"rapid-fire punches|" . $grade * 2, "real hammers|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "lateral flyes|" . round($grade * 1.333),
);

if (ob_start()) {
	?>
	<fieldset>
		<legend>
			<?php echo ucfirst(trnslt("warming-up")) ?>:
			<?php echo $grade * 4 ?> <?php echo trnslt("rapid-fire punches") ?>
			+
			<?php echo floor($grade * 2.666) ?> <?php echo trnslt("elbow rolls") ?>
		</legend>
		<table>
			<?php
			if (!$this->is_mobile) {
				?>
				<thead>
					<tr>
						<th colspan="3"><?php echo trnslt("single-arm exercises") ?></th>
						<th colspan="3"><?php echo trnslt("double-arm exercises") ?></th>
					</tr>
				</thead>
				<?php
			}
			?>
			<tbody>
				<tr>
					<?php
					foreach ($exercises as $key => $exercise) {
						$exercise = explode("|", $exercise);
						$value = $this->getPost('exercises_for_the_arms', 'exercises', $key);
						?>
						<td class="a-left">
							<input id="exercise_<?php echo $key ?>" name="exercises_for_the_arms[exercises][<?php echo $key ?>]" type="checkbox" <?php if ($value && $value != BOH) echo 'checked' ?>  />
							<label for="exercise_<?php echo $key ?>">
								<?php echo $exercise[1] ?>
								<?php echo trnslt($exercise[0]) ?>
							</label>
						</td>
						<?php
						if (is_int(($key + 1) / 2))
							echo '<td class="a-right">' . $grade . 's ' . trnslt('pause') . '</td>';
						if (($this->is_mobile && is_int(($key + 1) / 2))
							|| (is_int(($key + 1) / 4)))
							echo '</tr><tr>';
					}
					?>
				</tr>
				<tr>
					<td class="a-left" colspan="<?php echo $this->is_mobile ? 3 : 4 ?>">
						<?php echo ucfirst(trnslt("finishing")) ?>:
						<?php echo $grade * 2 ?> <?php echo trnslt("rapid-fire punches") ?>
						+
						<?php echo floor($grade * 2.666) ?> <?php echo trnslt("wrist-rolls") ?>
						+
						<?php echo $grade * 4 ?> <?php echo trnslt("rapid-fire punches") ?>
					</td>
					<?php if ($this->is_mobile) echo '</tr><tr>' ?>
					<td class="a-right" colspan="<?php echo $this->is_mobile ? 3 : 2 ?>">
						<?php echo ucfirst(trnslt('grade')) ?>:
						<input type="number" name="exercises_for_the_arms[grade]" min="10" max="50" value="<?php echo $grade ?>" />
						<?php if (!$this->is_mobile) echo submit() ?>
					</td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<?php
	if (!$this->is_mobile)
		file_put_contents('./tables/arms-2x5kg.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}
