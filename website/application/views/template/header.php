<?php
$logo = array(
    'src' => 'images/logo.big.min.png',
    'alt' => 'Logo Adapte-me!',
    'height' => '34',
    'class' => 'img-responsive'
);

$logo_responsive = array(
    'src' => 'images/logo-responsive.min.png',
    'alt' => 'Logo Adapte-me!',
    'height' => '34',
    'class' => 'img-responsive'
);

$this->lang->load('template');

?>
<header class="topnavbar-wrapper"></header>


<!-- Navigation -->
<nav style="margin-bottom: 0" role="navigation" class="navbar navbar-default navbar-static-top">
    <div class="navbar-header">
	<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
	    <span class="sr-only">Toggle navigation</span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	</button>
	<a href="<?php echo base_url(); ?>" class="navbar-brand"><?php echo img($logo); ?></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
	<li class="dropdown">
	    <?php echo anchor('login/logout', '<i class="fa fa-sign-out fa-fw"></i> '.lang('template_menu_logout')); ?>
	</li>
    </ul>
    <!-- /.navbar-top-links -->

    <div role="navigation" class="navbar-default sidebar">
	<div class="sidebar-nav navbar-collapse" aria-expanded="false" style="height: 1px;">
	    <ul id="side-menu" class="nav">
		<li class="sidebar-search">
		    <div class="input-group custom-search-form">
			<input type="text" placeholder="Search..." class="form-control">
			<span class="input-group-btn">
			    <button type="button" class="btn btn-default">
				<i class="fa fa-search"></i>
			    </button>
			</span>
		    </div>
		    <!-- /input-group -->
		</li>
		<li>
		    <?php echo anchor('dashboard', '<i class="fa fa-dashboard fa-fw"></i> '.lang('template_menu_home')); ?>
		</li>
		<li>
		    <?php echo anchor('contact', '<i class="fa fa-envelope fa-fw"></i> '.lang('template_menu_contact')); ?>
		</li>
		
	    </ul>
	</div>
	<!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>