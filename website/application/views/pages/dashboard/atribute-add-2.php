<?php

echo '<style> #example-config{';
foreach ($config as $key => $value) {
    echo $key . ':' . $value . ';';
}
if(array_key_exists('border-color', $config)){
    echo  'border-style: solid;';
}
echo '}</style>';

echo $this->form_builder->open_form(array('action' => 'dashboard/attribute_save/'));

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
		'name' => 'id_attribute',
		'type' => 'hidden',
		'value' => $data->id_attribute
	    )
	));

if($type == 'color'){
    echo $this->form_builder->build_form_horizontal(
	array(
	    array(/* INPUT */
		'label' => lang('label_value').':',
		'id' => 'value',
		'type' => 'color',
		'value' => $data->value,
		'placeholder' => lang('label_value'),
		'data-format' => 'hex',
		'minlength' => 4,
		'maxlength' => 7,
		'config' => "colorSelectors: {'default': '#777777', 'primary': '#337ab7', 'success': '#5cb85c', 'info': '#5bc0de', 'warning': '#f0ad4e', 'danger': '#d9534f'}",
		'required' => 'true',
	    )
	));
    
    $javascript = "
    $('#value').parent().find( 'i' ).css( 'background-color', '{$data->value}' );
    $('#value').on('changeColor', function(ev) {
	    $('#value').parent().find( 'i' ).css( 'background-color', ev.color.toHex() );
	    $('#example-config').css( '{$data->property}', ev.color.toHex() );
	});";
}

if($type == 'number'){
    $input_number = $this->form_builder->build_form_horizontal(
	array(
	    array(/* INPUT */
		'label' => lang('label_value').':',
		'id' => 'value',
		'type' => 'number',
		'value' => str_replace('%', '', $data->value),
		'placeholder' => lang('label_value'),
		'min' => 1,
		'max' => 999,
		'required' => 'true',
		'range' => '[1, 999]',
		'input_addons' => array(
		    'post' => '%'
		),
	    )
	));
    echo str_replace('input-group"', 'input-group col-sm-4"', $input_number);
    $javascript = "
    $('#value').on('change', function() {
	    $('#example-config').css( '{$data->property}', $(this).prop('value') + '%' );
	});";
}


?>


<div class="col-md-4 col-md-offset-3 mb-lg text-center" style="padding-left: 8px;"><div id="example-config"><?php echo lang('label_item_menu'); ?></div></div>
<div class="clearfix"></div>

<?php
echo $this->form_builder->build_form_horizontal(
	array(
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

$CI = & get_instance();

$CI->set_javascript_inline($javascript);

?>