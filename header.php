		<header>
			<div>
				<table>
					<thead>
						<tr>
							<th class="a-left title">
								<img src="statics/icon-32x32.png" alt="<?php echo APPLICATION_NAME ?>" class="logo" />
								&nbsp;<?php echo APPLICATION_TITLE ?>&nbsp;
							</th>
							<th class="a-right">
								<?php button() ?>
								<nav class="invisible-on-tablet">
									<?php
									if ($main->isLogged())
										echo '<p class="invisible-on-mobile" style="float:left">' . ucfirst(trnslt('hallo')) . ' ' . $_SESSION['username'] /*. ' (' . $_SESSION['id'] . ')*/ . '!</p>';
									?>
									<?php button('close') ?>
									<?php //button('print') ?>
									<?php if ($main->isLogged()) button('settings') ?>
									<?php button('credits', APPLICATION_CREDITS) ?>
								</nav>
							</th>
						</tr>
						<tr>
							<th colspan="2"><hr /></th>
						</tr>
					</thead>
				</table>
				<fieldset class="content settings">
					<table>
						<tr>
							<td class="a-left"><?php echo trnslt('E-Mail') ?>:</td>
							<td class="a-center"><input type="text" name="settings[email]" value="<?php echo $main->getPost('settings', 'email') ?>" /></td>
							<?php if ($main->is_mobile) echo '<td class="a-right">' . submit('update') . '</td></tr><tr>' ?>
							<td class="a-left"><?php echo trnslt('Username') ?>:</td>
							<td class="a-center" colspan="2"><input type="text" name="settings[username]" value="<?php echo $main->getPost('settings', 'username') ?>" readonly disabled /></td>
							<?php if ($main->is_mobile) echo '</tr><tr>' ?>
							<td class="a-left"><?php echo trnslt('Password') ?>:</td>
							<td class="a-center" colspan="2"><input type="text" name="settings[password]" value="<?php echo $main->getPost('settings', 'password') ?>" readonly disabled /></td>
							<?php if (!$main->is_mobile) echo '<td class="a-right">' . submit() . '</td>' ?>
						</tr>
					</table>
				</fieldset>
			</div>
		</header>