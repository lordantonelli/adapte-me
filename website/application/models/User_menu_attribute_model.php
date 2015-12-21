<?php

class User_menu_attribute_model extends A11Y_Model {
    protected $table = 'user_menu_attribute';
    
    protected $data_attribute = NULL;

    public function get_attributes(){
	$this->db->select('*');
	$this->db->from('user_menu_attribute');
	$this->db->join('attribute', 'attribute.id_attribute = user_menu_attribute.id_attribute');
	$this->db->where('id_user_menu', $this->id);
	$query = $this->db->get();
	
	if ($query->num_rows() > 0) {
	    $results = $query->result_array();
	    $objects = array();

	    foreach ($results as $result) {
		if ($class = get_called_class()) {
		    $obj = new $class($result);

		    $objects[] = $obj;
		} else {
		    throw new Exception("Model class not found.");
		}
	    }

	    return $objects;
	} else {
	    return false;
	}
	
    }
    
    public function get_name(){
	if($this->data_attribute === NULL){
	    $this->db->select('*');
	    $this->db->from('attribute');
	    $this->db->where('id_attribute', $this->id_attribute);
	    $query = $this->db->get();

	    if ($query->num_rows() > 0) {
		$result = $query->result_array();
		$this->data_attribute = $result[0];
	    } else {
		return '';
	    }
	}
	return $this->data_attribute['name_attribute'];
    }
    
    public function get_property(){
	if($this->data_attribute === NULL){
	    $this->db->select('*');
	    $this->db->from('attribute');
	    $this->db->where('id_attribute', $this->id_attribute);
	    $query = $this->db->get();

	    if ($query->num_rows() > 0) {
		$result = $query->result_array();
		$this->data_attribute = $result[0];
	    } else {
		return '';
	    }
	}
	return $this->data_attribute['property'];
    }
    
    public function get_type(){
	$this->db->select('name_type_attribute');
	$this->db->from('type_attribute');
	$this->db->where('id_type_attribute', $this->data_attribute['id_type_attribute']);
	$query = $this->db->get();
	
	if ($query->num_rows() > 0) {
	    $result = $query->result_array();
	    return $result[0]['name_type_attribute'];
	} else {
	    return '';
	}
    }

    public function update_password($id, $password)
    {
        $data['password'] = sha1($password.$this->salt);
        $this->db->where('id_user', $id);
        $update = $this->db->update('user', $data);
        return $update;
    }
    
}