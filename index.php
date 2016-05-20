<?php require_once 'init.php'; include_once('head.php') ?>

	<body>
		<form id="main" method="post">
		<input type="hidden" name="width" id="width" />
		<?php include_once('header.php') ?>
		<section>
			<article>
				<div>
					<!-- place for logs (admin only) -->

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

					<div class="content icon running-trainings">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('running trainings')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<p>
								[...] in PROGRESS
							</p>
						</div>
					</div>
<?php if ($_SESSION['status'] <= 1) { // only advanced users ?>
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
								<strong>1/2</strong>:
								tazza jogurt bianco | tazzina jogurt plus | 2 Knäckerbrot | 200ml di succo | porzione di verdura | frutto piccolo | 1 pugno chiuso di frutta secca (ceci)<br />
								<strong>(1)</strong>:
								tazzona jogurt bianco | tazza jogurt plus | 1 fetta di pane | 400ml di succo | piatto di verdura | 1 frutto normale | 1 birra da 33/50cl<br />
								<strong>1&1/2</strong>:
								caffélattemüsli | tazzona jogurt plus | klappstulle | porzione di pasta | ciccia o pesce | porzione di formaggio<br />
								<strong>(2!!)</strong>:
								dolce piccolo | kebap o similia | colazione alla tedesca | kaffee-kuchen | skifezze varie<br />
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
				</div>
			</article>
<?php } ?>
			<aside></aside>
		</section>
		</form>

<?php include_once 'footer.php'; include_once 'finish.php' ?>