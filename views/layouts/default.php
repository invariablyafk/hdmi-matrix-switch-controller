<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle ?></title>


    <link href="css/styles.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<?php
	
	if (isset($requiredCss)) {
		foreach ($requiredCss as $css => $use) {
			echo '<link rel="stylesheet" href="' . WWW_CSS_PATH . $css . '" type="text/css" media="all" charset="utf-8" />' . "\n";
		}
	}
	
	if (isset($requiredJsInHead)) {
		foreach ($requiredJsInHead as $js => $use) {
			echo '<script type="text/javascript" charset="utf-8" src="' . WWW_JS_PATH . $js . '"></script>' . "\n";
		}
	}
	
	?>

  </head>
  <body>
    <?php echo $layoutContent ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

	<?php
	if (isset($requiredJs)) {
		foreach ($requiredJs as $js => $use) {
			echo '<script type="text/javascript" charset="utf-8" src="' . WWW_JS_PATH . $js . '"></script>' . "\n";
		}
	}
	?>

  </body>
</html>