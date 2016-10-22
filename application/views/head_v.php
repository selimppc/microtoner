<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php
				if(!empty($page_data->title)){

					if(!empty($page_data->meta_title)){
						echo $page_data->meta_title;
					}else{
					   echo $page_data->title;
					}
					
				}else if(!empty($page_data->printer_name)){

					if(!empty($page_data->meta_title)){
						echo $page_data->meta_title;
					}else{
						echo $page_data->printer_name;
					}

				}else{
					echo 'Micro Toner Supplies';
				}
			?>
		</title>
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="<?php if(!empty($page_data->manufacter)){ echo $page_data->manufacter;  } ?>">
		<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>styles/styles.css">

		<link rel="canonical" href="<?php echo base_url(); ?>" />
		<link rel="publisher" href="https://plus.google.com/101428502724401207551/posts"/>

		<script src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js" type="text/javascript"></script> 
  		<script src="<?php echo base_url(); ?>js/jquery.hashchange.min.js" type="text/javascript"></script>
  		<script src="<?php echo base_url(); ?>js/jquery.easytabs.min.js" type="text/javascript"></script>
  		
                <!--[if lt IE 9]>
		 <script src="<?php echo base_url(); ?>js/html5shiv.js" type="text/javascript"></script>
		 <script src="<?php echo base_url(); ?>js/respond.min.js" type="text/javascript"></script>
		<![endif]-->

		<script type="text/javascript">
		    $(document).ready( function() {		    	
		      $('#tab-container').easytabs();
		    });
		</script>
                
	</head>