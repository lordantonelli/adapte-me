<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
 
class Login extends A11Y_Controller {
    
    function __construct() {
	parent::__construct();
	$this->lang->load('login');
    }
 
    public function index()
    {
        // Load View
        $this->data['email'] = '';
        $this->data['password'] = '';
        $this->_render('pages/login/index', 'SIMPLEPAGE');
    }
    
    public function validate()
    {
        $this->load->model('user_model');
        $result = $this->user_model->validate($this->input->post('email'),$this->input->post('password'));
        if($result) {
	    if($result['verified'] == 0){
		// Load View
		$this->data['email'] = $this->input->post('email');
		$this->data['password'] = $this->input->post('password');
		$this->data['id_crypt'] = encode_url($result['id_user']);
		$this->data['error'] = 2;
		
		$this->_render('pages/login/index', 'SIMPLEPAGE');
	    }else{
		$this->session->set_userdata(array(
		    'logged' => true,
		    'user'  => $result['id_user'],
		    'email'  => $result['email'],
		    'level' => $result['level']
		));

		redirect('dashboard');
	    }
        } else {
            // Load View
            $this->data['email'] = $this->input->post('email');
            $this->data['password'] = $this->input->post('password');
            $this->data['error'] = 1;

	    $this->_render('pages/login/index', 'SIMPLEPAGE');
        }
    }
    
    public function recover()
    {
	if(empty($this->input->post())){
	    $this->data['email'] = '';	    
	    $this->_render('pages/login/recover', 'SIMPLEPAGE');
	}else{

	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('email', lang('label_email'), 'trim|required|valid_email|is_exist[user.email]');
	    
	    if($this->form_validation->run() === false)  {
		$this->data = $this->input->post();
		$this->_render('pages/login/recover', 'SIMPLEPAGE');    
		return;
	    }
	    
	    $this->load->model('user_model');
	    $result = $this->user_model->find(array('email' => $this->input->post('email')));
	    $this->send_recover_password($result->id_user, $result->email);
	    $this->_render('pages/login/recover-send', 'SIMPLEPAGE');
	}
	
    }
    
    public function recover_password($id)
    {
	if(empty($this->input->post())){  
	    $this->data['id_crypt'] = $id;
	    $this->_render('pages/login/recover-password', 'SIMPLEPAGE');
	}else{

	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('password', lang('label_password'), 'trim|required|min_length[8]');
	    $this->form_validation->set_rules('password_repeat', lang('label_password_repeat'), 'trim|required|matches[password]');
	    
	    if($this->form_validation->run() === false)  {
		$this->data['id_crypt'] = $id;
		$this->_render('pages/login/recover-password/', 'SIMPLEPAGE');    
		return;
	    }
	    
	    $this->load->model('user_model');
	    $this->user_model->update_password(decode_url($id), $this->input->post('password'));
	    
	    if($this->user_model->db->affected_rows() > 0){
		$result = $this->user_model->get(decode_url($id)); 
		$this->session->set_userdata(array(
			'logged' => true,
			'user'  => $result['id_user'],
			'level' => $result['level']
		    ));

		$this->_render('pages/login/recover-ok', 'SIMPLEPAGE');
	    }else{
		$this->data['id_crypt'] = $id;
		$this->data['error'] = TRUE;
		$this->_render('pages/login/recover-password/', 'SIMPLEPAGE');    
	    }
	    
	}
	
    }
    
