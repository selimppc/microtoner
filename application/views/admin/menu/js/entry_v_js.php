<script type="text/javascript">
    $(function(){
        $('#myTab a:first').tab('show');
    })
    
</script>

<script type="text/javascript">
    // create menu class definition
    function Menu(id, title) {
        // set menu id for edit
        this.id = id;
        // set menu title
        this.title = title

        // set all post data
        this.postData = {
            menu_title: this.title
        };

        // for updating, send id
        if (id != null) {
            this.postData[id] = this.id;
        };

        // get csrf hash from global variable
        this.postData[csrfTokenName] = csrfHash;

        // define save functionality
        this.save = $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/menu/save",
            data: this.postData
        }).done(function(msg){
            // get and parse json
            this.reply = jQuery.parseJSON(msg);
            $('.validation-msg').html(this.reply.msg);
            setTimeout(function() {$('.validation-msg').html('');}, 1000);
        })
    }

    // what save menu button will do
    $("#menu-create-form").submit(function(){
        // is update case?
        if ($('#menu_id').length > 0) {
            // yes, get menu id from dom
            var id = parseInt($('#menu_id').val());
        } else {
            // set menu id to null
            var id = null;
        }
        
        // get menu title
        var title = $('#menu_title').val();

        // create a new instance of menu class
        var menu = new Menu(id, title);
        // save menu
        menu.save;
        // prevent default button behavior
        return false;
    });

    // what reset button will do
    $('#reset').click(function(){
        // hide validation message
        $('.validation-msg').html('');
    })
</script>