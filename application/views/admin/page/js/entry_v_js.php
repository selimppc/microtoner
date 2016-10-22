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
                    url: siteUrl + 'admin/page/save_photo',
                    data: this.postData
                }).done(function(msg){
                     
                    this.reply = jQuery.parseJSON(msg);

                    var img = "<div class='gallery-photo' data-page-photo-id='"+this.reply.last_insert_id+"'><img src='"+siteUrl+"/server/php/files/thumbnail/"+fileName+"'></a><span class='delete-photo-link' data-file-name='"+fileName+"' data-page-photo-id='"+this.reply.last_insert_id+"'>Delete</span><div class='photo-settings'><p><input type='text' name='pri_date' placeholder='Date' class='pri_date' value='' data-page-photo-id='"+this.reply.last_insert_id+"' data-page-id='"+page_id+"'></p><p><input type='text' name='pri_sort_title' placeholder='Sort Title' class='pri_sort_title' value='' data-page-photo-id='"+this.reply.last_insert_id+"' data-page-id='"+page_id+"'></p><p><input type='text' name='pri_sort_description' class='pri_sort_description' placeholder='Sort Description' value='' data-page-photo-id='"+this.reply.last_insert_id+"' data-page-id='"+page_id+"'></p><p><label class='checkbox'><input type='checkbox' name='is_primary_photo' class='is_primary_photo' value='1' data-page-photo-id='"+this.reply.last_insert_id+"' data-page-id='"+page_id+"'> <span>Is primary photo?</span></label></p><p><label class='checkbox'><input type='checkbox' name='is_banner_photo' class='is_banner_photo' value='1' data-page-photo-id='"+this.reply.last_insert_id+"' data-page-id='"+page_id+"'> <span>Is banner photo?</span></label></p><p><label class='checkbox'><input type='checkbox' name='is_logo' class='is_logo' value='1' data-page-photo-id='"+this.reply.last_insert_id+"' data-page-id='"+page_id+"'> <span>Is logo?</span></label></p></div></div>";

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
</script>

    <script type="text/javascript">

        // $(function() {
        //     // what file upload button will do?
        //     $('#file_upload').uploadify({
        //         'swf'      : '<?php echo base_url(); ?>uploadify/uploadify.swf',
        //         'uploader' : '<?php echo base_url(); ?>uploadify/uploadify2.php',
        //         'onUploadSuccess' : function(file, data, response) {
                
        //             var reply = jQuery.parseJSON(data);
        //             //alert(reply.unique_name);
        //             //alert(reply.file_extension);
        //             var fileName = reply.unique_name + reply.file_extension;
        //             var imgSrc = reply.unique_name + '_thumb' + reply.file_extension;

        //             $.ajax({
        //                 type: 'post',
        //                 url: "<?php echo site_url(); ?>admin/page/save_photo",
        //                 data: {page_id: "<?php echo $page_data->id ?>", file_name: fileName, raw_name: reply.unique_name, file_ext: reply.file_extension}
        //             }).done(function(msg){
        //                 var photoReply = jQuery.parseJSON(msg);
        //                 //photoReply.last_insert_id = photoReply.last_insert_id;

        //                 //var img = "<div class='gallery-photo' data-page-photo-id='"+photoReply.last_insert_id+"'><a href='#'><img src='<?php echo base_url(); ?>uploads/primary_gallery_photos/"+imgSrc+"'></a><span class='delete-photo-link' data-page-photo-id='"+photoReply.last_insert_id+"'>Delete</span></div>";


        //                 var img = "<div class='gallery-photo' data-page-photo-id='"+photoReply.last_insert_id+"'><a href='#'><img src='<?php echo base_url(); ?>uploads/primary_gallery_photos/"+imgSrc+"'></a><span class='delete-photo-link' data-page-photo-id='"+photoReply.last_insert_id+"'>Delete</span><div class='photo-settings'><p><label class='checkbox'><input type='checkbox' name='is_primary_photo' class='is_primary_photo' value='1' data-page-photo-id='"+photoReply.last_insert_id+"' data-page-id='"+photoReply.page_id+"'> <span>Is primary photo?</span></label></p><p><label class='checkbox'><input type='checkbox' name='is_banner_photo' class='is_banner_photo' value='1' data-page-photo-id='"+photoReply.last_insert_id+"' data-page-id='"+photoReply.page_id+"'> <span>Is banner photo?</span></label></p></div></div>";

        //                 $('.page-photos').prepend(img);
        //             })
                
        //         },
        //         'onUploadComplete': function(file) {
        //             //alert('The file ' + file.name + ' finished processing.');
        //         }
        //     });
        // });

        // what delete photo button will do?
        $('.delete-photo-link').live('click', function(){
            var id = $(this).attr('data-page-photo-id');
            bootbox.confirm("Are you sure, you want to delete that photo?", function(result){
                if(result) {

                    $.ajax({
                        type: 'post',
                        url: "<?php echo site_url(); ?>admin/page/delete_photo",
                        data: {photo_id: id}
                    }).done(function(msg) {
                        $('div[data-page-photo-id="'+id+'"]').hide();
                    })
                }
            })
            
        })

        // make photo as banner photo
        $('.is_banner_photo').live('click', function(){
            var objectRef = $(this);
            var photoId = $(this).attr('data-page-photo-id');
            var pageId = $(this).attr('data-page-id');
            if($(this).is(':checked')) {
                var action = 'set';
            } else {
                var action = 'unset';
            }
            objectRef.next('span').addClass('muted');
            $.ajax({
                type: 'post', 
                url: "<?php echo site_url(); ?>admin/page/set_banner_photo",
                data: {photo_id: photoId, page_id: pageId, action: action}
            }).done(function(msg){
                objectRef.next('span').removeClass('muted');
            })
        })

        // make photo as primary photo
        $('.is_primary_photo').live('click', function(){
            var objectRef = $(this);
            $('.is_primary_photo').not(objectRef).removeAttr('checked')

        
            var photoId = $(this).attr('data-page-photo-id');
            var pageId = $(this).attr('data-page-id');
            if($(this).is(':checked')) {
                var action = 'set';
            } else {
                var action = 'unset';
            }
            objectRef.next('span').addClass('muted');
            $.ajax({
                type: 'post', 
                url: "<?php echo site_url(); ?>admin/page/set_primary_photo",
                data: {photo_id: photoId, page_id: pageId, action: action}
            }).done(function(msg){
                objectRef.next('span').removeClass('muted');
            })
        })


        // make photo as pri_sort_title
        $('.pri_sort_title').live('blur', function(){
            var objectRef = $(this);
            
            var pri_sort_title = $(this).val();


        
            var photoId = $(this).attr('data-page-photo-id');
            var pageId = $(this).attr('data-page-id');

            
            
            objectRef.next('span').addClass('muted');
            $.ajax({
                type: 'post', 
                url: "<?php echo site_url(); ?>admin/page/set_pri_sort_title",
                data: {photo_id: photoId, page_id: pageId, pri_sort_title: pri_sort_title}
            }).done(function(msg){
                objectRef.next('span').removeClass('muted');
            })
        })


         // make photo as pri_sort_title
        $('.pri_sort_description').live('blur', function(){
            var objectRef = $(this);
            
            var pri_sort_description = $(this).val();


        
            var photoId = $(this).attr('data-page-photo-id');
            var pageId = $(this).attr('data-page-id');

            
            
            objectRef.next('span').addClass('muted');
            $.ajax({
                type: 'post', 
                url: "<?php echo site_url(); ?>admin/page/pri_sort_description",
                data: {photo_id: photoId, page_id: pageId, pri_sort_description: pri_sort_description}
            }).done(function(msg){
                objectRef.next('span').removeClass('muted');
            })
        })


    </script>
<?php endif; ?>

<script type="text/javascript">

    // Page class definition
    function Page(createSegment) {
        // will we create a segment or page?
        this.createSegment = createSegment;

        if($('#is-home-page').is(":checked")) {
            this.isHomePage = 1;
        } else {
            this.isHomePage = 0;
        }

        if($('#is-published').is(":checked")) {
            this.is_published = 0;
        } else {
            this.is_published = 1;
        }

        if($('#is-show-in-printer-list').is(":checked")) {
            this.is_show_printer = 0;
        } else {
            this.is_show_printer = 1;
        }

        if($('#is-contact-page').is(":checked")) {
            this.isContactPage = 1;
        } else {
            this.isContactPage = 0;
        }

        if($('#is-service-page').is(":checked")) {
            this.isServicePage = 1;
        } else {
            this.isServicePage = 0;
        }

        if($('#is-project').is(":checked")) {
            this.isProject = 1;
        } else {
            this.isProject = 0;
        }

        if($('#is-featured-project').is(":checked")) {
            this.isFeaturedProject = 1;
        } else {
            this.isFeaturedProject = 0;
        }


        // get parent page id
        this.parentPageId = $('#parent_page').val() || 0;

        // get page id (for edit case)
        this.id = parseInt($('#page_id').val());
        // get page title
        this.title = $('#page_title').val();

        //get page slug
        this.page_slug = $('#page_slug').val();

        //get brand
        this.brand = $('#brand').val();

        //get product no
        this.product_no = $('#product_no').val();

        //get alternate_name1
        this.alternate_name1 = $('#alternate_name1').val();

        //get alternate_name2
        this.alternate_name2 = $('#alternate_name2').val();

        //get alternate_name3
        this.alternate_name3 = $('#alternate_name3').val();

        // get additionaltype
        this.additionaltype = $('#additionaltype').val();

        //get meta_title
        this.meta_title = $('#meta_title').val();

        //get meta_description
        this.meta_description = $('#meta_description').val();

        //get manufacter
        this.manufacter = $('#manufacter').val();

        //get price
        this.price = $('#price').val();

        // get short description
        this.short_description = $('#short_description').val();

        // get page description
        this.description = $('#page_description').val();

        // get printer description
        this.printer_description = $('#printer_description').val();

        // get printer_type
        this.printer_type = $('#printer_type').val();

        // get printer_technology
        this.printer_technology = $('#printer_technology').val();

        // get color
        this.color = $('#color').val();

        // get page_yield
        this.page_yield = $('#page_yield').val();

        // get condition
        this.condition = $('#condition').val();

        // get sku
        this.sku = $('#sku').val();

        // get condition

        this.resetValidationMsg = $('.validation-msg').html('');

        // define save functionality
        this.save = $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/page/save",
            data: {is_show_printer:this.is_show_printer,is_published:this.is_published,additionaltype:this.additionaltype,meta_description:this.meta_description,meta_title:this.meta_title,sku:this.sku,condition:this.condition,color:this.color,page_yield:this.page_yield,printer_technology:this.printer_technology,printer_type:this.printer_type,printer_description:this.printer_description,price:this.price,manufacter:this.manufacter,brand:this.brand,product_no:this.product_no,alternate_name3:this.alternate_name3,alternate_name2:this.alternate_name2,alternate_name1:this.alternate_name1,page_slug:this.page_slug, create_segment: this.createSegment, parent_page: this.parentPageId, page_id: this.id, page_title: this.title, short_description: this.short_description, page_description: this.description, is_home_page: this.isHomePage,  is_contact_page: this.isContactPage, is_service_page: this.isServicePage, is_project: this.isProject, is_featured_project: this.isFeaturedProject}
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
        // will we create a segment or page
        if($('#create_segment').is(":checked")) {
            // create instance of a new page
            var page = new Page(1);
        } else {
            // create instance of a new page
            var page = new Page(0);
        }

        // save this page
        page.save;
        // prevent default button behavior
        return false;
    });

    // what reset button will do?
    $('#reset').click(function(){
        // hide validation msg
        $('.validation-msg').html('');
    })

    // what (select parent page drop down list) will do?
    $('#set-page-rel').change(function(){
        // get current page id
        var currentPageId = parseInt( $('#set-page-rel option:selected').attr('data-current-page-id'));
        // get parent page id
        var parentPageId = parseInt($(this).val());
        // get parent page text
        var parentPageText = $(this).find('option:selected').attr('data-page-label');
        
        // save relation
        $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/page/page_self_rel",
            data: {current_page_id: currentPageId, parent_page_id: parentPageId}
        }).done(function(msg){
            // get and parse ajax response
            this.reply = jQuery.parseJSON(msg);
            // show message
            $('.validation-msg').html(this.reply.message);
            // is relation created?
            if(this.reply.new_rel_created == 1) {
                // yes, relation is created
                // create new DOM element to show new parent
                var newParentPageLabel = "<span class='label label-info parent-page-label' data-current-page-id='"+currentPageId+"' data-parent-page-id='"+parentPageId+"'>"+parentPageText+"<i class='icon-remove-sign icon-white'></i></span>&nbsp;";
                // append new parent into DOM
                $('.parent-pages').append(newParentPageLabel);
            }
        })
    })

    // what (select parent gallery dropdown list) will do?
    $('#set-gallery-rel').change(function(){
        // get current page id
        var childId = parseInt( $('#set-gallery-rel option:selected').attr('data-current-page-id'));
        // get parent page id
        var parentId = parseInt($(this).val());
        // get parent page text
        var parentText = $(this).find('option:selected').text();
        
        // save relation
        $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/page/set_page_gallery_rel",
            data: {child_id: childId, parent_id: parentId, parent_is: 'gallery'}
        }).done(function(msg){
            // get and parse ajax response
            this.reply = jQuery.parseJSON(msg);
            // show message
            $('.validation-msg').html(this.reply.message);
            // is relation created?
            if(this.reply.new_rel_created == 1) {
                // yes, relation is created
                // create new DOM element to show new parent
                var parentLabel = "<span class='label label-info parent-gallery-label' data-current-page-id='"+childId+"' data-parent-gallery-id='"+parentId+"'>"+parentText+"<i class='icon-remove-sign icon-white'></i></span>&nbsp;";
                // append new parent into DOM
                $('.parent-galleries').append(parentLabel);
            }
        })  
    })

