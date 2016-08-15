<?php include_once 'head.php' ?>

<?php $speed_second_coefficient = .666; $grade = $this->getPost('morning_serie', 'grade') // default value 25 ?>

<?php

$exercises = array(
	"sun salutation (S chain extension)" => $grade . "s|" . $grade,
	"agile pushups (2 steps in 2s)" => $grade . " x|" . $grade * 2,
	"straight abdominals (var. legs)" => $grade * 3 . " x|" . $grade * 3 * 5,
	"leg rollovers (+ iperextension)" => $grade * 2 . "s + " . $grade . "s|" . $grade * 3,
		
	"sitting pulls (with straight legs)" => $grade * 2 . "s|" . $grade * 2,
	"sitting pulls (with crossed legs)" => $grade . "s|" . $grade,
	"frontal concave bridge (static)" => $grade . "s|" . $grade,
	"egg buttocks (static backwards)" => $grade . "s|" . $grade,
		
	"right-leg anti-piriform (pushing)" => $grade * 2 . "s|" . $grade * 2,
	"agile pushups (---P-P steps in 5s)" => $grade . " x|" . $grade * 5,
	"alternated crunches (crossed legs)" => $grade . " + " . $grade . " x|" . $grade * 2 * 5,
	"angles handling (overturned)" => $grade . "s|" . $grade,
		
	"lumbar pulls (overturned)" => $grade * 2 . "s|" . $grade * 2,
	"lumbar pulls (with crossed legs)" => $grade . "s|" . $grade,
	"boot vibrations (static)" => $grade . "s|" . $grade,
	"rear L bridge (neck down)" => $grade . "s|" . $grade,

	"core pushups (static flat body)" => $grade . "s|" . $grade,
	"static pushups (2/3 up and 1/3 down)" => $grade * 2 . "s + " . $grade . "s|" . $grade * 3,
	//"rear pushes (with widening at half)" => $grade . "s + " . $grade . "s",
	//"crouching (with balancing)" => $grade . "s",
	"rear pushes and crouching" => $grade . " + " . $grade . " x|" . $grade * 2,
);

if (ob_start()) {
	?>
	<fieldset>
		<table>
			<tr>
				<?php
				$count = 0;
				$total = 0;
				$cols = $this->is_mobile ? 2 : 4;
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
				    <?php echo ucfirst(trnslt('total')) ?>: <?php echo date('i:s', $total * $speed_second_coefficient) ?>
				    |
					<?php echo ucfirst(trnslt('grade')) ?>:
					<input type="number" name="morning_serie[grade]" min="10" max="50" value="<?php echo $grade ?>" />
					<?php if (!$this->is_mobile) echo submit() ?>
				</td>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$this->is_mobile)
		file_put_contents('./tables/morning-serie.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}