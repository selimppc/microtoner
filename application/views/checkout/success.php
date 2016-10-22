<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>
	
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
								<div class="checkout-circle forspecialcase_section">
									<div class="circle">6</div>
									<div class="circleHead">Pay</div>
								</div>
								<div class="circleSeperator forspecialcase_border"></div>
								<div class="checkout-circle forspecialcase_section active">
									<div class="circle">7</div>
									<div class="circleHead checkout_complete">Checkout Complete</div>
								</div>
							</div>
							<div class="checkout_title">
								Complete
							</div>

							
							<div class="paymentmethod_info">								
								
								<div class="benefit_of_paypall">
									
									<p>Congratulations your order have been successfully sent.</p>									

									<?php 
                                        $invoice_id = $this->session->userdata('invoice_id');

                                        $invoice_id_request = $this->common_m->get_by_fields(
                                            '', 
                                            'product_request', 
                                            array('invoice_id' => $invoice_id), 
                                            '', 
                                            1
                                        );

                                        if(!empty($invoice_id_request)){
                                          
                                            $result = $this->common_m->update_status($invoice_id);

                                        }


                                       $this->session->unset_userdata('invoice_id');
                                       
                                            
					?>
								</div>
							</div>


						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	
	
<?php $this->load->view('footer_v.php'); ?>			