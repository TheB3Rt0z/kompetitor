<?php $exercises = array(); $grade = 25; Main::addLog("grade value should be an input with submit", 'todo') ?>

<?php
if (ob_start()) {
	?>
	<fieldset>
		<legend><?php echo ucfirst(trnslt("warming-up")) ?>: <?php echo $grade * 4 ?> <?php echo trnslt("rapid-fire punches") ?> + <?php echo $grade * 3 ?> <?php echo trnslt("elbow rolls") ?></legend>
		<table>
			<thead>
				<tr>
					<th colspan="2"><?php echo trnslt("single-arm exercises") ?></th>
					<th colspan="2"><?php echo trnslt("double-arm exercises") ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="a-left"><input type="checkbox" /> <?php echo $grade * 2 ?> <?php echo trnslt("rapid-fire punches") ?></td>
					<td class="a-left"><input type="checkbox" /> <?php echo $grade ?> + <?php echo $grade ?> <?php echo trnslt("biceps") ?></td>
					<td class="a-left"><input type="checkbox" /> <?php echo $grade * 2 ?> <?php echo trnslt("rapid-fire punches") ?></td>
					<td class="a-left"><input type="checkbox" /> <?php echo round($grade * 1.333) ?> <?php echo trnslt("vertical pulls") ?></td>
				</tr>
			</tbody>
			<tfoot></tfoot>
		</table>
	</fieldset>
	<?php
	file_put_contents('tables/arms-2x5kg.htm', ob_get_contents());
	ob_end_flush();
}
?>