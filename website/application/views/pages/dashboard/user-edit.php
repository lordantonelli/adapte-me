<?php

echo $this->form_builder->open_form(array('action' => ''));

echo $this->form_builder->build_form_horizontal(
	array(
	    array(
		'label' => lang('label_name').':',
		'name' => 'name_user',
		'placeholder' => lang('label_name'),
		'required' => 'true',
		'minlength' => 5,
		'autofocus'=> 'true',
		'value' => $data->name_user
	    ),
	    array(
		'label' => lang('label_birthdate').':',
		'name' => 'birthdate',
		'type' => 'date',
		'value' => $data->birthdate,
		'placeholder' => lang('label_birthdate'),
		'required' => 'true',
		'minlength' => 10,
		'maxlength' => 10,
		'config' => 'endDate: "'.  date('d/m/Y').'", startView: 2, autoclose: true'
	    ),
	    array(
		'label' => lang('label_gender').':',
		'name' => 'gender',
		'type' => 'radio',
		'required' => 'true',
		'value' => $data->gender,
		'class' => 'radio-inline',
		'options' => array(
		    'F' => lang('label_gender_female'),
		    'M' => lang('label_gender_male')
		)
	    ),
	    array(
		'label' => lang('label_email'). ':',
		'name' => 'email',
		'type' => 'email',
		'required' => 'true',
		'placeholder' => lang('label_email'),
		'value' => $data->email
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