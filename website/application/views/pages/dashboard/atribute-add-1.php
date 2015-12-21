<?php

echo $this->form_builder->open_form(array('action' => ''));

echo $this->form_builder->build_form_horizontal(
	array(
	    array(
		'name' => 'id_user_menu_attribute',
		'type' => 'hidden',
		'value' => $data->id_user_menu_attribute
	    ),
	    array(
		'name' => 'id_user_menu',
		'type' => 'hidden',
		'value' => $data->id_user_menu
	    ),
	    array(
		'label' => lang('label_attribute').':',
		'name' => 'id_attribute',
		'type' => 'dropdown',
		'value' => $data->id_attribute,
		'placeholder' => lang('label_attribute'),
		'required' => 'true',
		'options' => $attributes
	    ),
	    array(
		'id' => 'buttons',
		'type' => 'combine',
		'class' => 'text-center',
		'elements' => array(
		    array(
			'label' => lang('label_button_next'),
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