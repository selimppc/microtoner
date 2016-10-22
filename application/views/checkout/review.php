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
								<div class="checkout-circle ">
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
								<div class="checkout-circle forspecialcase_section active">
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
								Review and Order
							</div>

							<div class="cart_content_part2">								
								<p>Please review your information before pay</p>
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
											<div class="product_container_second review_order_page">
												PRICE
											</div>
											<div class="product_container_second review_order_page">
												QUANTITY
											</div>
											<div class="product_container_second review_order_page">
												TOTAL
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
							            			$product_id_r = $check_product_id_list[$i];

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
														<img src='<?php echo base_url(); ?>server/php/files/<?php echo $primry_photo_r->photo_file_name;?>' style='margin-left:15px;'>
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
											<div class="product_container_second review_order_page">
												$ <?php echo $page_data->price; ?>
											</div>
											<div class="product_container_second review_order_page">
												<?php 
													echo $check_product_quantity_list[$j];
													$quantity_r = $check_product_quantity_list[$j];
												?>
											</div>
											<div class="product_container_second review_order_page">
												$ <?php 
												echo number_format($page_data->price * $check_product_quantity_list[$j], 2, '.', '');
												$total_price+= $page_data->price * $check_product_quantity_list[$j];
											 ?>
											</div>
											
										</div>	

								<?php
									endif;
										}
									}								
								?>


								<?php

								$user_id = $this->session->userdata('user_id');
											
								$user_data_r = $this->common_m->get_by_fields(
								        '', 
								        'guest_user', 
								        array(
								           'id' => $user_id
										)
								);
								 // set found pages for view file
								            
								$data['user_data'] = $user_data_r['data'];

								$user_data = $data['user_data'];
							?>


							<div class="cart_total_price_1">
								<div class="total_price_container">
									<div class="sub_total_container">
										<div class="total_header">Sub Total</div>
										<div class="total_amount">$ <?php 
											echo number_format($total_price, 2, '.', '');
										 ?></div>
									</div>
									<div class="shipping_cost_container">
									<div class="total_header">Shipping Cost</div>
										<div class="total_amount">$ <?php 

											if($user_data->billing_state == 'WA' || $user_data->billing_state == 'TAS'){
												echo $shipping_cost = number_format(30.00, 2, '.', '');
											}else if($total_price < 50 ){
												echo $shipping_cost = number_format(4.50, 2, '.', '');
											}else{
												echo $shipping_cost = number_format(0.00, 2, '.', '');
											}
										  ?>
										</div>
									</div>
									<div class="total_cost_container">
										<div class="total_header">Total Price</div>
										<div class="total_amount">$ <?php 
										echo number_format($total_price + $shipping_cost, 2, '.', ''); ?></div>
									</div>
								</div>
							</div>

							
							    <div class="review_customer_information">
									<div class="customer_info_first">
										<span class="customer_heading">ACCOUNT INFORMATION</span>
													
										<p style="margin:0;"><?php echo $user_data->billing_firstname; ?>, <?php echo $user_data->billing_lastname; ?> </p>
										<p style="margin:0;"><?php echo $user_data->billing_email; ?> </p>
									</div>

									<div class="customer_info_second">
										<div class="billing_info">
											<span class="customer_heading">BILLING INFORMATION</span>
												<p style="margin:0;"><?php echo $user_data->billing_firstname; ?>  <?php echo $user_data->billing_lastname;?> </p>
												<p style="margin:0;"><?php echo $user_data->billing_address; ?> </p>
												<p style="margin:0;"><?php echo $user_data->billing_suburb; ?>, <?php echo $user_data->billing_state; ?> <?php echo $user_data->billing_postcode; ?> </p>
												<p style="margin:0;"><?php echo $user_data->billing_country; ?> </p>
												<p style="margin:0;"><?php echo $user_data->billing_telephone; ?></p>
										</div>
										<div class="billing_info">
											<span class="customer_heading">SHIPPING INFORMATION</span>
											<p style="margin:0;"><?php echo $user_data->shipping_firstname; ?>  <?php echo $user_data->shipping_lastname;?> </p>
											<p style="margin:0;"><?php echo $user_data->shipping_address; ?> </p>
											<p style="margin:0;"><?php echo $user_data->shipping_suburb; ?>, <?php echo $user_data->shipping__state; ?> <?php echo $user_data->shipping_postcode; ?> </p>
											<p style="margin:0;"><?php echo $user_data->shipping_coubntry; ?> </p>
												
										</div>
													
									</div>

												
								</div>
								<a href="<?php echo base_url(); ?>checkout/pay_now" class="review_to_pay">Confirm order</a>	
								<a href="<?php echo base_url(); ?>checkout/shoppingcart" class="review_edit_order">Edit Order</a>	
						</div>


						<?php }else{
							echo '<span class="empty_shopping">Your Shopping Bag is empty</span>';
						}?>



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

		$('.product_remove').click(function(){

			var detail_page_id = $('#cart_product_id').val();
			var detail_page_qty = $('#cart_product_qty').val();
			var detail_page_price = $('#cart_product_price').val();

			this.save = $.ajax({
	            type: 'post',
	            url: "<?php echo site_url(); ?>checout/remove_addtocart",
	            data: {detail_page_id:detail_page_id,detail_page_qty:detail_page_qty,detail_page_price:detail_page_price}
	        }).done(function(msg){
	            
	            location.reload();
	        });


			return false;
		});
	</script>
<?php $this->load->view('footer_v.php'); ?>			