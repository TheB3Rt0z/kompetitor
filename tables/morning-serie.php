<?php include_once 'head.php' ?>

<?php

$speed_second_coefficient = .7;

$grade = $this->getPost('morning_serie', 'grade'); // default value 25

$single = $grade;
$double = $grade * 2;
$triple = $grade * 3;
$four_thirds = round($grade * 1.333);

$exercises = array(

	"sun salutation (S chain extension)" => $single . "s|" . $single,
	"agile pushups (2 steps in 2s)" => $single . " x|" . $double,

	"straight abdominals (var. legs)" => $triple . " x|" . $triple * 4, // 1|1-2-3
	"leg rollovers (+ iperextension)" => $four_thirds . "s + " . $four_thirds . "s|" . $four_thirds * 2, // sum

	"sitting pulls (with straight legs)" => $four_thirds . "s|" . $four_thirds,
	"sitting pulls (with crossed legs)" => $four_thirds . "s|" . $four_thirds,
	"frontal concave bridge (static)" => $four_thirds . "s|" . $four_thirds,
	"egg buttocks (static backwards)" => $four_thirds . "s|" . $four_thirds,
	"right-leg anti-piriform (pushing)" => $four_thirds . "s|" . $four_thirds,
        "left-leg anti-piriform (pushing)" => $four_thirds . "s|" . $four_thirds,

	"agile pushups (---P-P steps in 5s)" => $single . " x|" . $single * 4, // 1-2-3|P|1|P
	"alternated crunches (crossed legs)" => $single . " + " . $single . " x|" . $double * 4, // 1|1-2-3, alternated SX-DX

	"angles handling (overturned)" => $four_thirds . "s|" . $four_thirds,
	"lumbar pulls (overturned)" => $four_thirds . "s|" . $four_thirds,
	"lumbar pulls (with crossed legs)" => $four_thirds . "s|" . $four_thirds,

	"boot vibrations (static)" => $four_thirds . "s|" . $four_thirds,
	"rear L bridge (neck down)" => $four_thirds . "s|" . $four_thirds,

	"core pushups (static flat body)" => $four_thirds . "s|" . $four_thirds,
	"static pushups (2/3 up and 1/3 down)" => $four_thirds . "s + " . $four_thirds . "s|" . $four_thirds * 2,
	//"rear pushes (with widening at half)" => $single . "s + " . $single . "s",
	//"crouching (with balancing)" => $single . "s", // reduced to single bottom exercise
	"widening rear pushes and crouching" => $four_thirds . "s + " . $four_thirds . "s x|" . $four_thirds * 2,
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
				    <?php echo ucfirst(trnslt('total time')) ?> (*<?php echo trim($speed_second_coefficient, "0") ?>): <?php echo date('i:s', $total * $speed_second_coefficient) ?>
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
