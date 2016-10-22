<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<br/><br/>
<div class="row-fluid">
	<div class="span2">
		<br/>
        <?php $this->load->view('admin/requestuser/sidebar_nav_v.php'); ?>
    </div>
    <div class="span10">
    	<h2>List of Current Order & Shipped Order</h2>
    	<div class="delete-msg"></div>
    	<div class="control-group">
            <form action="<?php echo base_url(); ?>admin/requestuser/show_excel_result" method="post" >  
                <div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="float: left;margin-right: 20px;" >
                    <input size="16" type="text" name="start_date" value="" readonly placeholder="Start Date">
                   
					<span class="add-on"><i class="icon-th"></i></span>
                </div>
                <div class="controls input-append date out_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="float: left;margin-right: 20px;">
                    <input size="16" name="end_date" type="text" value="" readonly placeholder="end Date">
                   
					<span class="add-on"><i class="icon-th"></i></span>
                </div>

                <select name="order_method" style="margin-right:20px;float:left;">
                	<option value="0">On Order</option>
                	<option value="1">Shipped</option>
                	<option value="2">Paypal Pending</option>
                	<option value="3">All</option>
                </select>

                <input type="submit" name="g_excel" class="btn btn-primary" value="Generate Excel"> 
				<!-- <input type="hidden" id="dtp_input2" value="" /><br/> -->
        	</form>
        </div>

        <?php

        	if(isset($_POST['g_excel']) == 'Generate Excel'){
        		error_reporting(E_ALL);
				ini_set('display_errors', TRUE);
				ini_set('display_startup_errors', TRUE);
				date_default_timezone_set('Europe/London');

				define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

				/** Include PHPExcel */
				require_once dirname(__FILE__) . '/phpexcel/PHPExcel.php';

				// Create new PHPExcel object
				//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
				$objPHPExcel = new PHPExcel();

				// Set document properties
				//echo date('H:i:s') , " Set document properties" , EOL;
				$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
											 ->setLastModifiedBy("Maarten Balliauw")
											 ->setTitle("PHPExcel Test Document")
											 ->setSubject("PHPExcel Test Document")
											 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
											 ->setKeywords("office PHPExcel php")
											 ->setCategory("Test result file");


				// Add some data
				//echo date('H:i:s') , " Add some data" , EOL;
				$objPHPExcel->setActiveSheetIndex(0)
				            ->setCellValue('A1', 'Invoice Id')
				            ->setCellValue('B1', 'Order Date')
				            ->setCellValue('C1', 'Product Name')
				            ->setCellValue('D1', 'Product Quantity')
				            ->setCellValue('E1', 'Product Price')
				            ->setCellValue('F1', 'Email')
				            ->setCellValue('G1', 'First Name')
				            ->setCellValue('H1', 'Last Name')
				            ->setCellValue('I1', 'Address')
				            ->setCellValue('K1', 'Post Code')
				            ->setCellValue('L1', 'SubUrb')
				            ->setCellValue('M1', 'State')
				            ->setCellValue('N1', 'Country')
				            ->setCellValue('O1', 'Telephone');

				$start_date = $_POST['start_date'];
				$end_date = $_POST['end_date'];
				$order_method = $_POST['order_method'];

				if($order_method == 3){

					$page_sql =     
		            	"SELECT * FROM product_request
		            	INNER JOIN page on page.id = product_request.product_id
		            	WHERE product_request.current_date BETWEEN '$start_date' AND '$end_date'  ";

				}else{
					$page_sql =     
		            	"SELECT * FROM product_request
		            	INNER JOIN page on page.id = product_request.product_id
		            	WHERE product_request.current_date BETWEEN '$start_date' AND '$end_date' && status ='$order_method' ";
				}
				

		        // set data for view file
		        $all_order_data_r = $this->db->query($page_sql);
		        $count = 3;
		        foreach($all_order_data_r->result() as $all_order_data):
		        	$objPHPExcel->setActiveSheetIndex(0)
				            ->setCellValue('A'.$count, $all_order_data->invoice_id)
				            ->setCellValue('B'.$count, $all_order_data->current_date)
				            ->setCellValue('C'.$count, $all_order_data->title)
				            ->setCellValue('D'.$count, $all_order_data->product_quantity)
				            ->setCellValue('E'.$count, $all_order_data->price);

				           $user_sql =     
					            "SELECT * FROM guest_user WHERE id='$all_order_data->user_id'   ";

					        // set data for view file
					        $all_user_data_r = $this->db->query($user_sql);

					        foreach($all_user_data_r->result() as $all_user_data):
					        	$objPHPExcel->setActiveSheetIndex(0)
						            ->setCellValue('F'.$count, $all_user_data->billing_email)
						            ->setCellValue('G'.$count, $all_user_data->billing_firstname)
						            ->setCellValue('H'.$count, $all_user_data->billing_lastname)
						            ->setCellValue('I'.$count, $all_user_data->billing_address)
						            ->setCellValue('K'.$count, $all_user_data->billing_postcode)
						            ->setCellValue('L'.$count, $all_user_data->billing_suburb)
						            ->setCellValue('M'.$count, $all_user_data->billing_state)
						            ->setCellValue('N'.$count, $all_user_data->billing_country)
						            ->setCellValue('O'.$count, $all_user_data->billing_telephone);
						            
					        endforeach;
		        	$count++;
		        endforeach;

				  //echo date('H:i:s') , " Rename worksheet" , EOL;
				$objPHPExcel->getActiveSheet()->setTitle('Simple');


				// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);


				// Save Excel 2007 file
				///echo date('H:i:s') , " Write to Excel2007 format" , EOL;
				$callStartTime = microtime(true);

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
				$callEndTime = microtime(true);
				$callTime = $callEndTime - $callStartTime;

				//echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
				//echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
				// Echo memory usage
				//echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


				// Save Excel 95 file
				//echo date('H:i:s') , " Write to Excel5 format" , EOL;
				$callStartTime = microtime(true);

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save(str_replace('.php', '.xls', __FILE__));
				$callEndTime = microtime(true);
				$callTime = $callEndTime - $callStartTime;

				$old_path = "./application/views/admin/requestuser/generate_excel.xlsx";
				$new_path = "./excel/generate_excel.xlsx";
				copy($old_path, $new_path); 
				
				echo '<br /><br />';
				echo '<a href="'.base_url().'excel/generate_excel.xlsx">
					Please download this excel file
				</a>';
        	}

        	// copy('generate_excel.xls', '../generate_excel.xls');
        ?>
    	
    </div>
</div>
<?php $this->load->view('admin/requestuser/js/all_v_js.php') ?>
<?php $this->load->view('admin/footer_v.php'); ?>