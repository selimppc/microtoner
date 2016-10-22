<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>


	<div id="body_section" >
		<div id="middle_container">
			<?php $this->load->view('leftsidebar_v.php'); ?>
			<div itemscope itemtype="http://schema.org/Product" id="body_container_right">
				<div class="row">
					<div class="first_left">
						<h1 itemprop="name"><?php echo $page_data->title; ?></h1>
						<link itemprop="additionalType" href="<?php echo $page_data->additionaltype; ?>" />
						<div class="row">
							<div class="inner3_left">Brand</div>
							<div class="inner3_right" itemprop="brand"><?php echo $page_data->brand; ?></div>
						</div>

						<div class="row">
							<div class="inner3_left">Product</div>
							<div class="inner3_right" itemprop="productID"><?php echo $page_data->product_no; ?></div>
							<div style="display:none;" class="inner3_right" itemprop="alternateName"><?php echo $page_data->alternate_name1; ?></div>
							<div style="display:none;" class="inner3_right" itemprop="alternateName"><?php echo $page_data->alternate_name2; ?></div>
							<div style="display:none;" class="inner3_right" itemprop="alternateName"><?php echo $page_data->alternate_name3; ?></div>
						</div>

						<div class="row" >
							<div class="inner3_left">Type</div>
							<div class="inner3_right" itemprop="model"><?php echo $page_data->printer_type; ?></div>
						</div>

						<div class="row">
							<div class="inner3_left">Printer Technology</div>
							<div class="inner3_right"><?php echo $page_data->printer_technology; ?></div>
						</div>

						<div class="row">
							<div class="inner3_left">Color</div>
							<div class="inner3_right" itemprop="color"><?php echo $page_data->color; ?></div>
						</div>

						<div class="row" >
							<div class="inner3_left">Page Yield @ 5% Coverage</div>
							<div>
								<div class="inner3_right" ><?php echo $page_data->page_yield; ?></div>
							</div>
						</div>

						<div class="row" >
							<div class="inner3_left">Condition</div>
							<div class="inner3_right" itemprop="itemCondition"><?php echo $page_data->condition; ?></div>
						</div>

						<div class="row">
							<div class="inner3_left">SKU</div>
							<div itemprop="sku" class="inner3_right"><?php echo $page_data->sku; ?></div>
						</div>

						<div class="row">
							<div class="inner3_left">Price</div>
							<div class="inner3_right" itemprop="offers" itemscope itemtype="http://schema.org/Offer"><span itemprop="priceCurrency" content="AUD">$</span> <span itemprop="price" content="<?php echo number_format($page_data->price, 2, '.', ''); ?>"><?php echo number_format($page_data->price, 2, '.', ''); ?></span> </div>
						</div>

						<div class="row">
							<div class="inner3_left">Quantity</div>
							<div class="inner3_right">
								<div class="inner2_amount">
									<input type="text" name="" itemprop="depth" value="1" id="detail_page_qty">
									<input type="hidden" name="" id="detail_page_id" value="<?php echo $page_data->id; ?>" >
									<input type="hidden" name="" id="detail_page_price" value="<?php echo $page_data->price; ?>">
									
								</div>
							</div>
						</div>

						<div class="row">
							<div class="product_description">
								<?php echo $page_data->printer_description; ?>
							</div>
						</div>
						 
						<div class="row">
							<div class="inner3_add_to_cart_button">
								<a href="#" class="detail_page_addtocart" >Add to Cart</a>
							</div>
						</div>
					</div>

					<div class="first_right">
						<div class="product_no_r"><?php echo $page_data->product_no; ?></div>
						<?php 
							$primry_photo_r = $this->common_m->get_primary_photo($page_data->id);
							if(!empty($primry_photo_r->photo_file_name)):						
						?>
							<img caption="<?php echo $page_data->product_no; ?>" title="<?php if(empty($primry_photo_r)){ echo $page_data->product_no; }else{ echo $primry_photo_r->sort_title; }  ?>" alt="<?php if(empty($primry_photo_r)){ echo $page_data->product_no; }else{ echo $primry_photo_r->sort_description; }  ?>" src='<?php echo base_url(); ?>server/php/files/<?php echo $primry_photo_r->photo_file_name;?>' style='width:130px;margin-left:15px;'>
						<?php else: ?>
							<img caption="<?php echo $page_data->product_no; ?>" title="<?php if(empty($primry_photo_r)){ echo $page_data->product_no; }else{ echo $primry_photo_r->sort_title; }  ?>" alt="<?php if(empty($primry_photo_r)){ echo $page_data->product_no; }else{ echo $primry_photo_r->sort_description; }  ?>" src='<?php echo base_url(); ?>images/image-coming-soon.png' >
						<?php endif;?>
					</div>

				</div>

				<div class="row">
					<div class="product_description">
						<?php echo $page_data->description; ?>
					</div>
				</div>

				<div class="border_bottom">&nbsp;</div>

				<div id="inner_container">

							<div class="row">
								<div class="inner3_tab_container">
									<div id="tab-container" class='tab-container'>
										<ul class='etabs'>
										   <li class='tab'><a href="#tabrelatedproduct">Related Product</a></li>
										   <li class='tab'><a href="#tabcompatibleprinter">Suitable Printer</a></li>
										   <li class='tab'><a href="#tabsshipping">Shipping</a></li>
										   <li class='tab'><a href="#tabspaymentmerhod">Payment Method</a></li>
										</ul>

										<div class='panel-container'>
											<div id="tabrelatedproduct">
											
												<?php 
													$i=0;
													foreach($related_data_q->result() as $related_data):
														if($i == 0){															
															$i++;
															$show_product_r = $this->common_m->sub_menu_printer_r($related_data->printer_id);
															foreach($show_product_r->result() as $show_product){
															if($page_data->id != $show_product->page_id):
												?>				<div>
																	<div  class="inner2_container inner3_container">
																		<div class="inner2_first">
																			<?php 
																				$primry_photo_r = $this->common_m->get_primary_photo($show_product->page_id);
																				if(!empty($primry_photo_r->photo_file_name)):						
																			?>
																				<img title="<?php if(empty($primry_photo_r)){ echo $page_data->product_no; }else{ echo $primry_photo_r->sort_title; }  ?>" alt="<?php if(empty($primry_photo_r)){ echo $page_data->product_no; }else{ echo $primry_photo_r->sort_description; }  ?>" src='<?php echo base_url(); ?>server/php/files/<?php echo $primry_photo_r->photo_file_name;?>'>
																			<?php else: ?>
																				<img title="<?php if(empty($primry_photo_r)){ echo $page_data->product_no; }else{ echo $primry_photo_r->sort_title; }  ?>" alt="<?php if(empty($primry_photo_r)){ echo $page_data->product_no; }else{ echo $primry_photo_r->sort_description; }  ?>" style="width:80px;" src='<?php echo base_url(); ?>images/image-coming-soon.png' >
																			<?php endif;?>
																		</div>
																		<div class="inner2_second">
																			<a href="<?php echo base_url(); ?><?php echo $show_product->page_slug; ?>"><h3 itemprop="isRelatedTo"><?php echo $show_product->title; ?></h3></a>
																			<span class="inner2_pagesamount" >
																				<span><?php echo $show_product->manufacter; ?></span>
																			</span>
																		</div>
																		<div class="inner2_third">
																			<div class="inner2_price" >Price</div>
																			<div class="inner2_amount" >
																				<span >$</span>
																				<span><?php echo $show_product->price; ?></span>
																			</div>
																		</div>
																		<form action="<?php echo base_url(); ?>add_related_product" method="post" >	
																			<div class="inner2_third">
																				<div class="inner2_price">Quantity</div>
																				<div class="inner2_amount">
																					<input type="text" name="detials_related_qty" class="detials_related_qty" value="1" details_product_id="<?php echo $show_product->page_id; ?>">
																				</div>
																			</div>
																			<div class="inner2_fourth inner3_fourth">
																				<div class="inner2_viewall"><a href="<?php echo base_url(); ?><?php echo $show_product->page_slug; ?>">View</a></div>
																				<input type="hidden" name="product_id" value="<?php echo $show_product->page_id; ?>">
																				<input type="submit" class="inner2_buy_now_s" name="Addtocart" value="Add to Cart">
																				<!-- <div class="inner2_buy_now add_to_cart_details_related" details-inner-pageid="<?php echo $show_product->page_id; ?>" details-inner-price="<?php echo $show_product->price; ?>"><a  href="#">Add to Cart</a></div> -->
																			</div>
																		</form>
																	</div> <!--vv-->
																</div>
												<?php		
														endif;		
															}
														}														
												?>
																										
												<?php endforeach;?>											

												
											</div>
											<div id="tabcompatibleprinter">
												<div class="subcategory_box">
													<?php
														foreach($printer_list_r->result() as $printer_list):
													?>
														<div class="subcategory"><a class="for_printer" href="<?php echo base_url(); ?><?php echo $parent_data->page_slug; ?>/<?php echo $printer_list->printer_slug; ?>"><span itemprop="isConsumableFor"><?php echo $printer_list->printer_name; ?></span></a></div>
													<?php
														endforeach;
													?>
												</div>
											</div>
											
											
											<div id="tabsshipping">
												<p>Free delivery on purchases over <b>$50.00</b> (inc. GST), Except for Perth & Tasmania.</p>
												<p>For order below <b>$50.00</b> will be charged of $4.50 (inc. GST) per order.
												<p>All orders are despatched on same day, if ordered before 3pm.  We use mainly Fastway, Couriers Please, Australian Post and various couriers for delivery service.</p>
												<p>For Perth & Tasmania or Express or same day delivery please call on 02 9785 2488 or 0421 438 035. Additional cost applies.
