<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Page Class
 * 
 */

class Printer extends CI_Controller
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

    /**
     * Index
     */

    public function index()
    {
        // set default method
        $this->home();
    }

    /**
     * Home
     * 
     * Intro page of page module.
     */

    public function home()
    {
        
        // set page title
        $data['page_title'] = $this->common_m->get_page_title('Printer module');

        // // load views
        $this->load->view('admin/printer/home_v.php', $data);
    }


     public function entry($edit_page_id = ''){

        // is page_id available from save method?
        if (!empty($edit_page_id)) {
            // yes, then get that id
            $page_id = (int) $edit_page_id;
        } else {
            // no, try to get page id from url
            $page_id = (int) $this->uri->segment(4);
        }

        // is page_id available?
        if (!empty($page_id)) {

            // check for valid page id
            $page_request = $this->common_m->get_by_fields(
                '', 
                'printer', 
                array('id' => $page_id), 
                '', 
                1
            );

            $page_data = $page_request['data'];

            // set page data for view file
            $data['page_data'] = $page_data;

            

            // get all primary photos of current printer
                $page_photo_r = $this->common_m->get_by_fields(
                        '', 
                        'printer_photos', 
                        array(
                            'printer_id' => $page_data->id
                            )
                    );
                $data['page_photo_q'] = $page_photo_r['query'];

        }

        // check for parent Printer list
            $parent_printer_list_request = $this->common_m->get_by_fields(
                '', 
                'page', 
                array('is_service_page' => 1), 
                '', 
                ''
            );

            $data['parent_printer_list_r'] = $parent_printer_list_request['query'];

            

        $data['page_title'] = $this->common_m->get_page_title('Create a new printer');
         // load view
        $this->load->view('admin/printer/entry_v.php', $data);
     }


     /**
     * Save photo information
     */
    public function save_photo()
    {
        // get page id
        $page_id = (int) $this->input->post('page_id');
        // get photo file name
        $file_name = $this->input->post('file_name');
        // get photo raw name
        $raw_name = $this->input->post('raw_name');
        // get photo file extension
        $file_ext = $this->input->post('file_ext');

        // prepare insert update data
        $insert_update_data = array(
            'printer_id' => $page_id,
            'photo_file_name' => $file_name,
            'photo_raw_name' => $raw_name,
            'photo_file_ext' => $file_ext
        );

        $this->common_m->insert('printer_photos', $insert_update_data);
        $last_insert_id = $this->db->insert_id();
        echo json_encode(array('last_insert_id' => $last_insert_id, 'page_id' => $page_id));
        exit;
    }

     /**
     * Delete primary photo
     */

    public function delete_photo()
    {
        // get photo id
        $photo_id = (int) $this->input->post('photo_id');

        // check for valid photo id 
        $photo_r = $this->common_m->get_by_fields(
                        '', 
                        'printer_photos', 
                        array(
                            'id' => $photo_id
                            ), 
                        '', 
                        1
        );
        if ($photo_r['num_rows'] != 0) {
            // valid photo id
            $photo_data = $photo_r['data'];

            // delete photo from disk
            unlink("./server/php/files/{$photo_data->photo_file_name}");
            unlink("./server/php/files/thumbnail/{$photo_data->photo_file_name}");            

            // delete from db
            $this->db->delete('printer_photos', array('id' => $photo_id));
        } else {
            // invalid photo
            redirect('admin/page');
        }
        
    }
    
    public function update_sort_order()
    {
        $page_id = $this->input->post('page_id');
        $sort_order = $this->input->post('sort_order');

        $this->db->update(  
                'printer', 
                array('sort_order' => $sort_order), 
                array('id' => $page_id)
            );
        echo 'done';
    }

    public function set_pri_sort_title()
    {
        // get photo id
        $photo_id = (int) $this->input->post('photo_id');
        // get page id
        $page_id = (int) $this->input->post('page_id');
        $pri_sort_title = $this->input->post('pri_sort_title');

            $this->db->update(
               'printer_photos', 
                array(
                    'short_title' => $pri_sort_title
                ), 
                 array(
                   'id' => $photo_id,
                    'printer_id' => $page_id
                   )
                );
            
        
    }

     public function pri_sort_description()
    {
        // get photo id
        $photo_id = (int) $this->input->post('photo_id');
        // get page id
        $page_id = (int) $this->input->post('page_id');
        $pri_sort_description = $this->input->post('pri_sort_description');

            $this->db->update(
               'printer_photos', 
                array(
                    'short_description' => $pri_sort_description
                ), 
                 array(
                   'id' => $photo_id,
                    'printer_id' => $page_id
                   )
                );
            
        
    }

    /**
     * Save a page
     * 
     */

    public function save()
    {

        // for updating page, page id will be available in post data
        $page_id = (int) $this->input->post('page_id');


        // set page title for create page
        $data['page_title'] = $this->common_m->get_page_title('Create a new printer');
        

        // set valiation rules
        

        $this->form_validation->set_rules(  
                'printer_name', 
                'Printer Name', 
                'trim|required|htmlspecialchars'
            );
        

        if ($this->form_validation->run() == false) {
            // validation failed
            // send error message to view
            $ajax_return_data['msg'] = validation_errors('<p class="alert alert-warning">', '</p>');
            echo json_encode($ajax_return_data);
            exit;
        } else {


            
            // validation passed
            $insert_update_data = array(
                'published' => $this->input->post('is_published'),
                'printer_name' => $this->input->post('printer_name'),
                'printer_slug' => $this->input->post('printer_slug'),
                'meta_title' => $this->input->post('meta_title'),
                'alternative_name1' => $this->input->post('alternative_name1'),
                'alternative_name2' => $this->input->post('alternative_name2'),
                'alternative_name3' => $this->input->post('alternative_name3'),
                'additionaltype' => $this->input->post('additionaltype'),
                'parent_printer' => $this->input->post('parent_printer'),
                'printer_description' => $this->input->post('printer_description', false)
            );



            // is page id available?
            if (!empty($page_id)) {

                    $updated = $this->common_m->update(
                        'printer', 
                        $insert_update_data, 
                        array(
                                'id' => $page_id
                            )
                    );
                        if ($updated) {
                            // successfully updated
                            // send message to view
                            $ajax_return_data['msg'] = 
                                "<p class='alert alert-success'>Successfully updated.</p>";
                            echo json_encode($ajax_return_data);
                            exit;
                        } else {
                            // update failed
                            $ajax_return_data['msg'] = 
                                "<p class='alert alert-error'>Failed to update.</p>";
                            echo json_encode($ajax_return_data);
                            exit;
                        }

            }else{


                if ($this->common_m->insert('printer', $insert_update_data)) {
                    // create successful
                    

                    // send message to view
                    $ajax_return_data['msg'] = "<p class='alert alert-success'>Successfully created.</p>";
                    echo json_encode($ajax_return_data);
                    exit;
                } else {
                    // failed to create
                    // send message to view
                    $ajax_return_data['msg'] = "<p class='alert alert-error'>Failed to create.</p>";
                    echo json_encode($ajax_return_data);
                    exit;
                }

            }

            



            
        }
    }



    /**
     * Show all pages and sub pages based on availability of parent page id.
     */

    public function all()
    {    
            

        // set page title
        $data['page_title'] = $this->common_m->get_page_title('All Printer');

         // get all top level parent pages
            $page_sql =     
                "SELECT distinct parent_printer 
                FROM printer";

            // set data for view file
            $data['page_q'] = $this->db->query($page_sql);

        // load views
        $this->load->view('admin/printer/all_v.php', $data);
        
    }

    function more(){

        $printer_title = $this->uri->segment(4);
         // set page title
        $data['page_title'] = $this->common_m->get_page_title('All Printer');

          // get all top level parent pages
             $page_sql =     
                 "SELECT * 
                 FROM printer where parent_printer = '$printer_title'";

             // set data for view file
             $data['page_q'] = $this->db->query($page_sql);

         // load views
         $this->load->view('admin/printer/all_sub.php', $data);
    }


    /**
     * Delete printer
     */

    public function delete()
    {
        // get page id
        $page_id = (int) $this->input->post('page_id');

        if ($this->db->delete('printer', array('id' => $page_id))) {

            // delete relations with galleries
                    $ajax_response_data = array(
                        'deleted' => 1,
                        'message' => 
                            "<p class='alert alert-success'>
                            Successfully deleted.

                            </p>",
                        'deleted_page_id' => $page_id
                    );
                    echo json_encode($ajax_response_data);
                    exit;
        }

    }


    public function duplicate(){

        $current_page_id = (int) $this->uri->segment(4);

        $current_page_data_r = $this->common_m->get_by_fields(
                '', 
                'printer', 
                array('id' => $current_page_id), 
                '', 
                1
            );

       $current_page_data = $current_page_data_r['data'];

       $this->db->insert('printer', array(
            'printer_name' => $current_page_data->printer_name . ' copy',
            'printer_slug' => $current_page_data->printer_slug. 'copy',
            'printer_description' => $current_page_data->printer_description,
            'parent_printer' => $current_page_data->parent_printer,
            'alternative_name1' => $current_page_data->alternative_name1,
            'alternative_name2' => $current_page_data->alternative_name2,
            'alternative_name3' => $current_page_data->alternative_name3,
            'additionaltype' => $current_page_data->additionaltype,
            'meta_title' => $current_page_data->meta_title           
        ));
        $duplicate_start_id = $this->db->insert_id();

        redirect('admin/printer_list/more/'.$current_page_data->parent_printer);
    }


}

