<script type="text/javascript">
    $(function(){
        $('#myTab a:first').tab('show');
    })
    
</script>

<?php if (!empty($gallery_data)): ?>

    <script type="text/javascript">

        $(function() {
            // what file upload button will do?
            $('#file_upload').uploadify({
                'swf'      : '<?php echo base_url(); ?>uploadify/uploadify.swf',
                'uploader' : '<?php echo base_url(); ?>uploadify/uploadify.php',
                'onUploadSuccess' : function(file, data, response) {
                        
                    var reply = jQuery.parseJSON(data);
                    //alert(reply.unique_name);
                    //alert(reply.file_extension);
                    var fileName = reply.unique_name + reply.file_extension;
                    var imgSrc = reply.unique_name + '_thumb' + reply.file_extension;

                    $.ajax({
                        type: 'post',
                        url: "<?php echo site_url(); ?>admin/gallery/save_photo",
                        data: {gallery_id: "<?php echo $gallery_data->id ?>", file_name: fileName, raw_name: reply.unique_name, file_ext: reply.file_extension}
                    }).done(function(msg){
                        var photoReply = jQuery.parseJSON(msg);
                        photoReply.last_insert_id = photoReply.last_insert_id;
                        var img = "<div class='gallery-photo' data-gallery-photo-id='"+photoReply.last_insert_id+"'><a href='#'><img src='<?php echo base_url(); ?>uploads/gallery_photos/"+imgSrc+"'></a><span class='delete-photo-link' data-gallery-photo-id='"+photoReply.last_insert_id+"'>Delete</span></div>";

                        $('.gallery-photos').prepend(img);
                    })
                        
                },
                'onUploadComplete': function(file) {
                    //alert('The file ' + file.name + ' finished processing.');
                }
            });
        });

        // what delete photo button will do?
        $('.delete-photo-link').live('click', function(){
            var id = $(this).attr('data-gallery-photo-id');
            bootbox.confirm("Are you sure, you want to delete that photo?", function(result){
                if(result) {

                    $.ajax({
                        type: 'post',
                        url: "<?php echo site_url(); ?>admin/gallery/delete_photo",
                        data: {photo_id: id}
                    }).done(function(msg) {
                        $('div[data-gallery-photo-id="'+id+'"]').hide();
                    })
                }
            })
                    
        })
    </script>
<?php endif; ?>

<script type="text/javascript">
    // create Gallery class definition
    function Gallery() {
        // get gallery id for edit
        this.id = parseInt($('#gallery_id').val());
        // get gallery title
        this.title = $('#gallery_title').val();
        // get gallery description
        this.description = $('#gallery_description').val();

        // define save functionality
        this.save = $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/gallery/save",
            data: {gallery_id: this.id, gallery_title: this.title, gallery_description: this.description}
        }).done(function(msg){
            // get and parse json
            this.reply = jQuery.parseJSON(msg);
            $('.validation-msg').html(this.reply.msg);
            setTimeout(function() {$('.validation-msg').html('');}, 1000);
        })
    }

    // what save gallery button will do
    $("#save_gallery").click(function(){
        // create a new instance of Gallery class
        var gallery = new Gallery();
        // save gallery
        gallery.save;
        // prevent default button behavior
        return false;
    });

    // what reset button will do
    $('#reset').click(function(){
        // hide validation message
        $('.validation-msg').html('');
    })

    // what select parent page will do?
    $('#set-page-gallery-rel').change(function(){
        // get current gallery id
        var currentGalleryId = parseInt( $('#set-page-gallery-rel option:selected').attr('data-current-gallery-id'));
        // get parent page id
        var parentPageId = parseInt($(this).val());
        // get parent page text, to show parent page label
        // var parentPageText = $(this).find('option:selected').text();
        var parentPageText = $('#set-page-gallery-rel option:selected').attr('data-page-label');
        
        $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/gallery/set_page_gallery_rel",
            data: {current_gallery_id: currentGalleryId, parent_page_id: parentPageId, parent_is: 'page'}
        }).done(function(msg){
            // get and parse ajax response
            this.reply = jQuery.parseJSON(msg);
            // show message
            $('.validation-msg').html(this.reply.message);
            // is created?
            if(this.reply.new_rel_created == 1) {
                // create new parent page label
                var newParentPageLabel = "<span class='label label-info parent-page-label' data-current-gallery-id='"+currentGalleryId+"' data-parent-page-id='"+parentPageId+"'>"+parentPageText+"<i class='icon-remove-sign icon-white'></i></span>&nbsp;";
                // appen parent page into dom
                $('.parent-pages').append(newParentPageLabel);
            }
        })
    })

    // what parent page label wil do
    $('.parent-page-label').live('click', function(){
        // get a reference of this page label
        var targetParent = $(this);
        // get current gallery id
        var currentGalleryId = $(this).attr('data-current-gallery-id');
        // get parent page id
        var parentPageId = $(this).attr('data-parent-page-id');

        // show bootbox confirmation
        bootbox.confirm("Are you sure, you want to remove that relation?", function(result) {
            // sure?
            if(result) {
                // yes, then break relation
                $.ajax({
                    type: 'post',
                    url: "<?php echo site_url(); ?>admin/gallery/remove_page_rel",
                    data: {current_gallery_id: currentGalleryId, parent_page_id: parentPageId}
                }).done(function(msg){
                    // get and parse ajax response
                    this.reply = jQuery.parseJSON(msg);
                    // hide just removed parent page label
                    targetParent.hide();
                    // show message
                    $('.validation-msg').html(this.reply.message);  
                })
            } 
        })
    })
</script>