<?php
    // Form Attributes
    $attributes_form = array('role' => 'form', 'id'=>'form-login', 'class'=>'mb-lg');
    $attributes_label = array('class' => 'sr-only');
?>


<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading text-center">
                <h3 class="panel-title"><?php echo img('images/logo.min.png', FALSE, 'height="50" alt="Logotipo Adapte-me!"'); ?></h3>
            </div>
            <div class="panel-body text-center text-success">
		<i class="fa fa-check fa-5x"></i>
		<?php 
		    echo '<p class="text-center pv">'.lang('message_recover_ok').'</p>';
		    echo anchor('dashboard', lang('button_back'), 'class="btn btn-success btn-block mt-lg"');
		?>
	    </div>
	</div>
    </div>
</div>

