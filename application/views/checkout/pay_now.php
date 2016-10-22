<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>styles/jquery.fancybox.css">
	<script src="<?php echo base_url(); ?>js/jquery.fancybox.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox({
				'padding':'0'
			});
		});
    </script>
    <a style="display:none;" class="fancybox" href="#open_alert_box" title="">Inline</a>
	<div id="open_alert_box" style="width:400px;display: none;">
		<h3 style="background: red;color: #fff;padding: 10px;text-align: center;margin-top: 0;">Important</h3>
		<p style="width: 350px;margin: auto;font-size: 13px;padding-bottom: 30px;">
			Please wait until Paypal completes payment processing and
			redirects to step7 to complete your order.
		</p>
		<p style="width: 100%;float: left;text-align: center;color: green;font-size: 20px;margin-bottom: 30px;">Loading ...</p>
	</div>
	<div id="body_section">
		<div id="middle_container">
			<?php $this->load->view('leftsidebar_v.php'); ?>
			<div id="body_container_right">
				<div id="inner_container">
					<div class="row">
						<div class="cart_container">
							<div class="checkoutmargin">
								<div class="checkout-circle">
									<div class="circle">1</div>
									<div class="circleHead">Checkout</div>
								</div>
								<div class="circleSeperator"></div>
								<div class="checkout-circle">
									<div class="circle">2</div>
									<div class="circleHead">Address</div>
								</div>
								<div class="circleSeperator"></div>
								<div class="checkout-circle">
									<div class="circle">3</div>
									<div class="circleHead">Shipping</div>
								</div>
								<div class="circleSeperator"></div>
								<div class="checkout-circle ">
									<div class="circle">4</div>
									<div class="circleHead payment_method">Payment Method</div>
								</div>
								<div class="circleSeperator forspecialcase_border"></div>
								<div class="checkout-circle forspecialcase_section">
									<div class="circle">5</div>
									<div class="circleHead review_and_order">Review and Order</div>
								</div>
								<div class="circleSeperator forspecialcase_border"></div>
								<div class="checkout-circle forspecialcase_section active">
									<div class="circle">6</div>
									<div class="circleHead">Pay</div>
								</div>
								<div class="circleSeperator forspecialcase_border"></div>
								<div class="checkout-circle forspecialcase_section">
									<div class="circle">7</div>
									<div class="circleHead checkout_complete">Checkout Complete</div>
								</div>
							</div>
							<div class="checkout_title">
								Pay Now
							</div>

							<?php

								$user_id = $this->session->userdata('user_id');
											
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
							?>

							<?php
								$user_id = $this->session->userdata('user_id');
								$product_quantity_value = $this->session->userdata('product_quantity');
								if(!empty($product_quantity_value) && !empty($user_id)):

							?>
							<div class="paymentmethod_info">								
								
								<div class="benefit_of_paypall">
									<div class="condition_container">
										<input type="checkbox" name="" id="is_continue" >
										<span class="condition_content">
											I agree with <a href="<?php echo base_url(); ?>privacy-policy" target="_blank">Privacy</a> and <a href="<?php echo base_url(); ?>terms-n-conditions" target="_blank">Terms & Condition</a>
										</span>											
									</div>
									<p class="pay_now">Please click to pay now button for continue</p>									
								</div>
								
							</div>


							<?php

								// $check_product_quantity_list = $this->session->userdata('product_quantity');
       	// 						$check_product_id_list = $this->session->userdata('product_id');
       	// 						$i_total_price = 0;
       	// 						$total_price = 0;
       	// 						$total_quantity_value = 0;

       	// 						for($i=0;$i<sizeof($check_product_id_list);$i++){
					   //              for($j=0;$j<sizeof($check_product_quantity_list);$j++){
					   //                  if($i == $j):

					   //                  	$page_data_r = $this->common_m->get_by_fields(
					   //                                  '', 
					   //                                  'page', 
					   //                                    array(
					   //                                             'id' => $check_product_id_list[$i]
					   //                                          )
					   //                                  );
					   //                      // set found pages for view file
					                        
					   //                      $data['page_data'] = $page_data_r['data'];
					   //                      $page_data = $data['page_data'];

					   //                  	$product_quantity = $check_product_quantity_list[$j];
        //               						$product_price = $page_data->price * $check_product_quantity_list[$j];
					   //                  	$original_price = $product_price / $product_quantity;

					   //                  	$total_quantity_value += $check_product_quantity_list[$j];
					   //                  	$total_price += $product_quantity * $original_price;
					   //                  endif;
					   //         		}
					   //         	}

					           	



								if(!empty($_POST['pay_now_submit'])){
									echo '<p class="success_info">You have successfully buy this product.</p>';
								}
							?>
							<form id="submit_payment" method="post" action="https://www.paypal.com/cgi-bin/webscr">
								<input type="hidden" name="address_override" value="1">
								<input type="hidden" name="cmd" value="_cart">
								<input type="hidden" name="upload" value="1">
								<input type="hidden" name="business" value="anil_tha_ma@optusnet.com.au">
								<input type="hidden" name="currency_code" value="AUD">
								<!-- <input type="hidden" name="invoice" value="10" > -->

								<input type="hidden" name="shipping" value="0.00">
								<input type="hidden" name="shipping2" value="20.00">

								<?php
								$count = 1;
								$check_product_quantity_list = $this->session->userdata('product_quantity');
       							$check_product_id_list = $this->session->userdata('product_id');
       							$i_total_price = 0;
       							$total_price = 0;
       							$total_quantity_value = 0;


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

					                    	$product_quantity = $check_product_quantity_list[$j];
					                    	
                      				?>
                      					<p>
											<input type="hidden" name="item_name_<?php echo $count; ?>" value="<?php echo $page_data->title; ?>">
											<input type="hidden" name="amount_<?php echo $count; ?>" value="<?php echo $page_data->price; ?>">
											<input type="hidden" name="quantity_<?php echo $count; ?>" value="<?php echo $product_quantity; ?>">
										</p>
                      				<?php
                      					$total_price += $page_data->price * $product_quantity;
                      					$count++;
					                    endif;
					           		}
					           	}

								?>

								
							 <!-- Enable override of buyers's address stored with PayPal . -->
								
								<!-- Set variables that override the address stored with PayPal. -->
								<!-- <input type="hidden" name="first_name" value="<?php //echo $user_data->billing_firstname; ?>">
								<input type="hidden" name="last_name" value="<?php //echo $user_data->billing_lastname; ?>">
								<input type="hidden" name="address1" value="<?php //echo $user_data->billing_address; ?>">
								<input type="hidden" name="city" value="<?php //echo $user_data->billing_suburb; ?>">
								<input type="hidden" name="state" value="<?php //echo $user_data->billing_state; ?>">
								<input type="hidden" name="zip" value="<?php //echo $user_data->billing_postcode; ?>">
								<input type="hidden" name="country" value="<?php //echo $user_data->billing_country; ?>">
 // -->							<?php //echo $total_price; ?>
								<input type="hidden" name="return" value="<?php echo base_url(); ?>checkout/success">
								<!-- <input type="hidden" name="handling_cart" value="<?= $total_price < 50 ? 4.50 : 0.00 ?>"> -->
								<input type="hidden" name="handling_cart" value="<?php if($user_data->billing_state == 'WA' || $user_data->billing_state == 'TAS'){echo '30.00';}else if($total_price < 50){echo '4.50';}else{echo '0.00';}?>">

						<input class="paynowbutton" type="image" src="<?php echo base_url(); ?>/images/paynow.png" border="0" name="submit" width="120" alt="Make payments with PayPal - it's fast, free and secure!">
						<img src="<?php echo base_url(); ?>/images/paynow.png" class="before_paynow">
