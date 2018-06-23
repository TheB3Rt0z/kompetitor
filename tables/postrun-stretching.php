<?php include_once 'head.php' ?>

<?php

$speed_second_coefficient = .7;

$grade = $this->getPost('postrun_stretching', 'grade'); // default value 25

$double = $grade * 2;

/*$exercises = array(
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
);*/

$exercises = array(

    "double and alternated calves (at bigger tree)" => $grade . "s + " . $grade . " x|" . $double,
    "vertical pulls (with shoes string loosing)" => $dozble . "s|" . $double,

    "broken A stretching (variable starting, springy final)" => $grade . "s + " . $grade . "s|" . $double,

    "knee to chest (right leg, with rotation of the foot)" => $grade . " + " . $grade . " x|" . $double,
	"knee to chest (left leg, with rotation of the foot)" => $grade . " + " . $grade . " x|" . $double,

    "bar pulls (right leg, horizontal + L configuration)" => $grade . "s + " . $grade . "s|" . $double,
    "bar pulls (left leg, horizontal + L configuration)" => $grade . "s + " . $grade . "s|" . $double,

    "rear and lateral pulls (right leg, with fixed twists)" => $grade . "s + " . $grade . "s|" . $double,
    "rear and lateral pulls (left leg, with fixed twists)" => $grade . "s + " . $grade . "s|" . $double,

    "upper pulls on high bench (with rigid body)" => $grade . "s " . trnslt('synchronous') . "|" . $grade,
	"lower pulls on middle bench (with rigid body)" => $grade . "s " . trnslt('synchronous') . "|" . $grade,
	"squatting pulls (variable, with swinging)" => $grade . "s " . trnslt('synchronous') . "|" . $grade,

    "anti-piriformis (right leg, fixed position on the bench)" => $grade . "s + " . $grade . "s|" . $double,
	"anti-piriformis (left leg, fixed position on the bench)" => $grade . "s + " . $grade . "s|" . $double,

    "vertical pulls (in progression, enlivened final)" => $grade . "s " . trnslt('synchronous') . "|" . $grade,

	/*"broken A stretching (with shoes string loosing)" => $grade . " + " . $grade * 2 . " x|" . $grade * 4,
    "vertical pulls to 3/4 of height (hands on knees)" => $grade * 3 . " " . trnslt('synchronous') . " x|" . $grade * 3,
	"tree calves (variable starting, springy final)" => $grade * 5 . " " . trnslt('synchronous') . " x|" . $grade * 5,
	"tree pulls (with forefoot movimentation)" => $grade * 3 . " + " . $grade * 3 . " x|" . $grade * 6,
	"knee to chest (right leg, with rotation of the foot)" => $grade * 2 . " + " . $grade * 2 . " x|" . $grade * 4,
	"knee to chest (left leg, with rotation of the foot)" => $grade * 2 . " + " . $grade * 2 . " x|" . $grade * 4,
	"bar pulls (variable starting, springy final)" => $grade * 3 . " + " . $grade * 3 . " x|" . $grade * 6,
    "rear and lateral pulls (right leg, with fixed twists)" => $grade * 2 . " + " . $grade * 2 . " x|" . $grade * 4,
    "rear and lateral pulls (left leg, with fixed twists)" => $grade * 2 . " + " . $grade * 2 . " x|" . $grade * 4,
    "upper pulls on high bench (with rigid body)" => $grade * 5 . " " . trnslt('synchronous') . " x|" . $grade * 5,
	"lower pulls on middle bench (with rigid body)" => $grade * 4 . " " . trnslt('synchronous') . " x|" . $grade * 4,
	"squatting pulls (variable, with swinging)" => $grade * 3 . " " . trnslt('synchronous') . " x|" . $grade * 3,
	"anti-piriformis (right leg, fixed position on the bench)" => $grade * 2 . " + " . $grade * 2 . " x|" . $grade * 4,
	"anti-piriformis (left leg, fixed position on the bench)" => $grade * 2 . " + " . $grade * 2 . " x|" . $grade * 4,
	"vertical pulls (in progression, enlivened final)" => $grade * 5 . " " . trnslt('synchronous') . " x|" . $grade * 5,*/
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
						<?php echo str_replace(" (", "<br />(", trnslt($key)) ?>
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
				    <?php echo ucfirst(trnslt('total time')) ?> (*<?php echo trim($speed_second_coefficient, "0") ?>): <?php echo date('i:s', $total * $speed_second_coefficient) ?>
				    |
					<?php echo ucfirst(trnslt('grade')) ?>:
					<input type="number" name="postrun_stretching[grade]" min="25" max="50" value="<?php echo $grade ?>" />
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
