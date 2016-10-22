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
				<!--<div class="first_right">
					<h1>Excellent</h1>
					<img src="images/stars.png">
					<p>1000 customers have written a review on this site</p>
				</div>-->
                                <!--end of first right-->
			</div><!--end of row-->
						
			<div id="home_search_section">
				

				<!-- <div class="search_container">
					<form action="<?php //echo base_url(); ?>search_by_cartridge_number" method="post">
						<input type="text" name="search_by_v_cartridge_number" class="search_input" placeholder="Search by cartridge number">
						<input type="submit" name="btn_cartridge_number" class="search_btn" value="Search">
					</form>
				</div> --><!--end of search container-->
			</div><!--end of home_search_section-->

			<div class="border_bottom">&nbsp;</div>

			<div class="row">
				<?php 
					$home_page_product = $this->common_m->sub_menu(558);						
				?>
				<?php foreach($home_page_product->result() as $home_product): ?>
					<div class="box">
					<?php 
						$primry_photo_r = $this->common_m->get_primary_photo($home_product->page_id);						
					?>
						<span class="images">
<?php
								$base_url = base_url(); 
								$path = 'uploads/test_img/'.$primry_photo_r->photo_file_name;

								$image_url = $base_url.$path;
							?>
							<img src='<?php echo $image_url; ?>'>
</span>
						<span class="category_content">
							<ul>
								<?php
									$i = 0;
									 $home_sub_product_q = $this->common_m->sub_menu($home_product->page_id);
									 foreach($home_sub_product_q->result() as $home_sub_product):
									 	$str = strtolower($home_sub_product->title);;
								?>
									<li>
										<a href="<?php echo base_url();?><?php if($i == 0){ echo 'toner'; }else{ echo 'ink'; } ?>/<?php echo $home_sub_product->page_slug; ?>"><?php echo $home_sub_product->title; ?></a>
									</li>
								<?php 
								$i++;
								endforeach; ?>
							</ul>
						</span>
						<!-- <span class="view_all"><a href="">View All</a></span> -->
					</div>
				<?php endforeach; ?>
			</div><!--end of row-->

		</div><!--end of body container right-->
	</div><!--end of middle_container-->
</div><!--end of body container-->
<?php $this->load->view('footer_v.php'); ?>			