<script type="text/javascript">
    $(function(){
        $('#myTab a:first').tab('show');
    })
    
</script>

<?php if (!empty($page_data)): ?>
        <script type="text/javascript">
            
            $(function () {

            $('#file_upload').fileupload({
                dataType: 'json',
                done: function (e, data) {
                    
                        $.each(data.result.files, function (index, file) {  
                        var fileName = file.name;
                        var file_ext = file.type; 
                        var page_id = $('#page_id').val();
                                     
                        
                        this.postData ={page_id: page_id,file_name: fileName,file_ext: file_ext}
                        $.ajax({
                            type: 'post',
                            url: siteUrl + 'admin/printer_list/save_photo',
                            data: this.postData
                        }).done(function(msg){
                             
                            this.reply = jQuery.parseJSON(msg);

                           var img = "<div class='gallery-photo' data-page-photo-id='"+this.reply.last_insert_id+"'><img src='"+siteUrl+"/server/php/files/thumbnail/"+fileName+"'></a><span class='delete-photo-link' data-file-name='"+fileName+"' data-page-photo-id='"+this.reply.last_insert_id+"'>Delete</span><div class='photo-settings'><p><input type='text' name='pri_short_title' placeholder='Short Title' class='pri_short_title' value='' data-page-photo-id='"+this.reply.last_insert_id+"' data-page-id='"+page_id+"'></p><p><input type='text' name='pri_short_description' class='pri_short_description' placeholder='Short Description' value='' data-page-photo-id='"+this.reply.last_insert_id+"' data-page-id='"+page_id+"'></p></div></div>";

                           $('.page-photos').prepend(img);
                        })

                    });

                                
                    
                }, progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                    'width',
                    progress + '%'
                );

                setTimeout(function() {$('#progress').html('');}, 4000);
            }
                          
            });
        });

    // what delete photo button will do?
            $('.delete-photo-link').live('click', function(){
                var id = $(this).attr('data-page-photo-id');
                bootbox.confirm("Are you sure, you want to delete that photo?", function(result){
                    if(result) {

                        $.ajax({
                            type: 'post',
                            url: "<?php echo site_url(); ?>admin/printer_list/delete_photo",
                            data: {photo_id: id}
                        }).done(function(msg) {
                            $('div[data-page-photo-id="'+id+'"]').hide();
                        })
                    }
                })
                
            })


        // make photo as pri_short_title
        $('.pri_short_title').live('blur', function(){
            var objectRef = $(this);
            
            var pri_sort_title = $(this).val();

            var photoId = $(this).attr('data-page-photo-id');
            var pageId = $(this).attr('data-page-id');

            
            
            objectRef.next('span').addClass('muted');
            $.ajax({
                type: 'post', 
                url: "<?php echo site_url(); ?>admin/printer_list/set_pri_sort_title",
                data: {photo_id: photoId, page_id: pageId, pri_sort_title: pri_sort_title}
            }).done(function(msg){
                objectRef.next('span').removeClass('muted');
            })
        })


         // make photo as pri_short_description
        $('.pri_short_description').live('blur', function(){
            var objectRef = $(this);
            
            var pri_sort_description = $(this).val();


        
            var photoId = $(this).attr('data-page-photo-id');
            var pageId = $(this).attr('data-page-id');

            
            
            objectRef.next('span').addClass('muted');
            $.ajax({
                type: 'post', 
                url: "<?php echo site_url(); ?>admin/printer_list/pri_sort_description",
                data: {photo_id: photoId, page_id: pageId, pri_sort_description: pri_sort_description}
            }).done(function(msg){
                objectRef.next('span').removeClass('muted');
            })
        })

    </script>

<?php endif; ?>

<script type="text/javascript">



    // Page class definition
    function Page() {
        
        // get page id (for edit case)
        this.id = parseInt($('#page_id').val());

        if($('#is-published').is(":checked")) {
            this.is_published = 0;
        } else {
            this.is_published = 1;
        }

        // get page title
        this.printer_name = $('#printer_name').val();

        // get page slug
        this.printer_slug = $('#printer_slug').val();

        // get meta_title
        this.meta_title = $('#meta_title').val();

        // get alternative_name1
        this.alternative_name1 = $('#alternative_name1').val();

        // get alternative_name2
        this.alternative_name2 = $('#alternative_name2').val();

        // get alternative_name3
        this.alternative_name3 = $('#alternative_name3').val();

        // get additionaltype
        this.additionaltype = $('#additionaltype').val();

        // get parent printer

        this.parent_printer = $('#parent_printer').val();

        // get page description
        this.printer_description = $('#printer_description').val();

        
        this.resetValidationMsg = $('.validation-msg').html('');

        // define save functionality
        this.save = $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/printer/save",
            data: {is_published:this.is_published,meta_title:this.meta_title,additionaltype:this.additionaltype,alternative_name3:this.alternative_name3,alternative_name2:this.alternative_name2,alternative_name1:this.alternative_name1,parent_printer:this.parent_printer,page_id:this.id,printer_name:this.printer_name,printer_description:this.printer_description,printer_slug:this.printer_slug}
        }).done(function(msg){
            // receive and parse ajax response
            this.reply = jQuery.parseJSON(msg);
            // show message
            $('.validation-msg').html(this.reply.msg);
            setTimeout(function() {$('.validation-msg').html('');}, 10000);
        });
    }

    // what save button will do?
    $("#save_page").click(function(){
        
            // create instance of a new page
        var page = new Page(0);
       

        // save this page
        page.save;
        // prevent default button behavior
        return false;
    });

    // what delete button will do?
    $(".btn-delete").click(function(){
        // get page id, to be delete
        var page_id = $(this).attr('data-page-id');
        // show bootbox confirmation
        var confirmation = bootbox.confirm('Are you sure, you want to delete that item?', function(result){
            // is confirmed?
            if(result) {
                // define delete functionality
		        this.delete = $.ajax({
		            type: 'post',
		            url: "<?php echo site_url(); ?>admin/printer/delete",
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
        });
        // prevent default functionality
        return false;
    })


</script>