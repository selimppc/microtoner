<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends CI_Controller
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
        $data['page_title'] = $this->common_m->get_page_title(
                'Settings module'
        );

        // load views
        $this->load->view('admin/settings/home_v.php', $data);
    }

    

    public function primary_contact_info()
    {

        $settings_r = $this->common_m->get_by_fields('', 'settings', '', '', 1);

        $data['settings_data'] = $settings_r['data'];

        // set page title
        $data['page_title'] = $this->common_m->get_page_title(
                'Update primary contact information'
        );

        // load views
        $this->load->view('admin/settings/primary_contact_info_v.php', $data);
    }

    public function save_primary_contact_info()
    {
        $this->form_validation->set_rules(
                'primary_contact_info', 'Primary contact info', 'trim|required'
        );

        if ($this->form_validation->run() == false) {
            // validation failed
            // send message to view
            $ajax_return_data['msg'] = validation_errors('<p class="alert alert-warning">', '</p>');
            echo json_encode($ajax_return_data);
            exit;
        } else {
            $insert_update_data = array(
                'primary_contact_info' => $this->input->post(
                        'primary_contact_info', false
                )
            );

            $updated = $this->db->update(
                    'settings', $insert_update_data
            );

            if ($updated) {
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
        }
    }

}