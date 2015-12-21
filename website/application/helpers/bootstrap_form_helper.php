<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Form Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/form_helper.html
 */
//---------- <form>
/**
 * Este método crea un nuevo form con la configuración de bootstrap
 * @since 	1.0.1
 * @version 1.0.1
 * @param 	$action - controllador/method que captara el submit 
 * @return  String -> <form ...>
 */
if (!function_exists('bform_open')) {

    function bform_open($action = '', $attributes = array(), $hidden = array()) {
	//obtenemos instancia global del core CodeIgniter
	$CI = & get_instance();

	$lang = str_replace('-', '_', $CI->lang->lang());
	$CI->set_javascript('assets/jquery-validation/jquery.validate.min.js', 'validate');
	$CI->set_javascript('assets/jquery-validation/jquery.validate.bootstrap.js', 'validate_bootstrap');
	$CI->set_javascript('assets/jquery-validation/localization/messages_' . $lang . '.min.js', 'validate-lang');
	$CI->set_javascript_inline('$("form").validate();', 'validate');

	// If no action is provided then set to the current url
	if (!$action) {
	    $action = $CI->config->site_url($CI->uri->uri_string());
	}
	// If an action is not a full URL then turn it into one
	elseif (strpos($action, '://') === FALSE) {
	    $action = $CI->config->site_url($action);
	}

	$attributes = _attributes_to_string($attributes);

	if (stripos($attributes, 'method=') === FALSE) {
	    $attributes .= ' method="post"';
	}
	if (stripos($attributes, 'accept-charset=') === FALSE) {
	    $attributes .= ' accept-charset="' . strtolower(config_item('charset')) . '"';
	}
	if (stripos($attributes, 'role=') === FALSE) {
	    $attributes .= ' role="form"';
	}

	$form = '<form action="' . $action . '"' . $attributes . ">\n";

	// Add CSRF field if enabled, but leave it out for GET requests and requests to external websites
	if ($CI->config->item('csrf_protection') === TRUE && strpos($action, $CI->config->base_url()) !== FALSE && !stripos($form, 'method="get"')) {
	    $hidden[$CI->security->get_csrf_token_name()] = $CI->security->get_csrf_hash();
	}

	if (is_array($hidden)) {
	    foreach ($hidden as $name => $value) {
		$form .= '<input type="hidden" name="' . $name . '" value="' . html_escape($value) . '" style="display:none;" />' . "\n";
	    }
	}
	return $form;
    }

}

if (!function_exists('bform_open_multipart')) {

    /**
     * Form Declaration - Multipart type
     *
     * Creates the opening portion of the form, but with "multipart/form-data".
     *
     * @param	string	the URI segments of the form destination
     * @param	array	a key/value pair of attributes
     * @param	array	a key/value pair hidden data
     * @return	string
     */
    function bform_open_multipart($action = '', $attributes = array(), $hidden = array()) {
	if (is_string($attributes)) {
	    $attributes .= ' enctype="multipart/form-data"';
	} else {
	    $attributes['enctype'] = 'multipart/form-data';
	}
	return bform_open($action, $attributes, $hidden);
    }

}
//---------- </form>
/**
 * Este método cierra la etiqueta form de html
 * @since 	1.0.1
 * @version 1.0.1
 * @return  String -> </form>
 */
if (!function_exists('bform_close')) {

    function bform_close() {
	//retornamos el cierre de la etiqueta
	return "</form>";
    }

}

// ------------------------------------------------------------------------
if (!function_exists('bform_hidden')) {

    /**
     * Hidden Input Field
     *
     * Generates hidden fields. You can pass a simple key/value string or
     * an associative array with multiple values.
     *
     * @param	mixed	$name		Field name
     * @param	string	$value		Field value
     * @param	bool	$recursing
     * @return	string
     */
    function bform_hidden($name, $value = '', $recursing = FALSE) {
	static $form;
	if ($recursing === FALSE) {
	    $form = "\n";
	}
	if (is_array($name)) {
	    foreach ($name as $key => $val) {
		bform_hidden($key, $val, TRUE);
	    }
	    return $form;
	}
	if (!is_array($value)) {
	    $form .= '<input type="hidden" name="' . $name . '" value="' . html_escape($value) . "\" />\n";
	} else {
	    foreach ($value as $k => $v) {
		$k = is_int($k) ? '' : $k;
		bform_hidden($name . '[' . $k . ']', $v, TRUE);
	    }
	}
	return $form;
    }

}

