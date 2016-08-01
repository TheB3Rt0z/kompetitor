<?php include_once 'head.php' ?>

<?php $grade = $main->getPost('morning_serie', 'grade') // default value 25 ?>

<?php

$exercises = array(
	"agile pushups (2 steps in 2s)" => $grade . " x",
	"straight abdominals (var. legs)" => $grade * 3 . " x",
	"leg rollovers (+ iperextension)" => $grade * 2 . "s + " . $grade . "s",
	"sitting pulls (with straight legs)" => $grade * 2 . "s",

	"sitting pulls (with crossed legs)" => $grade . "s",
	"frontal concave bridge (static)" => $grade . "s",
	"egg buttocks (static backwards)" => $grade . "s",
	"right-leg anti-piriform (pushing)" => $grade * 2 . "s",

	"agile pushups (---P-P steps in 6s)" => $grade . " x",
	"alternated crunches (crossed legs)" => $grade . " + " . $grade . " x",
	"angles handling (overturned)" => $grade . "s",
	"lumbar pulls (overturned)" => $grade * 2 . "s",

	"static pushups (2/3 up and 1/3 down)" => $grade * 2 . "s + " . $grade . "s",
	"rear pushes (with widening at half)" => $grade . "s + " . $grade . "s",
	"crouching (with balancing)" => $grade . "s",
);

if (ob_start()) {
	?>
	<fieldset>
		<table>
			<tr>
				<?php
				$count = 0;
				$cols = $main->is_mobile ? 2 : 4;
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
					if (is_int($count / $cols))
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
	if (!$main->is_mobile)
		file_put_contents('./tables/morning-serie.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}