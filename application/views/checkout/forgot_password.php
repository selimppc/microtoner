<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>
		<div id="body_section">
			<div id="middle_container">
				<?php $this->load->view('leftsidebar_v.php'); ?>
				<div id="body_container_right">
					<div id="inner_container">
						<div class="row">
							<div class="forgot_password_container">
								<h2>Find your Password</h2>
								<div class="login_container forgot_password_form">
									<input type="text" name="login_email" id="forgot_email" placeholder="Email Address">
									
									<input type="submit" name="login_button" value="Submit" class="forgot_password_button" id="forgot_password_button">
									<span style="margin-top: 5px;margin-left:5px;" class="login_error error">please provide valid email address</span>
									<span style="margin-top: 8px;margin-left:8px;float:left;" class="success_info">please check your email (Inbox/Spam)</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">

		$('#forgot_password_button').click(function(){
			var forgot_email = $("#forgot_email").val();
			
			if(forgot_email){

				this.save = $.ajax({
		            type: 'post',
		            url: "<?php echo site_url(); ?>checkout/send_forgot_password",
		            data: {forgot_email:forgot_email}
		        }).done(function(msg){
		            this.ajax_response = $.parseJSON(msg);

		            if (this.ajax_response.valid_user == 1) {
		            	$('.login_error').css({'display':'none'})
		            	$('.success_info').css({'display':'block'})
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