<?php $exercises = array(); $grade = 25; Main::addLog("grade value should be an input with submit", 'todo') ?>

<?php

$exercises = array(
	"rapid-fire punches|" . $grade * 2, "biceps|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "vertical pulls|" . round($grade * 1.333),
	"rapid-fire punches|" . $grade * 2, "rear handles|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "90°-openings|" . round($grade * 1.333),
	"rapid-fire punches|" . $grade * 2, "hammer-curls|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "90°-pulls|" . round($grade * 1.333),
	"rapid-fire punches|" . $grade * 2, "straight punches|" . $grade . " + " . $grade,
	"rapid-fire punches|" . $grade * 2, "hump-launches|" . round($grade * 2),
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
			<thead>
				<tr>
					<th colspan="2"><?php echo trnslt("single-arm exercises") ?></th>
					<th colspan="2"><?php echo trnslt("double-arm exercises") ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php
					foreach ($exercises as $key => $exercise) {
						$exercise = explode("|", $exercise);
						?>
						<td class="a-left">
							<input id="exercise_<?php echo $key ?>" type="checkbox" />
							<label for="exercise_<?php echo $key ?>">
								<?php echo $exercise[1] ?>
								<?php echo trnslt($exercise[0]) ?>
							</label>
						</td>
						<?php
						if (is_int(($key + 1) / 4))
							echo '<tr></tr>';
					}
					?>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3">
						<?php echo ucfirst(trnslt("finishing")) ?>:
						<?php echo $grade * 2 ?> <?php echo trnslt("rapid-fire punches") ?>
						+
						<?php echo floor($grade * 2.666) ?> <?php echo trnslt("wrist-rolls") ?>
						+
						<?php echo $grade * 4 ?> <?php echo trnslt("rapid-fire punches") ?>
					</td>
					<td><?php submit() ?></td>
				</tr>
			</tfoot>
		</table>
	</fieldset>
	<?php
	file_put_contents('tables/arms-2x5kg.htm', ob_get_contents());
	ob_end_flush();
}
?>