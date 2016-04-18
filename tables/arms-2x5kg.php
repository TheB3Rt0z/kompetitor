<?php $grade = 25;Main::addLog("grade value should be an input with submit", 'todo') ?>

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
				<td><?php echo $grade * 2 ?> <?php echo trnslt("rapid-fire punches") ?></td>
				<td><?php echo $grade ?> + <?php echo $grade ?> <?php echo trnslt("biceps") ?></td>
				<td><?php echo $grade * 2 ?> <?php echo trnslt("rapid-fire punches") ?></td>
				<td><?php echo round($grade * 1.333) ?> <?php echo trnslt("vertical pulls") ?></td>
			</tr>
		</tbody>
		<tfoot></tfoot>
	</table>
</fieldset>