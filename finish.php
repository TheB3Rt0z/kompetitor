<?php define('APPLICATION_LOG', Main::hasLogs() ? serialize(Main::getLogs()) : false) ?>

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