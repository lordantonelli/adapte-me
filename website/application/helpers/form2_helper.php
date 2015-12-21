<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('has_error'))
{
	/**
	 * Form Error
	 *
	 * Returns the error for a specific form field. This is a helper for the
	 * form validation class.
	 *
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function has_error($field = '')
	{
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			return '';
		}
		$errors = $OBJ->error_array();
		//var_dump($errors);
		if (empty($errors[$field])){
		    return '';
		}else{
		    return ' has-error';
		}
	}
}


if ( ! function_exists('form_email'))
{
	/**
	 * Text Input Field
	 *
	 * @param	mixed
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_email($data = '', $value = '', $extra = '')
	{
		$defaults = array(
			'type' => 'email',
			'name' => is_array($data) ? '' : $data,
			'value' => $value
		);

		return '<input '._parse_form_attributes($data, $defaults).$extra." />\n";
	}
}

if (!function_exists('form_date')) {

    function form_date($data = '', $value = '', $extra = '', $config = null) {

	if (is_array($config)) {
	    $config = json_encode($config);
	}

	//obtenemos instancia global del core CodeIgniter
	$CI = & get_instance();
	$CI->set_css('assets/datepicker/css/bootstrap-datepicker.min.css', 'datepicker');
	$CI->set_javascript('assets/datepicker/js/bootstrap-datepicker.min.js', 'datepicker');
	$CI->set_javascript('assets/maskedinput/jquery.maskedinput.min.js', 'maskedinput');
	$CI->set_javascript_inline('$("#birthdate").datepicker({' . $config . '});$("#birthdate").mask("99/99/9999");', 'datepicker');

	$defaults = array(
		'type' => 'text',
		'name' => is_array($data) ? '' : $data,
		'value' => $value
	);

	return '<input '._parse_form_attributes($data, $defaults).$extra." />\n";
    }

}