if (!function_exists('bform_label')) {

    /**
     * Form Label Tag
     *
     * @param	string	The text to appear onscreen
     * @param	string	The id the label applies to
     * @param	string	Additional attributes
     * @return	string
     */
    function bform_label($label_text = '', $id = '', $attributes = array()) {
	$label = '<label';
	if ($id !== '') {
	    $label .= ' for="' . $id . '"';
	}
	if (is_array($attributes) && count($attributes) > 0) {
	    foreach ($attributes as $key => $val) {
		$label .= ' ' . $key . '="' . $val . '"';
	    }
	}
	return $label . '>' . $label_text . "</label>\n";
    }

}

//---------- <input type=''>
/**
 * Código genérico para generar elementos <input> de los siguientes tipos
 * type = [text, password]
 * @since 	1.0.1
 * @version 1.0.1
 * @return <input>
 */
if (!function_exists('bform_input')) {

    function bform_input($type = 'text', $name = '', $message = '', $attributes = null) {

	if (is_string($attributes)) {
	    $attributes = current((array) new SimpleXMLElement("<element $attributes />"));
	}
	if (isset($attributes['class'])) {
	    $attributes['class'] .= ' form-control';
	} else {
	    $attributes['class'] = 'form-control';
	}
	if (!isset($attributes['id'])) {
	    $attributes['id'] = $name;
	}
	$attributes['type'] = $type;
	$attributes['name'] = $name;
	$attributes['aria-describedby'] = $name . '-error';
	$attributes['aria-invalid'] = 'false';


	$div = "<div class=\"form-group\">\n";
	if (!empty($message)) {
	    $div .= bform_label($message . ':', $attributes['id']);
	}
	$div .= '<input ' . _attributes_to_string($attributes) . " />\n";
	$div .= "</div>\n";

	return $div;
    }

}
//---------- <input type='text'>
/**
 * Este método crea un input con la clase form-control, el atributo required, el
 * atributo name = $name y los atributos enviados como array asociativo, también crea  
 * un label que tiene el valor del parámetro $message
 * @param $name 		= valor del atributo name
 * @param $message 		= <label>$message</label>
 * @param $atributos 	= array('placeholder' => 'ingresa texto') 
 * @since 	1.0.1
 * @version 1.0.1
 */
if (!function_exists('bform_input_text')) {

    function bform_input_text($name = '', $message = '', $attributes = null) {
	return bform_input("text", $name, $message, $attributes);
    }

}
//---------- <input type='email'>
/**
 * Este método crea un input con la clase form-control, el atributo required, el
 * atributo name = $name y los atributos enviados como array asociativo, también crea  
 * un label que tiene el valor del parámetro $message
 * @param $name 		= valor del atributo name
 * @param $message 		= <label>$message</label>
 * @param $atributos 	= array('placeholder' => 'ingresa texto') 
 * @since 	1.0.1
 * @version 1.0.1
 */
if (!function_exists('bform_input_email')) {

    function bform_input_email($name = '', $message = '', $attributes = null) {
	return bform_input('email', $name, $message, $attributes);
    }

}
//---------- <input type='date'>
/**
 * Este método crea un input con la clase form-control, el atributo required, el
 * atributo name = $name y los atributos enviados como array asociativo, también crea  
 * un label que tiene el valor del parámetro $message
 * @param $name 		= valor del atributo name
 * @param $message 		= <label>$message</label>
 * @param $atributos 	= array('placeholder' => 'ingresa texto') 
 * @since 	1.0.1
 * @version 1.0.1
 */
