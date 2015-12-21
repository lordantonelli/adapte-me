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
            <div class="panel-body">
    
        <?php 
            echo bform_open('login/recover', $attributes_form); 
            echo form_fieldset();
	    
	    if(isset($error) && $error) {
		echo '<p class="alert alert-danger alert-login text-center">'.lang('error_recover').'</p>';
	    }else{
		echo '<p class="text-center pv">'.lang('message_recover').'</p>';
	    }
        ?>
        
        
        <div class="form-group input-group margin-bottom-sm<?php echo has_error('email');?>">
	    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
	    <?php echo form_label(lang('label_email'), 'email', $attributes_label); ?>
            <?php echo form_email('email', $email, 'class="form-control" aria-describedby="email-error" placeholder="'.lang('label_email').'" required="true" autofocus=""'); ?>
        </div>
	<?php echo form_error('email'); ?>
        
 
        <?php 
                echo form_submit('recover', lang('button_reset'), 'class="btn btn-danger btn-block mt-lg"'); 
                echo form_fieldset_close();
                echo form_close();
        ?>
	    </div>
	</div>
    </div>
</div>