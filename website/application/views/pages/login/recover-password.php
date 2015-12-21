<?php
    // Form Attributes
    $attributes_form = array('role' => 'form', 'id'=>'form-login', 'class'=>'mb-lg');
    $attributes_label = array('class' => 'text-muted');
    $attributes_label_gender = array('class' => 'radio-inline');
?>


<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading text-center">
                <h3 class="panel-title"><?php echo img('images/logo.min.png', FALSE, 'height="50" alt="Logotipo Adapte-me!"'); ?></h3>
            </div>
            <div class="panel-body">
        <?php 
            echo bform_open('login/recover_password/'.$id_crypt, $attributes_form); 
            echo form_fieldset();
	    
	    if(isset($error) && $error) {
		echo '<p class="alert alert-danger alert-login text-center">'.lang('error_login').'</p>';
	    }else{
		echo '<p class="text-center pv">'.lang('message_recover_password').'</p>';
	    }
        ?>
       
	<?php echo form_label(lang('label_new_password').':', 'password', $attributes_label); ?>
        <div class="form-group input-group margin-bottom-sm<?php echo has_error('password');?>">
	    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <?php echo form_password('password', '', 'id="password" class="form-control" placeholder="'.lang('label_new_password').'" required="true" minlength="8"'); ?>
        </div>
	<?php echo form_error('password'); ?>
	<?php echo form_label(lang('label_password_repeat').':', 'password_repeat', $attributes_label); ?>
        <div class="form-group input-group margin-bottom-sm<?php echo has_error('password_repeat');?>">
	    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <?php echo form_password('password_repeat', '', 'class="form-control" placeholder="'.lang('label_password_repeat').'" required="true" equalTo="#password"'); ?>
        </div>
	<?php echo form_error('password_repeat'); ?>
        
 
        <?php 
	    echo form_submit('recover', lang('button_recover_password'), 'class="btn btn-success btn-block mt-lg"'); 
	    echo form_fieldset_close();
	    echo form_close();
        ?>
	    </div>
	</div>
    </div>
</div>