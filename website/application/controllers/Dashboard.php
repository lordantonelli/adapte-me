<?php

defined('BASEPATH') OR exit('No direct script access allowed');
 
class Dashboard extends A11Y_Controller {
 
    function Dashboard()
    {
        parent::__construct();
	
	$this->lang->load('dashboard');
        
	if(!$this->session->userdata('logged'))
            redirect('login');
	
	$username = explode('@', $this->session->userdata('email'));
	
	$this->title = lang('page_title') . " <strong>{$username[0]}</strong>!";
    }
 
    public function index()
    {
        $this->subtitle = lang('subtitle_index');
	
	$this->load->model('user_model');
	$this->load->model('user_menu_attribute_model');
	$this->load->model('user_menu_model');
	$this->load->model('menu_model');
	
	$this->data['user'] = $this->user_model->find($this->session->userdata('user'));
	$menu_default = $this->user_menu_model->find(array('id_user' => $this->session->userdata('user'), 'default_menu' => true));
	if($menu_default){
	    $this->data['menu'] = $this->menu_model->find($menu_default->id_menu);
	    $this->data['menu_default'] = $menu_default;
	    $this->data['has_attribute'] = $this->data['menu']->has_attributes() - $menu_default->has_attributes();
	    $this->data['attributes'] = $menu_default->get_attributes();
	} else{
	    $this->data['menu'] = FALSE;
	    $this->data['menu_default'] = FALSE;
	    $this->data['attributes'] = FALSE;
	}
	//var_dump($this->data['attributes']);
 
        // Load View
        $this->_render('pages/dashboard/index', 'DASHBOARD');
    }
    
    public function user_edit()
    {
	$this->subtitle = lang('subtitle_user_edit');
        $this->load->model('user_model');
	
	if(empty($this->input->post())){
	    $this->data['data'] = $this->user_model->find($this->session->userdata('user'));
	    $this->_render('pages/dashboard/user-edit');
	}else{

	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('name_user', lang('label_name'), 'trim|required|min_length[5]');
	    $this->form_validation->set_rules('birthdate', lang('label_birthdate'), 'trim|required|date');
	    $this->form_validation->set_rules('gender', lang('label_gender'), 'trim|required');
	    $this->form_validation->set_rules('email', lang('label_email'), 'trim|required|valid_email|callback_email_check');
	    
	    if($this->form_validation->run() === false)  {
		$this->data['data'] = (object) $this->input->post();
		$this->_render('pages/dashboard/user-edit');    
		return;
	    }
	    
	    $sql_data = $this->input->post();
	    $sql_data['birthdate'] = date('Y-m-d', strtotime(str_replace('/', '-', $sql_data['birthdate'])));

	    $user = $this->user_model->find($this->session->userdata('user'));
	    $result = $user->update($sql_data);
	    $this->_render('pages/dashboard/result-ok');
	    
	}
        
    }
    
    public function alter_password(){
	
	$this->subtitle = lang('subtitle_alter_password');
	$this->load->model('user_model');
	
	if(empty($this->input->post())){
	    $this->_render('pages/dashboard/alter-password');
	}else{

	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('password_old', lang('label_old_password'), 'trim|required|callback_password_check');
	    $this->form_validation->set_rules('password', lang('label_new_password'), 'trim|required|min_length[8]');
	    $this->form_validation->set_rules('password_repeat', lang('label_password_repeat'), 'trim|required|matches[password]');
	    
	    if($this->form_validation->run() === false)  {
		$this->_render('pages/dashboard/alter-password');    
		return;
	    }
	    
	    $result = $this->user_model->update_password($this->session->userdata('user'), $this->input->post('password'));
	    
	    if($result){
		$this->_render('pages/dashboard/result-ok');
	    }else{
		$this->_render('pages/dashboard/result-error/');    
	    }
	    
	}
    }
    
    public function user_delete(){
	
	$this->subtitle = lang('subtitle_user_delete');
	$this->load->model('user_model');
	
	if(empty($this->input->post())){
	    $this->_render('pages/dashboard/user-delete');
	}else{
	    
	    $result = $this->user_model->delete($this->session->userdata('user'));
	    
	    if($result){
		$this->_render('pages/dashboard/result-ok');
	    }else{
		$this->_render('pages/dashboard/result-error');    
	    }
	    
	}
    }
    
