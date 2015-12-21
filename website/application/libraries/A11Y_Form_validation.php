<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class A11Y_Form_validation extends CI_Form_validation {
    
    /**
    * Is Unique
    *
    * Check if the input value doesn't already exist
    * in the specified database field.
    *
    * @param	string	$str
    * @param	string	$field
    * @return	bool
    */
   public function is_exist($str, $field)
   {
	   sscanf($field, '%[^.].%[^.]', $table, $field);
	   return isset($this->CI->db)
		   ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() > 0)
		   : FALSE;
   }
   
   public function date($str)
    {
	return (preg_match('~^(((0[1-9]|[12]\\d|3[01])\\/(0[13578]|1[02])\\/((19|[2-9]\\d)\\d{2}))|((0[1-9]|[12]\\d|30)\\/(0[13456789]|1[012])\\/((19|[2-9]\\d)\\d{2}))|((0[1-9]|1\\d|2[0-8])\\/02\\/((19|[2-9]\\d)\\d{2}))|(29\\/02\\/((1[6-9]|[2-9]\\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$~', $str))
	    ? TRUE
	    : FALSE;
    }
    
    // --------------------------------------------------------------------

    /**
     * Get Error Message
     *
     * Gets the error message associated with a particular field
     *
     * @param	string	$field	Field name
     * @param	string	$prefix	HTML start tag
     * @param 	string	$suffix	HTML end tag
     * @return	string
     */
    public function error($field, $prefix = '', $suffix = '')
    {
	    if (empty($this->_field_data[$field]['error']))
	    {
		    return '';
	    }

	    if ($prefix === '')
	    {
		    $prefix = str_replace('{field}', $field, $this->_error_prefix);
	    }

	    if ($suffix === '')
	    {
		    $suffix = $this->_error_suffix;
	    }

	    return $prefix.$this->_field_data[$field]['error'].$suffix;
    }
}

