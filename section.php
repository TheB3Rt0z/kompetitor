		<section>
			<article>
				<div>
					<!-- place for logs (admin only) -->
					<?php $main->renderBlock(60, 'personal-data', ucfirst(trnslt('personal-data'))) ?>
					<?php $main->renderBlock(40, 'processed-physiological-data', ucfirst(trnslt('processed physiological data'))) ?>
					<div class="separator"></div>
					<?php $main->renderBlock(100, 'running-trainings', ucfirst(trnslt('running trainings'))) ?>
					<?php
					if ($_SESSION['status'] <= 1) { // only advanced users
						?>
						<div class="separator"></div>
						<?php $main->renderBlock(100, 'running-samples', ucfirst(trnslt('running samples'))) ?>
						<div class="separator"></div>
						<?php $main->renderBlock(50, 'stretching exercises', ucfirst(trnslt('stretching exercises'))) ?>
						<?php $main->renderBlock(50, 'core exercises', ucfirst(trnslt('core exercises'))) ?>
						<div class="separator"></div>
						<?php $main->renderBlock(67, 'post-run exercises', ucfirst(trnslt('post-run stretching'))) ?>
						<?php $main->renderBlock(33, 'ton-stab exercises', ucfirst(trnslt('toning and stability'))) ?>
						<div class="separator"></div>
						<?php $main->renderBlock(100, 'morning exercises', ucfirst(trnslt('morning serie'))) ?>
						<div class="separator"></div>
						<?php $main->renderBlock(67, 'arms-exercises', ucfirst(trnslt('exercises for the arms'))) ?>
						<?php $main->renderBlock(33, 'bertoz-calculator', ucfirst(trnslt('Bertoz calculator'))) ?>
						<div class="separator"></div>
						<?php $main->renderBlock(40, 'riegel-calculator', ucfirst(trnslt('Riegel\'s calculator'))) ?>
						<?php $main->renderBlock(60, 'foods-table', ucfirst(trnslt('table of foods'))) ?>
						<div class="separator"></div>
						<?php $main->renderBlock(67, 'tables-and-appendices', ucwords(trnslt('tables & appendices'))) ?>
						<?php $main->renderBlock(33, 'bibliography', ucfirst(trnslt('technical bibliography'))) ?>
						<?php
					}
					?>
					<div class="separator"></div>
					<?php $main->renderBlock(100, 'definitions-list', ucfirst(trnslt('definitions list'))) ?>
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