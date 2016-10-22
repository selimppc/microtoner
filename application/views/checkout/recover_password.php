<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>
		<div id="body_section">
			<div id="middle_container">
				<?php $this->load->view('leftsidebar_v.php'); ?>
				<div id="body_container_right">
					<div id="inner_container">
						<div class="row">
							<div class="forgot_password_container">
								<h2>Put your Password</h2>
								<div class="login_container forgot_password_form">
									<input type="password" name="login_email" id="recover_password_input" placeholder="Password">
									<input type="hidden" id="random_number" value="<?php echo $this->uri->segment(3); ?>">
									<input type="submit" name="login_button" value="Submit" class="forgot_password_button" id="recover_password">
									<span style="margin-top: 5px;margin-left:5px;" class="login_error error">Unauthorized Access</span>
									<span style="margin-top: 8px;margin-left:8px;float:left;" class="success_info">Successfully recover your password</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">

		$('#recover_password').click(function(){
			var recover_password_input = $("#recover_password_input").val();
			var random_number = $('#random_number').val();
			if(recover_password_input){

				this.save = $.ajax({
		            type: 'post',
		            url: "<?php echo site_url(); ?>checkout/send_recover_password",
		            data: {recover_password_input:recover_password_input,random_number:random_number}
		        }).done(function(msg){
		            this.ajax_response = $.parseJSON(msg);

		            if (this.ajax_response.valid_user == 1) {
		            	$('.success_info').css({'display':'block'})
		            }
	
		        });

			}else{
				$('.login_error').css({'display':'block'})
			}
			return false;
		});

		</script>
<?php $this->load->view('footer_v.php'); ?>			