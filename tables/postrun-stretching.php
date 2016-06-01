<?php include_once 'head.php' ?>

<?php $grade = $main->getPost('postrun_stretching', 'grade') // default value 11 ?>

<?php

$exercises = array(
	"three calves (variable starting, springy final)" => $grade * 5 . " " . trnslt('synchronous') . " x",
	"vertical pulls to 3/4 of height (hands on knees)" => $grade * 3 . " " . trnslt('synchronous') . " x",
	"tree pulls (with forefoot movimentation)" => $grade * 3 . " + " . $grade * 3 . " x",
	"vertical pulls (in progression, enlivened final)" => $grade * 5 . " " . trnslt('synchronous') . " x",
	"knee to chest (right leg, with rotation of the foot)" => $grade * 3 . " + " . $grade * 3 . " x",
	"knee to chest (left leg, with rotation of the foot)" => $grade * 3 . " + " . $grade * 3 . " x",
	"rear and lateral pulls (right leg, with fixed twists)" => $grade * 3 . " + " . $grade * 3 . " x",
	"rear and lateral pulls (left leg, with fixed twists)" => $grade * 3 . " + " . $grade * 3 . " x",
	"bar pulls (variable starting, springy final)" => $grade * 3 . " + " . $grade * 3 . " x",
		"tirate superiori alla panchina alta (con corpo rigido)" => $grade * 5 . " " . trnslt('synchronous') . " x",
		"tirate inferiori alla panchina bassa (con corpo rigido)" => $grade * 4 . " " . trnslt('synchronous') . " x",
		"tirate verticali (inizio variabile, finale molleggiante)" => $grade * 3 . " " . trnslt('synchronous') . " x",
		"anti-piriforme (gamba DX, posizione fissa su panchina)" => $grade * 3 . " + " . $grade * 3 . " x",
		"anti-piriforme (gamba SX, posizione fissa su panchina)" => $grade * 3 . " + " . $grade * 3 . " x",
		"tirate in accovacciamento (variabile, con dondolamento)" => $grade * 3 . " " . trnslt('synchronous') . " x",
);

if (ob_start()) {
	?>
	<fieldset>
		<table>
			<tr>
				<?php
				$count = 0;
				foreach ($exercises as $key => $value) {
					?>
					<td class="a-left">
						<?php echo $value ?>
						<?php echo trnslt($key) ?>
					</td>
					<?php
					if ($main->is_mobile || is_int((++$count) / 2))
						echo '</tr><tr>';
				}
				?>
				<td class="a-right">
				    <?php echo ucfirst(trnslt('grade')) ?>:
					<input type="number" name="postrun_stretching[grade]" min="11" max="55" value="<?php echo $grade ?>" />
					<?php if (!$main->is_mobile) echo submit() ?>
				</td>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$main->is_mobile && ($_SERVER['HTTP_HOST'] == 'localhost'))
		file_put_contents('tables/postrun-stretching.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}