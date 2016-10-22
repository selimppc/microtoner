<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Page Class
 * 
 */

class Page extends CI_Controller
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
        $data['page_title'] = $this->common_m->get_page_title('Page module');

        // load views
        $this->load->view('admin/page/home_v.php', $data);
    }

    /**
     * Create or Update a page.
     * 
     * Data entry page for both creating and updating page. While updating 
     * page_id will be available for this method.
     * 
     * @param int $edit_page_id
     */

    public function entry($edit_page_id = '')
    {
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
                    'page', 
                    array('id' => $page_id), 
                    '', 
                    1
                );

            if ($page_request['num_rows'] == 0) {
                // invalid page id
                redirect('admin/page');
            } else {
                // valid page id
                // fetch page data
                $page_data = $page_request['data'];

                // set page data for view file
                $data['page_data'] = $page_data;

                /**
                 * Get pages to show in page relation dropdown list.
                 * 
                 * A page cannot be sub-page of itself. So do not include current
                 * page. Also a segment cannot have sub-page. So do not include
                 * page segments in this list.
                 */

                $all_pages_not_this_r = $this->common_m->get_by_fields(
                        '', 
                        'page', 
                        array(
                                'id !=' => $page_id, 
                                'is_segment' => 0
                            )
                    );
                // set found pages for view file
                $data['all_pages_not_this_q'] = $all_pages_not_this_r['query'];

                // get all gallereis, to show in page gallery relation dropdown
                $all_galleries_r = $this->common_m->get_by_fields(
                        '', 
                        'gallery', 
                        '', 
                        'title'
                    );
                $data['all_galleries_q'] = $all_galleries_r['query'];

                $firest_parent_id = $this->common_m->get_parent_page($page_data->id);

                if(!empty($firest_parent_id)):

                    $second_parent_id = $this->common_m->get_parent_page($firest_parent_id->parent_page_id);
                    if(!empty($second_parent_id->parent_page_id)):
                        // get all printer
                        $all_printer_r = $this->common_m->get_by_fields(
                           '', 
                           'printer',
                           array('parent_printer' => $second_parent_id->page_slug), 
                           '', 
                          ''
                     );
                     $data['all_printer_q'] = $all_printer_r['query'];
                    endif;
                    
                endif;
                
                

                // get all page-page relations for this page
                $all_page_rel_sql =     
                    "SELECT page_rel.page_id, 
                            page_rel.parent_page_id, 
                            page.title AS parent_page_title
                    FROM page_self_rel AS page_rel 
                    INNER JOIN page
                    ON page_rel.parent_page_id = page.id
                    WHERE page_rel.page_id = {$page_id}";
                $data['all_page_rel_q'] = $this->db->query($all_page_rel_sql);

                // get all page-gallery relations for this page
                $page_gallery_rel_sql =     
                    "SELECT pg_rel.page_id, 
                            pg_rel.gallery_id, 
                            page.title AS page_title, 
                            gallery.title AS gallery_title
                    FROM page_gallery_rel AS pg_rel, page, gallery
                    WHERE pg_rel.page_id = page.id 
                        AND pg_rel.gallery_id = gallery.id
                        AND pg_rel.page_id = {$page_data->id}";
                $data['page_gallery_rel_q'] = $this->db->query($page_gallery_rel_sql);

                // get all page-printer relations for this page
                $page_printer_rel_sql =     
                    "SELECT pg_rel.page_id, 
                            pg_rel.printer_id, 
                            page.title AS page_title, 
                            printer.printer_name AS printer_name
                    FROM page_printer_rel AS pg_rel, page, printer
                    WHERE pg_rel.page_id = page.id 
                        AND pg_rel.printer_id = printer.id
                        AND pg_rel.page_id = {$page_data->id}";
                $data['page_printer_rel_q'] = $this->db->query($page_printer_rel_sql);

                // get all primary photos of current page
                $page_photo_r = $this->common_m->get_by_fields(
                        '', 
                        'primary_gallery_photo', 
                        array(
                            'page_id' => $page_data->id
                            )
                    );
                $data['page_photo_q'] = $page_photo_r['query'];

                // set page title for update page
                $data['page_title'] = $this->common_m->get_page_title('Update page - ' . $page_data->title);
            }
        } else {
            /**
             * Get all pages to show in (select parent page) list
             * 
             * A segment cannot have child page.
             */
            $all_pages_r = "
                        SELECT * 
                        FROM page 
                        WHERE is_segment != 1 AND
                        id NOT IN (SELECT page_id FROM page_self_rel) 
                        ORDER BY sort_order, title
                    ";

            // set found pages for view file
            $data['all_pages_q'] = $this->db->query($all_pages_r);

            // set page title for create page
            $data['page_title'] = $this->common_m->get_page_title('Create a new page');
        }

        // load view
        $this->load->view('admin/page/entry_v.php', $data);
    }

    /**
     * Custom validation function for segment creation.
     * 
     * While creating a segment, a parent page has to be selected. It works by 
     * checking id of parent page from (select parent page) drop down list.
     * If ($parent_id > 0) means a page is selected.
     * 
     * @param int $parent_id
     * @return bool
     */

    function parent_for_segment($parent_id)
    {
        if ($parent_id > 0) {
            return true;
        } else {
            $this->form_validation->set_message('parent_for_segment', 'Please select parent for segment.');
            return FALSE;
        }
    }

    /**
     * Save a page
     * 
     */

    public function save()
    {

        // for updating page, page id will be available in post data
        $page_id = (int) $this->input->post('page_id');

        // is page id available?
        if (!empty($page_id)) {

            // page id available
            // check for valid page id
            $page_request = $this->common_m->get_by_fields(
                    '', 
                    'page', 
                    array('id' => $page_id), 
                    '', 
                    1
                );

            if ($page_request['num_rows'] == 0) {

                // invalid page id
                redirect('admin/page');
            } else {

                // valid page id
                // fetch page id
                $page_data = $page_request['data'];

                // set page data for view file
                $data['page_data'] = $page_data;

                // set page title for updating page
                $data['page_title'] = $this->common_m->get_page_title('Update page - ' . $page_data->title);
            }
        } else {
            // set page title for create page
            $data['page_title'] = $this->common_m->get_page_title('Create a new page');
        }

        // set valiation rules
        // check page / segment create request
        $create_segment = (int) $this->input->post('create_segment');
        

        // for creating a segment, user has to select a parent page.
        if ($create_segment == 1) {
            $this->form_validation->set_rules(
                'parent_page', 
                'Parent page', 
                'trim|required|numeric|callback_parent_for_segment|htmlspecialchars'
            );
        } else {
            $this->form_validation->set_rules(
                'parent_page', 
                'Parent page', 
                'trim|numeric|htmlspecialchars'
            );
        }

        
        // is it contact us page?
        $is_contact_page = (int) $this->input->post('is_contact_page');

        // is it home page?
        $is_home_page = (int) $this->input->post('is_home_page');

        // is it services page?
        $is_service_page = (int) $this->input->post('is_service_page');
        $is_project = (int) $this->input->post('is_project');
        $is_featured_project = (int) $this->input->post('is_featured_project');
        

        $this->form_validation->set_rules(  
                'page_title', 
                'Page title', 
                'trim|required|htmlspecialchars'
            );
        $this->form_validation->set_rules(
                'short_description', 
                'Short description', 
                'trim'
            );
        $this->form_validation->set_rules(
                'page_description', 
                'Page description', 
                'trim'
            );

        if ($this->form_validation->run() == false) {
            // validation failed
            // send error message to view
            $ajax_return_data['msg'] = validation_errors('<p class="alert alert-warning">', '</p>');
            echo json_encode($ajax_return_data);
            exit;
        } else {

            $parent_page = (int) $this->input->post('parent_page');

            // validation passed
            $insert_update_data = array(
                'published' => $this->input->post('is_published'),
                'show_in_product_list' => $this->input->post('is_show_printer'),
                'title' => $this->input->post('page_title'),
                'short_description' => $this->input->post('short_description'),
                'description' => $this->input->post('page_description', false),
                'printer_description' => $this->input->post('printer_description', false),                
                'is_home_page' => $this->input->post('is_home_page'),
                'page_slug' => $this->input->post('page_slug'),
                'brand' => $this->input->post('brand'),
                'printer_technology' => $this->input->post('printer_technology'),
                'color' => $this->input->post('color'),
                'page_yield' => $this->input->post('page_yield'),
                'condition' => $this->input->post('condition'),
                'sku' => $this->input->post('sku'),
                'product_no' => $this->input->post('product_no'),
                'alternate_name1' => $this->input->post('alternate_name1'),
                'alternate_name2' => $this->input->post('alternate_name2'),
                'alternate_name3' => $this->input->post('alternate_name3'),
                'additionaltype' => $this->input->post('additionaltype'),
                'meta_title' => $this->input->post('meta_title'),
                'meta_description' => $this->input->post('meta_description'),
                'manufacter' => $this->input->post('manufacter'),
                'price' => $this->input->post('price'),
                'printer_type' => $this->input->post('printer_type'),
                'is_contact_page' => $is_contact_page,
                'is_service_page' => $is_service_page,
                'is_project' => $is_project,                
                'is_featured_project' => $is_featured_project
            );

            
            // prevent duplicate contact us page
            if ($is_contact_page == 1) {
                $this->db->update('page', array('is_contact_page' => 0));
            }

            // prevent duplicate home page
            if ($is_home_page == 1) {
                $this->db->update('page', array('is_home_page' => 0));
            }


            // is page id available?
            if (!empty($page_id)) {
                // page id is available, that means we're updating page
                // update page
                $updated = $this->common_m->update(
                        'page', 
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
            } else {
                // page id is not available, that means we are creating a new page
                // get last sort order value
                $sort_order_sql = 
                    "SELECT sort_order 
                    FROM page 
                    ORDER BY sort_order DESC 
                    LIMIT 1";
                $sort_order_q = $this->db->query($sort_order_sql);
                if ($sort_order_q->num_rows() != 0) {
                    $sort_order_data = $sort_order_q->row();
                    $current_last_sort_order = $sort_order_data->sort_order;
                    $insert_update_data['sort_order'] = $current_last_sort_order + 1;
                } else {
                    $insert_update_data['sort_order'] = 1;
                }

                // are we creating a page or segment
                if ($create_segment == 1) {
                    // we're creating segment
                    $insert_update_data['is_segment'] = 1;
                    $insert_update_data['segment_parent_id'] = $parent_page;
                }

                if ($this->common_m->insert('page', $insert_update_data)) {
                    // create successful
                    /**
                     * If a page is not a segment and has parent page, then
                     * save that relation 
                     */
                    if ($create_segment != 1) {
                        if ($parent_page != 0) {
                            $last_page_id = $this->db->insert_id();
                            $this->db->insert('page_self_rel', array(
                                'page_id' => $last_page_id,
                                'parent_page_id' => $parent_page
                                    )
                            );
                        }
                    }

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
            'page_id' => $page_id,
            'photo_file_name' => $file_name,
            'photo_raw_name' => $raw_name,
            'photo_file_ext' => $file_ext
        );

        $this->common_m->insert('primary_gallery_photo', $insert_update_data);
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
                        'primary_gallery_photo', 
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
            $this->db->delete('primary_gallery_photo', array('id' => $photo_id));
        } else {
            // invalid photo
            redirect('admin/page');
        }
        
    }

    /**
     * Set banner photo
     */

    public function set_banner_photo()
    {
        //get photo id
        $photo_id = (int) $this->input->post('photo_id');
        // get page id
        $page_id = (int) $this->input->post('page_id');
        // get action
        $action = $this->input->post('action');

        // check for valid photo id and ownership
        $photo_r = $this->common_m->get_by_fields(
                    '', 
                    'primary_gallery_photo', 
                    array(
                        'id' => $photo_id,
                        'page_id' => $page_id
                    ), 
                    '', 
                    1
            );

        if ($photo_r['num_rows'] != 0) {
            if ($action == 'set') {
                $this->db->update(
                            'primary_gallery_photo', 
                            array(
                                'is_banner_photo' => 1
                            ), 
                            array(
                                'id' => $photo_id,
                                'page_id' => $page_id
                            )
                );
            } else {
                $this->db->update(
                        'primary_gallery_photo', 
                        array(
                            'is_banner_photo' => 0
                        ), 
                        array(
                        'id' => $photo_id,
                        'page_id' => $page_id
                        )
                );
            }
        } else {
            exit;
        }
    }

    /**
     * Set primary photo
     */

    public function set_primary_photo()
    {
        // get photo id
        $photo_id = (int) $this->input->post('photo_id');
        // get page id
        $page_id = (int) $this->input->post('page_id');
        $action = $this->input->post('action');

        // check for valid photo id and ownership
        $photo_r = $this->common_m->get_by_fields(
                    '', 
                    'primary_gallery_photo', 
                    array(
                    'id' => $photo_id,
                    'page_id' => $page_id
                    ), 
                    '', 
                    1
        );
        if ($photo_r['num_rows'] != 0) {
            if ($action == 'set') {
                // at first set all photo to not primary photo
                $this->db->update(
                            'primary_gallery_photo',    
                            array(
                                'is_primary_photo' => 0,
                            ),
                            array(
                                'page_id' => $page_id
                                )
                );

                $this->db->update(
                        'primary_gallery_photo', 
                        array(
                        'is_primary_photo' => 1
                        ), 
                        array(
                        'id' => $photo_id,
                        'page_id' => $page_id
                        )
                );
            } else {
                $this->db->update(
                        'primary_gallery_photo', 
                        array(
                            'is_primary_photo' => 0
                        ), 
                        array(
                            'id' => $photo_id,
                            'page_id' => $page_id
                        )
                );
            }
        }
    }

    public function set_pri_sort_title()
    {
        // get photo id
        $photo_id = (int) $this->input->post('photo_id');
        // get page id
        $page_id = (int) $this->input->post('page_id');
        $pri_sort_title = $this->input->post('pri_sort_title');

            $this->db->update(
               'primary_gallery_photo', 
                array(
                    'sort_title' => $pri_sort_title
                ), 
                 array(
                   'id' => $photo_id,
                    'page_id' => $page_id
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
               'primary_gallery_photo', 
                array(
                    'sort_description' => $pri_sort_description
                ), 
                 array(
                   'id' => $photo_id,
                    'page_id' => $page_id
                   )
                );
            
        
    }
    

    /**
     * Show all pages and sub pages based on availability of parent page id.
     */

    public function all()
    {
        // check if parent page id is available
        $parent_page_id = (int) $this->uri->segment(4);

        // is parent page id available?
        if (!empty($parent_page_id)) {

            // YES, then check for valid parent page id
            $parent_page_request = $this->common_m->get_by_fields(
                    '', 
                    'page', 
                    array('id' => $parent_page_id), 
                    '', 
                    1
                );

            if ($parent_page_request['num_rows'] == 0) {
                // invalid parent page id
                redirect('admin/page/all');
            } else {
                // fetch parent page data
                $parent_page_data = $parent_page_request['data'];

                // get all subpages of parent page
                $sub_page_sql = 
                    "SELECT page_rel.page_id AS id, 
                            page.title, 
                            page.sort_order,
                            page.published,
                            page.show_in_product_list
                    FROM page_self_rel AS page_rel 
                    INNER JOIN page ON page_rel.page_id = page.id 
                    WHERE page_rel.parent_page_id = {$parent_page_id} 
                    ORDER BY sort_order";

                // set data for view file
                $data['sub_page_q'] = $this->db->query($sub_page_sql);

                // set page title
                $data['page_title'] = $this->common_m->get_page_title(
                        'All subpages of ' . $parent_page_data->title
                    );

                //get all menus
            $menu_r = $this->common_m->get_by_fields('', 'menu', '', 'title');
            $data['menu_q'] = $menu_r['query'];

                // load views
                $this->load->view('admin/page/all_subitems_v.php', $data);
            }   
        } else {
            //get all menus
            $menu_r = $this->common_m->get_by_fields('', 'menu', '', 'title');
            $data['menu_q'] = $menu_r['query'];

            // get all top level parent pages
            $page_sql =     
                "SELECT * 
                FROM page 
                WHERE is_segment != 1 AND
                id NOT IN (SELECT page_id FROM page_self_rel) 
                ORDER BY sort_order, title";

            // set data for view file
            $data['page_q'] = $this->db->query($page_sql);

            // set page title
            $data['page_title'] = $this->common_m->get_page_title('All pages');

            // load views
            $this->load->view('admin/page/all_v.php', $data);
        }
    }

    public function all_news()
    {

         
        //get all menus
        $menu_r = $this->common_m->get_by_fields('', 'menu', '', 'title');
        $data['menu_q'] = $menu_r['query'];

        // get all top level parent pages
        $page_sql =     
            "SELECT * 
            FROM page 
            WHERE is_news = 1
            ORDER BY sort_order, title";

        // set data for view file
        $data['page_q'] = $this->db->query($page_sql);

        // set page title
        $data['page_title'] = $this->common_m->get_page_title('All news');

        // load views
        $this->load->view('admin/page/all_v.php', $data);
        
    }

    /**
     * Delete page
     */

    public function delete()
    {
        // get page id
        $page_id = (int) $this->input->post('page_id');
        // check for valid page id
        if (!empty($page_id)) {
            $page_request = $this->common_m->get_by_fields(
                    '', 
                    'page', 
                    array('id' => $page_id), 
                    '', 
                    1
                );

            if ($page_request['num_rows'] == 0) {
                // invalid page id
                // send message to view
                $ajax_response_data = array(
                    'message' => 
                    "<p class='alert alert-warning'>Sorry, wrong page identifier provided.</p>"
                );
                echo json_encode($ajax_response_data);
                exit;
            } else {
                // valid page id found
                // delete that page

                if ($this->db->delete('page', array('id' => $page_id))) {

                    // delete relations with pages
                    $this->db->delete('page_self_rel', array('page_id' => $page_id));
                    $this->db->delete('page_self_rel', array('parent_page_id' => $page_id));
                    $this->db->delete('page_gallery_rel', array('page_id' => $page_id));
                    $this->db->delete('menu_page_rel', array('page_id' => $page_id));

                    // delete page segments
                    $segment_r = $this->common_m->get_by_fields(
                            '', 
                            'page', 
                            array('segment_parent_id' => $page_id)
                        );
                    if ($segment_r['num_rows'] != 0) {
                        $this->db->delete('page', array('segment_parent_id' => $page_id));
                    }


                    // delete primary gallery photos
                    $primary_gallery_photo_r = 
                            $this->common_m->get_by_fields(
                                    '', 
                                    'primary_gallery_photo', 
                                    array('page_id' => $page_id)
                                );
                    if ($primary_gallery_photo_r['num_rows'] != 0) {
                        $primary_gallery_photo_q = $primary_gallery_photo_r['query'];
                        foreach ($primary_gallery_photo_q->result() as $primary_photo) {
                            unlink("./uploads/primary_gallery_photos/{$primary_photo->photo_file_name}");
                            unlink("./uploads/primary_gallery_photos/{$primary_photo->photo_raw_name}_thumb{$primary_photo->photo_file_ext}");
                            unlink("./uploads/primary_gallery_photos/{$primary_photo->photo_raw_name}_banner{$primary_photo->photo_file_ext}");
                            unlink("./uploads/primary_gallery_photos/{$primary_photo->photo_raw_name}_slider{$primary_photo->photo_file_ext}");
                        }

                        $this->db->delete(
                                'primary_gallery_photo', 
                                array('page_id' => $page_id)
                            );
                    }

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
                } else {
                    $ajax_response_data = array(
                        'message' => 
                            "<p class='alert alert-error'>
                            Due to unexpected server error, failed to delete.
                            </p>"
                    );
                    echo json_encode($ajax_response_data);
                    exit;
                }
            }
        } else {
            $ajax_response_data = array(
                'message' => 
                    "<p class='alert alert-warning'>
                    Sorry, wrong page identifier provided.
                    </p>"
            );
            echo json_encode($ajax_response_data);
            exit;
        }
    }

    /**
     * Establish page-page relation
     */

    public function page_self_rel()
    {
        // get current page id
        $current_page_id = (int) $this->input->post('current_page_id');
        // get current parent page id
        $parent_page_id = (int) $this->input->post('parent_page_id');

        // check for valid current page id
        $current_page_request = $this->common_m->get_by_fields(
                '', 
                'page', 
                array('id' => $current_page_id), 
                '', 
                1
            );

        if ($current_page_request['num_rows'] == 0) {
            // invalid current page id
            // send message to view
            $ajax_response_data['message'] = 
                "<p class='alert alert-error'>
                Invalid page identifier provided.
                </p>";
            echo json_encode($ajax_response_data);
            exit;
        }

        // check for valid parent page id
        $parent_page_request = $this->common_m->get_by_fields(
                '', 
                'page', 
                array('id' => $parent_page_id), 
                '', 
                1
            );
        if ($parent_page_request['num_rows'] == 0) {
            // invalid parent page id
            // send message to view
            $ajax_response_data['message'] = 
                "<p class='alert alert-error'>
                Invalid page identifier provided.
                </p>";
            echo json_encode($ajax_response_data);
            exit;
        }

        // set insert update data

        $insert_update_data = array(
            'page_id' => $current_page_id,
            'parent_page_id' => $parent_page_id
        );

        // is requested relation already exists?
        $page_rel_request = $this->common_m->get_by_fields(
                "", 
                'page_self_rel', 
                $insert_update_data
            );

        if ($page_rel_request['num_rows'] == 0) {
            // NO, directly this relation doesn't exist
            // BUT,
            // parent can't be child of it's child, check that issue
            // is requested parent is a child of child
            if ($this->common_m->invalid_child($current_page_id, $parent_page_id)) {
                // yes
                // send error message to view
                $ajax_response_data['message'] = 
                    "<p class='alert alert-error'>
                    Parent cannot be child of it's own child.
                    </p>";
                echo json_encode($ajax_response_data);
                exit;
            }

            // set new relation

            if ($this->common_m->insert('page_self_rel', $insert_update_data)) {
                // new relation is set
                // send following data back, to assist view file
                $ajax_response_data['current_page_id'] = $current_page_id;
                $ajax_response_data['parent_page_id'] = $parent_page_id;
                $ajax_response_data['new_rel_created'] = 1;
                $ajax_response_data['message'] = 
                    "<p class='alert alert-success'>
                    Successfully assigned.
                    </p>";
                echo json_encode($ajax_response_data);
                exit;
            }
        } else {
            // requested relation already assigned
            // send message to view
            $ajax_response_data['message'] = 
                "<p class='alert alert-warning'>
                Already assigned.
                </p>";
            echo json_encode($ajax_response_data);
            exit;
        }
    }

    public function set_page_gallery_rel()
    {
        $parent_id = (int) $this->input->post('parent_id');
        $child_id = (int) $this->input->post('child_id');
        $parent_is = $this->input->post('parent_is');

        if ($parent_is == 'gallery') {
            $insert_update_data = array(
                'gallery_id' => $parent_id,
                'page_id' => $child_id,
                'parent_is' => $parent_is
            );
        } elseif ($parent_is == 'page') {
            $insert_update_data = array(
                'gallery_id' => $child_id,
                'page_id' => $parent_id,
                'parent_is' => $parent_is
            );
        } else {
            
        }

        // get current page relations
        $page_rel_request = $this->common_m->get_by_fields(
                "", 
                'page_gallery_rel', 
                $insert_update_data
            );

        if ($page_rel_request['num_rows'] == 0) {

            if ($this->common_m->insert('page_gallery_rel', $insert_update_data)) {
                $ajax_response_data['parentId'] = $parent_id;
                $ajax_response_data['childId'] = $child_id;
                $ajax_response_data['new_rel_created'] = 1;

                $ajax_response_data['message'] = 
                    "<p class='alert alert-success'>
                    Successfully assigned.
                    </p>";
                echo json_encode($ajax_response_data);
                exit;
            }
        } else {
            $ajax_response_data['message'] = 
                "<p class='alert alert-warning'>
                Already assigned.
                </p>";
            echo json_encode($ajax_response_data);
            exit;
        }
    }



    public function set_page_printer_rel()
    {
        $parent_id = (int) $this->input->post('parent_id');
        $child_id = (int) $this->input->post('child_id');
        
        $insert_update_data = array(
            'page_id' => $child_id,
            'printer_id' => $parent_id        
        );
        

        // get current page relations
        $page_rel_request = $this->common_m->get_by_fields(
                "", 
                'page_printer_rel', 
                $insert_update_data
            );

        if ($page_rel_request['num_rows'] == 0) {

            if ($this->common_m->insert('page_printer_rel', $insert_update_data)) {
                $ajax_response_data['parentId'] = $parent_id;
                $ajax_response_data['childId'] = $child_id;
                $ajax_response_data['new_rel_created'] = 1;

                $ajax_response_data['message'] = 
                    "<p class='alert alert-success'>
                    Successfully assigned.
                    </p>";
                echo json_encode($ajax_response_data);
                exit;
            }
        } else {
            $ajax_response_data['message'] = 
                "<p class='alert alert-warning'>
                Already assigned.
                </p>";
            echo json_encode($ajax_response_data);
            exit;
        }
    }



    public function remove_page_rel()
    {
        // get current page id
        $current_page_id = (int) $this->input->post('current_page_id');
        // get parent page id
        $parent_page_id = (int) $this->input->post('parent_page_id');

        // check for valid current page id
        $current_page_request = $this->common_m->get_by_fields(
                '', 
                'page', 
                array('id' => $current_page_id), 
                '', 
                1
            );
        if ($current_page_request['num_rows'] == 0) {
            $ajax_response_data['message'] = 
                "<p class='alert alert-error'>
                Invalid page identifier provided.
                </p>";
            echo json_encode($ajax_response_data);
            exit;
        }

        // check for valid parent page id
        $parent_page_request = $this->common_m->get_by_fields(
                '', 
                'page', 
                array('id' => $parent_page_id), 
                '', 
                1
            );
        if ($parent_page_request['num_rows'] == 0) {
            $ajax_response_data['message'] = 
                "<p class='alert alert-error'>
                Invalid page identifier provided.
                </p>";
            echo json_encode($ajax_response_data);
            exit;
        }

        // break this relation
        if ($this->db->delete('page_self_rel', array('page_id' => $current_page_id, 'parent_page_id' => $parent_page_id))) {
            // relation is broken
            // send following data back to view file
            $ajax_response_data['parent_page_id'] = $parent_page_id;
            $ajax_response_data['is_relation_broken'] = 1;
            $ajax_response_data['message'] = 
                "<p class='alert alert-success'>Successfully removed.</p>";
            echo json_encode($ajax_response_data);
            exit;
        }
    }


    public function remove_printer_rel()
    {
        // get current page id
        $current_page_id = (int) $this->input->post('current_page_id');
        // get parent page id
        $parent_page_id = (int) $this->input->post('parent_page_id');

        // check for valid current page id
        $current_page_request = $this->common_m->get_by_fields(
                '', 
                'printer', 
                array('id' => $parent_page_id), 
                '', 
                1
            );
        if ($current_page_request['num_rows'] == 0) {
            $ajax_response_data['message'] = 
                "<p class='alert alert-error'>
                Invalid page identifier provided.
                </p>";
            echo json_encode($ajax_response_data);
            exit;
        }

        // check for valid parent page id
        $parent_page_request = $this->common_m->get_by_fields(
                '', 
                'printer', 
                array('id' => $parent_page_id), 
                '', 
                1
            );
        if ($parent_page_request['num_rows'] == 0) {
            $ajax_response_data['message'] = 
                "<p class='alert alert-error'>
                Invalid page identifier provided.
                </p>";
            echo json_encode($ajax_response_data);
            exit;
        }

        // break this relation
        if ($this->db->delete('page_printer_rel', array('page_id' => $current_page_id, 'printer_id' => $parent_page_id))) {
            // relation is broken
            // send following data back to view file
            $ajax_response_data['parent_page_id'] = $parent_page_id;
            $ajax_response_data['is_relation_broken'] = 1;
            $ajax_response_data['message'] = 
                "<p class='alert alert-success'>Successfully removed.</p>";
            echo json_encode($ajax_response_data);
            exit;
        }
    }

    public function remove_page_gallery_relation()
    {
        $child_id = (int) $this->input->post('child_id');
        $parent_id = (int) $this->input->post('parent_id');
        $parent_is = (int) $this->input->post('parent_is');

        if ($parent_is == 'gallery') {

            $gallery_id = $parent_id;
            $page_id = $child_id;
        } elseif ($parent_is == 'page') {

            $gallery_id = $child_id;
            $page_id = $page_id;
        }

        // break this relation
        if ($this->db->delete('page_gallery_rel', array('page_id' => $page_id, 'gallery_id' => $gallery_id))) {
            // relation is broken
            // send following data back to view file
            $ajax_response_data['parent_id'] = $parent_id;
            $ajax_response_data['is_relation_broken'] = 1;
            $ajax_response_data['message'] = 
                "<p class='alert alert-success'>Successfully removed.</p>";
            echo json_encode($ajax_response_data);
            exit;
        }
    }

    public function update_sort_order()
    {
        $page_id = $this->input->post('page_id');
        $sort_order = $this->input->post('sort_order');

        $this->db->update(  
                'page', 
                array('sort_order' => $sort_order), 
                array('id' => $page_id)
            );
        echo 'done';
    }

    public function set_page_menu_rel()
    {
        $page_id = (int) $this->input->post('page_id');
        $menu_id = (int) $this->input->post('menu_id');
        $action = $this->input->post('action');

        if ($action == 'set') {
            $this->db->insert('menu_page_rel', array('menu_id' => $menu_id, 'page_id' => $page_id));
        } else {
            $this->db->delete('menu_page_rel', array('menu_id' => $menu_id, 'page_id' => $page_id));
        }
    }

    public function set_page_is_published()
    {
        $page_id = (int) $this->input->post('page_id');
        $action = $this->input->post('action');

        if ($action == 'set') {

            $updated = $this->common_m->update(
                'page', 
                array(
                        'published' => '0'
                    ), 
                array(
                        'id' => $page_id
                    )
            );
            
        } else {
            
            $updated = $this->common_m->update(
                'page', 
                array(
                        'published' => '1'
                    ), 
                array(
                        'id' => $page_id
                    )
            );

        }
    }

    public function set_page_is_product_list_l()
    {
        $page_id = (int) $this->input->post('page_id');
        $action = $this->input->post('action');

        if ($action == 'set') {

            $updated = $this->common_m->update(
                'page', 
                array(
                        'show_in_product_list' => '0'
                    ), 
                array(
                        'id' => $page_id
                    )
            );
            
        } else {
            
            $updated = $this->common_m->update(
                'page', 
                array(
                        'show_in_product_list' => '1'
                    ), 
                array(
                        'id' => $page_id
                    )
            );

        }
    }

    public function get_child_pages_old($parent_page_id)
    {

        $query = 
            "SELECT * 
            FROM page_self_rel 
            WHERE parent_page_id = {$parent_page_id}";
        $result = mysql_query($query) or die(mysql_error());

        if (mysql_num_rows($result) != 0) {
            $data = mysql_fetch_assoc($result);
            $this->child_pages[] = $data['page_id'];

            $this->get_child_pages($data['page_id']);
        } else {
            
        }
    }

    public function get_child_pages($parent_page_id)
    {

        //$query = "SELECT * FROM page_self_rel WHERE parent_page_id = {$parent_page_id}";
        $query =    
            "SELECT page_self_rel.page_id, page.title, page_self_rel.id
            FROM page_self_rel 
            INNER JOIN page ON page_self_rel.page_id = page.id
            WHERE page_self_rel.parent_page_id = {$parent_page_id}";

        $result = mysql_query($query) or die(mysql_error());

        while ($row = mysql_fetch_assoc($result)) {
            $i = $parent_page_id;
            $this->child_pages[$i]['id'][] = $row['page_id'];
            $this->child_pages[$i]['title'][] = $row['title'];

            $this->get_child_pages($row['page_id']);
        }
    }

    public function insert_duplicate($page_array, $duplicate_start_id)
    {
        // print_r($page_array);
        $i = 0;
        foreach ($page_array as $parent_page_id => $parent_page_childs) {
            foreach ($page_array[$parent_page_id]['id'] as $child_page_array_index => $child_page_id) {

                $this->db->insert('page', array('title' => $page_array[$parent_page_id]['title'][$child_page_array_index] . ' -copy'));

                $last_id = $this->db->insert_id();
                if (isset($page_array[$child_page_id])) {
                    $page_array[$child_page_id]['id_of_new_parent'] = $last_id;
                }
                if (isset($page_array[$parent_page_id]['id_of_new_parent'])) {
                    $this->db->insert(
                        'page_self_rel', 
                        array('page_id' => $last_id, 'parent_page_id' => $page_array[$parent_page_id]['id_of_new_parent'])
                        );
                } else {
                    $this->db->insert('page_self_rel', array('page_id' => $last_id, 'parent_page_id' => $duplicate_start_id));
                }
            }
            $i++;
        }
       // print_r($page_array);
    }

    public function duplicate()
    {
        // get parent page id
        $parent_page_id = (int) $this->uri->segment(4);
        $parent_rel_r = $this->common_m->get_by_fields(
                '',     
                'page_self_rel', 
                array('page_id' => $parent_page_id)
            );
        $parent_rel_q = $parent_rel_r['query'];

        $parent_rel_d = $parent_rel_r['data'];

        $parent_id = $parent_rel_d->parent_page_id;

        
        

        // get current data
       $current_page_data_r = $this->common_m->get_by_fields(
                '', 
                'page', 
                array('id' => $parent_page_id), 
                '', 
                1
            );

       $current_page_data = $current_page_data_r['data'];

       $this->db->insert('page', array(
            'title' => $current_page_data->title . ' copy',
            'page_slug' => $current_page_data->page_slug,
            'meta_title' => $current_page_data->meta_title,
            'meta_description' => $current_page_data->meta_description,
            'brand' => $current_page_data->brand,
            'product_no' => $current_page_data->product_no,
            'alternate_name1' => $current_page_data->alternate_name1,
            'alternate_name2' => $current_page_data->alternate_name2,
            'alternate_name3' => $current_page_data->alternate_name3,
            'additionaltype' => $current_page_data->additionaltype,
            'manufacter' => $current_page_data->manufacter,
            'price' => $current_page_data->price,
            'printer_type' => $current_page_data->printer_type,
            'printer_technology' => $current_page_data->printer_technology,
            'color' => $current_page_data->color,
            'page_yield' => $current_page_data->page_yield,
            'condition' => $current_page_data->condition,
            'sku' => $current_page_data->sku,
            'description' => $current_page_data->description,  
            'printer_description' =>  $current_page_data->printer_description,       
            'is_featured_project' => $current_page_data->is_featured_project            
        ));
        $duplicate_start_id = $this->db->insert_id();

        foreach ($parent_rel_q->result() as $parent_rel) {
             $this->db->insert('page_self_rel', array('page_id' => $duplicate_start_id, 'parent_page_id' => $parent_rel->parent_page_id));
        }

        // find out printer relation

        $find_printer_rel_r = $this->common_m->get_by_fields(
                '',     
                'page_printer_rel', 
                array('page_id' => $parent_page_id)
            );
        $find_printer_rel_q = $find_printer_rel_r['query'];

        foreach($find_printer_rel_q->result() as $find_printer_rel){
             $this->db->insert('page_printer_rel', array('page_id' => $duplicate_start_id, 'printer_id' => $find_printer_rel->printer_id));
        }

        $this->get_child_pages($parent_page_id);

        // //print_r($this->child_pages);
         $this->insert_duplicate($this->child_pages, $duplicate_start_id);

         redirect('admin/page/all/'.$parent_id);
    }

    public function all_brochures() 
    {
        $data['page_title'] = $this->common_m->get_page_title('All brochures');
        $data['brochure_error'] = '';

        // get all brochures
        $this->db->from('brochure');
        $this->db->order_by('title');
        $data['brochure_q'] = $this->db->get();

        $this->load->view('admin/page/all_brochures_v.php', $data);
    }

    public function upload_brochure()
    {
        $title = $this->input->post('title');
        if(empty($title)) {
            $this->session->set_flashdata('brochure_error', "<p class='alert alert-warning'>Please provide title</p>");
            redirect('admin/page/all_brochures');
            exit;
        }

        $config['upload_path'] = './uploads/brochures/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = '0';
        $config['max_width']  = '0';
        $config['max_height']  = '0';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('brochure'))
        {

            $data['brochure_error'] = $this->upload->display_errors();

            // get all brochures
        $this->db->from('brochure');
        $this->db->order_by('title');
        $data['brochure_q'] = $this->db->get();

            // $this->session->set_flashdata('brochure_msg', $error);
            $data['page_title'] = $this->common_m->get_page_title('All brochures');

            $this->load->view('admin/page/all_brochures_v.php', $data);
        }
        else
        {
            $file_data = $this->upload->data();
            $insert_data = array(
                    'title' => $title,
                    'file_name' => $file_data['file_name'],
                    'raw_name' => $file_data['raw_name'],
                    'file_ext' => $file_data['file_ext']
                );

            $this->db->insert('brochure', $insert_data); 

            redirect('admin/page/all_brochures');           
        }
    }

    public function delete_brochure()
    {
        $brochure_id = (int) $this->uri->segment(4);

        // check for valid brochure id
        $brochure_r = $this->common_m->get_by_fields(
                '',
                'brochure',
                array('id' => $brochure_id),
                '',
                1
            );

        if ($brochure_r['num_rows'] != 0) {
            $brochure_data = $brochure['data'];
            unlink("uploads/brochures/{$brochure_data->file_name}");
            $this->db->delete('brochure', array('id' => $brochure_id));
            redirect('admin/page/all_brochures');
        } else {
            redirect('admin/home');
        }
    }

}

