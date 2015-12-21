<?php

echo $this->form_builder->open_form(array('action' => ''));

echo $this->form_builder->build_form_horizontal(
	array(
	    array(
		'id' => 'id',
		'type' => 'hidden',
		'value' => 1
	    ),
	    array(
		'label' => lang('label_old_password').':',
		'name' => 'password_old',
		'type' => 'password',
		'value' => '',
		'placeholder' => lang('label_old_password'),
		'required' => 'true',
		//'minlength' => 8,
	    ),
	    array(
		'label' => lang('label_new_password').':',
		'name' => 'password',
		'type' => 'password',
		'value' => '',
		'placeholder' => lang('label_new_password'),
		'required' => 'true',
		'minlength' => 8,
	    ),
	    array(
		'label' => lang('label_password_repeat').':',
		'name' => 'password_repeat',
		'type' => 'password',
		'value' => '',
		'placeholder' => lang('label_password_repeat'),
		'required' => 'true',
		'minlength' => 8,
		'equalTo' => '#password'
	    ),
	    array(
		'id' => 'buttons',
		'type' => 'combine',
		'class' => 'text-center',
		'elements' => array(
		    array(
			'label' => lang('label_button_save'),
			'id' => 'submit',
			'type' => 'submit',
			'class' => 'col-sm-2'
		    ),
		    array(
			'label' => lang('label_button_cancel'),
			'name' => 'cancel',
			'type' => 'a',
			'class' => 'col-sm-2',
			'href' => base_url('dashboard')
		    )
		)
	    )
));


$this->form_builder->close_form();
?>