<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>


<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/settings/sidebar_nav_v.php'); ?>
    </div>
    <div class="span10">
        <?php echo form_open('', array('class' => 'form-horizontal')); ?>

        <?php echo form_fieldset("Update primary contact information"); ?>

        <div class="validation-msg"></div>

        <ul class="nav nav-tabs" id="myTab">
            <li><a href="#basic" data-toggle="tab">Basic fields</a></li>
            <li><a href="#advanced" data-toggle="tab">Advanced fields</a></li>
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
        </ul> 

        <div class="tab-content">
            <div class="tab-pane" id="basic">
                <div class="control-group">
                    <?php
                    echo form_label(
                            'Primary contact info', 'primary_contact_info', array(
                        'class' => 'control-label'
                            )
                    );
                    ?>
                    <div class="controls">
                        <textarea name="primary_contact_info" id="primary-contact-info">
<?php echo (isset($settings_data) && !empty($settings_data)) ?
        $settings_data->primary_contact_info : '';
?>
                        </textarea>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="advanced">
                <p>this is advanced tab pane</p>
            </div>

            <div class="tab-pane" id="settings">
                <p>this is settings tab pane</p>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="save_settings" id="save-settings" class="btn btn-primary"> <i class="icon-plus-sign icon-white"></i> Save </button>

            <button type="reset" name="reset" id="reset" class="btn"> <i class="icon-refresh"></i> Reset </button>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#myTab a:first').tab('show');
    })
    
</script>

<script type="text/javascript">
    // create menu class definition
    function Settings() {

        // get primary contact info
        this.primaryContactInfo = $('#primary-contact-info').val();

        // define save functionality
        this.save = $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/settings/save_primary_contact_info",
            data: {primary_contact_info: this.primaryContactInfo}
        }).done(function(msg){
            // get and parse json
            this.reply = jQuery.parseJSON(msg);
            $('.validation-msg').html(this.reply.msg);
            setTimeout(function() {$('.validation-msg').html('');}, 1000);
        })
    }

    // what save menu button will do
    $("#save-settings").click(function(){
        // create a new instance of settings class
        var settings = new Settings();
        // save settings
        settings.save;
        // prevent default button behavior
        return false;
    });

    // what reset button will do
    $('#reset').click(function(){
        // hide validation message
        $('.validation-msg').html('');
    })
</script>

<?php $this->load->view('admin/footer_v.php'); ?>