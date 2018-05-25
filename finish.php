<?php
if (($main->isLogged() && $_SESSION['status'] == 0) && Main::hasLogs()) {
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

<div id="loader"><img src="/statics/loader-120x120.gif" /></div>

<script type="text/javascript">
    jQuery(function()
    {
	    var form = jQuery('form#main')/*,
	        footer_container = jQuery('.footer'),
	        garmin_iframe = jQuery('.footer > iframe')*/;

	    form.on('submit', function() {
	    	jQuery('#loader').fadeIn(125);
	    });

	    jQuery(window).scrollTop(form.children('#v-pos').val());

	    form.children('#width').val(jQuery(window).width());
	    jQuery(window).resize(function() {
	    	form.children('#width').val(jQuery(window).width());
	    });

	    form.children('#v-pos').val(jQuery(window).scrollTop());
	    jQuery(window).scroll(function() {
	    	form.children('#v-pos').val(jQuery(window).scrollTop());
	    });

	    /*garmin_iframe.on('load', function ()
	    {
		    jQuery(this).width(footer_container.width());
	    });*/

	    <?php
	    if ($main->getPost('width') == BOH)
	    {
	    	echo "form.submit();";
	    }
	    ?>
    });
</script>
