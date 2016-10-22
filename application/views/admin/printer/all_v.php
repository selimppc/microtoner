<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>
	
	<div class="row-fluid">
		<div class="span2">
	        <?php $this->load->view('admin/printer/sidebar_nav_v.php'); ?>
	    </div>
	    <div class="span10">
	    	<h2>List of Printer</h2>
	    	<div class="delete-msg"></div>
	    	<table class="table">
	    		<caption></caption>
	    		<thead>
	                <tr>
	                    <th>#</th>
	                    <th>Printer Name</th>
	                    <th>Actions</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php $row_count = 1; ?>
	            	<?php foreach ($page_q->result() as $page): ?>
	            		<tr data-page-row="">
	            			<td><?php echo $row_count; ?></td>
	            			<td><?php echo $page->parent_printer; ?> ( 
	            				<?php
	            					$page_sql =     
						                 "SELECT * 
						                 FROM printer where parent_printer = '$page->parent_printer'";
	            					$page_count = $this->db->query($page_sql);
	            					echo $page_count->num_rows();
	            				?>
	            			 )</td>
	            			<td>
	            				<?php echo anchor("admin/printer_list/more/{$page->parent_printer}", "<i class='icon-edit'></i> More", array('class' => 'btn btn-mini')); ?>
	            				<?php //echo anchor("admin/printer_list/entry/{$page->id}", "<i class='icon-edit'></i> Update", array('class' => 'btn btn-mini')); ?>
    							<?php //echo anchor("admin/printer_list/delete/{$page->id}", "<i class='icon-trash'></i> Delete", array('class' => 'btn btn-mini btn-delete', 'data-page-id' => $page->id)); ?>
	            			</td>
	            		</tr>
	            	<?php $row_count++; ?>
	            	<?php endforeach; ?>
	            </tbody>
	    	</table>
	    </div>
	</div>
<?php $this->load->view('admin/printer/js/entry_v_js.php'); ?>
<?php $this->load->view('admin/footer_v.php'); ?>