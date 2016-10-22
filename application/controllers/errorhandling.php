<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Errorhandling extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();        
	}

	public function index()
	{
		$page_slug = $this->uri->segment(2);
		$get_slug_data = explode(".",$page_slug);

            $this->db->like('product_no', $get_slug_data[0],'both');
            $this->db->or_like('alternate_name1', $get_slug_data[0],'both');
            $this->db->or_like('page_slug', $get_slug_data[0],'both');
            $this->db->or_like('alternate_name2', $get_slug_data[0],'both');
            $this->db->or_like('alternate_name3', $get_slug_data[0],'both');
            $this->db->limit(1);
            $search_query_r = $this->db->get('page');

            if($search_query_r->num_rows() > 0){
                // for 404 page
                foreach($search_query_r->result() as $search_query_data){
                    $page_slug = $search_query_data->page_slug;

                     redirect($page_slug, 'refresh');
                }

            }else{
                //redirect('', 'refresh');
                $this->load->view('error.php');
            }
	}
}