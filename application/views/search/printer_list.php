<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>
	<div id="body_section">
		<div id="middle_container">
			<?php $this->load->view('leftsidebar_v.php'); ?>
			<div id="body_container_right">
				<div id="inner_container">
					<div class="row">
						<div class="search_header">
							You are searching 
							<span class="search_keyword"><?php echo $search_by_product_number;?></span>
						</div>

						<div class="search_result_container">
							<?php
								if($search_query_r->num_rows() > 0):
								foreach($search_query_r->result() as $search_query){
							?>
							<div class="search_content">
								<div class="product_name">
									<a href="<?php echo base_url(); ?><?php echo $search_query->parent_printer;?>/<?php echo $search_query->printer_slug; ?>"><?php echo $search_query->printer_name; ?></a>
								</div>
								
							</div>
							<?php
								}
							else:
								echo 'Please Type accurate printer number';
							endif;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('footer_v.php'); ?>			