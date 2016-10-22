<?php $this->load->view('head_v.php'); ?>
<?php $this->load->view('header_v.php'); ?>

<div id="body_section">
	<div id="middle_container">
		<?php $this->load->view('leftsidebar_v.php'); ?>
		<div itemscope itemtype="http://schema.org/Product" id="body_container_right">
			<div class="row">
				<div class="first_left">
					<h1 itemprop="name"><?php echo $page_data->printer_name; ?></h1>
					<link itemprop="additionalType" href="<?php echo $page_data->additionaltype; ?>" />
					<span style="display:none;" itemprop="alternateName"><?php echo $page_data->alternative_name1; ?></span>
					<span style="display:none;" itemprop="alternateName"><?php echo $page_data->alternative_name2; ?></span>
					<span style="display:none;" itemprop="alternateName"><?php echo $page_data->alternative_name3; ?></span>
					<div itemprop="description"><?php echo $page_data->printer_description; ?></div>
				</div>	
				<div class="first_right">
					<?php 
							$primry_photo_r = $this->common_m->get_printer_photo($page_data->id);
							if(!empty($primry_photo_r->photo_file_name)):						
						?>
							<img caption="<?php echo $page_data->printer_name; ?>" title="<?php if(empty($primry_photo_r)){ echo $page_data->printer_name; }else{ echo $primry_photo_r->short_title; }  ?>" alt="<?php if(empty($primry_photo_r)){ echo $page_data->printer_name; }else{ echo $primry_photo_r->short_description; }  ?>" src='<?php echo base_url(); ?>server/php/files/<?php echo $primry_photo_r->photo_file_name;?>' style='width:130px;margin-left:15px;'>
						<?php else: ?>
							<img caption="<?php echo $page_data->printer_name; ?>" title="<?php if(empty($primry_photo_r)){ echo $page_data->printer_name; }else{ echo $primry_photo_r->short_title; }  ?>" alt="<?php if(empty($primry_photo_r)){ echo $page_data->printer_name; }else{ echo $primry_photo_r->short_description; }  ?>" src='<?php echo base_url(); ?>images/image-coming-soon.png' >
						<?php endif;?>
				</div>			
			</div>
			<div class="border_bottom">&nbsp;</div>

			<div id="inner_container">
				<div class="row">
					<?php foreach($related_data_q->result() as $related_data): ?>
						<div class="inner2_container_section inner_printer_container">
							<!-- <div class="inner2header">
								<h2><?php //echo $related_data->title; ?> </h2>
							</div> -->
							<div class="inner2_container">
								<div class="inner2_first">
										<?php 
											$primry_photo_r = $this->common_m->get_primary_photo($related_data->page_id);						
											if(!empty($primry_photo_r->photo_file_name)):
										?>
											<img src='<?php echo base_url(); ?>server/php/files/<?php echo $primry_photo_r->photo_file_name;?>' >
										
										<?php else: ?>
											<img style="width:80px;" src='<?php echo base_url(); ?>images/image-coming-soon.png' >
										<?php endif;?>

								</div>
								<div class="inner2_second">
											<a href="<?php echo base_url(); ?><?php echo $related_data->page_slug; ?>"><h3><?php echo $related_data->title; ?></h3></a>
											<span class="inner2_pagesamount"><?php echo $related_data->manufacter; ?></span>
										</div>
										<div class="inner2_third">
											<div class="inner2_price">Price</div>
											<div class="inner2_amount">$<?php echo $related_data->price; ?></div>
										</div>
										<form action="<?php echo base_url(); ?>add_related_product" method="post" >	
											<div class="inner2_third">
												<div class="inner2_price">Quantity</div>
												<div class="inner2_amount"><input type="text" name="detials_related_qty" class="ptinter_related_qty" value="1"></div>
											</div>
											<div class="inner2_fourth">
												<div class="inner2_viewall"><a href="<?php echo base_url(); ?><?php echo $related_data->page_slug; ?>">View</a></div>
												<input type="hidden" name="product_id" value="<?php echo $related_data->page_id; ?>">
												<input type="submit" class="inner2_buy_now_s" name="Addtocart" value="Add to Cart">
												<!-- <div class="inner2_buy_now add_to_cart_printer_related"  ptinter-inner-pageid="<?php echo $related_data->page_id; ?>" ptinter-inner-price="<?php echo $related_data->price; ?>" ><a href="#">Add to Cart</a></div> -->
											</div>
										</form>
							</div>
							
						</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
		


	$('.add_to_cart_printer_related').live('click', function(){
			var objectRef = $(this);
			var detail_page_id =$(this).attr('ptinter-inner-pageid');
			var detail_page_qty = $('.ptinter_related_qty').val();
			var detail_page_price = $(this).attr('ptinter-inner-price');

			
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