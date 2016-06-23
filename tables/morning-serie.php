<?php include_once 'head.php' ?>

<?php $grade = $main->getPost('morning_serie', 'grade') // default value 25 ?>

<?php

$exercises = array(
	"agile pushups (2 steps in 2s)" => $grade . " x",
	"straight abdominals (var. legs)" => $grade * 3 . " x",
	"leg rollovers (+ iperextension)" => $grade * 2 . "s + " . $grade . "s",
	"pull sitting (with straight legs)" => $grade * 2 . "s",
	"pull sitting (with crossed legs)" => $grade . "s",
	/*"vertical pulls to 3/4 of height (hands on knees)" => $grade * 3 . " " . trnslt('synchronous') . " x",
	"tree pulls (with forefoot movimentation)" => $grade * 3 . " + " . $grade * 3 . " x",
	"vertical pulls (in progression, enlivened final)" => $grade * 5 . " " . trnslt('synchronous') . " x",
	"knee to chest (right leg, with rotation of the foot)" => $grade * 3 . " + " . $grade * 3 . " x",
	"knee to chest (left leg, with rotation of the foot)" => $grade * 3 . " + " . $grade * 3 . " x",
	"rear and lateral pulls (right leg, with fixed twists)" => $grade * 3 . " + " . $grade * 3 . " x",
	"rear and lateral pulls (left leg, with fixed twists)" => $grade * 3 . " + " . $grade * 3 . " x",
	"bar pulls (variable starting, springy final)" => $grade * 3 . " + " . $grade * 3 . " x",
    "upper pulls on high bench (with rigid body)" => $grade * 5 . " " . trnslt('synchronous') . " x",
	"lower pulls on middle bench (with rigid body)" => $grade * 4 . " " . trnslt('synchronous') . " x",
	"vertical pulls (variable starting, springy final)" => $grade * 3 . " " . trnslt('synchronous') . " x",
	"anti-piriformis (right leg, fixed position on the bench)" => $grade * 3 . " + " . $grade * 3 . " x",
	"anti-piriformis (left leg, fixed position on the bench)" => $grade * 3 . " + " . $grade * 3 . " x",
	"squatting pulls (variable, with swinging)" => $grade * 3 . " " . trnslt('synchronous') . " x",*/
);

if (ob_start()) {
	?>
	<fieldset>
		<table>
			<tr>
				<?php
				$count = 0;
				$cols = 5;
				foreach ($exercises as $key => $value) {
					$count++;
					$dir = (is_int($count / $cols)
					       ? 'right'
					       : (is_int(($count - 1) / $cols)
					       	 ? 'left'
					       	 : 'center'));
					?>
					<td class="a-<?php echo $dir ?>">
						<?php echo $value ?>
						<?php echo trnslt($key) ?>
					</td>
					<?php
					if ($main->is_mobile || is_int($count / $cols))
						echo '</tr><tr>';
				}
				?>
				<td class="a-right">
				    <?php echo ucfirst(trnslt('grade')) ?>:
					<input type="number" name="morning_serie[grade]" min="10" max="50" value="<?php echo $grade ?>" />
					<?php if (!$main->is_mobile) echo submit() ?>
				</td>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$main->is_mobile && ($_SERVER['HTTP_HOST'] == 'localhost'))
		file_put_contents('tables/morning-serie.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}