    public function menu_change($id = NULL){
	
	$this->subtitle = lang('subtitle_menu_add_change');
	
	if($id === NULL){
	    $this->load->model('menu_model');
	    $this->data['menus'] = $this->menu_model->findAll();
	    $this->_render('pages/dashboard/menu-add-change', 'DASHBOARD');
	}else{
	    $this->load->model('user_menu_model');
	    $this->user_menu_model->change(decode_url($id), $this->session->userdata('user'));
	    
	    $result = true;//$this->user_model->update_password($this->session->userdata('user'), $this->input->post('password'));
	    
	    if($result){
		$this->_render('pages/dashboard/result-ok');
	    }else{
		$this->_render('pages/dashboard/result-error');    
	    }
	    
	}
    }
    
    public function restore_config($id_user_menu){
	
	$this->subtitle = lang('subtitle_restore_config');
	
	$this->load->model('user_menu_model');
	if(empty($this->input->post())){
	    $this->data['id_user_menu'] = $id_user_menu;
	    $this->_render('pages/dashboard/restore-config');
	}else{
	    $this->load->model('user_menu_attribute_model');
	    $attributes = $this->user_menu_attribute_model->findAll(array('id_user_menu' => decode_url($this->input->post('id_user_menu'))));
	    foreach ($attributes as $attribute) {
		$result = $attribute->delete();
	    }
	    if($result){
		$this->_render('pages/dashboard/result-ok');
	    }else{
		$this->_render('pages/dashboard/result-error');    
	    }
	    
	}
    }
    
    public function attribute_add($id_user_menu){
	
	if($this->input->post('id_attribute') !== NULL && !empty($this->input->post('id_attribute'))){
	    
	    $this->load->model('attribute_model');
	    $attribute = $this->attribute_model->find($this->input->post('id_attribute'));
	    $type_attribute = $attribute->get_name_type();
	
	    $this->subtitle = lang('subtitle_add_attribute_step2'). ': <strong class="text-primary">'. $attribute->name_attribute . '</strong>';

	    $this->load->model('menu_model');
	    $this->load->model('user_menu_model');
	    $this->load->model('user_menu_attribute_model');
	    
	    $user_menu = $this->user_menu_model->find(decode_url($id_user_menu));
	    $config = array();
	    $value_default = '';
	    $property_default = '';
	    
	    $attributes_default = $this->menu_model->find(array('id_menu' => $user_menu->id_menu))->get_attributes();
	    foreach ($attributes_default as $attribute) {
		$config[$attribute->property] = $attribute->default_value;
		if($attribute->id_attribute == $this->input->post('id_attribute')){
		    $value_default = $attribute->default_value;
		    $property_default = $attribute->property;
		}
	    }
	    
	    $user_menu_attributes = $user_menu->get_attributes();
	    if($user_menu_attributes){
		foreach ($user_menu_attributes as $attribute) {
		    $config[$attribute->property] = $attribute->value;
		}
	    }
	    
	    $this->data['config'] = $config;


	    $this->data['data'] = $this->user_menu_attribute_model;
	    $this->data['data']->id_user_menu = $id_user_menu;
	    $this->data['data']->id_attribute = $this->input->post('id_attribute');
	    $this->data['data']->value = $value_default;
	    $this->data['data']->property = $property_default;
	    $this->data['type'] = $type_attribute;
	    $this->_render('pages/dashboard/atribute-add-2');
	    
	}else{
	    $this->subtitle = lang('subtitle_add_attribute_step1');

	    $this->load->model('user_menu_model');
	    $this->load->model('user_menu_attribute_model');
	    $user_menu = $this->user_menu_model->find(decode_url($id_user_menu));
	    $attributes_exist = array();
	    $user_menu_attributes = $user_menu->get_attributes();
	    if($user_menu_attributes){
		foreach ($user_menu_attributes as $attribute) {
		    $attributes_exist[] = $attribute->id_attribute;
		}
	    }

	    $this->load->model('menu_model');
	    $menu = $this->menu_model->find($user_menu->id_menu);

	    $attributes = $menu->getAttributesAllow($attributes_exist);
	    $this->data['attributes'] = array();
	    foreach ($attributes as $attribute) {
		$this->data['attributes'][$attribute->id_attribute] = $attribute->name_attribute;
	    }

	    $this->data['data'] = $this->user_menu_attribute_model;
	    $this->data['data']->id_user_menu = $id_user_menu;
	    $this->_render('pages/dashboard/atribute-add-1');
	}
    }
    
