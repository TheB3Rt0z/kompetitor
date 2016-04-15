<?php require_once 'init.php' ?><!DOCTYPE html>
<html>
	<head>
		<title><?php echo APPLICATION_TITLE ?></title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="statics/icon-32x32.png" type="image/x-icon" />
        <link rel="shortcut icon" href="statics/icon-32x32.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" type="text/css" href="rwd.css" />
		<script type="text/javascript" src="includes/jquery.min.js" charset="UTF-8"></script>
		<script type="text/javascript" src="scripts.js" charset="UTF-8"></script>
	</head>
	<body>
		<form method="post">
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
									<?php button('close') ?>
									<?php button('print') ?>
									<?php button('settings') ?>
									<?php button('credits', APPLICATION_CREDITS) ?>
								</nav>
							</th>
						</tr>
						<tr>
							<th colspan="2"><hr /></th>
						</tr>
					</thead>
				</table>
			</div>
		</header>
		<section>
			<article>
				<div>
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
					<div class="content width-50">
						<div class="header">
							<?php echo ucfirst(trnslt('personal data')) ?>
							<span>&#8679;</span>
						</div>
						<div class="body">
							<br />
							<fieldset>
								<table>
									<tr>
										<td class="a-left"><?php echo ucfirst(trnslt('first name')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[first_name]" value="<?php echo $main->getPost('personal_data', 'first_name') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('last name')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[last_name]" value="<?php echo $main->getPost('personal_data', 'last_name') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('date of birth')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[date_of_birth]" value="<?php echo $main->getPost('personal_data', 'date_of_birth') ?>" /></td>
									</tr>
									<tr>
										<td class="a-left"><?php echo ucfirst(trnslt('height')) ?> (cm):</td>
										<td class="a-right"><input type="text" name="personal_data[height]" /></td>
									</tr>
								</table>
							</fieldset>
							<br />
							<fieldset>
								<legend><?php echo ucfirst(trnslt('daily weighing')) ?> (kg)</legend>
								<table>
									<tr>
										<td class="a-left"><?php echo ucfirst(trnslt('mon')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][mon]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'mon') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('tue')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][tue]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'tue') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('wed')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][wed]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'wed') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('thu')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][thu]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'thu') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('fri')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][fri]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'fri') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('sat')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][sat]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'sat') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('sun')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][sun]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'sun') ?>" /></td>
									</tr>
								</table>
							</fieldset>
							<br />
							<?php submit() ?>
						</div>
					</div>
					<div class="content width-50">
						<div class="header">
							<?php echo ucfirst(trnslt('processed physiological data')) ?>
							<span>&#8679;</span>
						</div>
						<div class="body">
							<br />
							<fieldset>
								<table>
									<tr>
										<td class="a-left"><?php echo ucfirst(trnslt('age')) ?>:</td>
										<td class="a-right"><input type="text" name="processed_physiological_data[age]" value="<?php echo $main->getPost('processed_physiological_data', 'age') ?>" readonly disabled /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('mediated weekly weight')) ?> (kg):</td>
										<td class="a-right"><input type="text" name="processed_physiological_data[mediated_weekly_weight]" value="<?php echo $main->getPost('processed_physiological_data', 'mediated_weekly_weight') ?>" readonly disabled /></td>
									</tr>
								</table>
							</fieldset>
						</div>
					</div>
					<div class="separator"></div>
					<div class="content width-50">
						<div class="header">
							<?php echo ucfirst(trnslt('stretching exercises')) ?>
							<span>&#8679;</span>
						</div>
						<div class="body">
							<br />
							<p>
								Da codificare e integrare con immagini e links, vedi file ideas.txt
							</p>
						</div>
					</div>
					<div class="content width-50">
						<div class="header">
							<?php echo ucfirst(trnslt('core exercises')) ?>
							<span>&#8679;</span>
						</div>
						<div class="body">
							<br />
							<p>
								Anche qui, tutto di decidere..
							</p>
						</div>
					</div>
					<div class="separator"></div>
					<div class="content width-50">
						<div class="header">
							<?php echo ucfirst(trnslt('exercises for the arms')) ?>
							<span>&#8679;</span>
						</div>
						<div class="body">
							<br />
							<p>
								Da compilare a partire dalle note e il foglietto a casa..
							</p>
						</div>
					</div>
					<div class="content width-50">
						<div class="header">
							<?php echo ucfirst(trnslt('Bertoz calculator')) ?>
							<span>&#8679;</span>
						</div>
						<div class="body">
							<br />
							<p>
								Spazio alla creatività!
							</p>
						</div>
					</div>
					<div class="separator"></div>
				</div>
			</article>
			<aside>
				<div>
					<div class="content width-33">
						<div class="header">
							<?php echo ucfirst(trnslt('Riegel calculator')) ?>
							<span>&#8679;</span>
						</div>
						<div class="body">
							<br />
							<p>
								<?php echo ucfirst(trnslt('using the RsF to calculate expected time on a given distance')) ?>
							</p>
						</div>
					</div>
					<div class="content width-33">
						<div class="header">
							<?php echo ucwords(trnslt('tables & appendices')) ?>
							<span>&#8679;</span>
						</div>
						<div class="body">
							<br />
							<p>
								- tabella alimenti con valutazione quantitá<br />

							</p>
						</div>
					</div>
					<div class="content width-33">
						<div class="header">
							<?php echo ucfirst(trnslt('bibliography')) ?>
							<span>&#8679;</span>
						</div>
						<div class="body">
							<br />
							<p>
								<?php echo str_replace('\n', '<br />', APPLICATION_BIBLIOGRAPHY) ?>
							</p>
						</div>
					</div>
					<div class="separator">&nbsp;<br />&nbsp;</div>
				</div>
			</aside>
		</section>
		<footer>
			<div>
				<table>
					<tfoot>
						<tr>
							<td colspan="3"><hr /></td>
						</tr>
						<tr>
							<td class="a-left">REPORT</td>
							<td class="a-left debug">
								<pre>POST: <?php var_dump($main->post) ?></pre>
							</td>
							<td class="a-right">EXPORT</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</footer>
		</form>
	</body>
</html>