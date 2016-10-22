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
								<div class="inner2_container">
									<div class="inner2_first">
										<?php 
											$primry_photo_r = $this->common_m->get_primary_photo($search_query->id);
											if(!empty($primry_photo_r->photo_file_name)):						
										?>
												<img alt="<?php echo $search_query->title; ?>" src='<?php echo base_url(); ?>server/php/files/<?php echo $primry_photo_r->photo_file_name;?>'>
										<?php else: ?>
												<img alt="<?php echo $search_query->title; ?>" style="width:80px;" src='<?php echo base_url(); ?>images/image-coming-soon.png' >
										<?php endif;?>
									</div>

									<div class="inner2_second">
										<a href="<?php echo base_url(); ?><?php echo $search_query->page_slug; ?>"><h3><?php echo $search_query->title; ?></h3></a>
										<span class="inner2_pagesamount" >
											<span><?php echo $search_query->manufacter; ?></span>
										</span>
									</div>

									<div class="inner2_third">
										<div class="inner2_price" >Price</div>
										<div class="inner2_amount" >
											<span >$</span>
												<span><?php echo number_format($search_query->price, 2, '.', ''); ?></span>
										</div>
									</div>

									<form action="<?php echo base_url(); ?>add_related_product" method="post" >	
										<div class="inner2_third">
											<div class="inner2_price">Quantity</div>
											<div class="inner2_amount">
												<input type="text" name="detials_related_qty" class="detials_related_qty" value="1" details_product_id="<?php echo $search_query->id; ?>">
											</div>
										</div>
										<div class="inner2_fourth inner3_fourth">
											<div class="inner2_viewall"><a href="<?php echo base_url(); ?><?php echo $search_query->page_slug; ?>">View</a></div>
												<input type="hidden" name="product_id" value="<?php echo $search_query->id; ?>">
												<input type="submit" class="inner2_buy_now_s" name="Addtocart" value="Add to Cart">
												<!-- <div class="inner2_buy_now add_to_cart_details_related" details-inner-pageid="<?php //echo $show_product->page_id; ?>" details-inner-price="<?php echo $show_product->price; ?>"><a  href="#">Add to Cart</a></div> -->
											</div>
										</form>


								</div>
							</div>
							<?php
								}
								else:
									echo 'Please Type accurate product no.';
								endif;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('footer_v.php'); ?>			