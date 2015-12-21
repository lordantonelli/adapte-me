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
            echo bform_open('login/register', $attributes_form); 
            echo form_fieldset();
	    
	    if(isset($error) && $error) {
		echo '<p class="alert alert-danger alert-login text-center">'.lang('error_login').'</p>';
	    }else{
		echo '<p class="text-center pv">'.lang('message_register').'</p>';
	    }
        ?>
        
	<?php echo form_label(lang('label_name').':', 'name_user', $attributes_label); ?>
        <div class="form-group input-group margin-bottom-sm<?php echo has_error('name_user');?>">
	    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
            <?php echo form_input('name_user', set_value('name_user', $name_user), 'class="form-control" aria-describedby="name_user-error" placeholder="'.lang('label_name').'" required="true" minlength="5" autofocus="true"'); ?>
        </div>
	<?php echo form_error('name_user'); ?>
	<?php echo form_label(lang('label_birthdate').':', 'birthdate', $attributes_label); ?>
	<div class="form-group input-group margin-bottom-sm<?php echo has_error('birthdate');?>">
	    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
            <?php echo form_date('birthdate', set_value('birthdate', $birthdate), 'id="birthdate" data-date-format="dd/mm/yyyy" aria-describedby="birthdate-error" class="form-control" placeholder="'.lang('label_birthdate').'" required="true" minlength="3"', 'endDate: "'.  date('d/m/Y').'", startView: 2, autoclose: true'); ?>
        </div>
	<?php echo form_error('birthdate'); ?>
	<?php echo form_label(lang('label_gender').':', 'gender', $attributes_label); ?>
	<div class="form-group input-group margin-bottom-sm<?php echo has_error('gender');?>">
	    <?php echo form_label(form_radio('gender', 'F', (($gender == 'F') ? true : false), 'required="true" aria-describedby="gender-error"') . lang('label_gender_female'), '', $attributes_label_gender); ?>
	    <?php echo form_label(form_radio('gender', 'M', (($gender == 'M') ? true : false), 'aria-describedby="gender-error"') . lang('label_gender_male'), '', $attributes_label_gender); ?>
        </div>
	<?php echo form_error('gender'); ?>
	<?php echo form_label(lang('label_email').':', 'email', $attributes_label); ?>
	<div class="form-group input-group margin-bottom-sm<?php echo has_error('email');?>">
	    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
            <?php echo form_email('email', set_value('email', $email), 'class="form-control" aria-describedby="email-error" placeholder="'.lang('label_email').'" required="true"'); ?>
        </div>
	<?php echo form_error('email'); ?>
	<?php echo form_label(lang('label_password').':', 'password', $attributes_label); ?>
        <div class="form-group input-group margin-bottom-sm<?php echo has_error('password');?>">
	    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <?php echo form_password('password', '', 'id="password" class="form-control" aria-describedby="password-error" placeholder="'.lang('label_password').'" required="true" minlength="8"'); ?>
        </div>
	<?php echo form_error('password'); ?>
	<?php echo form_label(lang('label_password_repeat').':', 'password_repeat', $attributes_label); ?>
        <div class="form-group input-group margin-bottom-sm<?php echo has_error('password_repeat');?>">
	    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <?php echo form_password('password_repeat', '', 'class="form-control" aria-describedby="password_repeat-error" placeholder="'.lang('label_password_repeat').'" required="true" equalTo="#password"'); ?>
        </div>
	<?php echo form_error('password_repeat'); ?>
        
 
        <?php 
	    echo form_submit('login', lang('button_register'), 'class="btn btn-success btn-block mt-lg"'); 
	    echo form_fieldset_close();
	    echo form_close();
        ?>
		<p class="pt-lg text-center"><?php echo lang('message_sign_in'); ?></p>
		<?php echo anchor('login', lang('button_sing_in'), 'class="btn btn-block btn-default"'); ?>
	    </div>
	</div>
    </div>
</div>