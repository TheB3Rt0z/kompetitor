<?php require_once 'init.php' ?><!DOCTYPE html>
<html>
	<head>
		<title><?php echo APPLICATION_TITLE ?></title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" href="statics/icon-32x32.png" type="image/png" />
        <link rel="shortcut icon" href="statics/icon-32x32.png" type="image/png" />
		<link rel="stylesheet" type="text/css" href="statics/style.css" />
		<link rel="stylesheet" type="text/css" href="statics/rwd.css" />
		<script type="text/javascript" src="includes/jquery.min.js" charset="UTF-8"></script>
		<script type="text/javascript" src="statics/scripts.js" charset="UTF-8"></script>
	</head>
	<body>
		<form id="main" method="post">
		<input type="hidden" name="width" id="width" />
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
					<!-- place for logs -->
					<div class="content width-60 icon personal-data">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('personal data')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<fieldset>
								<table>
									<tr>
										<td class="a-left"><?php echo ucfirst(trnslt('first name')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[first_name]" value="<?php echo $main->getPost('personal_data', 'first_name') ?>" /></td>
										<?php if ($main->is_mobile) echo '</tr><tr>' ?>
										<td class="a-left"><?php echo ucfirst(trnslt('last name')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[last_name]" value="<?php echo $main->getPost('personal_data', 'last_name') ?>" /></td>
										<?php if ($main->is_mobile) echo '</tr><tr>' ?>
										<td class="a-left"><?php echo ucfirst(trnslt('date of birth')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[date_of_birth]" value="<?php echo $main->getPost('personal_data', 'date_of_birth') ?>" /></td>
									</tr>
									<tr>
										<td class="a-left"><?php echo ucfirst(trnslt('height')) ?> (in cm):</td>
										<td class="a-right"><input type="text" name="personal_data[height]" value="<?php echo $main->getPost('personal_data', 'height') ?>" /></td>
										<?php if ($main->is_mobile) echo '</tr><tr>' ?>
										<td class="a-left"><?php echo ucfirst(trnslt('foot length FL')) ?> (in cm):</td>
										<td class="a-right"><input type="text" name="personal_data[foot_length]" value="<?php echo $main->getPost('personal_data', 'foot_length') ?>" /></td>
										<?php if ($main->is_mobile) echo '</tr><tr>' ?>
										<td class="a-right" colspan="2"><?php submit() ?></td>
									</tr>
								</table>
							</fieldset>
							<br />
							<fieldset>
								<legend><?php echo ucfirst(trnslt('daily weighing')) ?> (in kg)</legend>
								<table>
									<tr>
										<td class="a-left"><?php echo ucfirst(trnslt('mon')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][mon]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'mon') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('tue')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][tue]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'tue') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('wed')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][wed]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'wed') ?>" /></td>
									    <?php if ($main->is_mobile) echo '</tr><tr>' ?>
										<td class="a-left"><?php echo ucfirst(trnslt('thu')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][thu]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'thu') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('fri')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][fri]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'fri') ?>" /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('sat')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][sat]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'sat') ?>" /></td>
										<?php if ($main->is_mobile) echo '</tr><tr>' ?>
										<td class="a-left"><?php echo ucfirst(trnslt('sun')) ?>:</td>
										<td class="a-right"><input type="text" name="personal_data[daily_weighing][sun]" value="<?php echo $main->getPost('personal_data', 'daily_weighing', 'sun') ?>" /></td>
										<td class="a-right" colspan="4"><?php submit() ?></td>
									</tr>
								</table>
							</fieldset>
							<br />
							<fieldset>
								<legend><?php echo ucwords(trnslt('distances & records')) ?></legend>
								<table>
									<thead>
										<tr>
											<th class="a-left"><?php echo ucfirst(trnslt("distance")) ?></th>
											<th><?php echo ucwords(trnslt($main->is_mobile ? "records" : "personal best")) ?></th>
											<th><?php echo ucfirst(trnslt("step")) ?></th>
											<th><?php echo ucfirst(trnslt("speed")) ?></th>
											<?php
											if (!$main->is_mobile) {
												?>
												<th><?php echo ucwords(trnslt("most recent personal")) ?></th>
												<th><?php echo ucfirst(trnslt("step")) ?></th>
												<th><?php echo ucfirst(trnslt("speed")) ?></th>
												<?php
											}
											?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="a-left"><?php echo trnslt('5km') ?>:<input type="hidden" name="distances_and_records[5km][distance]" value="5" /></td>
											<td class="a-right"><input type="text" name="distances_and_records[5km][pb]" value="<?php echo $main->getPost('distances_and_records', '5km', 'pb') ?>" /></td>
											<td class="a-right"><input type="text" name="distances_and_records[5km][step]" value="<?php echo $main->getPost('distances_and_records', '5km', 'step') ?>" readonly disabled /></td>
											<td class="a-right"><input type="text" name="distances_and_records[5km][speed]" value="<?php echo $main->getPost('distances_and_records', '5km', 'speed') ?>" readonly disabled /></td>
											<?php if ($main->is_mobile) echo '</tr><tr><td>' . trnslt('MRP') . '-' . trnslt('5km') . ':</td>' ?>
											<td class="a-right"><input type="text" name="distances_and_records[5km][last_pb]" value="<?php echo $main->getPost('distances_and_records', '5km', 'last_pb') ?>" /></td>
											<td class="a-right"><input type="text" name="distances_and_records[5km][last_step]" value="<?php echo $main->getPost('distances_and_records', '5km', 'last_step') ?>" readonly disabled /></td>
											<td class="a-right"><input type="text" name="distances_and_records[5km][last_speed]" value="<?php echo $main->getPost('distances_and_records', '5km', 'last_speed') ?>" readonly disabled /></td>
										</tr>
									</tbody>
								</table>
							</fieldset>
						</div>
					</div>
					<div class="content width-40 icon processed-physiological-data">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('processed physiological data')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<fieldset>
								<table>
									<tr>
										<td class="a-left"><?php echo ucfirst(trnslt('age')) ?>:</td>
										<td class="a-right"><input type="text" name="processed_physiological_data[age]" value="<?php echo $main->getPost('processed_physiological_data', 'age') ?>" readonly disabled /></td>
										<td class="a-left"><?php echo ucfirst(trnslt('mediated weekly weight')) ?> (in kg):</td>
										<td class="a-right"><input type="text" name="processed_physiological_data[mediated_weekly_weight]" value="<?php echo $main->getPost('processed_physiological_data', 'mediated_weekly_weight') ?>" readonly disabled /></td>
									</tr>
									<tr>
										<td class="a-left"><?php echo trnslt('BMI') ?>:</td>
										<td class="a-right"><input type="text" name="processed_physiological_data[bmi]" value="<?php echo $main->getPost('processed_physiological_data', 'bmi') ?>" readonly disabled /></td>
									</tr>
								</table>
							</fieldset>
							<br />
							<fieldset>
								<legend><?php echo ucfirst(trnslt('shoes size')) ?></legend>
								<table>
									<tr>
										<td class="a-left"><?php echo strtoupper(trnslt('usa')) ?>:</td>
										<td class="a-right"><input type="text" name="processed_physiological_data[shoes_size][usa]" value="<?php echo $main->getPost('processed_physiological_data', 'shoes_size', 'usa') ?>" readonly disabled /></td>
										<td class="a-left"><?php echo strtoupper(trnslt('uk')) ?>:</td>
										<td class="a-right"><input type="text" name="processed_physiological_data[shoes_size][uk]" value="<?php echo $main->getPost('processed_physiological_data', 'shoes_size', 'uk') ?>" readonly disabled /></td>
										<td class="a-left"><?php echo strtoupper(trnslt('eu')) ?>:</td>
										<td class="a-right"><input type="text" name="processed_physiological_data[shoes_size][eu]" value="<?php echo $main->getPost('processed_physiological_data', 'shoes_size', 'eu') ?>" readonly disabled /></td>
									</tr>
								</table>
							</fieldset>
						</div>
					</div>
					<div class="separator"></div>
					<div class="content width-50 icon exercises">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('stretching exercises')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<p>
								Da codificare e integrare con immagini e links, vedi file ideas.txt
							</p>
						</div>
					</div>
					<div class="content width-50 icon exercises">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('core exercises')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<p>
								Anche qui, tutto di decidere..
							</p>
						</div>
					</div>
					<div class="separator"></div>
					<div class="content width-50 icon exercises">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('post-run stretching')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<p>
								[...]
							</p>
						</div>
					</div>
					<div class="content width-50 icon exercises">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('toning and stability')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<p>
								Anche qui, tutto di decidere..
							</p>
						</div>
					</div>
					<div class="separator"></div>
					<div class="content width-67 icon arms-exercises">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('exercises for the arms')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<?php include 'tables/arms-2x5kg.php' ?>
						</div>
					</div>
					<div class="content width-33 icon bertoz-calculator">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('Bertoz calculator')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<p>
								Spazio alla creatività!
							</p>
						</div>
					</div>
					<div class="separator"></div>
					<div class="content width-33 icon riegel-calculator">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('Riegel calculator')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<p>
								<?php echo ucfirst(trnslt('using the RsF to calculate expected time on a given distance')) ?>
							</p>
						</div>
					</div>
					<div class="content width-33 icon tables-and-appendices">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucwords(trnslt('tables & appendices')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<p>
								- tabella alimenti con valutazione quantitá<br />
							</p>
						</div>
					</div>
					<div class="content width-33 icon bibliography">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('bibliography')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<p>
								<?php echo str_replace('\n', '<br />', APPLICATION_BIBLIOGRAPHY) ?>
							</p>
						</div>
					</div>
					<div class="separator">&nbsp;<br />&nbsp;</div>
				</div>
			</article>
			<aside></aside>
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
</html><?php include_once 'finish.php' ?>