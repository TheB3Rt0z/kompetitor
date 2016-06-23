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

					<div class="content width-50 icon exercises closed">
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

					<div class="content width-50 icon exercises closed">
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

					<div class="content width-67 icon exercises closed">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('post-run stretching')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<?php include 'tables/postrun-stretching.php' ?>
						</div>
					</div>

					<div class="content width-33 icon exercises closed">
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

					<div class="content icon exercises closedd">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('morning serie')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<?php include 'tables/morning-serie.php' ?>
						</div>
					</div>

					<div class="separator"></div>

					<div class="content width-67 icon arms-exercises closed">
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

					<div class="content width-33 icon bertoz-calculator closed">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('Bertoz calculator')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<fieldset>
								<legend><?php echo ucfirst(trnslt('average speed calculation')) ?> (in min/km)</legend>
								<table>
									<td class="a-left"><?php echo ucfirst(trnslt('time')) ?>:</td>
									<td class="a-right"><input type="text" name="bertoz_calculator[time]" value="<?php echo $main->getPost('bertoz_calculator', 'time') ?>" title="<?php echo trnslt('format: (h)h:mm:ss') ?>" /></td>
									<td class="a-left"><?php echo ucfirst(trnslt('distance')) ?>:</td>
									<td class="a-right"><input type="text" name="bertoz_calculator[distance]" value="<?php echo $main->getPost('bertoz_calculator', 'distance') ?>" title="<?php echo trnslt('format: ?(.?) (in km)') ?>" /></td>
									<td class="a-left"><?php echo ucfirst(trnslt('speed')) ?>:</td>
									<td class="a-right"><input type="text" name="bertoz_calculator[speed]" value="<?php echo $main->getPost('bertoz_calculator', 'speed') ?>" readonly disabled /></td>
								</table>
							</fieldset>
						</div>
					</div>

					<div class="separator"></div>

					<div class="content width-40 icon riegel-calculator closed">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('Riegel\'s calculator')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<?php include 'tables/riegel-calculator.php' ?>
						</div>
					</div>

					<div class="content width-30 icon tables-and-appendices closed">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucwords(trnslt('tables & appendices')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<fieldset>
								<table>
									<thead>
										<tr>
											<th>
												[T]
											</th>
											<th>
												[LIST]
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<strong>1/2</strong>
											</td>
											<td>
												tazza jogurt bianco | tazzina jogurt plus | 2 Knäckerbrot | 200ml di succo | porzione di verdura | frutto piccolo | 1 pugno chiuso di frutta secca (ceci)
											</td>
										</tr>
										<tr>
											<td>
												<strong>(1)</strong>
											</td>
											<td>
												tazzona jogurt bianco | tazza jogurt plus | 1 fetta di pane | 400ml di succo | piatto di verdura | 1 frutto normale | 1 birra da 33/50cl
											</td>
										</tr>
										<tr>
											<td>
												<strong>1.5</strong>
											</td>
											<td>
												caffélattemüsli | tazzona jogurt plus | klappstulle | porzione di pasta | ciccia o pesce | porzione di formaggio
											</td>
										</tr>
										<tr>
											<td>
												<strong>(2)</strong>
											</td>
											<td>
												dolce piccolo | kebap o similia | colazione alla tedesca | kaffee-kuchen | skifezze varie
											</td>
										</tr>
									</tbody>
								</table>
							</fieldset>
						</div>
					</div>

					<div class="content width-30 icon bibliography closed">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('technical bibliography')) ?>
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
<?php } ?>
					<div class="separator"></div>

					<div class="content icon definitions-list closed">
						<span class="icon"></span>
						<div class="header">
							<?php echo ucfirst(trnslt('definitions list')) ?>
							<span>&#8679;</span>
						</div>
						<br />
						<br />
						<div class="body">
							<br />
							<fieldset>
								<table>
									<?php
									foreach ($shorts_refs as $short => $ref) {
										?>
										<tr>
											<td><strong><?php echo $ref ?></strong></td>
											<td><strong><?php echo $short ?></strong></td>
											<td><?php echo $shorts[$short] ?></td>
										</tr>
										<?php
									}
									?>
								</table>
							</fieldset>
						</div>
					</div>
				</div>
			</article>
			<aside></aside>
		</section>