if (!function_exists('bform_input_date')) {

    function bform_input_date($name = '', $message = '', $attributes = null, $config = null) {

	if (is_array($config)) {
	    $config = json_encode($config);
	}

	//obtenemos instancia global del core CodeIgniter
	$CI = & get_instance();
	$CI->set_css('assets/datepicker/css/bootstrap-datepicker.min.css', 'datepicker');
	$CI->set_javascript('assets/datepicker/js/bootstrap-datepicker.min.js', 'datepicker');
	$CI->set_javascript_inline('$("#birthdate").datepicker({' . $config . '});', 'datepicker');

	return bform_input('text', $name, $message, $attributes);
    }

}
//---------- <input type='password'>
/**
 * Este método crea un input con la clase form-control, el atributo required, el 
 * atributo name = $name y los atributos enviados como array asociativo, también crea  
 * un label que tiene el valor del parametro $message
 * @param $name 		= valor del atributo name
 * @param $message 		= <label>$message</label>
 * @param $atributos 	= array('placeholder' => 'ingresa texto') 
 * @since 	1.0.1
 * @version 1.0.1
 */
if (!function_exists('bform_input_password')) {

    function bform_input_password($name = '', $message = '', $attributes = null) {
	return bform_input("password", $name, $message, $attributes);
    }

}
//----- Text area
/**
 * Este método crea un textarea con la clase form-control, el atributo required, el
 * atributo name = $name y los atributos enviados como array asociativo, también crea  
 * un label que tiene el valor del parametro $message
 * @param $name 		= valor del atributo name
 * @param $message 		= <label>$message</label>
 * @param $atributos 	= array('placeholder' => 'ingresa texto') 
 * @since 	1.0.1
 * @version 1.0.1
 */
if (!function_exists('bform_input_textarea')) {

    function bform_input_textarea($name = '', $message = '', $attributes = null) {
	$value = '';
	
	if (is_string($attributes)) {
	    $attributes = current((array) new SimpleXMLElement("<element $attributes />"));
	}
	if (isset($attributes['class'])) {
	    $attributes['class'] .= ' form-control';
	} else {
	    $attributes['class'] = 'form-control';
	}
	if (!isset($attributes['id'])) {
	    $attributes['id'] = $name;
	}
	if (!isset($attributes['rows'])) {
	    $attributes['rows'] = 3;
	}
	if (!isset($attributes['value'])) {
	    $value = $attributes['value'];
	    unset($attributes['value']);
	}
	$attributes['name'] = $name;
	$attributes['aria-describedby'] = $name . '-error';
	$attributes['aria-invalid'] = 'false';

	$div = "<div class=\"form-group\">\n";
	if (!empty($message)) {
	    $div .= bform_label($message . ':', $attributes['id']);
	}
	$div .= '<textarea ' . _attributes_to_string($attributes) . " >{$value}</textarea>\n";
	$div .= "</div>\n";

	return $div;
    }

}
//----- Radios
/**
 * Este método crea un radiobutton horizontal con la clase form-control
 * y el atributo required, el atributo name = $name y los atributos enviados como 
 * array asociativo, también crea un label que tiene el valor del parametro $message
 * @param $name 		= valor del atributo name
 * @param $message 		= <label>$message</label>
 * @param $atributos 	= array('placeholder' => 'ingresa texto') 
 * @since 	1.0.1
 * @version 1.0.1
 */