</form>
<?php else: ?>

	<p>Please fill up all necessary information</p>
<?php endif;?>
<!-- 
							<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
								<input type="hidden" name="cmd" value="_xclick">
								<input type="hidden" name="business" value="mithun-facilitator@dcastalia.com">
								
								<input type="hidden" name="item_name_1" value="beach ball">
								<input type="hidden" name="amount_1" value="15">

								<input type="hidden" name="item_name_2" value="towel">
								<input type="hidden" name="amount_2" value="20">						
								
								<input type="hidden" name="no_note" value="1">
								<input type="hidden" name="currency_code" value="AUD">

								Enable override of buyers's address stored with PayPal . -->
								<!-- <input type="hidden" name="address_override" value="1"> -->
								<!-- Set variables that override the address stored with PayPal. -->
								<!-- <input type="hidden" name="first_name" value="John">
								<input type="hidden" name="last_name" value="Doe">
								<input type="hidden" name="address1" value="345 Lark Ave">
								<input type="hidden" name="city" value="San Jose">
								<input type="hidden" name="state" value="CA">
								<input type="hidden" name="zip" value="95121">
								<input type="hidden" name="country" value="US">
								<input type="image" name="submit" border="0"
								src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
								alt="PayPal - The safer, easier way to pay online">
								</form> --> 
							<!-- <form name="_xclick" method="post" action="https://www.sandbox.paypal.com/webscr">
								<input type="hidden" name="cmd" value="_xclick">
								<input type="hidden" name="business" value="mithun-facilitator@dcastalia.com">
								 Paypal sandbox seller account email id -->
								<!-- <input type="hidden" name="currency_code" value="AUD"> -->
								<!-- enter your currency code -->
								<!-- <input type="hidden" name="item_name" value="Microtoner Product">
								<input type="hidden" name="quantity" value="<?php //echo $total_quantity_value; ?>"> -->
								<!-- enter the item name -->
								<!-- <input type="hidden" name="return" value="<?php //echo base_url(); ?>checkout/success"> -->
								<!-- url to return once payment is done. -->
								<!-- <input type="hidden" name="amount" value="<?php //echo $total_price; ?>">
								<input type="hidden" name="first_name" value="John">
								<input type="hidden" name="last_name" value="Doe">
								<input type="hidden" name="address1" value="9 Elm Street">
								<input type="hidden" name="address2" value="Apt 5">
								<input type="hidden" name="city" value="Berwyn">
								<input type="hidden" name="state" value="PA">
								<input type="hidden" name="zip" value="19312"> -->
								<!-- amount of transaction needs to be credited to your paypal account -->
								<!-- <input type="image" class="paynowbutton" src="http://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Make payments with PayPal – it’s fast, free and secure!"> -->
								<!-- <input type="submit" class="paynowbutton" name="pay_now_submit" value="Pay Now"> -->
							<!-- </form> -->
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	
	<script>
	
	$( document ).ready(function() {
		$('#is_continue').change(function() {
	        var get_is_continue = $(this).is(':checked');
	        
	        if(get_is_continue){
	        	$('.before_paynow').css({'display':'none'})
	        	$('.paynowbutton').css({'display':'block'})
	        }else{

	        	$('.before_paynow').css({'display':'block'})
	        	$('.paynowbutton').css({'display':'none'})
	        }
	    });

	   $('.paynowbutton').click(function(){ 
	    
			$.fancybox($('a[href="#open_alert_box"]').click());
			final_payment = 0;
			this.save = $.ajax({
		            type: 'get',
		            url: "<?php echo site_url(); ?>checkout/paynow",
		            data: {final_payment:final_payment}
		        }).done(function(msg){
		            $( "#submit_payment" ).submit()
		        });

		        return false;

		});;
		
	});

	// $('.payment_method_to_revieworder').click(function(){

	// 	redirect_url = "<?php echo base_url(); ?>checkout/revieworder_info" ;				
	// 	window.location.replace(redirect_url);
	// 	return false;
	// });



	</script>
<?php $this->load->view('footer_v.php'); ?>			