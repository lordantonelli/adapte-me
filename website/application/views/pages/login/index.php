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
    <?php if(isset($already_installed) && $already_installed) { ?>
    Simple Task Board has already been installed.
    <?php } else { ?>
        <?php 
            if(isset($already_installed) && !$already_installed) { 
                echo bform_open('install/run', $attributes_form); 
            } else { 
                echo bform_open('login/login_plugin', $attributes_form); 
            } 
            echo form_fieldset();
	    
	    if(isset($error) && $error == 1) {
		echo '<p class="alert alert-danger alert-login text-center mb-lg">'.lang('error_login').'</p>';
	    }elseif(isset($error) && $error == 2) {
		echo '<p class="alert alert-warning alert-login text-center mb-lg">'.lang('error_verify').'<br />'. anchor('login/verification_new/'.$id_crypt, lang('a_new_verify')) .'</p>';
	    }else{
		echo '<p class="text-center pv">'.lang('message_login').'</p>';
	    }
        ?>
        
        
        <div class="form-group input-group margin-bottom-sm">
	    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
	    <?php echo form_label(lang('label_email'), 'email', $attributes_label); ?>
            <?php echo form_email('email', $email, 'class="form-control" placeholder="'.lang('label_email').'" required="true" autofocus=""'); ?>
        </div>
        <div class="form-group input-group margin-bottom-sm">
	    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <?php echo form_label(lang('label_password'), 'password', $attributes_label); ?>
            <?php echo form_password('password', $password, 'class="form-control" placeholder="'.lang('label_password').'" required="true"'); ?>
        </div>
    <div class="clearfix">
	<div class="pull-right">
	    <?php echo anchor('login/recover', lang('forgot_password'), 'class="text-muted"'); ?>
	</div>
    </div>
        
 
        <?php 
                if(isset($already_installed) && !$already_installed) { 
                    echo form_submit('install', 'Install', 'class="btn btn-success btn-block mt-lg"'); 
                } else { 
                    echo form_submit('login', lang('button_login'), 'class="btn btn-success btn-block mt-lg"'); 
                } 
                echo form_fieldset_close();
                echo form_close();
            } 
        ?>
		<p class="pt-lg text-center"><?php echo lang('message_sign_up'); ?></p>
		<?php echo anchor('login/register', lang('button_sing_up'), 'class="btn btn-block btn-default"'); ?>
	    </div>
	</div>
    </div>
</div>