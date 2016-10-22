<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->privilege_m->is_admin()) {
            redirect('accounts/login');
        }
    }

    public function index()
    {
        // set default method
        $this->create();
    }

    public function create()
    {
        // set page title
        $data['page_title'] = $this->common_m->get_page_title('Admin Home');

        // load view
        $this->load->view('admin/home/home_v.php', $data);
    }

    

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */
