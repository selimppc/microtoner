<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>
	<div id="body_section">
		<div id="middle_container">
			<?php $this->load->view('leftsidebar_v.php'); ?>
			<div id="body_container_right">
				<div id="inner_container">
					<div class="row">
						<div class="common_container">
							<h1><?php echo $page_data->title; ?></h1>
							<div id="contact_form_section">
								<form method="post" action="<?php echo base_url(); ?>contact_post">
									<div class="contact_container">
										<label>Name</label>
										<input type="text" name="your_name" required>
									</div>
									<div class="contact_container">
										<label>Phone</label>
										<input type="text" name="your_phone" >
									</div>
									<div class="contact_container">
										<label>Email</label>
										<input type="email" name="your_email" required>
									</div>
									<div class="contact_container">
										<label>Subject</label>
										<input type="text" name="your_subject" required>
									</div>
									<div class="contact_container">
										<label>Message</label>
										<textarea name="your_message"></textarea>
									</div>
									<div class="contact_container">
										<input type="submit" class="contact_submit" name="submit" value="submit" >
									</div>
									<div class="success_message">
											<?php
												if(isset($_POST['your_name'])){
													echo 'Successfully Sent';
												}
											?>
									</div>
								</form>
								<div class="contact_us_bottom">
									<?php echo $page_data->printer_description; ?>
								</div>
							</div>
							<div class="contact_form_text">
								<?php
									echo $page_data->description;
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('footer_v.php'); ?>			