<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privilege_m extends CI_Model {
    
    function get_by_id($id, $return_type = 'query') {
        $query = $this->db->get_where('privilege', array(
                                                         'id' => $id
                                                         ));
        if($return_type == 'data') {
            $data = $query->row();
        } else {
            
        }
    }
    
    function is_logged_in() {
        if($this->session->userdata('is_logged_in') === TRUE) {
            return TRUE;
        }
        return FALSE;
    }
    
    function is_admin() {
        if($this->session->userdata('is_admin') === TRUE) {
            return TRUE;
        }
        return FALSE;
    }
    
}