if (!function_exists('bform_input_radio')) {

    function bform_input_radio($name, $message, $value, $inline = TRUE, $attributes = null) {
	
	if (is_string($attributes)) {
	    $attributes = current((array) new SimpleXMLElement("<element $attributes />"));
	}
	if (isset($attributes['class'])) {
	    $attributes['class'] .= ' form-control';
	} else {
	    $attributes['class'] = 'form-control';
	}
	if (!isset($attributes['id'])) {
	    $attributes['id'] = $name;
	}
	$attributes['type'] = 'radio';
	$attributes['name'] = $name;
	$attributes['value'] = $value;
	$attributes['aria-describedby'] = $name . '-error';
	$attributes['aria-invalid'] = 'false';
	
	$class_label = ($inline) ? 'class="radio-inline"' : 'class="radio"';
	$input = '<input ' . _attributes_to_string($attributes) . " />\n";

	$div = "<div class=\"form-group\">\n";
	$div .= bform_label($input . $message, $attributes['id'], $class_label);
	$div .= "</div>\n";

	return $div;
	
    }

}
//----- Check
/**
 * Este método crea checkbox horizontal con la clase form-control
 * y el atributo required, el atributo name = $name y los atributos enviados como 
 * array asociativo, también crea un label que tiene el valor del parámetro $message
 * @param $name 		= valor del atributo name
 * @param $message 		= <label>$message</label>
 * @param $atributos 	= array('placeholder' => 'ingresa texto') 
 * @since 	1.0.1
 * @version 1.0.1
 * @return  string - <input type='checkbox' ...>  
 */
if (!function_exists('bform_input_checkbox')) {

    function bform_input_checkbox($name = '', $message = '', $atributos = null) {
	$div = "<div class='checkbox-inline'>";
	$div .= "<label class='checkbox-inline'>";
	$div .= "<input type='checkbox' name='" . $name . "'";
	if ($atributos == null) {
	    $div .= " id='" . $name . "'";
	}
	$div .= setAtributos($atributos, 'checkbox') . ">";
	$div .= $message;
	$div .= "</label>";
	$div .= "</div>";
	return $div;
    }

}
//----- Select
/**
 * Este método genera código estándar para la creación de opciones de un select html
 * es necesario utilizar el método select_options($data = array('value' => 'display'));
 * para que este método funcione correctamente.
 * @param 	$options - [array asociativo]
 * @since 	1.0.1
 * @version 1.0.1
 * @return 	String - <div class...><select ...> 
 */
if (!function_exists('bform_input_select')) {

    function bform_input_select($name = '', $multiple = false) {
	$div = "<div class='form-group'>";
	if (!$multiple) {
	    $div .= "<select name='" . $name . "' class='form-control'>";
	} else {
	    $div .= "<select name='" . $name . "' multiple class='form-control'>";
	}
	return $div;
    }

}
//----- input file
/**
 * Este método genera código estándar para la creación de un input file de html
 * @param   $texto - texto que se mostrara en el input example: 'choose a file'
 * @since 	1.2.0
 * @version 1.2.0
 * @return 	String - <div class...><input ...> 
 */
if (!function_exists('bform_input_file')) {

    function bform_input_file($texto = 'Seleccionar archivo') {
	$div = "<div class='form-group'>";
	$div .= "<input name='userfile' type='file' id='userfile' class='filestyle' data-icon='true' data-buttonText='$texto'>";
	$div .= "</div>";
	return $div;
    }

}
//----- options
/**
 * Este método genera código estándar para la creación de opciones de un select html
 * es necesario usar antes el método bform_input_select
 * @param 	$options - [array asociativo]
 * @since 	1.0.1
 * @version 1.0.1
 * @return 	options con valores
 */
if (!function_exists('select_options')) {

    function select_options($options = null) {
	$html = "";
	if ($options != null) {
	    foreach ($options as $value => $option) {
		$html .= "<option value='" . $value . "'>" . $option . "</option>";
	    }
	}
	$html .= "</select></div>";
	return $html;
    }

}
//----- submit
/**
 * Este metodo genera un boton de submit para el formulario que se esta creando
 * @param   $atributos 	= array('placeholder' => 'ingresa texto') 
 * @since 	1.2.0
 * @version 1.0.1
 * @return  button submit bootstrap
 */