// what (select product printer dropdown list) will do?
    $('#set-printer-rel').change(function(){
        // get current page id
        var childId = parseInt( $('#set-printer-rel option:selected').attr('data-current-page-id'));
        // get parent page id
        var parentId = parseInt($(this).val());
        // get parent page text
        var parentText = $(this).find('option:selected').text();
        
        // save relation
        $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/page/set_page_printer_rel",
            data: {child_id: childId, parent_id: parentId}
        }).done(function(msg){
            // get and parse ajax response
            this.reply = jQuery.parseJSON(msg);
            // show message
            $('.validation-msg').html(this.reply.message);
            // is relation created?
            if(this.reply.new_rel_created == 1) {
                // yes, relation is created
                // create new DOM element to show new parent
                var parentLabel = "<span class='label label-info parent-printer-label' data-current-page-id='"+childId+"' data-parent-printer-id='"+parentId+"'>"+parentText+"<i class='icon-remove-sign icon-white'></i></span>&nbsp;";
                // append new parent into DOM
                $('.parent-printer').append(parentLabel);
            }
        })  
    })

    // what will parent gallery labels do?
    $('.parent-gallery-label').live('click', function(){
        // clicking the parent label will break relation with current selected page
        // take a reference of this element to use later
        var targetParent = $(this);
        // get current page id
        var childId = $(this).attr('data-current-page-id');
        // get parent page id
        var parentId = $(this).attr('data-parent-gallery-id');

        // initialize bootbox confirm box
        bootbox.confirm("Are you sure, you want to remove that relation?", function(result) {
            if(result) {
                // if ok button is pressed
                $.ajax({
                    type: 'post',
                    url: "<?php echo site_url(); ?>admin/page/remove_page_gallery_relation",
                    data: {child_id: childId, parent_id: parentId, parent_is: 'gallery'}
                }).done(function(msg){
                    // get and parse ajax response
                    this.reply = jQuery.parseJSON(msg);
                    // is relation broken?
                    if(this.reply.is_relation_broken == 1) {
                        // successfully broken
                        targetParent.hide();
                        $('.validation-msg').html(this.reply.message);
                    }
                })
            } 
        })
    })

    // what will parent page label button do?
    $('.parent-page-label').live('click', function(){
        var targetParent = $(this);
        var currentPageId = $(this).attr('data-current-page-id');
        var parentPageId = $(this).attr('data-parent-page-id');

        bootbox.confirm("Are you sure, you want to remove that relation?", function(result) {
            if(result) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo site_url(); ?>admin/page/remove_page_rel",
                    data: {current_page_id: currentPageId, parent_page_id: parentPageId}
                }).done(function(msg){
                    this.reply = jQuery.parseJSON(msg);
                    targetParent.hide();
                    $('.validation-msg').html(this.reply.message);  
                })
            } 
        })
    })


    // what will parent page label button do?
    $('.parent-printer-label').live('click', function(){
        var targetParent = $(this);
        var currentPageId = $(this).attr('data-current-page-id');
        var parentPageId = $(this).attr('data-parent-printer-id');

        bootbox.confirm("Are you sure, you want to remove that relation?", function(result) {
            if(result) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo site_url(); ?>admin/page/remove_printer_rel",
                    data: {current_page_id: currentPageId, parent_page_id: parentPageId}
                }).done(function(msg){
                    this.reply = jQuery.parseJSON(msg);
                    targetParent.hide();
                    $('.validation-msg').html(this.reply.message);  
                })
            } 
        })
    })


    var reloadPage = function(){

    }
</script>