<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>
	
	<div id="body_section">
		<div id="middle_container">
			<?php $this->load->view('leftsidebar_v.php'); ?>
			<div id="body_container_right">
				<div id="inner_container">
					<div class="row">
						
							<div class="checkout_title">
								Registration Form
							</div>

							
							<div class="address_container">
							
								<!-- <form id="commentForm" method="get" accept=""> -->
									<div class="billing_address registration_section">
										
										<input type="text" placeholder="Email Address" class="inputField" id="reg_billing_email" >
										<input type="password" placeholder="Password" class="inputField" id="reg_billing_password" >
										<input type="text" placeholder="First Name" class="inputField" id="reg_billing_firstname" >
										<input type="text" placeholder="Last Name" class="inputField" id="reg_billing_lastname" >
										<input type="text" placeholder="Address" class="inputField" id="reg_billing_address_info" >
										<input type="text" placeholder="Suburb" class="inputField" id="reg_billing_suburb" >
										<input type="text" placeholder="Post Code" class="inputField" id="reg_billing_postcode" >
<input type="text" placeholder="Company Name" class="inputField" id="reg_billing_company_name" >
										<select id="reg_billing_state" class="inputSelect">
											<option>Please select State</option>
											<option>ACT</option>
											<option>NSW</option>
											<option>VIC</option>
											<option>QLD</option>
											<option>SA</option>
											<option>WA</option>
											<option>TAS</option>
											<option>NT</option>
										</select>
										<select id="reg_billingcountry" class="inputSelect">
											<option>Australia</option>
										</select>
										<input type="text" placeholder="Telephone" class="inputField" id="reg_billing_telephone" >
										<input class="submit_order" id="reg_submit_order" type="Submit" name="submit" value="Submit Order">
										<span style="margin-top: 5px;margin-left: 15px;" class="billing_email error">please fill up all required field</span>
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
		

	$('#reg_submit_order').click(function(){

		var billing_email = $("#reg_billing_email").val();
		var billing_password = $("#reg_billing_password").val();
		var billing_firstname = $("#reg_billing_firstname").val();
		var billing_lastname = $("#reg_billing_lastname").val();
		var billing_address_info = $("#reg_billing_address_info").val();
		var billing_postcode = $("#reg_billing_postcode").val();
		var billing_suburb = $("#reg_billing_suburb").val();
		var billing_state = $("#reg_billing_state").val();
		var billing_telephone = $("#reg_billing_telephone").val();
		var billingcountry = $("#reg_billingcountry").val();
                var reg_billing_company_name = $("#reg_billing_company_name").val();
		

		if(billing_email && billing_password && billing_firstname && billing_lastname && billing_address_info && billing_postcode && billing_suburb && billing_state !='Please select State' && billing_telephone){
				// define save functionality
		        this.save = $.ajax({
		            type: 'post',
		            url: "<?php echo site_url(); ?>checkout/save_register",
		            data: {reg_billing_company_name:reg_billing_company_name,billing_email:billing_email,billing_password:billing_password,billing_firstname:billing_firstname,billing_lastname:billing_lastname,billing_address_info:billing_address_info,billing_postcode:billing_postcode,billing_suburb:billing_suburb,billing_state:billing_state,billing_telephone:billing_telephone,billingcountry:billingcountry}
		        }).done(function(msg){
		            redirect_url = "<?php echo base_url(); ?>checkout/login" ;				
					window.location.replace(redirect_url);
		        });
		}else{
			$('.billing_email').css({'display':'block'})
		}
	

		return false;
	});
	</script>

<?php $this->load->view('footer_v.php'); ?>			