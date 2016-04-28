<?php require_once 'init.php'; include_once('header.php') ?>

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
							<?php include 'tables/personal-data.php' ?>
							<br />
							<?php include 'tables/daily-weighing.php' ?>
							<br />
							<?php include 'tables/distances-records.php' ?>
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
							<?php include 'tables/physiological-data.php' ?>
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
					<!--<div class="separator">&nbsp;<br />&nbsp;</div>-->
				</div>
			</article>

			<aside></aside>
		</section>
		</form>

<?php include_once 'footer.php'; include_once 'finish.php' ?>