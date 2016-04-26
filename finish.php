<?php Main::addLog("add php checks for an 'intelligent' form reloading, not only \$_POST based", 'todo'); define('APPLICATION_LOG', Main::hasLogs() ? serialize(Main::getLogs()) : false) ?>

<?php
if (APPLICATION_LOG) {
	?>
	<div class="content log">
		<div class="body">
			<fieldset>
				<legend><?php echo ucfirst(trnslt('application log')) ?></legend>
				<table>
					<?php
					foreach (unserialize(APPLICATION_LOG) as $log) {
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

	    <?php if (empty($_POST)) echo "form.submit();" ?>
    });
</script>