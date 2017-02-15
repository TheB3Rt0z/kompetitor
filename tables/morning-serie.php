<?php include_once 'head.php' ?>

<?php

$speed_second_coefficient = .675;

$grade = $this->getPost('morning_serie', 'grade'); // default value 25

$exercises = array(
	"sun salutation (S chain extension)" => $grade . "s|" . $grade,
	"agile pushups (2 steps in 2s)" => $grade . " x|" . $grade * 2,
	"straight abdominals (var. legs)" => $grade * 3 . " x|" . $grade * 3 * 5,
	"leg rollovers (+ iperextension)" => $grade * 2 . "s + " . $grade . "s|" . $grade * 3,

	"sitting pulls (with straight legs)" => round($grade * 1.333) . "s|" . $grade * 1.333,
	"sitting pulls (with crossed legs)" => round($grade * 1.333) . "s|" . $grade * 1.333,
	"frontal concave bridge (static)" => round($grade * 1.333) . "s|" . $grade * 1.333,
	"egg buttocks (static backwards)" => round($grade * 1.333) . "s|" . $grade * 1.333,

	"right-leg anti-piriform (pushing)" => round($grade * 1.333) . "s|" . $grade * 1.333,
    "left-leg anti-piriform (pushing)" => round($grade * 1.333) . "s|" . $grade * 1.333,
	"agile pushups (---P-P steps in 5s)" => $grade . " x|" . $grade * 5,
	"alternated crunches (crossed legs)" => $grade . " + " . $grade . " x|" . $grade * 2 * 5,

	"angles handling (overturned)" => $grade . "s|" . $grade,

	"lumbar pulls (overturned)" => $grade * 2 . "s|" . $grade * 2,
	"lumbar pulls (with crossed legs)" => $grade . "s|" . $grade,
	"boot vibrations (static)" => $grade * 2 . "s|" . $grade * 2,
	"rear L bridge (neck down)" => $grade * 2 . "s|" . $grade * 2,

	"core pushups (static flat body)" => $grade * 2 . "s|" . $grade * 2,
	"static pushups (2/3 up and 1/3 down)" => $grade * 2 . "s + " . $grade . "s|" . $grade * 3,
	//"rear pushes (with widening at half)" => $grade . "s + " . $grade . "s",
	//"crouching (with balancing)" => $grade . "s", // reduced to single bottom exercise
	"widening rear pushes and crouching" => round($grade * 1.333) . "s + " . round($grade * 1.333) . "s x|" . $grade * 2.666,
);

if (ob_start()) {
	?>
	<fieldset>
		<table>
			<tr>
				<?php
				$count = 0;
				$total = 0;
				$cols = $this->is_mobile ? 2 : 3;
				foreach ($exercises as $key => $value) {
					$count++;
					$value = explode("|", $value);
					$total += $value[1];
					$dir = 'left';/*(is_int($count / $cols)
					       ? 'right'
					       : (is_int(($count - 1) / $cols)
					       	 ? 'left'
					       	 : 'center'));*/
					?>
					<td class="a-<?php echo $dir ?>">
						<?php echo $value[0] ?>
						<?php echo trnslt($key) ?>
					</td>
					<td class="a-right">
						<?php echo date('i:s', $value[1]) ?>
					</td>
					<?php
					if (is_int($count / $cols))
						echo '</tr><tr>';
				}
				?>
				<td class="a-right" colspan="2">
				    <?php echo ucfirst(trnslt('total time')) ?>: <?php echo date('i:s', $total * $speed_second_coefficient) ?>
				    |
					<?php echo ucfirst(trnslt('grade')) ?>:
					<input type="number" name="morning_serie[grade]" min="10" max="50" value="<?php echo $grade ?>" />
					<?php /*if (!$this->is_mobile)*/ echo submit() ?>
				</td>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$this->is_mobile)
		file_put_contents('./tables/morning-serie.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}