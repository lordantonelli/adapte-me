<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Preferences extends A11Y_Controller {
    
    private $LEVEL;
    private $error = false;
    
    function User() {
        parent::__construct();
        if(!$this->session->userdata('logged'))
            redirect('login');

	$this->lang->load('preferences');
	$this->title = lang('page_title');
    }
    
    public function index()
    {
        // Load open transports
        $this->load->model('user_menu');
        $this->data['users'] = $this->user_model->get(false);
        $this->data['level_list'] = $this->LEVEL;

        $this->data['page_title']  = "Users";
	
	
	$this->css = ['css/dataTables.bootstrap.css', 'css/dataTables.responsive.css'];
	$this->javascript = ['js/jquery.dataTables.min.js', 'js/dataTables.bootstrap.min.js'];
	$this->javascript_inline = '
	    $(document).ready(function() {
		$("#dataTables-user").DataTable({
			responsive: true
		});
	    });';

        // Load View
        $this->_render('pages/users', $this->data);
    }
    
    public function add()
    {
        $data['page_title']  = "New User";
        $data['email']    = '';
        $data['password'] = '';
        $data['level']    = '1';
        $data['level_list'] = $this->LEVEL;

        if ($this->error) {
            $data['error'] = $this->error;
        }

        $this->template->show('users_add', $data);
    }

    public function edit($id)
    {
        $this->load->model('user_model');
        $data = $this->user_model->get($id);

        $data['password'] = '';
        $data['page_title']  = "Edit User #".$id;

        $data['level_list'] = $this->LEVEL;

        if ($this->error) {
            $data['error'] = $this->error;
        }
        $this->template->show('users_add', $data);
    }
    
    public function remove($id)
    {
        $this->load->model('user_model');
        $this->user_model->delete($id);

        redirect('user');
    }
    
    public function save()
    {
        if ($this->input->post('cancel') !== NULL) {
            redirect('user');
        }

        $user_id = $this->input->post('id');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('level', 'Level', 'required');

        if($this->form_validation->run() === false)  {
            $this->class_error = ' has-error';

            if ($user_id) {
                $this->edit($user_id);
            } else {
                $this->add();
            }

            return;
        }
        //var_dump($this->error);
        
        $this->load->model('user_model');

        $sql_data = array(
            'email'    => $this->input->post('email'),
            'level'    => $this->input->post('level')
        );

        if($this->input->post('reset_password')){
            $sql_data['password'] = $this->input->post('password');
        }

        if ($user_id) {
            $this->user_model->update($user_id, $sql_data);
        } else {
            $this->user_model->create($sql_data);
        }

        redirect('user');
    }
    
    public function teste(){
	$this->_render('pages/preferences/teste');
    }
 
}
