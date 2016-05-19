<?php
if (($_SESSION['status'] === 0) && Main::hasLogs()) {
	?>
	<div class="content log">
		<div class="body">
			<fieldset>
				<legend><?php echo ucfirst(trnslt('application log')) ?></legend>
				<table>
					<?php
					foreach (Main::getLogs() as $log) {
						?>
						<tr>
							<td><?php echo $log?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</fieldset>
		</div>
	</div>
	<?php
}
?>

<script type="text/javascript">
    jQuery(function() {

	    var form = jQuery('form#main');

	    form.children('#width').val(jQuery(window).width());
	    jQuery(window).resize(function() {
	    	form.children('#width').val(jQuery(window).width());
	    });
    });
</script>