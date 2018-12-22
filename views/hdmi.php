<?php
	$this->setLayoutVar('pageTitle', 'Select HDMI input');
	$this->requireJs('hdmi-switch.js');
?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<p>Select the input you would like to view on a particular TV.</p>
		</div>
	</div>
	<div class="row hdmi-switch">
		<div class="col-lg-12 well">
			<div class="form-group">
				<label for="">All TVs</label><br>
                <select class="form-control" data-tv-slug="all">
                    <option value="-1">Select Input</option>
                    <?php $i = 0; foreach($inputs as $input_slug => $input_name): $i++; ?>
                    <option value="<?php echo $input_slug; ?>"><?php echo $input_name; ?></option>
                    <?php endforeach; ?>
                </select>
			</div>
			<hr>
			<?php foreach($tvs as $tv_value => $tv): ?>
			<div class="form-group">
				<label for=""><?php echo $tv['name']; ?></label><br>
                <select class="form-control tv_<?php echo $tv_value ?>" data-tv-slug="<?php echo $tv_value ?>">
                    <option value="-1">Select Input</option>
                    <?php $i = 0; foreach($inputs as $input_slug => $input_name): $i++; ?>
                    <option value="<?php echo $input_slug; ?>"><?php echo $input_name; ?></option>
                    <?php endforeach; ?>
                </select>			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>