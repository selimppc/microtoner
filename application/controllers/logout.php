<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        // force to execute logout code
        $this->index();
    }

    function index()
    {
        $this->session->sess_destroy();
        redirect('accounts/login');
    }

}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */

