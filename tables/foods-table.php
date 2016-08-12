<?php include_once 'head.php' ?>

<?php $grade = $this->getPost('daily_diet_proposal', 'grade') // default value 20 ?>

<?php Main::addTodo("compile a comprehensive and deteiled table of aliments"); // http://www.duepiu.it/def/valorenutritivo2.html

$aliments = array( // data structure qty | unit | kcals | body-unit
	1 => array(
		'carbohydrates' => array(
			'crispbread' => "2|pieces|70",
			'small fruit' => "1|piece",
			'fruit juice' => "200|ml",
		),
		'proteins' => array(
			'plain jogurt' => "1|cup",
			'jogurt plus' => "1|small cup",
			'dried fruit' => "1|fist",
		),
		'minerals-fibers' => array(
			'vegetables' => "1|portion",
		),
	),
	2 => array(
		'carbohydrates' => array(
			'bread' => "1|slice",
			'fruit' => "1|piece",
			'fruit juice' => "400|ml",
			'beer' => "1|bottle",
		),
		'proteins' => array(
			'plain jogurt' => "1|big cup",
			'jogurt plus' => "1|cup",
			'fish' => "1|portion",
		),
		'minerals-fibers' => array(
			'vegetables' => "2|portions",
		),
	),
	3 => array(
		'carbohydrates' => array(
			'coffee-milk-müsli' => "1|big cup",
			'sandwich' => "1|piece",
			'pasta' => "1|portion",
			'small dessert' => "1|portion",
		),
		'proteins' => array(
			'plain jogurt' => "500|ml",
			'jogurt plus' => "1|big cup",
			'cheese' => "1|portion",
			'flesh' => "1|portion",
			'salmon' => '100|g',
		),
		'minerals-fibers' => array(
			'vegetables' => "3|portions",
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