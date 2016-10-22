<body>
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NDXSC4"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-NDXSC4');</script>
		<!-- End Google Tag Manager -->
		<div id="main_container"><!--start of main_container-->
			<div id="header_container"><!--start of header_container-->
				<div id="middle_container"><!--start of menu_container-->
					<div id="menu">

					<?php 
						$main_menu_q = $this->common_m->get_menu(7);						
					?>
					<ul>
						<li>
							<a href="<?php echo base_url(); ?>">Home</a>
						</li>
					<?php foreach($main_menu_q->result() as $main_menu): ?>
						<li>
							<a href="<?php echo base_url(); ?><?php echo $main_menu->page_slug; ?>"><?php echo $main_menu->title; ?></a>
						</li>
					<?php endforeach; ?>
					</ul>

					<div class="top_regodtration">
					<?php
						$logged_user_id = $this->session->userdata('logged_user_id');
						if($logged_user_id):
					?>
						<input type="hidden" name="logged_user_id" id="logged_user_id" value="<?php echo $logged_user_id; ?>"> 
						<a href="#" id="logout">Logout</a>

					<?php else: ?>

						<a href="<?php echo base_url(); ?>checkout/login">Login</a>
						<a style="margin-left:10px;" href="<?php echo base_url(); ?>checkout/register">Register</a>
					<?php endif;?>
					</div>
					<div class="welcomeuser">
						 
						<?php
							$logged_user_id = $this->session->userdata('logged_user_id');
							if(!empty($logged_user_id)){
								$user_data_r = $this->common_m->get_by_fields(
					                '', 
					                'register_user', 
					                array(
					                    'id' => $logged_user_id
					                )
					            );
					    		// set found pages for view file
					     		$user_data = $user_data_r['data'];
					     		echo 'Welcome back ' . $user_data->billing_firstname . ' '. $user_data->billing_lastname . ' &nbsp;&nbsp;|';
							}
						?>
						  
					</div>
					</div><!--end of menu-->

					<div id="header_bottom_container">
						<a href="<?php echo base_url(); ?>">
							<div id="logo_container">
								<span class="logo" itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
									<img src="<?php echo base_url(); ?>images/logo.png" itemprop="contentUrl" caption="Logo" >
								</span>
							</div><!--end of logo container-->
						</a>
						<div class="promotional_image_container">
							<div class="promotional_image">
								<img src="<?php echo base_url(); ?>images/van-free-devivery.png">
							</div>
						</div>
						<div id="top_shpping_cart_container">
							<div class="bag_container">
								<span class="text">Shopping cart</span>
								<a href="<?php echo base_url(); ?>checkout/shoppingcart" class="shopping_cart">
									<span class="bottom_text">

									<?php
										$total_price = 0;
										$check_product_id_list = $this->session->userdata('product_id');
										$check_product_quantity_list = $this->session->userdata('product_quantity');
			                            if(!empty($check_product_id_list)){
			                                echo $count = sizeof($check_product_id_list);
			                            }else{
			                                echo $count = '0';
			                            }
			                            
			                            
			                            
									?>
											item(s)

									- $<?php
										if(!empty($check_product_id_list)){

				                            for($i=0;$i<sizeof($check_product_id_list);$i++){
				                            	
				                            	for($j=0;$j<sizeof($check_product_quantity_list);$j++){
				                            		if($i == $j){
				                            			
				                            			$product_request = $this->common_m->get_by_fields(
										                    '', 
										                    'page', 
										                    array('id' => $check_product_id_list[$i]), 
										                    '', 
										                    ''
										                );

										                $product_data = $product_request['data'];
										                $total_price+= $product_data->price * $check_product_quantity_list[$j];
				                            		}
				                            	}
				                            }

				                            echo number_format($total_price, 2, '.', '');
				                        }else{
				                        	echo '0.00';
				                        }
									 ?>
									</span>
								</a>
							</div>
						</div><!--end of top shopping cart container-->
					</div><!--end of header_bottom-->
				</div><!--end of middle container-->
			</div><!--end of header container-->

			<div id="top_search_container">
				<div id="middle_container">
					<div id="top_category_text">
						Printer Cartridges
					</div><!--end of catgory text-->

					<div id="top_product_search">
							<div class="search_container">
								<form action="<?php echo base_url(); ?>search_by_printer" method="post">
									<input type="text" name="search_by_printer_number" class="search_input" value="" placeholder="Search by printer">
									<input type="submit" name="btn_cartridge_number" class="search_btn" value="Search">
								</form>
							</div><!--end of search container-->
							<div class="search_container search_container_right">
								<form action="<?php echo base_url(); ?>search_by_productno" method="post">
									<input type="text" name="search_by_product_number" class="search_input" placeholder="Search for a product">
									<input type="submit" name="btn_product_number" class="search_btn" value="Search">
								</form>
							</div><!--end of search container-->
					</div><!--end of top product search-->
				</div><!--end of middile container-->
			</div>