<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller 
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

    public function addtocart(){
        $detail_page_id = $this->input->post('detail_page_id');
        $detail_page_qty = $this->input->post('detail_page_qty');
        $detail_page_price = $this->input->post('detail_page_price');

        // $detail_page_price = $detail_page_price * $detail_page_qty;

        // $this->session->set_userdata('product_id', $detail_page_id);
        // $this->session->set_userdata('product_quantity', $detail_page_qty);
        // $this->session->set_userdata('product_price',$detail_page_price);

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

       
    }

    public function shoppingcart(){

        
            $this->load->view('checkout/shoppingcart.php'); 
                
    }


    public function remove_addtocart(){


        $this->session->unset_userdata('product_id');
        $this->session->unset_userdata('product_quantity');
        $this->session->unset_userdata('product_price');
    }

    public function remove_logout(){
        $this->session->unset_userdata('logged_user_id');
    }

    public function address(){

        $this->load->view('checkout/address.php');
    }


    public function save_address(){

        // validation passed
            $insert_update_data = array(
                'billing_email' => $this->input->post('billing_email'),
                'billing_firstname' => $this->input->post('billing_firstname'),
                'billing_lastname' => $this->input->post('billing_lastname'),
                'billing_address' => $this->input->post('billing_address_info'),                
                'billing_postcode' => $this->input->post('billing_postcode'),
                'billing_suburb' => $this->input->post('billing_suburb'),
                'billing_state' => $this->input->post('billing_state'),
                'billing_company_name' => $this->input->post('billing_company_name'),
                'billing_country' => $this->input->post('billingcountry'),
                'billing_telephone' => $this->input->post('billing_telephone'),
                'shipping_firstname' => $this->input->post('shipping_firstname'),
                'shipping_lastname' => $this->input->post('shipping_lastname'),
                'shipping_address' => $this->input->post('shipping_address'),
                'shipping_postcode' => $this->input->post('shipping_postcode'),
                'shipping_suburb' => $this->input->post('shipping_suburb'),
                'shipping__state' => $this->input->post('shipping_state'),
                'shipping_company_name' => $this->input->post('shipping_company_name'),
                'shipping_coubntry' => $this->input->post('shippingcountry'),
                'status' => 0
            );

        $this->common_m->insert('guest_user', $insert_update_data);

        $last_id = $this->db->insert_id();
        $this->session->set_userdata('user_id', $last_id);
    }

    public function save_register(){

        // validation passed
            $insert_update_data = array(
                'billing_email' => $this->input->post('billing_email'),
                'billing_password' => sha1($this->input->post('billing_password')),
                'billing_firstname' => $this->input->post('billing_firstname'),
                'billing_lastname' => $this->input->post('billing_lastname'),
                'billing_address' => $this->input->post('billing_address_info'),                
                'billing_postcode' => $this->input->post('billing_postcode'),
                'billing_suburb' => $this->input->post('billing_suburb'),
                'billing_state' => $this->input->post('billing_state'),
                'billing_country' => $this->input->post('billingcountry'),
                'billing_telephone' => $this->input->post('billing_telephone'),
                'billing_company_name' => $this->input->post('reg_billing_company_name'),
                'status' => 0
            );

        $to = $this->input->post('billing_email');
        $subject = "Microtoner | New Member";
        $message_content = 'Hello ' .$this->input->post('billing_firstname') . 
                           '.  Thank you for registration for microtoner site, You can buy differents cartridges of this site. Please visit www.microtonersupplies.com.au.';

        $from_mail = 'info@microtonersupplies.com.au';

        $header = "From: ".$from_mail."\r\n";
        $header .= "Content-type: text/html\r\n";


        mail ($to,$subject,$message_content,$header);

        $this->common_m->insert('register_user', $insert_update_data);

    }

    public function send_forgot_password(){
      $forgot_email = $this->input->post('forgot_email'); 
      
      $where_cond = array(
        'billing_email' => $forgot_email
        );

      $user_request = $this->common_m->get_by_fields('', 'register_user', $where_cond, '', 1);

      if ($user_request['num_rows'] != 0) {            
            $random_number = sha1(mt_rand(10, 250));

            $insert_update_data = array(
                'password_reset' => $random_number                
            );

            $updated = $this->common_m->update(
                'register_user', 
                $insert_update_data, 
                array('billing_email' => $forgot_email )
            );

            if($updated){
                $to = $forgot_email;
                $subject = "Microtoner | New recover";
                echo $message_content = "Please click here to recover your password <a href='http://www.microtonersupplies.com.au/checkout/recover_password/$random_number'>recover</a>";

                $from_mail = 'info@microtonersupplies.com.au';

                $header = "From: ".$from_mail."\r\n";
                $header .= "Content-type: text/html\r\n";


                mail ($to,$subject,$message_content,$header);

                $ajax_response['valid_user'] = 1;
                echo json_encode($ajax_response);
                exit; 
            }

        }else{
            $ajax_response['valid_user'] = 2;
            echo json_encode($ajax_response);
            exit;
        }
    }

    public function recover_password(){
        $this->load->view('checkout/recover_password.php');
    }

    public function send_recover_password(){
        $random_number = $this->input->post('random_number'); 
        $recover_password_input = sha1($this->input->post('recover_password_input')); 

        $where_cond = array(
            'password_reset' => $random_number
        );

        $user_request = $this->common_m->get_by_fields('', 'register_user', $where_cond, '', 1);

        if ($user_request['num_rows'] != 0) {            


            $insert_update_data = array(
                'billing_password' => $recover_password_input,
                'password_reset' => ''               
            );

            $updated = $this->common_m->update(
                'register_user', 
                $insert_update_data, 
                array('password_reset' => $random_number )
            );

            if($updated){
                $ajax_response['valid_user'] = 1;
                echo json_encode($ajax_response);
                exit; 
            }

        }else{
            $ajax_response['valid_user'] = 2;
            echo json_encode($ajax_response);
            exit;
        }
    }

    public function logged_check(){
        $email = $this->input->post('login_email');
        $password = sha1($this->input->post('login_password'));

        $where_cond = array(
                'billing_email' => $email,
                'billing_password' => $password
            );

            // get user by userpass
            $user_request = $this->common_m->get_by_fields('', 'register_user', $where_cond, '', 1);
            //$user_query = $this->user_m->get_by_userpass($username, $password, 'query');
            // is user available with that credentials ?
            if ($user_request['num_rows'] != 0) {
                $user_data = $user_request['data'];

                 $this->session->set_userdata('logged_user_id', $user_data->id);
                $ajax_response['valid_user'] = 1;
                echo json_encode($ajax_response);
                exit;
            }else{
                $ajax_response['valid_user'] = 2;
                echo json_encode($ajax_response);
                exit;
            }


    }

    public function shipping_info(){
        $this->load->view('checkout/shipping_info.php');   
    }

    public function paymentmethod_info(){
        $this->load->view('checkout/paymentmethod_info.php');   
    }

    public function revieworder_info(){
        $this->load->view('checkout/review.php');
    }

    public function pay_now(){
        $this->load->view('checkout/pay_now.php');
    }

    public function login(){
        $this->load->view('checkout/login.php');   
    }

    public function register(){
        $this->load->view('checkout/register.php');
    }

    public function success(){
        $this->load->view('checkout/success.php');   
    }

    public function forgot_password(){
        $this->load->view('checkout/forgot_password.php');
    }

    public function paynow(){

       $check_product_quantity_list = $this->session->userdata('product_quantity');
       $check_product_id_list = $this->session->userdata('product_id');

        $get_last_invoice_id_r = 
                    "SELECT invoice_id
                    FROM product_request
                    ORDER BY id desc 
                    LIMIT 1
                    ";

                $get_last_invoice_id_q = $this->db->query($get_last_invoice_id_r);
                foreach($get_last_invoice_id_q->result() as $get_last_invoice_id){
                    $invoice_id = $get_last_invoice_id->invoice_id+1;
                }

                $this->session->set_userdata('invoice_id', $invoice_id);
                $user_id = $this->session->userdata('user_id');


       $i_total_price = 0;
       $total_price = 0;
       $message_content_2 = '';
            for($i=0;$i<sizeof($check_product_id_list);$i++){
                for($j=0;$j<sizeof($check_product_quantity_list);$j++){
                    if($i == $j):

                        $page_data_r = $this->common_m->get_by_fields(
                                    '', 
                                    'page', 
                                      array(
                                               'id' => $check_product_id_list[$i]
                                            )
                                    );
                        // set found pages for view file
                        
                        $data['page_data'] = $page_data_r['data'];
                        $page_data = $data['page_data'];

                        $product_id = $page_data->id;
                        $product_quantity = $check_product_quantity_list[$j];
                        $product_price = $page_data->price;
                        

                        $current_date = date("Y-m-d");

                        $insert_update_data = array(
                            'product_id' => $product_id,
                            'invoice_id' => $invoice_id,
                            'product_quantity' => $product_quantity,
                            'product_price' => $product_price,
                            'user_id' => $user_id,
                            'current_date' => $current_date,
                            'status' => 2
                        );

                        $original_price = $product_price / $product_quantity;

                        $i_total_price = $product_quantity * $original_price;

                        $total_price += $product_quantity * $original_price;
                     
                     
                    $this->common_m->insert('product_request', $insert_update_data);




                    $user_id = $this->session->userdata('user_id');

                                       

                   

                    


                    endif;
                }
            }


            
            $i_total_price = 0;
                   $total_price = 0;
                   $message_content_2 = '';


                   if($user_id && $check_product_quantity_list && $check_product_quantity_list ){
                        
                        for($i=0;$i<sizeof($check_product_id_list);$i++){
                            for($j=0;$j<sizeof($check_product_quantity_list);$j++){
                                if($i == $j):

                                    $page_data_r = $this->common_m->get_by_fields(
                                                '', 
                                                'page', 
                                                  array(
                                                           'id' => $check_product_id_list[$i]
                                                        )
                                                );
                                    // set found pages for view file
                                    
                                    $data['page_data'] = $page_data_r['data'];
                                    $page_data = $data['page_data'];

                                    $product_id = $page_data->id;
                                    $product_quantity = $check_product_quantity_list[$j];
                                    $product_price = $page_data->price * $check_product_quantity_list[$j];
                                    

                                    $current_date = date("Y-m-d");

                                    $insert_update_data = array(
                                        'product_id' => $product_id,
                                        'invoice_id' => $invoice_id,
                                        'product_quantity' => $product_quantity,
                                        'product_price' => $product_price,
                                        'user_id' => $user_id,
                                        'current_date' => $current_date,
                                        'status' => 0
                                    );

                                    $original_price = $product_price / $product_quantity;

                                    $i_total_price = $product_quantity;

                                    $total_price += $product_quantity * $original_price;

                                    $message_content_2 .= '<tr><td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                            '.$page_data->title.'
                                                          </td>
                                                          <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                            '.$product_quantity.'
                                                          </td>
                                                          <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                            '.$original_price.'
                                                          </td>
                                                          <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                            '.$i_total_price.'
                                                          </td></tr>';
                                 
                                

                               // $this->common_m->insert('product_request', $insert_update_data);

                               
                                $this->session->unset_userdata('product_id');
                                endif;
                            }

                        if($total_price < 50){
                          $shipping_cost = 4.5;
                        }else{
                           $shipping_cost = 0;
                        }

                        $grand_total = $total_price + $shipping_cost;

                        $user_data_r = $this->common_m->get_by_fields(
                                        '', 
                                        'guest_user', 
                                        array(
                                            'id' => $user_id
                                            )
                                        );
                        // set found pages for view file
                                    
                        $data['user_data'] = $user_data_r['data'];
                        $user_data = $data['user_data'];

                        }

                        // for mail 

         $message_content_1 = '<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0">
                <div></div>
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" valign="top" style="padding:20px 0 20px 0">
                                <table style="background-color:#fff" cellspacing="0" cellpadding="10" border="0" width="650">
                                    <tbody><tr>
                                        <td valign="top">
                                            <a rel="nofollow" href="http://selimreza.com/microtoner/" target="_blank">
                                                <img alt="Micro Toner Supplies" src="http://selimreza.com/microtoner/images/logo.png" style="margin-bottom:10px" border="0" class="CToWUd">
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td valign="top">
                                            <h1 style="font-size:22px;font-weight:normal;line-height:22px;margin:0 0 11px 0">Hello,
                                                '.$user_data->billing_firstname.' '. $user_data->billing_lastname .'
                                                                                                    </h1>
                                            <div style="font-size:12px;line-height:16px;margin:0 0 10px 0">
                                                Thank you for your order from Main Website Store.
                                                Once your package ships we will send an email with a link to track your order.
                                                If you have any questions about your order please contact us at <a rel="nofollow" href="mailto:info@microtonersupplies.com.au" style="color:#1e7ec8" target="_blank">info@microtonersupplies.com.au</a>
                                            </div>
                                            <div style="font-size:12px;line-height:16px;margin:0">
                                                Your order confirmation is below. Thank you again.
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <h2 style="font-size:18px;font-weight:normal;margin:0">Your Order No:'.$invoice_id.' </h2>
                                        </td>
                                    </tr>


                                    <tr>
                                <td>
                                    <table cellspacing="0" cellpadding="0" border="0" width="650">
                                        <thead>
                                            <tr>
                                                <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Billing Information:</th>
                                                <th width="10"></th>
                                                <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Shipping Information:</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                '.$user_data->billing_firstname. ' '. $user_data->billing_lastname.'
                                                <br/>
                                                '.$user_data->billing_address.'
                                                <br>
                                                '.$user_data->billing_suburb.' '.$user_data->billing_state.' '. $user_data->billing_postcode.'
                                                <br>
                                                '.$user_data->billing_country.'
                                                <br>
                                                '.$user_data->billing_telephone.'
                                                
                                                </td>
                                                <td>&nbsp;</td>
                                                <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                    '.$user_data->shipping_firstname. ' '. $user_data->shipping_lastname.'
                                                    <br/>
                                                    '.$user_data->shipping_address.'
                                                    <br>
                                                    '.$user_data->shipping_suburb.' '. $user_data->shipping__state.' '. $user_data->shipping_postcode.'
                                                    <br>
                                                    '.$user_data->shipping_coubntry.'
                                                    
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>


                            <tr><td><br>

                            </td></tr><tr>
                                <td>
                                    <table cellspacing="0" cellpadding="0" border="0" width="650">
                                        <thead>
                                            <tr>
                                                <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Product Name</th>
                                                <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Product Quantity</th>
                                                <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Price</th>
                                                <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        ';
                                            
                                     $message_content_3='   
                                        </tbody>

                                        <tbody>
                                            
                                            
                            
                                            <tr>
                                                <td colspan="3" align="right" style="padding:3px 9px">
                                                    <strong>Total</strong>
                                                </td>
                                                <td align="right" style="padding:3px 9px">
                                                    <strong><span>'.$total_price.'</span></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="right" style="padding:3px 9px">
                                                    <strong>Shipping Cost</strong>
                                                </td>
                                                <td align="right" style="padding:3px 9px">
                                                    <strong><span>'.$shipping_cost.'</span></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="right" style="padding:3px 9px">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td align="right" style="padding:3px 9px">
                                                    <strong><span>'.$grand_total.'</span></strong>
                                                </td>
                                            </tr>
                                        
                                    </tbody>
                                    </table>
                                </td>
                            </tr>


                                </tbody></table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>';   
            $message_content = $message_content_1.$message_content_2.$message_content_3;

            $your_name = $user_data->billing_firstname. ' '. $user_data->billing_lastname;
            $your_email = $user_data->billing_email;

            //$to = "visionads.sydney@gmail.com";
            $to = "admin@microtonersupplies.com.au ";

            $from_mail = 'info@microtonersupplies.com.au';

            $header = "From: ".$from_mail."\r\n";
            $header .= "Content-type: text/html\r\n";

            $customer_subject = "Thank you for your Order No. " . $invoice_id;
            $admin_subject = "New Order No. " . $invoice_id;
            
            mail ($to,$admin_subject,$message_content,$header);
                
            // customer to
            $customer_to = $user_data->billing_email;
            mail ($customer_to,$customer_subject,$message_content,$header);

            $this->session->unset_userdata('product_quantity');
                    $this->session->unset_userdata('product_id');
            
        }

                    //$this->load->view('checkout/pay_now.php');



    }
    
    
    public function contact_post(){

        $your_name = $this->input->post('your_name');
        $your_phone = $this->input->post('your_phone');
        $your_email = $this->input->post('your_email');
        $your_subject = $this->input->post('your_subject');
        $your_message = $this->input->post('your_message');
        
        //$to = "visionads.sydney@gmail.com";
        $to = "admin@microtonersupplies.com.au ";

        $subject = $your_email .' | Microtoner Supply'.

        $from_mail = 'info@microtonersupplies.com.au';

        $header = "From: ".$from_mail."\r\n";
        $header .= "Content-type: text/html\r\n";

        $message_content = "Name     :  ". $your_name. "<br/><br/>
                            Phone    :  ". $your_phone. "<br/><br/>
                            Email    :  ". $your_email. "<br/><br/>
                            Message  :  ". $your_message;

        mail ($to,$subject,$message_content,$header);


        $page_slug = 'contact-us';
        
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

        $this->load->view('contact_us.php',$data);

    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
