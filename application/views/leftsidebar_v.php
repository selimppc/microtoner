<div id="body_container_left">
	<div class="left_shadow">&nbsp;</div>
	<div class="mobile_menu">
		<img src="<?php echo base_url(); ?>/images/menu.png">
	</div>
	<div id="cssmenu">
		<ul>
			<?php 
				$left_menu_q = $this->common_m->sub_menu(558);						
			?>
			<?php foreach($left_menu_q->result() as $left_menu): ?>
				<li>
					<a href="#"><?php echo $left_menu->title; ?></a>
					<ul>
						<?php
							$i = 0;
							 $home_sub_product_q = $this->common_m->sub_menu($left_menu->page_id);
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
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div><!--end of body container left-->	
<script type="text/javascript">
	$('.mobile_menu').click(function(){
		// $('#cssmenu').css({'display':'block'})
		$("#cssmenu").toggle();
	});
</script>				