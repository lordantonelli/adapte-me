<?php

class User_model extends A11Y_Model {
    protected $table = 'user';
    
    private $salt = 'e9axESBY';
    public $USER_LEVEL_ADMIN = 1;
    public $USER_LEVEL_PM = 2;
    public $USER_LEVEL_DEV = 3;
    

    public function insert($data)
    {
        $data['password'] = sha1($data['password'].$this->salt);
        return parent::insert($data);
    }
    
    public function validate($email, $password)
    {
        $this->db->where('email', $email)->where('password', sha1($password.$this->salt));
        $get = $this->db->get('user');

        if($get->num_rows() > 0) return $get->row_array();
        return array();
    }
    
    public function find_id($id)
    {
        $this->db->where('id_user', $id);
        $get = $this->db->get('user');

        if($get->num_rows() > 0) return $get->row_array();
        return array();
    }
    
    public function update_password($id, $password)
    {
        $data['password'] = sha1($password.$this->salt);
        $this->db->where('id_user', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }
    
    public function get_atributes($id = NULL){
	
    }
    
}