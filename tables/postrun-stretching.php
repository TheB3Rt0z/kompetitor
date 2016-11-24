<?php include_once 'head.php' ?>

<?php

$speed_second_coefficient = .666;

$grade = $this->getPost('postrun_stretching', 'grade'); // default value 11

$exercises = array(
	"tree calves (variable starting, springy final)" => $grade * 5 . " " . trnslt('synchronous') . " x|" . $grade * 5,
	"vertical pulls to 3/4 of height (hands on knees)" => $grade * 3 . " " . trnslt('synchronous') . " x|" . $grade * 3,

	"tree pulls (with forefoot movimentation)" => $grade * 3 . " + " . $grade * 3 . " x|" . $grade * 6,
	"vertical pulls (in progression, enlivened final)" => $grade * 5 . " " . trnslt('synchronous') . " x|" . $grade * 5,

	"knee to chest (right leg, with rotation of the foot)" => $grade * 3 . " + " . $grade * 3 . " x|" . $grade * 6,
	"knee to chest (left leg, with rotation of the foot)" => $grade * 3 . " + " . $grade * 3 . " x|" . $grade * 6,

	"rear and lateral pulls (right leg, with fixed twists)" => $grade * 3 . " + " . $grade * 3 . " x|" . $grade * 6,
	"rear and lateral pulls (left leg, with fixed twists)" => $grade * 3 . " + " . $grade * 3 . " x|" . $grade * 6,

	"bar pulls (variable starting, springy final)" => $grade * 3 . " + " . $grade * 3 . " x|" . $grade * 6,
    "upper pulls on high bench (with rigid body)" => $grade * 5 . " " . trnslt('synchronous') . " x|" . $grade * 5,

	"lower pulls on middle bench (with rigid body)" => $grade * 4 . " " . trnslt('synchronous') . " x|" . $grade * 4,
	"vertical pulls (variable starting, springy final)" => $grade * 3 . " " . trnslt('synchronous') . " x|" . $grade * 3,

	"anti-piriformis (right leg, fixed position on the bench)" => $grade * 3 . " + " . $grade * 3 . " x|" . $grade * 6,
	"anti-piriformis (left leg, fixed position on the bench)" => $grade * 3 . " + " . $grade * 3 . " x|" . $grade * 6,

	"squatting pulls (variable, with swinging)" => $grade * 3 . " " . trnslt('synchronous') . " x|" . $grade * 3,
);

if (ob_start()) {
	?>
	<fieldset>
		<table>
			<tr>
				<?php
				$count = 0;
				$total = 0;
				foreach ($exercises as $key => $value) {
					$value = explode("|", $value);
					$total += $value[1];
					?>
					<td class="a-left">
						<?php echo $value[0] ?>
						<?php echo trnslt($key) ?>
					</td>
					<td class="a-right">
						<?php echo date('i:s', $value[1]) ?>
					</td>
					<?php
					if ($this->is_mobile || is_int((++$count) / 2))
						echo '</tr><tr>';
				}
				?>
				<td class="a-right" colspan="2">
				    <?php echo ucfirst(trnslt('total time')) ?>: <?php echo date('i:s', $total * $speed_second_coefficient) ?>
				    |
					<?php echo ucfirst(trnslt('grade')) ?>:
					<input type="number" name="postrun_stretching[grade]" min="11" max="55" value="<?php echo $grade ?>" />
					<?php /*if (!$this->is_mobile)*/ echo submit() ?>
				</td>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$this->is_mobile)
		file_put_contents('./tables/postrun-stretching.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}