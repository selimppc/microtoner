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
								<div class="checkout-circle active">
									<div class="circle">2</div>
									<div class="circleHead">Address</div>
								</div>
								<div class="circleSeperator"></div>
								<div class="checkout-circle">
									<div class="circle">3</div>
									<div class="circleHead">Shipping</div>
								</div>
								<div class="circleSeperator"></div>
								<div class="checkout-circle">
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
								Address
							</div>

							<?php
								$logged_user_id = $this->session->userdata('logged_user_id');

								$user_id = $this->session->userdata('user_id');

								if(!empty($user_id)){
									$user_data_r = $this->common_m->get_by_fields(
							                '', 
							                'guest_user', 
							                array(
							                    'id' => $user_id
							                )
							            );
							    		// set found pages for view file
							     		$user_data = $user_data_r['data'];
								}else{

									if(!empty($logged_user_id)){
										$user_data_r = $this->common_m->get_by_fields(
							                '', 
							                'register_user', 
							                array(
							                    'id' => $logged_user_id
							                )
							            );
							    		// set found pages for view file
							     		$user_data = $user_data_r['data'];

									}
								}
								
								
							?>
							<div class="address_container">
							
								<!-- <form id="commentForm" method="get" accept=""> -->
									<div class="billing_address">
										<span class="title_of_billing_address">
											Billing Address
										</span>

										<input type="text" placeholder="Email Address" class="inputField" value="<?php if(!empty($user_data)){ echo $user_data->billing_email;} ?>" id="billing_email" >
										<span class="billing_email error">please fill up required filed</span>
										<input type="text" placeholder="First Name" value="<?php if(!empty($user_data)){ echo $user_data->billing_firstname;} ?>" class="inputField" id="billing_firstname" >
										<span class="billing_firstname error">please fill up required filed</span>
										<input type="text" placeholder="Last Name" value="<?php if(!empty($user_data)){ echo $user_data->billing_lastname;} ?>" class="inputField" id="billing_lastname" >
										<span class="billing_lastname error">please fill up required filed</span>
										<input type="text" placeholder="Address" class="inputField" value="<?php if(!empty($user_data)){ echo $user_data->billing_address;} ?>" id="billing_address_info" >
										<span class="billing_address_info error">please fill up required filed</span>
										<input type="text" placeholder="Suburb" class="inputField" id="billing_suburb" value="<?php if(!empty($user_data)){ echo $user_data->billing_suburb;} ?>" >
										<span class="billing_suburb error">please fill up required filed</span>
										<input type="text" placeholder="Post Code" class="inputField" id="billing_postcode" value="<?php if(!empty($user_data)){ echo $user_data->billing_postcode;} ?>" >
										<span class="billing_postcode error">please fill up only 4 digit number</span>										
<input type="text" placeholder="Company Name" class="inputField" id="billing_company_name" value="<?php if(!empty($user_data)){ echo $user_data->billing_company_name;} ?>" >
										<select id="billing_state" class="inputSelect">
										<?php if(!empty($user_data)){?>
										<option><?php echo $user_data->billing_state; ?></option>
											<?php }else { ?>
												<option>Please select State</option>
											<?php } ?>
											<option>ACT</option>
											<option>NSW</option>
											<option>VIC</option>
											<option>QLD</option>
											<option>SA</option>
											<option>WA</option>
											<option>TAS</option>
											<option>NT</option>
										</select>
										<span class="billing_state error">please fill up required filed</span>
										<select id="billingcountry" class="inputSelect">
											<option>Australia</option>
										</select>
										<input type="text" placeholder="Telephone" class="inputField" id="billing_telephone" value="<?php if(!empty($user_data)){ echo $user_data->billing_telephone;} ?>" >
										<span class="billing_telephone error">please fill up required filed</span>
									</div>

									<div class="shipping_address">
										<span class="title_of_shipping_address">
											Shipping Address
										</span>
										<div class="register_row">
											<input name="" type="checkbox" value="1" id="billinginfosameasshipping" class="billinginfosameasshipping">
											Shipping inforamtiom same as Billing information
										</div>
										<input type="text" placeholder="First Name" class="inputField" id="shipping_firstname">
										<input type="text" placeholder="Last Name" class="inputField" id="shipping_lastname">
										<input type="text" placeholder="Address" class="inputField" id="shipping_address">
										<input type="text" placeholder="Post Code" class="inputField" id="shipping_postcode">
										<input type="text" placeholder="Suburb" class="inputField" id="shipping_suburb">
