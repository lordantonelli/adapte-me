<?php

class Menu_attribute_model extends A11Y_Model {
    protected $table = 'menu_attribute';

    public function get_property(){
	$this->db->select('property');
	$this->db->from('attribute');
	$this->db->where('id_attribute', $this->id_attribute);
	$query = $this->db->get();
	
	if ($query->num_rows() > 0) {
	    $result = $query->result_array();
	    return $result[0]['property'];
	} else {
	    return '';
	}
    }
}