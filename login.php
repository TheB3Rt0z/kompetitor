			<div class="content login a-center">
				<fieldset>
					<legend><?php echo strtoupper(trnslt('login')) ?></legend>
					<img src="statics/icon-512x512.png" alt="<?php echo APPLICATION_TITLE ?>" />
					<br />
					<div>
						<?php echo strtoupper(trnslt('username')) ?>:
						<input type="text" name="username" value="<?php echo $main->getPost('username') ?>" />
					</div>
					<div>
						<?php echo strtoupper(trnslt('password')) ?>:
						<input type="password" name="password" value="<?php echo $main->getPost('password') ?>" />
					</div>
				</fieldset>
			</div>