    public function register()
    {
	$this->set_css('assets/datepicker/css/bootstrap-datepicker.min.css', 'datepicker');
	$this->set_javascript('assets/datepicker/js/bootstrap-datepicker.min.js', 'datepicker');
	
	if(empty($this->input->post())){
	    $this->data['name_user'] = '';
	    $this->data['birthdate'] = '';
	    $this->data['gender'] = '';
	    $this->data['email'] = '';	    
	    
	    $this->javascript_inline[] = '$("#birthdate").datepicker({endDate: "'.  date('d/m/Y').'", startView: 2, autoclose: true });';
	    $this->_render('pages/login/register', 'SIMPLEPAGE');
	}else{

	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('name_user', lang('label_name'), 'trim|required|min_length[5]');
	    $this->form_validation->set_rules('birthdate', lang('label_birthdate'), 'trim|required|date');
	    $this->form_validation->set_rules('gender', lang('label_gender'), 'trim|required');
	    $this->form_validation->set_rules('email', lang('label_email'), 'trim|required|valid_email|is_unique[user.email]');
	    $this->form_validation->set_rules('password', lang('label_password'), 'trim|required|min_length[8]');
	    $this->form_validation->set_rules('password_repeat', lang('label_password_repeat'), 'trim|required|matches[password]');
	    
	    if($this->form_validation->run() === false)  {
		$this->data = $this->input->post();
		
		$this->javascript_inline[] = '$("#birthdate").datepicker({endDate: "'.  date('d/m/Y').'", startView: 2, autoclose: true });';
		$this->_render('pages/login/register', 'SIMPLEPAGE');
	    
		return;
	    }
	    
	    $this->load->model('user_model');
	    $sql_data = $this->input->post();
	    $sql_data['birthdate'] = date('Y-m-d', strtotime(str_replace('/', '-', $sql_data['birthdate'])));
	    $sql_data['level'] = 3;
	    $sql_data['verified'] = false;

	    $result = $this->user_model->insert($sql_data);
	    //var_dump($result);
	    $this->send_verify_account($result->id_user, $result->email);
	    
	    $this->_render('pages/login/register-ok', 'SIMPLEPAGE');
	}
    }
    
    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('login');
    }
    
    public function verification_new($id)
    {
	$this->load->model('user_model');
	$result = $this->user_model->find(decode_url($id));
	if($result && decode_url($id) !== FALSE){
	    $this->send_verify_account($result->id_user, $result->email);
	    $this->_render('pages/login/register-ok', 'SIMPLEPAGE');
	}else{
	    $this->_render('pages/login/register-error', 'SIMPLEPAGE');
	}
    }
    
    public function verification_validate($id)
    {
	$this->load->model('user_model');
	$user = $this->user_model->find(decode_url($id));
	$user->verified = true;
	$result = $user->save();
	//var_dump($this->user_model->db->affected_rows());
        $this->_render('pages/login/verify-ok', 'SIMPLEPAGE');
    }
    
    protected function send_verify_account($id, $email){
	
	$this->data['id_crypt'] = encode_url($id);
	$html_email = $this->load->view('pages/login/mail-verify', $this->data, true);

	$this->email->to($email);
        $this->email->from();
        $this->email->subject(lang('verify_email_subject'));
        $this->email->message($html_email);
        $this->email->send();

    }

    protected function send_recover_password($id, $email){
	
	$this->data['id_crypt'] = encode_url($id);
	$html_email = $this->load->view('pages/login/mail-recover', $this->data, true);

	$this->email->to($email);
        $this->email->from();
        $this->email->subject(lang('recover_email_subject'));
        $this->email->message($html_email);
        $this->email->send();

    }
    
    
    public function login_plugin()
    {
	$name_menu = '';
	$attributes = '';
	
	// Load View
	$this->data = array(
		"logado" => false,
		"identify" => "",
		"name" => "",
		"menu" => $name_menu,
		"config" => $attributes
	    );
		
        $this->load->model('user_model');
	
	if($this->input->post('identify')){
	     $result = $this->user_model->find_id(decode_url($this->input->post('identify')));
	}else{
	    $result = $this->user_model->validate($this->input->post('email'),$this->input->post('password'));
	}
	
        if($result) {
	    if($result['verified'] != 0){
		$this->load->model('user_menu_model');
		$this->load->model('menu_model');
		$menu_default = $this->user_menu_model->find(array('id_user' => $result['id_user'], 'default_menu' => true));
		
		if($menu_default){    
		    $menu = $this->menu_model->find($menu_default->id_menu);
		    $name_menu = $menu->type;
		    $attributes_user = $menu_default->get_attributes(TRUE);
		    if($attributes_user){
			foreach ($attributes_user as $attribute) {
			    $attributes .= $attribute['property'] . '=' . $attribute['value'] . ',';
			}
			$attributes = substr($attributes, 0, -1);
		    }
		}
		
		$this->data = array(
			"logado" => true,
			"identify" => encode_url($result['id_user']),
			"name" => $result['name_user'],
			"menu" => $name_menu,
			"config" => $attributes
		    );
	    }
        }
	
	$this->_render('', 'JSON');
    }
 
}