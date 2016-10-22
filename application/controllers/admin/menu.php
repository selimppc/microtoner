<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends CI_Controller
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
        $data['page_title'] = $this->common_m->get_page_title('Menu module');

        // load views
        $this->load->view('admin/menu/home_v.php', $data);
    }

    public function entry($edit_menu_id = '')
    {
        // is menu id available from save method
        if (!empty($edit_menu_id)) {
            // yes, then take that
            $menu_id = (int) $edit_menu_id;
        } else {
            // for edit: get menu id from url
            $menu_id = (int) $this->uri->segment(4);
        }

        // is menu id available? 
        if (!empty($menu_id)) {
            // yes, then check for valid menu id
            $menu_request = $this->common_m->get_by_fields(
                    '', 'menu', array('id' => $menu_id), '', 1
                );
            if ($menu_request['num_rows'] == 0) {
                // invalid menu id
                redirect('admin/menu');
            } else {
                // fetch menu data
                $menu_data = $menu_request['data'];

                // set menu data for view file
                $data['menu_data'] = $menu_data;

                // set page title for update
                $data['page_title'] = $this->common_m->get_page_title(
                        'Update menu - ' . $menu_data->title
                    );
            }
        } else {
            // set page title
            $data['page_title'] = $this->common_m->get_page_title('Create a menu');
        }

        // load views
        $this->load->view('admin/menu/entry_v.php', $data);
    }

    function save()
    {
        // for updating, menu id will be available in post
        $menu_id = (int) $this->input->post('menu_id');

        // is menu id available
        if (!empty($menu_id)) {
            // yes, then check for valid menu id
            $menu_request = $this->common_m->get_by_fields(
                    '', 'menu', array('id' => $menu_id), '', 1
                );
            // is valid menu id?
            if ($menu_request['num_rows'] == 0) {
                // invalid menu id
                redirect('admin/menu');
            } else {
                // valid menu id
                // fetch menu data
                $menu_data = $menu_request['data'];
                // set data for view
                $data['menu_data'] = $menu_data;
                // set page title for update
                $data['page_title'] = $this->common_m->get_page_title(
                        'Update menu - ' . $menu_data->title
                    );
            }
        } else {
            // set page title for create
            $data['page_title'] = $this->common_m->get_page_title('Create menu');
        }

        // set validation rules
        $this->form_validation->set_rules(
                'menu_title', 'Menu title', 'trim|required|htmlspecialchars'
            );

        // apply validation rules
        if ($this->form_validation->run() == false) {
            // validation failed
            // send message to view
            $ajax_return_data['msg'] = validation_errors(
                    '<p class="alert alert-warning">', '</p>'
                );
            echo json_encode($ajax_return_data);
            exit;
        } else {
            $menu_title = $this->input->post('menu_title');

            $insert_update_data = array(
                'title' => $menu_title
            );

            // is update request?
            if (!empty($menu_id)) {
                // yes, then update
                if ($this->common_m->update(
                        'menu', $insert_update_data, array('id' => $menu_id))
                    ) {
                    // update successful
                    // send message back to view
                    $ajax_return_data['msg'] = "<p class='alert alert-success'>
                        Successfully updated.</p>";
                    echo json_encode($ajax_return_data);
                    exit;
                } else {
                    // update failed
                    $ajax_return_data['msg'] = "<p class='alert alert-error'>
                        Failed to update.</p>";
                    echo json_encode($ajax_return_data);
                    exit;
                }
            } else {
                // no, create request
                if ($this->common_m->insert('menu', $insert_update_data)) {
                    // create successful
                    // send message back to view
                    $ajax_return_data['msg'] = "<p class='alert alert-success'>
                        Successfully created.</p>";
                    echo json_encode($ajax_return_data);
                    exit;
                } else {
                    // create failed
                    $ajax_return_data['msg'] = "<p class='alert alert-error'>
                        Failed to create.</p>";
                    echo json_encode($ajax_return_data);
                    exit;
                }
            }
        }
    }

    public function all()
    {
        // get all menus
        $all_menu_r = $this->common_m->get_by_fields('', 'menu', '');
        $data['menu_q'] = $all_menu_r['query'];

        // set page title
        $data['page_title'] = $this->common_m->get_page_title('All menus');

        // load views
        $this->load->view('admin/menu/all_v.php', $data);
    }

    public function delete()
    {
        // get menu id
        $menu_id = (int) $this->input->post('menu_id');

        // check for valid menu id
        if (!empty($menu_id)) {
            $menu_request = $this->common_m->get_by_fields(
                    '', 'menu', array('id' => $menu_id), '', 1
                );
            if ($menu_request['num_rows'] == 0) {
                // invalid menu id
                // send message to view
                $ajax_response_data = array(
                    'message' => "<p class='alert alert-warning'>
                        Sorry, wrong menu identifier provided.</p>"
                );

                echo json_encode($ajax_response_data);
                exit;

            } else {
                // valid menu id found
                // delete that menu

                if ($this->db->delete('menu', array('id' => $menu_id))) {

                    // delete relations with menus
                    $this->db->delete('menu_page_rel', array('menu_id' => $menu_id));

                    // delete relations with galleries
                    $ajax_response_data = array(
                        'deleted' => 1,
                        'message' => "<p class='alert alert-success'>
                            Successfully deleted.</p>",
                        'deleted_menu_id' => $menu_id
                    );

                    echo json_encode($ajax_response_data);
                    exit;
                } else {
                    $ajax_response_data = array(
                        'message' => "<p class='alert alert-error'>
                        Due to unexpected server error, failed to delete.</p>"
                    );
                    echo json_encode($ajax_response_data);
                    exit;
                }
            }
        } else {
            $ajax_response_data = array(
                'message' => "<p class='alert alert-warning'>
                    Sorry, wrong menu identifier provided.</p>"
            );
            echo json_encode($ajax_response_data);
            exit;
        }
    }

}

/* End of file menu.php */
/* Location: ./application/controllers/admin/menu.php */