<input type="text" placeholder="Company Name" class="inputField" id="shipping_company_name">
										<input type="text" placeholder="State" class="inputField" id="shipping_state">
										<select id="shippingcountry" class="inputSelect">
											<option>Australia</option>
										</select><br/>
										<input class="submit_order" id="submit_order" type="Submit" name="submit" value="Submit Order">
									</div>
								<!-- </form> -->
							
							</div>



						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		 $('#billinginfosameasshipping').click(function(){
     	
     	if($('#billinginfosameasshipping').is(":checked")) {
           
           var billing_firstname = $("#billing_firstname").val();          
           document.getElementById("shipping_firstname").value = billing_firstname;

           var billing_lastname = $("#billing_lastname").val();          
           document.getElementById("shipping_lastname").value = billing_lastname;

           var billing_address_info = $("#billing_address_info").val();          
           document.getElementById("shipping_address").value = billing_address_info;

           var billing_postcode = $("#billing_postcode").val();          
           document.getElementById("shipping_postcode").value = billing_postcode;

           var billing_suburb = $("#billing_suburb").val();          
           document.getElementById("shipping_suburb").value = billing_suburb;

           var billing_state = $("#billing_state").val();          
           document.getElementById("shipping_state").value = billing_state;

           var billing_company_name = $("#billing_company_name").val();          
           document.getElementById("shipping_company_name").value = billing_company_name;

          

        } else {
          
          document.getElementById("shipping_firstname").value = '';
          document.getElementById("shipping_lastname").value = '';
          document.getElementById("shipping_address").value = '';
          document.getElementById("shipping_postcode").value = '';
          document.getElementById("shipping_suburb").value = '';
          document.getElementById("shipping_state").value = '';   
          document.getElementById("shipping_company_name").value = '';                
        }

     	// return false;
     });

	$('#submit_order').click(function(){

		var billing_email = $("#billing_email").val();

		if(billing_email){			
			$('.billing_email').css({'display':'none'})
		}else{
			$('.billing_email').css({'display':'block'})
		}
		

		var billing_firstname = $("#billing_firstname").val();

		if(billing_firstname){			
			$('.billing_firstname').css({'display':'none'})
		}else{
			$('.billing_firstname').css({'display':'block'})
		}

		var billing_lastname = $("#billing_lastname").val();

		if(billing_lastname){			
			$('.billing_lastname').css({'display':'none'})
		}else{
			$('.billing_lastname').css({'display':'block'})
		}

		var billing_address_info = $("#billing_address_info").val();

		if(billing_address_info){			
			$('.billing_address_info').css({'display':'none'})
		}else{
			$('.billing_address_info').css({'display':'block'})
		}

		var billing_postcode = $("#billing_postcode").val();

		if(billing_postcode){

			if(!isNaN(billing_postcode) && billing_postcode.toString().length == '4' ){			
				 $('.billing_postcode').css({'display':'none'})				
			}else{
				 $('.billing_postcode').css({'display':'block'})				
			}

		}else{
				$('.billing_postcode').css({'display':'block'})
		}
		

		var billing_suburb = $("#billing_suburb").val();

		if(billing_suburb){			
			$('.billing_suburb').css({'display':'none'})
		}else{
			$('.billing_suburb').css({'display':'block'})
		}

		var billing_state = $("#billing_state").val();

		if(billing_state != 'Please select State'){			
			$('.billing_state').css({'display':'none'})
		}else{
			$('.billing_state').css({'display':'block'})
		}

		var billing_telephone = $("#billing_telephone").val();

		if(billing_telephone){			
			$('.billing_telephone').css({'display':'none'})
		}else{
			$('.billing_telephone').css({'display':'block'})
		}

		//alert(billing_postcode);
                var billing_company_name = $("#billing_company_name").val();
		var billingcountry = $("#billingcountry").val();
		var shipping_firstname = $("#shipping_firstname").val();
		var shipping_lastname = $("#shipping_lastname").val();
		var shipping_address = $("#shipping_address").val();
		var shipping_postcode = $("#shipping_postcode").val();
		var shipping_suburb = $("#shipping_suburb").val();
		var shipping_state = $("#shipping_state").val();
                var shipping_company_name = $('#shipping_company_name').val();
		var shippingcountry = $("#shippingcountry").val();


		if(billing_state !='Please select State' && billing_email && billing_firstname && billing_lastname && billing_address_info && !isNaN(billing_postcode) && billing_postcode.toString().length == '4' && billing_suburb && billing_state && billing_telephone){
				// define save functionality
		        this.save = $.ajax({
		            type: 'post',
		            url: "<?php echo site_url(); ?>checkout/save_address",
		            data: {shipping_company_name:shipping_company_name,billing_company_name:billing_company_name,billing_email:billing_email,billing_firstname:billing_firstname,billing_lastname:billing_lastname,billing_address_info:billing_address_info,billing_postcode:billing_postcode,billing_suburb:billing_suburb,billing_state:billing_state,billing_telephone:billing_telephone,billingcountry:billingcountry,shipping_firstname:shipping_firstname,shipping_lastname:shipping_lastname,shipping_address:shipping_address,shipping_postcode:shipping_postcode,shipping_suburb:shipping_suburb,shipping_state:shipping_state,shippingcountry:shippingcountry}
		        }).done(function(msg){
		            redirect_url = "<?php echo base_url(); ?>checkout/shipping_info" ;				
					window.location.replace(redirect_url);
		        });
		}
	

		return false;
	});
	</script>

<?php $this->load->view('footer_v.php'); ?>			