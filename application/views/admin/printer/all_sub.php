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
	            		<tr data-page-row="<?php echo $page->id;?>">
	            			<td><?php echo $row_count; ?></td>
	            			<td><?php echo $page->printer_name; ?></td>
	            			<td>
	            				<?php echo anchor("admin/printer_list/entry/{$page->id}", "<i class='icon-edit '></i> Update", array('class' => 'btn btn-mini printer_icon')); ?>
    							<?php echo anchor("admin/printer_list/delete/{$page->id}", "<i class='icon-trash '></i> Delete", array('class' => 'printer_icon btn btn-mini btn-delete', 'data-page-id' => $page->id)); ?>
    							<?php echo anchor("admin/printer_list/duplicate/{$page->id}", "<i class='icon-repeat '></i> Duplicate", array('class' => 'printer_icon btn btn-mini duplicate-page')); ?>
    							<input placeholder="Sort Order" type="text" class="input-mini sort-order-printer" style="width:80px;" name="sort_order" id="page-sort-order" value="<?php echo $page->sort_order; ?>" data-page-id="<?php echo $page->id; ?>"><span class="add-on"></span>
                                
	            			</td>
	            		</tr>
	            	<?php $row_count++; ?>
	            	<?php endforeach; ?>
	            </tbody>
	    	</table>
	    </div>
	</div>
	<script type="text/javascript">
		$('.sort-order-printer').blur(function(){
	        var objectRef = $(this);
	        var pageId = $(this).attr('data-page-id');
	        var sortOrder = $(this).val();
	        $.ajax({
	            type: 'post',
	            url: "<?php echo site_url(); ?>admin/printer/update_sort_order",
	            data: {page_id: pageId, sort_order: sortOrder}
	        }).done(function(msg){
	            objectRef.next('.add-on').html('<i class="icon-ok"></i>')
	        })
	    })
	</script>
<?php $this->load->view('admin/printer/js/entry_v_js.php'); ?>
<?php $this->load->view('admin/footer_v.php'); ?>