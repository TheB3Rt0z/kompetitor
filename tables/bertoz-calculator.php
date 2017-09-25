<?php $test = @include_once 'init.php';

if (!$test) {
    $test = require_once '../init.php';
    if ($test === 1) {
        include_once '../head.php';
        ?>
        <style type="text/css">
            body {
                padding: 1%;
            }
        </style>
        <?php
    }
    else
        include_once 'head.php';
}
else
    include_once 'head.php';

if (!isset($main))
    $main = $this;

$distances = array(
	'5km' => 5,
	'7.5km' => 7.5,
	'10km' => 10,
	'1/3M' => 14.065,
	'15km' => 15,
	'10mi' => 16.093,
	'HM' => 21.0975,
	'25km' => 25,
	'2/3M' => 28.13,
	'3/4M' => 31.6463,
	'M' => 42.195,
    '50km' => 50,
	'100km' => 100,
    '100mi' => 161.76,
);

if (ob_start()) {
	?>
	<fieldset>
		<legend><?php echo ucfirst(trnslt('average speed calculation')) ?> (in min/km)</legend>
		<table>
			<td class="a-left"><?php echo ucfirst(trnslt('time')) ?>:</td>
			<td class="a-right"><input type="text" name="bertoz_calculator[time]" value="<?php echo $main->getPost('bertoz_calculator', 'time') ?>" title="<?php echo trnslt('format: (h)h:mm:ss') ?>" /></td>
			<td class="a-left"><?php echo ucfirst(trnslt('distance')) ?>:</td>
			<td class="a-right"><input type="text" name="bertoz_calculator[distance]" value="<?php echo $main->getPost('bertoz_calculator', 'distance') ?>" title="<?php echo trnslt('format: ?(.?) (in km)') ?>" /></td>
			<td class="a-left"><?php echo ucfirst(trnslt('speed')) ?>:</td>
			<td class="a-right"><input type="text" name="bertoz_calculator[speed]" value="<?php echo $main->getPost('bertoz_calculator', 'speed') ?>" readonly disabled /></td>
			<td class="a-right"><?php echo submit() ?></td>
		</table>
	</fieldset>
	<fieldset>
	    <legend><?php echo ucfirst(trnslt('forecast based on coefficient')) ?> <? echo BERTOZ_COEFFICIENT ?></legend>
		<table>
			<tr>
				<?php
				$count = 0;
				foreach ($distances as $key => $distance) {
					?>
					<td class="a-left"><?php echo trnslt($key) ?>:<input type="hidden" name="bertoz_calculator[distances][<?php echo $key ?>]" value="<?php echo $distance ?>" /></td>
					<td class="a-right"><input type="text" name="bertoz_calculator[forecasts][<?php echo $key ?>]" value="<?php echo $main->getPost('bertoz_calculator', 'forecasts', $key) ?>" readonly disabled /></td>
					<td class="a-right"><input type="text" name="bertoz_calculator[forespeed][<?php echo $key ?>]" value="<?php echo $main->getPost('bertoz_calculator', 'forespeed', $key) ?>" readonly disabled /></td>
					<?php
					if (is_int((++$count) / 2))
						echo '</tr><tr>';
				}
				?>
			</tr>
		</table>
	</fieldset>
	<?php
	if (!$main->is_mobile && $test !== 1)
		file_put_contents('./tables/bertoz-calculator.htm', file_get_contents('head.php') . ob_get_contents() . file_get_contents('footer.php'));
	ob_end_flush();
}
