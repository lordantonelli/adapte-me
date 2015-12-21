
<div class="text-center">
    <i class="fa fa-exclamation-triangle fa-5x text-danger"></i>
    <?php 
    
	echo $this->form_builder->open_form(array('action' => ''));
	
	echo '<p class="text-center pv"><strong>'.lang('message_restore_config').'</strong></p>';

	echo $this->form_builder->build_form_horizontal(
		array(
		    array(
			'name' => 'restore-config',
			'type' => 'hidden',
			'value' => 'true'
		    ),
		    array(
			'name' => 'id_user_menu',
			'type' => 'hidden',
			'value' => $id_user_menu
		    ),
		    array(
			'id' => 'buttons',
			'type' => 'combine',
			'class' => 'text-center',
			'elements' => array(
			    array(
				'label' => lang('button_no'),
				'name' => 'cancel',
				'type' => 'a',
				'class' => 'btn btn-primary mt-lg mb-lg col-md-4',
				'href' => base_url('dashboard')
			    ),
			    array(
				'label' => lang('button_yes'),
				'id' => 'submit',
				'type' => 'submit',
				'class' => 'btn btn-danger mt-lg mb-lg col-md-4'
			    )
			)
		    )
		));


	$this->form_builder->close_form();
    ?>
</div>
