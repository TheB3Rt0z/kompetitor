<?php include_once 'head.php' ?>

<?php $grade = $this->getPost('daily_diet_proposal', 'grade') // default value 20 ?>

<?php Main::addTodo("compile a comprehensive and detailed table of aliments"); // http://www.duepiu.it/def/valorenutritivo2.html

$aliments = array( // data structure qty | unit | kcals | body-unit (if portion specified)
	1 => array(
		'carbohydrates' => array(
			'crispbread' => 2 . "|pieces|" . (350 / (100/20)), // 10g
			'small fruit' => 3 . "|pieces|" . (40 / (100/150)), // 50g
			'banana' => 1 . "|piece|" . (80 / (100/175)), // 175g average
			'fruit juice' => 200 . "|ml|" . (50 / (100/200)), // 20cl
		),
		'proteins' => array(
			'plain jogurt' => 1 . "|cup|" . (60 / (100/125)), // 125g,
			'jogurt plus' => "1|small cup|" . ((60 / (100/125)) + (480 / (100/25)) + (60 / (100/40))), // 125g + 25g + 4cl
			'dried fruit' => "1|fist",
			'salmon' => 100 . '|g|' . (180 / (100/100)), // 1 hand or 1/2 pack
		),
		'minerals-fibers' => array(
			'vegetables' => "1|portion", // hand, 20 kcal x 100g
		),
	),
	2 => array(
		'carbohydrates' => array(
			'bread' => "1|slice",
			'fruit' => "1|piece", // 1 punch
			'fruit juice' => 400 . "|ml|" . (50 / (100/400)), // 40cl
			'beer' => "1|bottle",
		),
		'proteins' => array(
			'plain jogurt' => 1 . "|big cup|" . (60 / (100/250)), // 250g,
			'jogurt plus' => "1|cup|" . ((60 / (100/250)) + (480 / (100/50)) + (60 / (100/70))), // 250g + 50g + 7cl
			'fish' => "1|portion", // 1 hand
		),
		'minerals-fibers' => array(
			'vegetables' => "2|portions", // 2 hands
		),
	),
	3 => array(
		'carbohydrates' => array(
			'muesli + milkcoffee' => "1|big cup|" . ((350 / (100/100)) + (150 / (100/100))), // 100g + 10cl
			'muesli + orange juice' => 1 . "|big cup|" . ((350 / (100/100)) + (50 / (100/100))), // 100g + 10cl
			'sandwich' => "1|piece", // 1 hand
			'pasta' => "1|portion", // 1 punch
			'small dessert' => "1|portion", // 1 punch
		),
		'proteins' => array(
			'plain jogurt' => 500 . "|ml|" . (60 / (100/500)), // 500g
			'jogurt plus' => "1|big cup|" . ((60 / (100/325)) + (480 / (100/75)) + (60 / (100/100))), // 325g + 75g + 10cl
			'cheese' => "1|portion", // 1/2 punch or hand
			'flesh' => "1|portion", // 1 hand
		),
		'minerals-fibers' => array(
			'vegetables' => "3|portions", // 3 hands
		),
	),
);

if (ob_start()) {
	?>
	<fieldset>
		<legend>
			<?php echo ucfirst(trnslt("daily diet proposal")) ?>:
		</legend>
		<table>
			<?php
			if (!$this->is_mobile) {
				?>
				<thead>
					<tr>
						<th></th>
						<th><?php echo trnslt("carbohydrates") ?></th>
						<th><?php echo trnslt("proteins") ?></th>
						<th><?php echo trnslt("minerals & fibers") ?></th>
					</tr>
				</thead>
				<?php
			}
			?>
			<tbody>
				<tr>
					<?php
					$grades = count($aliments);
					foreach ($aliments as $grade => $types) {
						?>
						<tr valign="top">
							<td>
								<?php echo str_repeat('&starf;', $grade) . str_repeat('&star;', $grades - $grade) ?>
								<br />
								(< <?php echo 250 * $grade ?> kcal)
							</td>
							<?php
							foreach ($types as $type => $foods) {
								?>
								<td>
									<?php
									foreach ($foods as $food => $data) { // kcals not used ATM (only for calculation)
										$data = explode("|", $data);
										echo ucfirst(trnslt($food)) . ': '
		                                   . $data[0] . ' ' . trnslt($data[1])
										   . (isset($data[2])
										   	 ? ' x ' . $data[2] . " kcal"
										   	 : '')
										   . '<br />';
											
									}
									?>
								</td>
								<?php 
							}
							?>
						</tr>
						<?php 
					}
					?>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<?php Main::addIdea("add a grade (20) + submit to foods table with automatical day menu calculation! (with persistent checkboxes)");
	if (!$this->is_mobile)
		file_put_contents('./tables/foods-table.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}