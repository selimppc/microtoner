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
								<div class="checkout-circle active">
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
								<div class="checkout-circle forspecialcase_section">
									<div class="circle">7</div>
									<div class="circleHead checkout_complete">Checkout Complete</div>
								</div>
							</div>
							<div class="checkout_title">
								Payment Method
							</div>

							
							<div class="paymentmethod_info">								
								<img src="<?php echo base_url(); ?>images/paypal.png"><br/>
								<!-- <div class="benefit_of_paypall">
									<p class="benefit">Benefit of using PayPal</p>
									<p>Faster than a check</p>
									<p>Flexibility for recipients</p>
									<p>Simple record-keeping</p>
									<p>Competitive pricing</p>
								</div> -->
							</div>

							<a href="#" class="payment_method_to_revieworder">Continue</a>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	
	<script>

	$('.payment_method_to_revieworder').click(function(){

		redirect_url = "<?php echo base_url(); ?>checkout/revieworder_info" ;				
		window.location.replace(redirect_url);
		return false;
	});

	</script
<?php $this->load->view('footer_v.php'); ?>			