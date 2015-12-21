<?php

defined('BASEPATH') OR exit('No direct script access allowed');
 
class Contact extends A11Y_Controller {
 
    function Contact()
    {
        parent::__construct();
	
	$this->lang->load('contact');
	$this->title = lang('page_title');
    }
 
    public function index()
    {
        $this->subtitle = lang('subtitle_index');
	
	if(empty($this->input->post())){
	    $this->data['data']['subject'] = '';
	    $this->data['data']['message'] = '';	    
	    $this->_render('pages/contact/index');
	}else{
	    
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('subject', lang('label_subject'), 'trim|required|min_length[5]');
	    $this->form_validation->set_rules('message', lang('label_message'), 'trim|required');
	    
	    if($this->form_validation->run() === false)  {
		$this->data['data'] = $this->input->post();
		$this->_render('pages/contact/index');    
		return;
	    }
	    
	    $this->load->model('user_model');
	    $user = $this->user_model->find($this->session->userdata('user'));
	    
	    $this->data['message'] = $this->input->post('message');
	    $html_email = $this->load->view('pages/contact/mail', $this->data, true);

	    //$this->email->to('humbertoantonelli@gmail.com');
	    $this->email->to();
	    $this->email->from($user->email, $user->name_user);
	    $this->email->subject($this->input->post('subject'));
	    $this->email->message($html_email);
	    $result = $this->email->send();
	    var_dump($result);
	    
	    $this->_render('pages/contact/result-ok');
	    
	}
	
        // Load View
        $this->_render('pages/dashboard/index', 'DASHBOARD');
    }
    
 
}