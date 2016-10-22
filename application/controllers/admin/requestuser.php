<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Page Class
 * 
 */

class Requestuser extends CI_Controller
{

    public $child_pages = array();

    /**
     * Constructor
     * 
     */

    function __construct()
    {
        parent::__construct();

        // only admin can access this page
        if (!$this->privilege_m->is_admin()) {
            redirect('accounts/login');
        }
    }

    public function index()
    {
        // set default method
        $this->home();
    }

    public function home(){
    	// set page title
        $data['page_title'] = $this->common_m->get_page_title('Request User module');

        // load views
        $this->load->view('admin/requestuser/home_v.php', $data);
    }

    public function order(){

        // set page title
        $data['page_title'] = $this->common_m->get_page_title('Request User module');

        // get all top level parent pages
        $page_sql =     
            "SELECT * FROM product_request where status=0 || status =2 group by user_id order by id desc";

        // set data for view file
        $data['page_q'] = $this->db->query($page_sql);

        // load views
        $this->load->view('admin/requestuser/order_v.php', $data);
    }

    public function shipped(){

        $user_id = (int) $this->input->post('page_id');

        $this->db->update(
                    'product_request', 
                    array(
                        'status' => 1
                    ), 
                    array(
                        'user_id' => $user_id
                    )
        );

        $ajax_response_data = array(
            'message' => 
                "<p class='alert alert-success'>
                Successfully shipped.

                </p>"            
        );
        echo json_encode($ajax_response_data);
        exit;
    }


    public function order_delete_request(){
        $user_id = (int) $this->input->post('page_id');

        $this->db->delete('product_request', array('user_id' => $user_id));

        $ajax_response_data = array(
            'message' => 
                "<p class='alert alert-success'>
                Successfully Deleted.

                </p>"            
        );
        echo json_encode($ajax_response_data);
        exit;
    }

    public function archieve_request(){

        $user_id = (int) $this->input->post('page_id');

        $this->db->update(
                    'product_request', 
                    array(
                        'status' => 3
                    ), 
                    array(
                        'user_id' => $user_id
                    )
        );

        $ajax_response_data = array(
            'message' => 
                "<p class='alert alert-success'>
                Successfully archieve.

                </p>"            
        );
        echo json_encode($ajax_response_data);
        exit;

    }


    public function all_shipped(){

        // set page title
        $data['page_title'] = $this->common_m->get_page_title('Request User module');

        $page_sql =     
            "SELECT DISTINCT user_id FROM product_request where status=1 order by id desc";

        // set data for view file
        $data['page_q'] = $this->db->query($page_sql);

        // load views
        $this->load->view('admin/requestuser/shipped_v.php', $data);


    }


    public function all_archieve(){

        // set page title
        $data['page_title'] = $this->common_m->get_page_title('Request User module');

        $page_sql =     
            "SELECT DISTINCT user_id FROM product_request where status=3 order by id desc";

        // set data for view file
        $data['page_q'] = $this->db->query($page_sql);

        // load views
        $this->load->view('admin/requestuser/archive_v.php', $data); 

    }


    public function generate_excel(){

        // set page title
        $data['page_title'] = $this->common_m->get_page_title('Request User module');

        // load views
        $this->load->view('admin/requestuser/generate_excel.php', $data);
    }

}