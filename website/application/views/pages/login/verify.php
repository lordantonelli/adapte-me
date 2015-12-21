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
            <div class="panel-body text-center">
		<i class="fa fa-check fa-5x"></i>
		<?php 
		    echo '<p class="text-center pv">'.lang('message_verify_ok').'</p>';
		    echo anchor('login', lang('button_back'), 'class="btn btn-info btn-block mt-lg"');
		?>
	    </div>
	</div>
    </div>
</div>