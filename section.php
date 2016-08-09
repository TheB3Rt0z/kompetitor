		<section>
			<article>
				<div>
					<!-- place for logs (admin only) -->
					<?php $main->block(60, 'personal-data', ucfirst(trnslt('personal-data'))) ?>
					<?php $main->block(40, 'processed-physiological-data', ucfirst(trnslt('processed physiological data'))) ?>
					<div class="separator"></div>
					<?php $main->block(100, 'running-trainings', ucfirst(trnslt('running trainings'))) ?>
					<?php
					if ($_SESSION['status'] <= 1) { // only advanced users
						?>
						<div class="separator"></div>
						<?php $main->block(100, 'running-samples', ucfirst(trnslt('running samples'))) ?>
						<div class="separator"></div>
						<?php $main->block(50, 'stretching exercises', ucfirst(trnslt('stretching exercises'))) ?>
						<?php $main->block(50, 'core exercises', ucfirst(trnslt('core exercises'))) ?>
						<div class="separator"></div>
						<?php $main->block(67, 'post-run exercises', ucfirst(trnslt('post-run stretching'))) ?>
						<?php $main->block(33, 'ton-stab exercises', ucfirst(trnslt('toning and stability'))) ?>
						<div class="separator"></div>
						<?php $main->block(100, 'morning exercises', ucfirst(trnslt('morning serie'))) ?>
						<div class="separator"></div>
						<?php $main->block(67, 'arms-exercises', ucfirst(trnslt('exercises for the arms'))) ?>
						<?php $main->block(33, 'bertoz-calculator', ucfirst(trnslt('Bertoz calculator'))) ?>
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
		<!--<footer>
			<div>
				<table>
					<tfoot>
						<tr>
							<td colspan="3"><hr /></td>
						</tr>
						<tr>
							<td class="a-left">REPORT</td>
							<td class="a-left debug">
								<br /><?php var_dump($main->post) ?><br />
							</td>
							<td class="a-right">EXPORT</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</footer>-->