<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Accounts extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // load required models for this controller
        $this->load->model(array(
            'user_m',
            'privilege_m'
        ));


        // redirect logged in user to appropriate page
        if ($this->privilege_m->is_logged_in()) {
            if ($this->privilege_m->is_admin()) {
                redirect('admin/home');
            } else {
                redirect('home');
            }
        }
    }

    function index()
    {
        // set default method
        $this->login();
    }

    function login()
    {
        // set page title
        $data['page_title'] = $this->common_m->get_page_title('Admin Login');

        // load view
        $this->load->view('accounts/login_v.php', $data);
    }

    function do_login()
    {
        // set form validation rules
        $this->form_validation->set_rules(
                'username', 
                'Username', 
                'trim|required|prep_for_form'
            );
        $this->form_validation->set_rules(
                'password', 
                'Password', 
                'trim|required|prep_for_form'
            );

        if ($this->form_validation->run() == FALSE) {
            // validation failed
            // load login page again
            // $this->login();
            $ajax_response['message'] = validation_errors(
                    '<p class="alert alert-warning">', '</p>'
                );
            echo json_encode($ajax_response);
            exit;
        } else {
            // validation passed
            // fetch values

            $where_cond = array(
                'username' => htmlspecialchars($this->input->post('username')),
                'password' => sha1(htmlspecialchars($this->input->post('password')))
            );

            // get user by userpass
            $user_request = $this->common_m->get_by_fields('', 'user', $where_cond, '', 1);
            //$user_query = $this->user_m->get_by_userpass($username, $password, 'query');
            // is user available with that credentials ?
            if ($user_request['num_rows'] != 0) {

                // user exists
                // fetch user data
                $user_data = $user_request['data'];

                // get privilege type of this user
                $privilege_request = $this->common_m->get_by_fields('', 'privilege', array('id' => $user_data->privilege_id), '', 1);

                // is privilege type available for this user?
                if ($privilege_request['num_rows'] == 0) {
                    // no privilege is assigned for this user
                    /* $this->session->set_flashdata('login_msg', '<div class="alert alert-error">
                      You don\'t have privilege to access any page.
                      </div>');
                      redirect('accounts/login'); */
                    $ajax_response['message'] = "<div class='alert alert-error'>You don't have privilege to access any page.</div>";

                    echo json_encode($ajax_response);
                    exit;
                } else {
                    // privilege type is assigned for this user
                    // fetch privilege data
                    $privilege_data = $privilege_request['data'];

                    // based on defined privilege type and home page for those type
                    // redirect user to appropriate page
                    if ($privilege_data->type == $this->config->item('admin_privilege_type')) {
                        // set admin logged in flag
                        $this->session->set_userdata('is_logged_in', TRUE);
                        $this->session->set_userdata('is_admin', TRUE);

                        //redirect($this->config->item('admin_home_page'));
                        $ajax_response['valid_user'] = 1;
                        $ajax_response['valid_admin'] = 1;
                        $ajax_response['redirect_to'] = $this->config->item('admin_home_page');
                        $ajax_response['message'] = "<p class='alert alert-success'>Login successful.</p>";
                        echo json_encode($ajax_response);
                        exit;
                    }

                    // if failed all other cases redirect to public page
                    // redirect($this->config->item('public_home_page'));

                    $ajax_response['valid_user'] = 1;
                    $ajax_response['redirect_to'] = $this->config->item('public_home_page');
                    $ajax_response['message'] = "<p class='alert alert-success'>Login successful.</p>";
                    echo json_encode($ajax_response);
                    exit;
                }
            } else {
                // wrong userpass given
                /* $this->session->set_flashdata('login_msg', '<div class="alert alert-error">
                  Username, password combination was not correct.
                  </div>');
                  redirect('accounts/login'); */
                $ajax_response['message'] = "<p class='alert alert-error'>
                    Username, password combination was not correct.</p>";
                echo json_encode($ajax_response);
                exit;
            }
        }
    }

}

/* End of file accounts.php */
/* Location: ./application/controllers/accounts.php */
