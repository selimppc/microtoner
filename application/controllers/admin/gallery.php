<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gallery extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        // only admin can view this page
        if (!$this->privilege_m->is_admin()) {
            redirect('accounts/login');
        }
    }

    public function index()
    {
        // set default method
        $this->home();
    }

    public function home()
    {
        // set page title
        $data['page_title'] = $this->common_m->get_page_title('Gallery module');

        // load views
        $this->load->view('admin/gallery/home_v.php', $data);
    }

    public function entry($edit_gallery_id = '')
    {

        // is gallery id available from save method
        if (!empty($edit_gallery_id)) {
            // yes, then take that
            $gallery_id = (int) $edit_gallery_id;
        } else {
            // for edit: get gallery id from url
            $gallery_id = (int) $this->uri->segment(4);
        }

        // is gallery id available?
        if (!empty($gallery_id)) {
            // yes, then check for valid gallery id
            $gallery_request = $this->common_m->get_by_fields(
                    '', 
                    'gallery', 
                    array('id' => $gallery_id), 
                    '', 
                    1
                );
            if ($gallery_request['num_rows'] == 0) {
                // invalid gallery id
                redirect('admin/gallery');
            } else {
                // fetch gallery data
                $gallery_data = $gallery_request['data'];

                // set gallery data for view file
                $data['gallery_data'] = $gallery_data;

                // get all gallery photos
                $gallery_photo_r = $this->common_m->get_by_fields(
                        '', 
                        'gallery_photo', 
                        array('gallery_id' => $gallery_data->id)
                    );
                $data['gallery_photo_q'] = $gallery_photo_r['query'];

                // get all pages for page gallery relation dropdown list
                $all_page_r = $this->common_m->get_by_fields(  
                        '', 
                        'page', 
                        array('is_segment' => 0), 
                        'id'
                    );
                $data['all_pages_q'] = $all_page_r['query'];

                // get all current page-to-gallery relations
                $all_page_gallery_rel_r = "SELECT page.title as page_title, page_gallery_rel.page_id, page_gallery_rel.gallery_id
FROM page_gallery_rel INNER JOIN page
ON page_gallery_rel.page_id = page.id WHERE gallery_id = {$gallery_data->id} AND parent_is = 'page'";
                $data['all_page_gallery_rel_q'] = $this->db->query($all_page_gallery_rel_r);

                // set page title for update
                $data['page_title'] = $this->common_m->get_page_title(
                        'Update gallery - ' . $gallery_data->title
                    );
            }
        } else {
            // set page title for create
            $data['page_title'] = $this->common_m->get_page_title('Create gallery');
        }

        // load views
        $this->load->view('admin/gallery/entry_v.php', $data);
    }

    public function save()
    {
        // for updating, gallery id will be available in post
        $gallery_id = (int) $this->input->post('gallery_id');

        // is gallery id available
        if (!empty($gallery_id)) {
            // yes, then check for valid gallery id
            $gallery_request = $this->common_m->get_by_fields('', 'gallery', array('id' => $gallery_id), '', 1);
            // is valid gallery id?
            if ($gallery_request['num_rows'] == 0) {
                // invalid gallery id
                redirect('admin/gallery');
            } else {
                // valid gallery id
                // fetch gallery data
                $gallery_data = $gallery_request['data'];
                // set data for view
                $data['gallery_data'] = $gallery_data;
                // set page title for update
                $data['page_title'] = $this->common_m->get_page_title('Update gallery - ' . $gallery_data->title);
            }
        } else {
            // set page title for create
            $data['page_title'] = $this->common_m->get_page_title('Create gallery');
        }

        // set validation rules
        $this->form_validation->set_rules('gallery_title', 'Gallery title', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('gallery_description', 'Gallery description', 'trim|htmlspecialchars');

        // apply validation rules
        if ($this->form_validation->run() == false) {
            // validation failed
            // send message to view
            $ajax_return_data['msg'] = validation_errors('<p class="alert alert-warning">', '</p>');
            echo json_encode($ajax_return_data);
            exit;
        } else {
            $gallery_title = $this->input->post('gallery_title');
            $gallery_desription = $this->input->post('gallery_description');

            $insert_update_data = array(
                'title' => $gallery_title,
                'description' => $gallery_desription
            );

            // is update request?
            if (!empty($gallery_id)) {
                // yes, then update
                if ($this->common_m->update('gallery', $insert_update_data, array('id' => $gallery_id))) {
                    // update successful
                    // send message back to view
                    $ajax_return_data['msg'] = "<p class='alert alert-success'>Successfully updated.</p>";
                    echo json_encode($ajax_return_data);
                    exit;
                } else {
                    // update failed
                    $ajax_return_data['msg'] = "<p class='alert alert-error'>Failed to update.</p>";
                    echo json_encode($ajax_return_data);
                    exit;
                }
            } else {
                // no, create request
                if ($this->common_m->insert('gallery', $insert_update_data)) {
                    // create successful
                    // send message back to view
                    $ajax_return_data['msg'] = "<p class='alert alert-success'>Successfully created.</p>";
                    echo json_encode($ajax_return_data);
                    exit;
                } else {
                    // create failed
                    $ajax_return_data['msg'] = "<p class='alert alert-error'>Failed to create.</p>";
                    echo json_encode($ajax_return_data);
                    exit;
                }
            }
        }
    }

    public function all()
    {
        // get all galleries
        $all_gallery_r = $this->common_m->get_by_fields('', 'gallery', '');
        $data['gallery_q'] = $all_gallery_r['query'];
        // set page title
        $data['page_title'] = $this->common_m->get_page_title('All galleries');
        // load views
        $this->load->view('admin/gallery/all_v.php', $data);
    }

    public function delete()
    {
        // get gallery id
        $gallery_id = (int) $this->input->post('gallery_id');
        // check for valid gallery id
        if (!empty($gallery_id)) {
            $gallery_request = $this->common_m->get_by_fields('', 'gallery', array('id' => $gallery_id), '', 1);
            if ($gallery_request['num_rows'] == 0) {
                // invalid gallery id
                // send message to view
                $ajax_response_data = array(
                    'message' => "<p class='alert alert-warning'>Sorry, wrong gallery identifier provided.</p>"
                );
                echo json_encode($ajax_response_data);
                exit;
            } else {
                // valid gallery id found
                // get all gallery photos to delete
                $gallery_photo_r = $this->common_m->get_by_fields('', 'gallery_photo', array('gallery_id' => $gallery_id));
                if ($gallery_photo_r['num_rows'] != 0) {
                    $gallery_photo_q = $gallery_photo_r['query'];
                    foreach ($gallery_photo_q->result() as $gallery_photo) {
                        unlink("./uploads/gallery_photos/{$gallery_photo->photo_file_name}");
                        unlink("./uploads/gallery_photos/{$gallery_photo->photo_raw_name}_thumb{$gallery_photo->photo_file_ext}");
                    }
                    $this->db->delete('gallery_photo', array('gallery_id' => $gallery_id));
                }


                // delete that gallery

                if ($this->db->delete('gallery', array('id' => $gallery_id))) {

                    // delete relations with gallerys
                    $this->db->delete('page_gallery_rel', array('gallery_id' => $gallery_id));

                    // delete relations with galleries
                    $ajax_response_data = array(
                        'deleted' => 1,
                        'message' => "<p class='alert alert-success'>Successfully deleted.</p>",
                        'deleted_gallery_id' => $gallery_id
                    );
                    echo json_encode($ajax_response_data);
                    exit;
                } else {
                    $ajax_response_data = array(
                        'message' => "<p class='alert alert-error'>Due to unexpected server error, failed to delete.</p>"
                    );
                    echo json_encode($ajax_response_data);
                    exit;
                }
            }
        } else {
            $ajax_response_data = array(
                'message' => "<p class='alert alert-warning'>Sorry, wrong gallery identifier provided.</p>"
            );
            echo json_encode($ajax_response_data);
            exit;
        }
    }

    // save photo information into database
    public function save_photo()
    {
        // get gallery id
        $gallery_id = (int) $this->input->post('gallery_id');
        // get photo file name
        $file_name = $this->input->post('file_name');
        // get photo raw name
        $raw_name = $this->input->post('raw_name');
        // get photo file extension
        $file_ext = $this->input->post('file_ext');

        // prepare insert update data
        $insert_update_data = array(
            'gallery_id' => $gallery_id,
            'photo_file_name' => $file_name,
            'photo_raw_name' => $raw_name,
            'photo_file_ext' => $file_ext
        );

        $this->common_m->insert('gallery_photo', $insert_update_data);
        $last_insert_id = $this->db->insert_id();
        echo json_encode(array('last_insert_id' => $last_insert_id));
        exit;
    }

    public function delete_photo()
    {
        $photo_id = (int) $this->input->post('photo_id');
        $photo_r = $this->common_m->get_by_fields(
                '', 'gallery_photo', array(
            'id' => $photo_id
                ), '', 1
        );
        $photo_data = $photo_r['data'];
        unlink("./uploads/gallery_photos/{$photo_data->photo_file_name}");
        unlink("./uploads/gallery_photos/{$photo_data->photo_raw_name}_thumb{$photo_data->photo_file_ext}");
        $this->db->delete('gallery_photo', array('id' => $photo_id));
    }

    public function set_page_gallery_rel()
    {
        $current_gallery_id = (int) $this->input->post('current_gallery_id');
        $parent_page_id = (int) $this->input->post('parent_page_id');
        $parent_is = $this->input->post('parent_is');

        $insert_update_data = array(
            'gallery_id' => $current_gallery_id,
            'page_id' => $parent_page_id,
            'parent_is' => $parent_is
        );

        // get current page relations
        $page_rel_request = $this->common_m->get_by_fields("", 'page_gallery_rel', $insert_update_data);

        if ($page_rel_request['num_rows'] == 0) {

            if ($this->common_m->insert('page_gallery_rel', $insert_update_data)) {
                $ajax_response_data['current_gallery_id'] = $current_gallery_id;
                $ajax_response_data['parent_page_id'] = $parent_page_id;
                $ajax_response_data['new_rel_created'] = 1;

                $ajax_response_data['message'] = "<p class='alert alert-success'>Successfully assigned.</p>";
                echo json_encode($ajax_response_data);
                exit;
            }
        } else {
            $ajax_response_data['message'] = "<p class='alert alert-warning'>Already assigned.</p>";
            echo json_encode($ajax_response_data);
            exit;
        }
    }

    public function remove_page_rel()
    {
        $current_gallery_id = (int) $this->input->post('current_gallery_id');
        $parent_page_id = (int) $this->input->post('parent_page_id');


        if ($this->db->delete('page_gallery_rel', array('page_id' => $parent_page_id, 'gallery_id' => $current_gallery_id, 'parent_is' => 'page'))) {
            $ajax_response_data['parent_page_id'] = $parent_page_id;

            $ajax_response_data['message'] = "<p class='alert alert-success'>Successfully removed.</p>";
            echo json_encode($ajax_response_data);
            exit;
        }
    }

}

/* End of file gallery.php */
/* Location: ./application/controllers/admin/gallery.php */
