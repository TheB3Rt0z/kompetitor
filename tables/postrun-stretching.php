<?php $grade = $main->getPost('postrun_stretching', 'grade') // default value 11 ?>

<?php include_once 'head.php' ?>

<?php

$exercises = array(
	"polpacci all'albero (inizio variabile, finale molleggiato)" => $grade * 5 . " " . trnslt('sincroni') . " x",
	"tirate verticali a 3/4 di altezza (mani sulle ginocchia)" => $grade * 3 . " " . trnslt('sincroni') . " x",
	"tirate all'albero (con movimentazione del piede anteriore)" => $grade * 3 . " + " . $grade * 3 . " x",
	"tirate verticali (in progressione, finale movimentato)" => $grade * 5 . " " . trnslt('sincroni') . " x",
	"ginocchia al petto (gamba DX, con rotazione del piede)" => $grade * 3 . " + " . $grade * 3 . " x",
	"ginocchia al petto (gamba SX, con rotazione del piede)" => $grade * 3 . " + " . $grade * 3 . " x",
	"tirate posteriori e laterali (gamba DX, con torsioni fisse)" => $grade * 3 . " + " . $grade * 3 . " x",
	"tirate posteriori e laterali (gamba SX, con torsioni fisse)" => $grade * 3 . " + " . $grade * 3 . " x",
	"tirate alla sbarra (inizio variabile, finale molleggiato)" => $grade * 3 . " + " . $grade * 3 . " x",
	"tirate superiori alla panchina alta (con corpo rigido)" => $grade * 5 . " " . trnslt('sincroni') . " x",
	"tirate inferiori alla panchina bassa (con corpo rigido)" => $grade * 4 . " " . trnslt('sincroni') . " x",
	"tirate verticali (inizio variabile, finale molleggiante)" => $grade * 3 . " " . trnslt('sincroni') . " x",
	"anti-piriforme (gamba DX, posizione fissa su panchina)" => $grade * 3 . " + " . $grade * 3 . " x",
	"anti-piriforme (gamba SX, posizione fissa su panchina)" => $grade * 3 . " + " . $grade * 3 . " x",
	"tirate in accovacciamento (variabile, con dondolamento)" => $grade * 3 . " " . trnslt('sincroni') . " x",
);

if (ob_start()) {
	?>
	<fieldset>
<legend>CATASTROPHE! Da riordinare e tradurre..</legend>
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