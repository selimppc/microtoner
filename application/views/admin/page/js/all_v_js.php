<script type="text/javascript">
    // create Page class definition
    function Page(page_id) {
        // define delete functionality
        this.delete = $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/page/delete",
            data: {page_id: page_id}
        }).done(function(msg){
            // get and parse ajax response
            this.reply = jQuery.parseJSON(msg);
            // show delete message
            $('.delete-msg').html(this.reply.message);
            setTimeout(function() {$('.delete-msg').html('');}, 1000);
            // remove deleted item from dom
            $('tr[data-page-row="'+this.reply.deleted_page_id+'"]').hide();
        });
    }

    // what delete button will do?
    $(".btn-delete").click(function(){
        // get page id, to be delete
        var page_id = $(this).attr('data-page-id');
        // show bootbox confirmation
        var confirmation = bootbox.confirm('Are you sure, you want to delete that item?', function(result){
            // is confirmed?
            if(result) {
                // yes, then delete
                // create a new instance of Page class
                var page = new Page(page_id);
                // delete
                page.delete;
            }
        });
        // prevent default functionality
        return false;
    })
</script>