<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{

	/**
	 * Constructor
	 */

	function __construct() 
	{
		parent::__construct();
        $this->load->helper(array('text', 'email'));
	}

	/**
	 * Default method
	 */
    

	public function index()
	{
		// set page title
		$data['page_title'] = $this->common_m->get_page_title('Welcome to Micri Toner Supplies');

        $home_page_r = $this->common_m->get_by_fields(
                        '', 
                        'page', 
                        array(
                               'is_home_page' => 1
                            )
                    );
        // set found pages for view file
        $data['home_page_q'] = $home_page_r['data'];

		// load view
		$this->load->view('home/index_v.php', $data);
	}

        
        public function test()
	{
		// set page title
		$data['page_title'] = $this->common_m->get_page_title('Welcome to Micri Toner Supplies');

        $home_page_r = $this->common_m->get_by_fields(
                        '', 
                        'page', 
                        array(
                               'is_home_page' => 1
                            )
                    );
        // set found pages for view file
        $data['home_page_q'] = $home_page_r['data'];

		// load view
		$this->load->view('home/test.php', $data);
	}


}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
