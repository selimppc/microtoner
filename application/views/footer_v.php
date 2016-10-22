<div id="footer_section">
				<div id="middle_container">
					
					<div class="footer_row">
						<span class="one_row">
							<img src="<?php echo base_url(); ?>images/logo.png" class="footer_logo">
						</span>
						
					</div><!--end of footer row-->
					<div class="footer_payment_social" style="margin-left:100px;">
						<span class="one_row">
							<img src="<?php echo base_url(); ?>images/paypal.png" class="paypall">
						</span>
						<!-- <span class="one_row">
							<div class="two_row">
								<img src="<?php //echo base_url(); ?>images/visa.png">
							</div>
							<div class="two_row">
								<img src="<?php //echo base_url(); ?>images/mastercard.png">
							</div>
						</span> -->
					</div><!--end of footer row-->

					<div class="footer_payment_social">
						<span class="one_row">
							<a href="https://www.google.com/+MicrotonersuppliesAu" target="_blank" class="googleplus">
								<img src="<?php echo base_url(); ?>images/googleplug.png">
							</a>
							<a href="https://www.facebook.com/pages/MicroTonerSuppliescomau/216903545026194" target="_blank" class="facebook">
								<img src="<?php echo base_url(); ?>images/facebook.jpg">
							</a>
							<!-- <img src="<?php //echo base_url(); ?>images/social.jpg" class="social_icon"> -->
						</span>
						
					</div><!--end of footer row-->

					<div class="footer_row_full">
						<span class="footer_menu">
						<?php 
							$main_menu_q = $this->common_m->get_menu(8);						
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
						</span>

						<span class="footer_copyright">
							<p>&copy; 2015 Micro Toner Supplies Sydney, New South Wales, Australia</p>
                                                        <a class="developer_company" href="http://www.visionads.com.au/" rel="nofollow" target="_blank" >Seo & Website by VisionsAds</a>
						</span>
						
					</div><!--end of footer row-->	
				</div><!--end of middle container-->
			</div><!--end of footer section-->
		</div><!--end of main_container-->

		<script type="text/javascript">
	
			$('#logout').click(function(){

				var logged_user_id = $('#logged_user_id').val();

					this.save = $.ajax({
			            type: 'post',
			            url: "<?php echo site_url(); ?>checout/remove_logout",
			            data: {logged_user_id:logged_user_id}
			        }).done(function(msg){
			            
			            redirect_url = "<?php echo base_url(); ?>checkout/login" ;				
						window.location.replace(redirect_url);
			        });
				return false;
			});
		</script>
	</body>
	
</html>