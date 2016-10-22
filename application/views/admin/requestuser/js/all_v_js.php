<script type="text/javascript">

	$(".shipped_request").click(function(){
        // get page id, to be delete
        var page_id = $(this).attr('data-page-id');
        // show bootbox confirmation
        var confirmation = bootbox.confirm('Are you sure, you want to shipped that item?', function(result){
            // is confirmed?
            if(result) {
                
                this.delete = $.ajax({
		            type: 'post',
		            url: "<?php echo site_url(); ?>admin/requestuser/shipped",
		            data: {page_id: page_id}
		        }).done(function(msg){
		            // get and parse ajax response
		            this.reply = jQuery.parseJSON(msg);
		            // show delete message
		            $('.delete-msg').html(this.reply.message);
		            setTimeout(function() {$('.delete-msg').html('');}, 1000);
		            // remove deleted item from dom
		            $('tr[data-page-row="'+page_id+'"]').hide();
		        });

            }
        });
        // prevent default functionality
        return false;
    })

	$(".archive_request").click(function(){
        // get page id, to be delete
        var page_id = $(this).attr('data-page-id');
        // show bootbox confirmation
        var confirmation = bootbox.confirm('Are you sure, you want to archieve that item?', function(result){
            // is confirmed?
            if(result) {
                
                this.delete = $.ajax({
		            type: 'post',
		            url: "<?php echo site_url(); ?>admin/requestuser/archieve_request",
		            data: {page_id: page_id}
		        }).done(function(msg){
		            // get and parse ajax response
		            this.reply = jQuery.parseJSON(msg);
		            // show delete message
		            $('.delete-msg').html(this.reply.message);
		            setTimeout(function() {$('.delete-msg').html('');}, 1000);
		            // remove deleted item from dom
		            $('tr[data-page-row="'+page_id+'"]').hide();
		        });

            }
        });
        // prevent default functionality
        return false;
    })

	$(".order_delete_request").click(function(){
        // get page id, to be delete
        var page_id = $(this).attr('data-page-id');
        // show bootbox confirmation
        var confirmation = bootbox.confirm('Are you sure, you want to delete that item?', function(result){
            // is confirmed?
            if(result) {
                
                this.delete = $.ajax({
		            type: 'post',
		            url: "<?php echo site_url(); ?>admin/requestuser/order_delete_request",
		            data: {page_id: page_id}
		        }).done(function(msg){
		            // get and parse ajax response
		            this.reply = jQuery.parseJSON(msg);
		            // show delete message
		            $('.delete-msg').html(this.reply.message);
		            setTimeout(function() {$('.delete-msg').html('');}, 1000);
		            // remove deleted item from dom
		            $('tr[data-page-row="'+page_id+'"]').hide();
		        });

            }
        });
        // prevent default functionality
        return false;
    })

</script>