<?php 
				
	$home_page_product = $this->common_m->sub_menu(558);						
    foreach($home_page_product->result() as $home_product): 
	
		$primry_photo_r = $this->common_m->get_primary_photo($home_product->page_id);						
	
		$base_url = base_url(); 
		$path = 'uploads/test_img/'.$primry_photo_r->photo_file_name;

		$image_url = $base_url.$path;
?>
<img src='<?php echo $image_url; ?>'>

<?php endforeach;?>