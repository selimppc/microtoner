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
							<?php echo $page_data->description; ?>
						</div><!--end of common container-->					
					</div><!--end of row-->
				</div>
			</div>
		</div>
	</div>
	
<?php $this->load->view('footer_v.php'); ?>			