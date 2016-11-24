<?php include_once 'head.php' ?>

<?php

global $shorts, $shorts_refs;

if (ob_start()) {
	?>
	<fieldset>
		<table>
			<?php
			foreach ($shorts_refs as $short => $ref) {
				?>
				<tr>
					<td><strong><?php echo $ref ?></strong></td>
					<td><strong><?php echo $short ?></strong></td>
					<td><?php echo $shorts[$short] ?></td>
				</tr>
				<?php
			}
			?>
		</table>
	</fieldset>
	<?php
	if (!$this->is_mobile)
		@file_put_contents('./tables/definitions-list.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}