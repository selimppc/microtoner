<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>
		<div id="body_section">
			<div id="middle_container">
				<?php $this->load->view('leftsidebar_v.php'); ?>
				<div id="body_container_right">
					<div id="inner_container">
						<div class="row">
							<div class="customer_login_section">
								<div class="customer_login_left">
								
									<h2>Checkout as Guest</h2>
									<p>Don't have an account and you don't want to register? Checkout as a guest instead!</p>
									<br/>
									<a class="register_now_button" href="<?php echo base_url(); ?>checkout/address">Checkout As Guest</a>
									<br/><br/><br/><br/><br/><br/>
									<h2>Want to Register?</h2>
									<p>Registration allows you to avoid filling in billing and shipping forms every time you checkout on this website. You'll also be able to track your orders with ease!</p>
									<br/>
									<a class="register_now_button" href="<?php echo base_url(); ?>checkout/register">Register Now</a>
									
									
								</div>

								<div class="customer_login_right">
								
									

								<h2>Customer login</h2>
									<p>Please login using your existing account</p>
									<div class="login_container">
										<input type="text" name="login_email" id="login_email" placeholder="Email Address">
										<input type="password" name="login_password" id="login_password" placeholder="Password">
										<input type="submit" name="login_button" value="Login" class="login" id="logged_button">
										<span style="margin-top: 5px;" class="login_error error">please provide valid information</span>
									</div>
									<div class="login_Forgot_your_password">
										<a href="<?php echo base_url(); ?>checkout/forgot_password">Forgot your password?</a>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">

		$('#logged_button').click(function(){
			var login_email = $("#login_email").val();
			var login_password = $("#login_password").val();

			if(login_email && login_password){

				this.save = $.ajax({
		            type: 'post',
		            url: "<?php echo site_url(); ?>checkout/logged_check",
		            data: {login_email:login_email,login_password:login_password}
		        }).done(function(msg){
		            this.ajax_response = $.parseJSON(msg);
		            if (this.ajax_response.valid_user == 1) {
		            	redirect_url = "<?php echo base_url(); ?>checkout/address" ;				
						window.location.replace(redirect_url);
		            }

		            if (this.ajax_response.valid_user == 2) {
		            	$('.login_error').css({'display':'block'})
		            }	
		        });

			}else{
				$('.login_error').css({'display':'block'})
			}
			return false;
		});

		</script>
<?php $this->load->view('footer_v.php'); ?>			