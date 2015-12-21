<?php

echo $this->form_builder->open_form(array('action' => ''));

echo $this->form_builder->build_form_horizontal(
        array(
	    array(/* INPUT */
		'label' => lang('label_subject'). ':',
		'name' => 'subject',
		'placeholder' => lang('label_subject'),
		'required' => 'true',
		'minlength' => 5,
		'autofocus'=> 'true',
		'value' => $data['subject']
	    ),
	    array(/* TEXTAREA */
		'label' => lang('label_message'). ':',
		'name' => 'message',
		'type' => 'textarea',
		'required' => 'true',
		'placeholder' => lang('label_message'),
		'value' => $data['message']
	    ),
	    array(
		'id' => 'buttons',
		'type' => 'combine',
		'class' => 'text-center',
		'elements' => array(
		    array(
			'label' => lang('label_button_send'),
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