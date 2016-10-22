<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>

<div id="body_section">
	<div id="middle_container">
		<?php $this->load->view('leftsidebar_v.php'); ?>
		<div id="body_container_right">
			<div class="row">
				<?php if(!empty($home_page_q->description)):?>
					<div class="first_left">
						<h1><?php echo $home_page_q->title; ?></h1>
						<?php echo $home_page_q->description; ?>
					</div><!--end of first left-->
				<?php endif;?>
				<!-- <div class="first_right">
					<h1>Excellent</h1>
					<img src="<?php echo base_url(); ?>images/stars.png">
					<p>1000 customers have written a review on this site</p>
				</div> -->
				<!--end of first right-->
			</div><!--end of row-->
			

			<div class="border_bottom">&nbsp;</div>
				
				<div id="inner_container">
					<div class="row">
						<div class="common_container">
								<h1><?php echo $page_data_q->title; ?></h1>
								<?php echo $page_data_q->description; ?>
						</div><!--end of common container-->					
					</div><!--end of row-->

					<div class="row">
						<div class="subcategory_section">
							<div class="subcategory_first">
								<span class="first_tab first_tab_printer">Printer List</span>
								<div class="subcategory_container subcategory_for_printer">
									<div class="subcategory_box">
									<?php
										$printer_list_r = $this->common_m->sub_menu_printer_list($page_data_q->page_slug);	
										foreach($printer_list_r->result() as $printer_list):
									?>
									
										<div class="subcategory"><a class="for_printer" href="<?php echo base_url(); ?><?php echo $page_data_q->page_slug; ?>/<?php echo $printer_list->printer_slug; ?>"><?php echo $printer_list->printer_name; ?></a></div>
									
									
									<?php endforeach; ?>
									</div>		
									
								</div>
							</div>

							<div class="subcategory_second">
								<span class="first_tab">Product List</span>
								<div class="subcategory_container">
									<?php 
											
											$first_sub_product_r = $this->common_m->sub_menu($page_data_q->id);
											foreach($first_sub_product_r->result() as $first_sub_product):
									?>
												<div class="subcategory_box">
													<h2><?php echo $first_sub_product->title; ?></h2>
													<?php
														$show_printer_r = $this->common_m->sub_menu_printer_list_data($first_sub_product->page_id);

														foreach($show_printer_r->result() as $show_printer):
															
															
													?>
															<div class="subcategory"><a href="<?php echo base_url(); ?><?php echo $show_printer->page_slug; ?>"><?php echo $show_printer->product_no; ?></a></div>
														<?php endforeach; ?>
												</div>
											<?php endforeach; ?>
									
								</div>
							</div>
						</div>
					</div>
				</div><!-- end of inner container -->			

		</div><!--end of body container right-->
	</div><!--end of middle_container-->
</div><!--end of body container-->
<?php $this->load->view('footer_v.php'); ?>			