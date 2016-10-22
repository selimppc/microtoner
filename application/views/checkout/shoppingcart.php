<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>
	
	<div id="body_section">
		<div id="middle_container">
			<?php $this->load->view('leftsidebar_v.php'); ?>
			<div id="body_container_right">
				<div id="inner_container">
					<div class="row">
						<div class="cart_container">
							<div class="checkoutmargin">
								<div class="checkout-circle active">
									<div class="circle">1</div>
									<div class="circleHead">Checkout</div>
								</div>
								<div class="circleSeperator"></div>
								<div class="checkout-circle">
									<div class="circle">2</div>
									<div class="circleHead">Address</div>
								</div>
								<div class="circleSeperator"></div>
								<div class="checkout-circle">
									<div class="circle">3</div>
									<div class="circleHead">Shipping</div>
								</div>
								<div class="circleSeperator"></div>
								<div class="checkout-circle">
									<div class="circle">4</div>
									<div class="circleHead payment_method">Payment Method</div>
								</div>
								<div class="circleSeperator forspecialcase_border"></div>
								<div class="checkout-circle forspecialcase_section">
									<div class="circle">5</div>
									<div class="circleHead review_and_order">Review and Order</div>
								</div>
								<div class="circleSeperator forspecialcase_border"></div>
								<div class="checkout-circle forspecialcase_section">
									<div class="circle">6</div>
									<div class="circleHead">Pay</div>
								</div>
								<div class="circleSeperator forspecialcase_border"></div>
								<div class="checkout-circle forspecialcase_section">
									<div class="circle">7</div>
									<div class="circleHead checkout_complete">Checkout Complete</div>
								</div>
							</div>
							<div class="checkout_title">
								Checkout
							</div>

							<div class="cart_content_part2">								
								<p>SHOPPING CART CONTENTS</p>
							</div>
							<?php
								$check_product_quantity_list = $this->session->userdata('product_quantity');
								$check_product_id_list = $this->session->userdata('product_id');
								if(!empty($check_product_id_list)){
							?>

								<div class="cart_product_container">
									<div class="cart_product_container_top">
										<div class="product_container_first">
											PRODUCT
										</div>
										<div class="product_container_second">
											PRICE
										</div>
										<div class="product_container_second">
											QUANTITY
										</div>
										<div class="product_container_second">
											TOTAL
										</div>
										<div class="product_container_second">
											UPDATE / REMOVE
										</div>
									</div>
							<?php
								$total_price = 0;
									for($i=0;$i<sizeof($check_product_id_list);$i++){
										for($j=0;$j<sizeof($check_product_quantity_list);$j++){
											if($i == $j):

										$page_data_r = $this->common_m->get_by_fields(
							                            '', 
							                            'page', 
							                            array(
							                                   'id' => $check_product_id_list[$i]
							                                )
							                        );
							            // set found pages for view file
							            
							            $data['page_data'] = $page_data_r['data'];
							            $page_data = $data['page_data'];
							?>
										
										<div class="cart_product_container_middle">
											<div class="product_container_first">
												<div class="cart_product_images">
													<?php 
														$primry_photo_r = $this->common_m->get_primary_photo($page_data->id);
														if(!empty($primry_photo_r->photo_file_name)):						
													?>
														<img src='<?php echo base_url(); ?>server/php/files/<?php echo $primry_photo_r->photo_file_name;?>' style='width:130px;margin-left:15px;'>
													<?php else: ?>
														<img src='<?php echo base_url(); ?>images/image-coming-soon.png' >
													<?php endif;?>
												</div>
												<div class="cart_product_description">
													<span class="description"><p>
														<?php echo $page_data->title ?>
													</span>
												</div>
											</div>

											<div class="product_container_second">
												$ <?php 
													echo number_format($page_data->price, 2, '.', '');
												 ?>
											</div>
											<form method="post" action="<?php echo base_url(); ?>updateqty_shopping_cart">
											<div style="text-align:left;margin-top:-7px;" class="product_container_second inner2_amount">
												<input type="text" name="update_qty" value="<?php echo $check_product_quantity_list[$j];  ?>">	
												
											</div>
											<div class="product_container_second">
												$ <?php 
												echo number_format($page_data->price * $check_product_quantity_list[$j], 2, '.', '');
												$total_price+= $page_data->price * $check_product_quantity_list[$j];
											 ?>
											</div>
											<div class="product_container_second">							
												
													<input type="hidden" name="product_id" id="cart_product_id_b" value="<?php echo $page_data->id; ?>">
													<input type="hidden" name="product_qty" id="cart_product_price" value="<?php echo $page_data->price; ?>">
													<input type="hidden" value="<?php echo $check_product_quantity_list[$j];  ?>" name="cart_product_qty" id="cart_product_qty_b" class="cart_product_qty"> 
													<input type="submit" class="edit_icon" name="remove" title="update" value="">
												</form>
												<!-- <span class="product_remove" cart_product_qty="" cart_product_id="<?php echo $page_data->id; ?>"><img src="<?php echo base_url(); ?>images/close.png"></span> -->
												<form method="post" action="<?php echo base_url(); ?>update_shopping_cart">
													<input type="hidden" name="product_id" id="cart_product_id_b" value="<?php echo $page_data->id; ?>">
													<input type="hidden" name="product_qty" id="cart_product_price" value="<?php echo $page_data->price; ?>">
													<input type="hidden" value="<?php echo $check_product_quantity_list[$j];  ?>" name="cart_product_qty" id="cart_product_qty_b" class="cart_product_qty"> 
													<input type="submit" class="product_remove_cross" title="remove" name="remove" value="">
												</form>
											</div>
										</div>	



							<?php
								endif;
									}
								}
								
							?>
							<div class="cart_total_price_1">
								<div class="total_price_container">
									<div class="total_header">Total Price</div>
									<div class="total_amount">$
										<?php 
											echo number_format($total_price, 2, '.', '');
										?>
									</div>
								</div>
							</div>
							<div class="cart_product_container_last">
								<div class="cart_product_container_last_left">
									<?php  $continue_shopping = $this->session->userdata('continue_shopping');?>
									<a href="<?php echo base_url(); ?><?php if(!empty($continue_shopping)): echo $continue_shopping; endif;?>" class="">CONTINUE SHOPPING</a>
								</div>
								<div class="cart_product_container_right">									
									<a href="<?php echo base_url(); ?>checkout/login">CHECKOUT</a>
								</div>
							</div>
						</div>
							<?php

								}else{
									echo '<span class="empty_shopping">Your Shopping Bag is empty</span>';
								}
							?>

						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">

		$('.update_shopping_bag').click(function(){
			
			var detail_page_id = $('#cart_product_id').val();
			var detail_page_qty = $('#cart_product_qty').val();
			var detail_page_price = $('#cart_product_price').val();

			this.save = $.ajax({
	            type: 'post',
	            url: "<?php echo site_url(); ?>checout/addtocart",
	            data: {detail_page_id:detail_page_id,detail_page_qty:detail_page_qty,detail_page_price:detail_page_price}
	        }).done(function(msg){
	            
	            location.reload();
	        });


			return false;
		});

		// $('.product_remove').click(function(){

		// 	var detail_page_id = $(this).attr('cart_product_id');
		// 	var detail_page_qty = $('#cart_product_qty').val();
		// 	var detail_page_price = $('#cart_product_price').val();

		// 	alert(detail_page_id);alert(detail_page_qty);alert(detail_page_price);

		// 	exit;

		// 	// this.save = $.ajax({
	 //  //           type: 'post',
	 //  //           url: "<?php echo site_url(); ?>checout/remove_addtocart",
	 //  //           data: {detail_page_id:detail_page_id,detail_page_qty:detail_page_qty,detail_page_price:detail_page_price}
	 //  //       }).done(function(msg){
	            
	 //  //           location.reload();
	 //  //       });


		// 	return false;
		// });
	</script>
<?php $this->load->view('footer_v.php'); ?>			