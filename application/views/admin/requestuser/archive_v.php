<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<br/><br/>
<div class="row-fluid">
	<div class="span2">
		<br/>
        <?php $this->load->view('admin/requestuser/sidebar_nav_v.php'); ?>
    </div>
    <div class="span10">
    	<h2>List of Archive Order</h2>
    	<div class="delete-msg"></div>
    	<table class="table">
    		<caption></caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice Id</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            	
            	<?php foreach ($page_q->result() as $page): ?>
            		<tr data-page-row="<?php echo $page->user_id; ?>">
            			<td><?php echo $page->user_id; ?></td>
            			<td>
	            			<?php

	            				$invoice_info_request =     
				                    "SELECT *
				                    FROM  product_request
				                    WHERE user_id = {$page->user_id} LIMIT 1";
				                $invoice_info_request = $this->db->query($invoice_info_request);

				                foreach($invoice_info_request->result() as $invoice_info):
				            		echo $invoice_info->invoice_id;
				               	endforeach;
	            			?>
            			</td>
            			<td>
	            			<?php

	            				$customer_info_request =     
				                    "SELECT *
				                    FROM  guest_user
				                    WHERE id = {$page->user_id}";
				                $customer_info_r = $this->db->query($customer_info_request);

				                foreach($customer_info_r->result() as $customer_info):
				            ?>
				        	<a href="mailto:<?php echo $customer_info->billing_email; ?>"><img src="<?php echo base_url(); ?>/images/email.png" alt="Email" title="Email To <?php echo $customer_info->billing_email; ?>"  border="0"></a>
				        	<?php
				        		echo $customer_info->billing_firstname . ' '.$customer_info->billing_lastname ;
				        	?>
				        	<?php
				               	endforeach;
	            			?>
            			</td>
            			<td>
	            			<?php echo $customer_info->time ?>
            			</td>
            			<td>
            				<a class="btn btn-primary" href="" data-toggle="modal" data-target="#myModal<?php echo $page->user_id; ?>">Details</a>
		            			<div style="width: 60%;left: 40%;" class="modal fade" id="myModal<?php echo $page->user_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
									    <div class="modal-content">
									      
									        <button style="margin-top: 5px;float: right;margin-right: 5px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        
									      
									      <div class="modal-body">
									        <table class="table">
									        	<thead>
									        		<tr>
									        			<th>Product Name</th>
									        			<th>Quantity</th>
									        			<th>Price</th>
									        		</tr>
									        	</thead>
									        	<tbody>

									        		<?php

									        			$total_quantity = 0;
									        			$total_price = 0;
							            				$product_request =     
										                    "SELECT *
										                    FROM page
										                    INNER JOIN product_request
										                    ON product_request.product_id = page.id
										                    WHERE product_request.user_id = {$page->user_id} && product_request.status=3";
										                $product_data_r = $this->db->query($product_request);

										                foreach($product_data_r->result() as $product_data):
										            ?>
										        		<tr >
										        			<td>
										        				<?php echo $product_data->title; ?>
										        			</td>
										        			<td>
										        				<?php echo $product_data->product_quantity;
										        					$total_quantity +=$product_data->product_quantity;
										        				?>
										        			</td>
										        			<td>
										        				<?php echo $product_data->product_price * $product_data->product_quantity; 
										        				$total_price +=$product_data->product_price * $product_data->product_quantity;
										        				?>
										        			</td>
										        		</tr>
										        	<?php
										                	
										               	endforeach;
							            			?>
									        		
							            			<tr>
							            				<td style="text-align:right;">Total</td>
							            				<td><?php echo $total_quantity; ?></td>
							            				<td><?php echo $total_price; ?></td>
							            			</tr>
									        	</tbody>
									        </table>

									        <table>
									        	<thead>
									        		<tr>
									        			<th>
										        			Billing Information
										        		</th>
										        		<th>&nbsp;</th>
										        		<th>
										        			Shipping Information
										        		</th>
									        		</tr>	
									        	</thead>
									        	<tbody>
									        		<tr>
									        			<td>
									        				<?php
									        					$user_request =     
												                    "SELECT *
												                    FROM guest_user	       
												                    WHERE id = {$page->user_id}";
												                $user_data_r = $this->db->query($user_request);

									        					foreach($user_data_r->result() as $user_data){
									        						echo 'Email : '.$user_data->billing_email;
									        						echo '<br/>';
									        						echo 'Name : '.$user_data->billing_firstname. ' '.$user_data->billing_lastname;
									        						echo '<br/>';
									        						echo 'Address : '.$user_data->billing_address;
									        						echo '<br/>';
									        						echo 'SubURB : '.$user_data->billing_suburb;
									        						echo '<br/>';
									        						echo 'State : '.$user_data->billing_state;
									        						echo '<br/>';
									        						echo 'Post Code : '.$user_data->billing_postcode;									        			
echo '<br/>';	
									        						echo 'Company Name : '.$user_data->billing_company_name;			
									        						echo '<br/>';									        						
									        						echo 'Telephone : '.$user_data->billing_telephone;
									        						echo '<br/>';	
									        						echo 'Country : '.$user_data->billing_country;
									        					}
									        				?>
									        			</td>
									        			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									        			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									        			<td>
									        				<?php
									        					$user_request =     
												                    "SELECT *
												                    FROM guest_user	       
												                    WHERE id = {$page->user_id}";
												                $user_data_r = $this->db->query($user_request);

									        					foreach($user_data_r->result() as $user_data){
									        						
									        						if(!empty($user_data->shipping_firstname)):	
										        						echo 'Name : '.$user_data->shipping_firstname. ' '.$user_data->shipping_lastname;
										        						echo '<br/>';
										        						echo 'Address : '.$user_data->shipping_address;
										        						echo '<br/>';
										        						echo 'Suburb : '.$user_data->shipping_suburb;
										        						echo '<br/>';
										        						echo 'State : '.$user_data->shipping__state;
										        						echo '<br/>';
										        						echo 'Post Code : '.$user_data->shipping_postcode;
			
echo '<br/>';
										        						echo 'Company Name : '.$user_data->shipping_company_name;							        						echo '<br/>';
										        						echo 'Country : '.$user_data->shipping_coubntry;
										        					endif;
									        					}
									        				?>
									        			</td>
									        		</tr>
									        	</tbody>
									        </table>
									      </div>
									      
									    </div>
									  </div>
									</div>
            				<!-- <a data-page-id="<?php //echo $page->user_id; ?>" class="btn btn-primary archieve_request" href="">Archieve</a>
            				<a data-page-id="<?php //echo $page->user_id; ?>" class="btn btn-primary order_delete_request" href="">Delete</a> -->
            			</td>
            		</tr>
            	
            	<?php endforeach;?>
            </tbody>
    	</table>
    </div>
</div>
<?php $this->load->view('admin/requestuser/js/all_v_js.php') ?>
<?php $this->load->view('admin/footer_v.php'); ?>