if (!function_exists('bform_submit')) {

    function bform_submit($message = '') {
	return "<div class='form-group'><input type='submit' class='form-control btn-success' value='$message'/></div>";
    }

}
//----- table
/**
 * Este metodo genera una tabla a travez de un $result = $this->db->...('SQL');
 * example echo create_table($result);
 * @param   $matriz = $result 
 * @since 	1.2.1
 * @version 1.2.1
 * @return  codigo html para imprimir la tabla
 */
if (!function_exists('create_table')) {

    function create_table($matriz = null) {
	if ($matriz == null) {
	    return;
	}
	$content = "<div class='table-responsive'>";
	$content .= "<table class='table table-hover table-bordered table-condensed'>";
	$content .= "<thead>";
	$content .= "<tr>";
	foreach ($matriz->list_fields() as $field) {
	    $content .= "<th style='text-align: center;'>" . $field . "</th>";
	}
	$content .= "</tr>";
	$content .= "</thead>";
	$content .= "<tbody>";
	foreach ($matriz->result_array() as $row) {
	    $content .= "<tr>";
	    foreach ($row as $key => $value) {
		$content .= "<td style='text-align: center;'>" . $value . "</td>";
	    }
	    $content .= "</tr>";
	}
	$content .= "</tbody>";
	$content .= "</table>";
	$content .= "</div>";
	return $content;
    }

}
//----------------------
/**
 * Atributos de array asociativo a String
 * @access private
 * @param  $atributos - [array asociativo]
 * @param  $type 	  - [tipo de elemento]
 * @return string
 */
if (!function_exists('setAtributos')) {

    function setAtributos($atributos = null, $type = '') {
	$data = '';
	switch ($type) {
	    case 'form':
		if ($atributos != null) {
		    foreach ($atributos as $key => $value) {
			if ($key == 'method') {
			    if ($value != 'post' && $value != 'get') {
				$data .= ' method="post"';
			    }
			}
			$data .= ' ' . $key . '="' . $value . '"';
		    }
		    if (strpos($data, 'post') || strpos($data, 'get')) {
			return $data;
		    }
		}
		$data .= ' method="post"';
		break;

	    default:
		$data = _attributes_to_string($atributos);
		break;
	}
	return $data;
    }

}

// ------------------------------------------------------------------------

if (!function_exists('_attributes_to_string')) {

    /**
     * Attributes To String
     *
     * Helper function used by some of the form helpers
     *
     * @param	mixed
     * @return	string
     */
    function _attributes_to_string($attributes) {
	if (empty($attributes)) {
	    return '';
	}

	if (is_object($attributes)) {
	    $attributes = (array) $attributes;
	}

	if (is_array($attributes)) {
	    $atts = '';

	    foreach ($attributes as $key => $val) {
		$atts .= ' ' . $key . '="' . $val . '"';
	    }

	    return $atts;
	}

	if (is_string($attributes)) {
	    return ' ' . $attributes;
	}

	return FALSE;
    }

}


// ------------------------------------------------------------------------

if (!function_exists('_parse_form_attributes')) {

    /**
     * Parse the form attributes
     *
     * Helper function used by some of the form helpers
     *
     * @param	array	$attributes	List of attributes
     * @param	array	$default	Default values
     * @return	string
     */
    function _parse_form_attributes($attributes, $default) {
	if (is_array($attributes)) {
	    foreach ($default as $key => $val) {
		if (isset($attributes[$key])) {
		    $default[$key] = $attributes[$key];
		    unset($attributes[$key]);
		}
	    }

	    if (count($attributes) > 0) {
		$default = array_merge($default, $attributes);
	    }
	}

	$att = '';

	foreach ($default as $key => $val) {
	    if ($key === 'value') {
		$val = html_escape($val);
	    } elseif ($key === 'name' && !strlen($default['name'])) {
		continue;
	    }

	    $att .= $key . '="' . $val . '" ';
	}

	return $att;
    }

}
/* Fim do arquivo bootstrap_form_helper.php 				*/
/* Location: ./application/helper/bootstrap_form_helper.php 	*/