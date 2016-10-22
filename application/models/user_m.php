<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_m extends CI_Model {
    
    function get_by_userpass($username, $password, $return_type = 'query') {
        $where = array(
            'username' => $username,
            'password' => $password
        );
        
        $query = $this->db->get_where('user', $where);
        
        if($return_type == 'data') {
            $data = $query->row();
            return $data;
        } else {
            return $query;
        }
    }
}