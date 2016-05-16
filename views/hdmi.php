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
			<?php foreach($tvs as $tv): ?>
			<div class="form-group">
				<label for=""><?php echo $tv['name']; ?></label><br>
				<div class="btn-group" role="group">
					<?php $i = 0; foreach($inputs as $input_slug => $input_name): $i++; ?>
					<button type="button" class="btn btn-default <?php echo ($input_slug == $tv['selected']) ? 'btn-primary' : ''; ?> <?php echo $tv['slug'] . $i; ?>" value="<?php echo $tv['slug'] . $i; ?>"><?php echo $input_name; ?></button>
					<?php endforeach; ?>
				</div>
				
				

				
				
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>