    public function attribute_edit($id_user_menu_attribute){
	    
	$this->load->model('user_menu_attribute_model');
	$data = $this->user_menu_attribute_model->find(decode_url($id_user_menu_attribute));

	$this->subtitle = lang('subtitle_add_attribute_step2'). ': <strong class="text-primary">'. $data->get_name() . '</strong>';

	$this->load->model('menu_model');
	$this->load->model('user_menu_model');

	$config = array();
	$user_menu = $this->user_menu_model->find($data->id_user_menu);
	$attributes_default = $this->menu_model->find(array('id_menu' => $user_menu->id_menu))->get_attributes();
	foreach ($attributes_default as $attribute) {
	    $config[$attribute->property] = $attribute->default_value;
	}

	$user_menu_attributes = $user_menu->get_attributes();
	if($user_menu_attributes){
	    foreach ($user_menu_attributes as $attribute) {
		$config[$attribute->property] = $attribute->value;
	    }
	}

	$this->data['config'] = $config;
	$this->data['data'] = $data;
	$this->data['data']->id_user_menu = encode_url($this->data['data']->id_user_menu);
	$this->data['data']->property = $data->get_property();
	$this->data['type'] = $data->get_type();
	
	$this->_render('pages/dashboard/atribute-add-2');
    }
    
    public function attribute_save(){
	
	if(!empty($this->input->post())){
	    
	    
	    $this->load->model('user_menu_attribute_model');
	    $this->load->model('attribute_model');
	    
	    $attribute = $this->attribute_model->find($this->input->post('id_attribute'));
	    
	    $sql_data = $this->input->post();
	    $sql_data['id_user_menu'] = decode_url($sql_data['id_user_menu']);
	    if($attribute->get_name_type() == 'number'){
		$sql_data['value'] .= '%';
	    }

	    if(empty($this->input->post('id_user_menu_attribute'))){
		$result = $this->user_menu_attribute_model->insert($sql_data);
	    } else {
		$result = $this->user_menu_attribute_model->update($sql_data);
	    }
	    
	    if($result){
		$this->_render('pages/dashboard/result-ok');
	    }else{
		$this->_render('pages/dashboard/result-error');    
	    }
	    
	}else{
	    $this->_render('pages/dashboard/result-error');  
	}
    }
    
    public function attribute_delete($id){
	
	$this->subtitle = lang('subtitle_attribute_delete');
	$this->load->model('user_menu_attribute_model');
	
	if(empty($this->input->post())){
	    $this->data['id_attribute'] = $id;
	    $attribute = $this->user_menu_attribute_model->find(decode_url($id));
	    $this->data['name_attribute'] = $attribute->get_name();
	    $this->_render('pages/dashboard/attribute-delete');
	}else{
	    $result = $this->user_menu_attribute_model->delete(decode_url($this->input->post('id_attribute')));
	    
	    if($result){
		$this->_render('pages/dashboard/result-ok');
	    }else{
		$this->_render('pages/dashboard/result-error');    
	    }
	    
	}
    }

    public function password_check($value)
    {
	$this->load->model('user_model');
	$result = $this->user_model->validate($this->session->userdata('email'),$value);
	if(empty($result)){
	    $this->form_validation->set_message('password_check', 'A senha antiga está incorreta.');
	    return FALSE;
	}else{
	    return TRUE;
	}
    }
    
    public function email_check($value)
    {
	$this->load->model('user_model');
	$result = $this->user_model->find(array('email' => $value));
	if(!empty($result)){
	    if($result->email != $this->session->userdata('email')){
		$this->form_validation->set_message('email_check', 'Este e-mail já está cadastrado!');
		return FALSE;
	    }
	}
	return TRUE;
    }
 
}