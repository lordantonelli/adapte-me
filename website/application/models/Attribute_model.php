<?php

class Attribute_model extends A11Y_Model {
    protected $table = 'attribute';
    
    public function get_name_type(){
	$this->db->select('name_type_attribute');
	$this->db->from('type_attribute');
	$this->db->where('id_type_attribute', $this->id_type_attribute);
	$query = $this->db->get();
	
	if ($query->num_rows() > 0) {
	    $result = $query->result_array();
	    return $result[0]['name_type_attribute'];
	} else {
	    return '';
	}
    }
    
}