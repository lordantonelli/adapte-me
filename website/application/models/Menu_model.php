<?php

class Menu_model extends A11Y_Model {
    protected $table = 'menu';
    
    public function get_attributes(){
	$this->db->select('*');
	$this->db->from('menu_attribute');
	$this->db->join('attribute', 'attribute.id_attribute = menu_attribute.id_attribute');
	$this->db->join('type_attribute', 'type_attribute.id_type_attribute = attribute.id_type_attribute');
	$this->db->where('id_menu', $this->id);
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
    
    public function getAttributesAllow($param){
	$this->db->select('*');
	$this->db->from('menu_attribute');
	$this->db->join('attribute', 'attribute.id_attribute = menu_attribute.id_attribute');
	$this->db->join('type_attribute', 'type_attribute.id_type_attribute = attribute.id_type_attribute');
	$this->db->where('id_menu', $this->id);
	if($param)
	    $this->db->where_not_in('menu_attribute.id_attribute', $param);
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
    
    public function has_attributes(){
	$this->db->select('COUNT(*) as count');
	$this->db->from('menu_attribute');
	$this->db->where('id_menu', $this->id);
	$query = $this->db->get();
	
	if ($query->num_rows() > 0) {
	    $result = $query->result_array();
	    return $result[0]['count'];
	    
	} else {
	    return 0;
	}
    }
    
}