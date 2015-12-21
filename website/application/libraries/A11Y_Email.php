<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class A11Y_Email extends CI_Email {
    
    public $marker_mail	    = '';
    public $mail_from	    = '';
    public $mail_from_name  = '';

    /**
     * Set FROM
     *
     * @param	string	$from
     * @param	string	$name
     * @param	string	$return_path = NULL	Return-Path
     * @return	CI_Email
     */
    public function from($from = '', $name = '', $return_path = NULL) {
	if (empty($from)) {
	    if (empty($name)) {
		return parent::from($this->mail_from, $this->mail_from_name, $return_path);
	    } else {
		return parent::from($this->mail_from, $name, $return_path);
	    }
	} else {
	    return parent::from($from, $name, $return_path);
	}
    }
    
    /**
    * Set Recipients
    *
    * @param	string
    * @return	CI_Email
    */
   public function to($to = '')
   {
       if (empty($to)) {
	    return parent::to($this->mail_from);
	} else {
	    return parent::to($to);
	}
   }

    /**
     * Set Email Subject
     *
     * @param	string
     * @return	CI_Email
     */
    public function subject($subject) {
	return parent::subject('[' . $this->marker_mail . '] ' . $subject);
    }

}
