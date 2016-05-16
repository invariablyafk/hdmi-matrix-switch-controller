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
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Unknown <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  <?php $i = 0; foreach($inputs as $input_slug => $input_name): $i++; ?>
					<li><a value="<?php echo 'all' . $i; ?>"><?php echo $input_name; ?></a></li>
				  <?php endforeach; ?>
				  </ul>
				</div>
			</div>
			<hr>
			<?php foreach($tvs as $tv): ?>
			<div class="form-group">
				<label for=""><?php echo $tv['name']; ?></label><br>
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Unknown <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  <?php $i = 0; foreach($inputs as $input_slug => $input_name): $i++; ?>
					<li><a value="<?php echo $tv['slug'] . $i; ?>"><?php echo $input_name; ?></a></li>
				  <?php endforeach; ?>
				  </ul>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>