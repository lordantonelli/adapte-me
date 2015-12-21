<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends A11Y_Controller {
    
    private $LEVEL;
    private $error = false;
    
    function User() {
        parent::__construct();
        if(!$this->session->userdata('logged'))
            redirect('login');
	
	$this->lang->load('user');
 
        $this->LEVEL = array(
            1 => 'Full Access',
            2 => 'Project Manager',
            3 => 'Developer'
        );
	$this->title = lang('page_title');
    }
    
    public function index()
    {
	$this->subtitle = lang('subtitle_index');
        // Load open transports
        $this->load->model('user_model');
        $this->data['users'] = $this->user_model->findAll();
	//var_dump($this->data['users']);
        $this->data['level_list'] = $this->LEVEL;
	
	
	$this->css = ['css/dataTables.bootstrap.css', 'css/dataTables.responsive.css'];
	$this->javascript = ['js/jquery.dataTables.min.js', 'js/dataTables.bootstrap.min.js'];
	$this->javascript_inline = '
	    $(document).ready(function() {
		$("#dataTables-user").DataTable({
			responsive: true
		});
	    });';

        // Load View
        $this->_render('pages/user/index');
    }
    
    public function add()
    {
	$this->subtitle = lang('subtitle_add');
        $this->data['data'] = (object) array (
	    'name_user' => '',
	    'birthdate' => '',
	    'gender' => '',
	    'email' => '',
	    'password' => '',
	    'level' => 1,
	    'level_list' =>$this->LEVEL
	);

        if ($this->error) {
            $data['error'] = $this->error;
        }

        $this->_render('pages/user/users_add');
    }

    public function edit($id)
    {
	$id = decode_url($id);
	$this->subtitle = lang('subtitle_edit'). ': <strong>' . str_pad($id, 8, "0", STR_PAD_LEFT) . '</strong>';
        $this->load->model('user_model');
        $this->data['data'] = $this->user_model->find($id);

        $this->data['data']->password = '';

        $this->data['level_list'] = $this->LEVEL;

        if ($this->error) {
            $this->data['error'] = $this->error;
        }
        $this->_render('pages/user/users_add');
    }
    
    public function remove($id)
    {
	$id = decode_url($id);
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
 
}
