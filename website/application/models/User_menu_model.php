<?php

class User_menu_model extends A11Y_Model {
    protected $table = 'user_menu';

    public function get_attributes($array = FALSE){
	$this->db->select('*');
	$this->db->from('user_menu_attribute');
	$this->db->join('attribute', 'attribute.id_attribute = user_menu_attribute.id_attribute');
	$this->db->where('id_user_menu', $this->id);
	$query = $this->db->get();
	
	if ($query->num_rows() > 0) {
	    $results = $query->result_array();
	    
	    if(!$array){
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
	    }
	    return $results;
	} else {
	    return false;
	}
	
	}


    public function change($id_menu, $id_user)
    {
	$result = $this->find(array('id_menu' => $id_menu, 'id_user' => $id_user));
	
	$this->db->trans_start();
	$this->update(array('default_menu' => false),array('id_user' => $id_user));
	if($result){
	    $this->update(array('default_menu' => true),array('id_user' => $id_user, 'id_menu' => $id_menu));
	} else {
	    $data = array(
		'id_menu' => $id_menu,
		'id_user' => $id_user,
		'default_menu' => true
	    );
	    $this->insert($data);
	}
	$this->db->trans_complete();
    }
    
    public function has_attributes(){
	$this->db->select('COUNT(*) as count');
	$this->db->from('user_menu_attribute');
	$this->db->where('id_user_menu', $this->id);
	$query = $this->db->get();
	
	if ($query->num_rows() > 0) {
	    $result = $query->result_array();
	    return $result[0]['count'];
	    
	} else {
	    return 0;
	}
    }
    
}