Deliveries for all Major metropolitan area are 1 to 3 business day (if ordered before 3pm) except for Perth & Tasmania.</p>
<p><b>**Delivery times are indicative only and we do not accept any liability for failure to meet the scheduled delivery times or any inconvenience caused as a consequence **</b></p>
											</div>
											<div id="tabspaymentmerhod">
												<p>
													<img style="width:170px;" src="<?php echo base_url(); ?>/images/paypal.png"><br>
													
												</p>
											</div>
										</div>
									</div>
								</div><!--inner3 tab container -->
							</div>


						</div><!--end of inner container-->	

				
			</div>
		</div>
	</div>
	<script type="text/javascript">

		// $('.detials_related_qty').change(function(){

		// 	var details_product_id =$(this).attr('details_product_id');
		// 	var detials_related_qty = $('.detials_related_qty').val();
		// 	var pqty = details_product_id+'product_qty';
		// 	console.log(pqty);
		// 	$('.pqty').val(detials_related_qty);
		// });

		$('.detail_page_addtocart').click(function(){
			
			var detail_page_id = $('#detail_page_id').val();
			var detail_page_qty = $('#detail_page_qty').val();
			var detail_page_price = $('#detail_page_price').val();

			this.save = $.ajax({
	            type: 'post',
	            url: "<?php echo site_url(); ?>checout/addtocart",
	            data: {detail_page_id:detail_page_id,detail_page_qty:detail_page_qty,detail_page_price:detail_page_price}
	        }).done(function(msg){
	            
	            redirect_url = "<?php echo base_url(); ?>checkout/shoppingcart" ;				
				window.location.replace(redirect_url);
	            
	        });


			return false;
		});


		 $('.add_to_cart_details_related').live('click', function(){
			var objectRef = $(this);
			var detail_page_id =$(this).attr('details-inner-pageid');
			var detail_page_qty = $('.detials_related_qty').val();
			var detail_page_price = $(this).attr('details-inner-price');

			
			this.save = $.ajax({
	            type: 'post',
	            url: "<?php echo site_url(); ?>checout/addtocart",
	            data: {detail_page_id:detail_page_id,detail_page_qty:detail_page_qty,detail_page_price:detail_page_price}
	        }).done(function(msg){
	            
	            redirect_url = "<?php echo base_url(); ?>checkout/shoppingcart" ;				
				window.location.replace(redirect_url);
	            
	        });


			return false;
		});
	</script>
<?php $this->load->view('footer_v.php'); ?>			