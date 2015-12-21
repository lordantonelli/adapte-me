<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8" />
	<title>404 Page Not Found</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/animate.min.css" rel="stylesheet'); ?>" />
	<link href="<?php echo base_url('css/style.css'); ?>" rel="stylesheet" />
	<link href="assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
    </head>
    <body class="pace-top">

	<!-- begin #page-container -->
	<div id="page-container">
	    <!-- begin error -->
	    <div class="error">
		<div class="error-code mb-lg">404 <i class="fa fa-warning"></i></div>
		<div class="error-content">
		    <div class="error-message"><?php echo lang('error_404_heading'); ?></div>
		    <div class="error-desc mb-lg">
			<?php echo lang('error_404_message'); ?>
		    </div>
		    <div class="mt-lg">
			<a href="<?php echo base_url(); ?>" class="btn btn-success"><?php echo lang('error_404_button'); ?></a>
		    </div>
		</div>
	    </div>
	    <!-- end error -->
	</div>
    </body>
</html>