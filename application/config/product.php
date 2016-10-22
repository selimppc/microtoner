<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller 
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
		
	}


    public function add_related_product(){
        $detail_page_qty = $_POST['detials_related_qty'];
        $detail_page_id = $_POST['product_id'];

        // product id
        $check_product_id_list = $this->session->userdata('product_id');
        if (is_array($check_product_id_list) && count($check_product_id_list)) {
            $product_id = $check_product_id_list;           
        } else {
            $product_id = array();
        }
        array_push($product_id, $detail_page_id);
        $this->session->set_userdata('product_id', $product_id);

        // product_quantity
        $check_product_quantity_list = $this->session->userdata('product_quantity');
        if (is_array($check_product_quantity_list) && count($check_product_quantity_list)) {
            $product_quantity = $check_product_quantity_list;           
        } else {
            $product_quantity = array();
        }
        array_push($product_quantity, $detail_page_qty);
        $this->session->set_userdata('product_quantity', $product_quantity);

        $this->load->view('checkout/shoppingcart.php'); 
    }

    public function update_shopping_cart(){
        
        $delete_product_request = $_POST;

        $check_product_id_list = $this->session->userdata('product_id');
        $check_product_quantity_list = $this->session->userdata('product_quantity');

        for($i=0; $i<sizeof($check_product_id_list);$i++){
            
            if($check_product_id_list[$i] == $delete_product_request['product_id']){

                $new_array_product = array($delete_product_request['product_id']);
                $product_id=array_values(array_diff($check_product_id_list,$new_array_product));
                $this->session->set_userdata('product_id', $product_id);

                // print_r($check_product_id_list);
                // echo '<br/><br/>';
                // print_r($new_array_product);
                // echo '<br/></br>';
                // print_r($product_id);

                
                $new_array_product_qty = array($check_product_quantity_list[$i]);
                $product_quantity=array_values(array_diff_key($check_product_quantity_list,$new_array_product_qty));
                
                // echo '<br/><br/>';
                // print_r($check_product_quantity_list);
                // echo '<br/><br/>';
                // print_r($new_array_product_qty);
                // echo '<br/></br>';
                // print_r($product_quantity);
                $this->session->set_userdata('product_quantity', $product_quantity);
            }
        }
        //exit;
        $this->load->view('checkout/shoppingcart.php'); 
    }


    public function updateqty_shopping_cart(){

        $delete_product_request = $_POST;

        $check_product_id_list = $this->session->userdata('product_id');
        $check_product_quantity_list = $this->session->userdata('product_quantity');
        
        for($i=0; $i<sizeof($check_product_id_list);$i++){
            
            if($check_product_id_list[$i] == $delete_product_request['product_id']){

                $new_array_product = array($delete_product_request['product_id']);
                $product_id=array_values(array_diff($check_product_id_list,$new_array_product));
                array_push($product_id, $delete_product_request['product_id']);
                $this->session->set_userdata('product_id', $product_id);
                
                $new_array_product_qty = array($check_product_quantity_list[$i]);
                $product_quantity=array_values(array_diff($check_product_quantity_list,$new_array_product_qty));
                array_push($product_quantity, $delete_product_request['update_qty']);
                
                $this->session->set_userdata('product_quantity', $product_quantity);
            }
        }

        //exit;
         $this->load->view('checkout/shoppingcart.php'); 
    }

    public function inktoner(){

        // parent_slug
        $data['parent_id'] = $page_slug = $this->uri->segment(2); 

        // set page title
        $data['page_title'] = $this->common_m->get_page_title('Welcome to Micri Toner Supplies');
        $page_slug = $this->uri->segment(2);

        $continue_url = $this->uri->segment(1).'/'.$page_slug;
        $this->session->set_userdata('continue_shopping',$continue_url);

        //home page data
        $home_page_r = $this->common_m->get_by_fields(
                        '', 
                        'page', 
                        array(
                               'is_home_page' => 1
                            )
                    );
        // set found pages for view file
        $data['home_page_q'] = $home_page_r['data'];


        //currtent page data
        $page_data_r = $this->common_m->get_by_fields(
                        '', 
                        'page', 
                        array(
                               'page_slug' => $page_slug
                            )
                    );
        if(count($page_data_r) == 2){
            $this->load->view('error.php'); 
        }else{

            // set found pages for view file
            $data['page_data_q'] = $page_data_r['data'];
            $page_data_q = $data['page_data_q'];

            $data['page_data'] = $this->common_m->get_parent_page($page_data_q->id);

            // load view
            $this->load->view('product/inktoner.php', $data);
        }
    }

    public function printer_details(){


        $data['page_slug'] = $page_slug = $this->uri->segment(2); 

        $page_data_r = $this->common_m->get_by_fields(
                            '', 
                            'printer', 
                            array(
                                   'printer_slug' => $page_slug
                                )
                        );

        

        if(count($page_data_r) == 2){
            $this->load->view('error.php'); 
        }else{

            // set found pages for view file
            $data['page_data'] = $page_data_r['data'];
            
            $page_data = $data['page_data'];


            // for related data
            $parent_slug = $page_slug = $this->uri->segment(1); 
            $data['parent_slug'] = $parent_slug; 
            $parent_data_r = $this->common_m->get_by_fields(
                                '', 
                                'page', 
                                array(
                                       'page_slug' => $parent_slug
                                    )
                            );
            // set found pages for view file
            $data['parent_data'] = $parent_data_r['data'];
            $parent_data = $data['parent_data'];



            $data['related_data_q'] = $this->common_m->sub_menu_printer_r($page_data->id); 

            $this->load->view('product/printer.php',$data);
    }
    }


    public function details(){
        
       // // parent slug
       //   $data['parent_slug'] = $this->uri->segment(2);

       //  // main pages
       //  $page_slug = $this->uri->segment(3);
        
       //  //currtent page data
       //  $page_data_r = $this->common_m->get_by_fields(
       //                  '', 
       //                  'page', 
       //                  array(
       //                         'page_slug' => $page_slug
       //                      )
       //              );
       //  // set found pages for view file
       //  $data['page_data'] = $page_data_r['data'];
       //  $page_data = $data['page_data'];


       //  // related slug

       //  $parent_page = $this->common_m->get_parent_page($page_data->id);
        
       //  $data['related_data_q'] = $this->common_m->sub_menu($parent_page->parent_page_id);                      
       
       //  $this->load->view('product/details.php',$data);
    }


    public function pages(){

        $page_slug = $this->uri->segment(1);
        
        //currtent page data
        $page_data_r = $this->common_m->get_by_fields(
                        '', 
                        'page', 
                        array(
                               'page_slug' => $page_slug
                            )
                    );

        if(count($page_data_r) == 2){
             $this->load->view('error.php');
            
        }else{
            // set found pages for view file
            $data['page_data'] = $page_data_r['data'];
        
        

        $page_data = $data['page_data'];

        $page_slug_2 = $this->uri->segment(2);
        
        if(!empty($page_slug_2)){
                //currtent page data
                $page_data_r_2 = $this->common_m->get_by_fields(
                                '', 
                                'page', 
                                array(
                                       'page_slug' => $page_slug_2
                                    )
                            );
                // set found pages for view file
                $data['page_data_2'] = $page_data_r_2['data'];

                $page_data_2 = $data['page_data_2'];
            }

        // for brother
        if($page_data->is_project == 1){
            

            $data['page_title'] = $this->common_m->get_page_title('Welcome to Micri Toner Supplies');
            $page_slug = $this->uri->segment(1);

            $this->session->set_userdata('continue_shopping', $page_slug);

            //home page data
            $home_page_r = $this->common_m->get_by_fields(
                            '', 
                            'page', 
                            array(
                                   'is_home_page' => 1
                                )
                        );
            // set found pages for view file
            $data['home_page_q'] = $home_page_r['data'];

            //currtent page data
            $page_data_r = $this->common_m->get_by_fields(
                            '', 
                            'page', 
                            array(
                                   'page_slug' => $page_slug
                                )
                        );
            // set found pages for view file
            $data['page_data'] = $page_data_r['data'];
            $page_data = $data['page_data'];

            $data['get_child_id_r'] = $this->common_m->get_child_page($page_data->id); 


            // load view
            $this->load->view('product/index_v.php', $data);


        }else if($page_data->is_service_page == 1){
            
            // for printer
             // parent slug
             $data['parent_slug'] = $this->uri->segment(1);
             
            // main pages
            $page_slug = $this->uri->segment(2);
            
            //currtent page data
            $page_data_r = $this->common_m->get_by_fields(
                            '', 
                            'page', 
                            array(
                                   'page_slug' => $page_slug
                                )
                        );
            // set found pages for view file
            $data['page_data'] = $page_data_r['data'];
            $page_data = $data['page_data'];

            // related slug

            $parent_page = $this->common_m->get_parent_page($page_data->id);
            $data['parent_page'] = $parent_page;
            
            $data['related_data_q'] = $this->common_m->sub_menu_printer($parent_page->parent_page_id); 
            

            $this->load->view('product/printer.php',$data);


        }else if($page_data->is_featured_project == 1){
            
                     // parent slug
                 $data['parent_slug'] = $this->uri->segment(2);

                // main pages
                $page_slug = $this->uri->segment(1);
                
                //currtent page data
                $page_data_r = $this->common_m->get_by_fields(
                                '', 
                                'page', 
                                array(
                                       'page_slug' => $page_slug
                                    )
                            );
                // set found pages for view file
                $data['page_data'] = $page_data_r['data'];
                $page_data = $data['page_data'];

                // related slug

                $parent_page = $this->common_m->get_parent_page($page_data->id);
                $parent_page_up1 = $this->common_m->get_parent_page($parent_page->parent_page_id);
                
                $data['related_data_q'] = $this->common_m->related_printer_list($page_data->id);

                $first_parent = $this->common_m->get_parent_page($page_data->id);                     
                $second_parent = $this->common_m->get_parent_page($first_parent->parent_page_id);                     

                //currtent page data
                $parent_data_r = $this->common_m->get_by_fields(
                                '', 
                                'page', 
                                array(
                                       'id' => $second_parent->parent_page_id
                                    )
                            );
                // set found pages for view file
                $data['parent_data'] = $parent_data_r['data'];
                $parent_data = $data['parent_data'];                
                
                $printer_list_r = $this->common_m->related_printer_list($page_data->id);
                $data['printer_list_r'] = $printer_list_r; 
               
                $this->load->view('product/details.php',$data);

        }else if($page_data->is_contact_page == 1){
            $this->load->view('contact_us.php',$data);
        }else{
            $this->load->view('innerpages.php',$data);
        }

    }
        
    }

    public function search_by_productno(){
        $search_by_product_number = $_POST['search_by_product_number'];
        $data['search_by_product_number'] = $search_by_product_number;

        $this->db->like('product_no', $search_by_product_number);
        $this->db->or_like('alternate_name1', $search_by_product_number);
        $this->db->or_like('alternate_name2', $search_by_product_number);
        $this->db->or_like('alternate_name3', $search_by_product_number);
        
        $data['search_query_r'] = $this->db->get('page');

        $this->load->view('search/producr_no.php',$data);
       
    }


    public function search_by_printer(){

        $search_by_product_number = $_POST['search_by_printer_number'];

        $data['search_by_product_number'] = $search_by_product_number;

        $this->db->like('printer_name', $search_by_product_number);
        $this->db->or_like('alternative_name1', $search_by_product_number);
        $this->db->or_like('alternative_name2', $search_by_product_number);
        $this->db->or_like('alternative_name3', $search_by_product_number);
        
        
        $data['search_query_r'] = $this->db->get('printer');

        $this->load->view('search/printer_list.php',$data);
    }


    public function search_by_cartridge_number(){
        $search_by_product_number = $_POST['search_by_v_cartridge_number'];

        $data['search_by_product_number'] = $search_by_product_number;

        $this->db->like('title', $search_by_product_number);
        
        $data['search_query_r'] = $this->db->get('page');

        $this->load->view('search/cartridge_number.php',$data);
    }


}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
