<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>


<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/menu/sidebar_nav_v.php'); ?>
    </div>
    <div class="span10">

        <!-- start of menu create form -->
        <?php 
            echo form_open('', 
                    array( 'name' => 'menu_create_form', 
                            'class' => 'form-horizontal',
                            'id' => 'menu-create-form'
                        )
                ); 

        ?>
        <?php if (isset($menu_data) && !empty($menu_data)): ?>
            <?php echo form_fieldset("Update menu - " . $menu_data->title); ?>
        <?php else: ?>
            <?php echo form_fieldset("Create A New menu"); ?>
        <?php endif; ?>

        <!-- show validation message -->
        <div class="validation-msg"></div>

        <!-- start of tab head -->
        <ul class="nav nav-tabs" id="myTab">
            <li><a href="#basic" data-toggle="tab">Basic fields</a></li>
            <li><a href="#advanced" data-toggle="tab">Advanced fields</a></li>
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
        </ul> 
        <!-- end of tab head -->

        <!-- start of tab body -->
        <div class="tab-content">
            <!-- start of basic tab body -->
            <div class="tab-pane" id="basic">
                <div class="control-group">
                    <label for="menu_title" class="control-label">Menu title</label>
                    <div class="controls">
                        <input type="text" name="menu_title" id="menu_title" 
                        value="<?php echo (isset($menu_data) 
                                && !empty($menu_data)) 
                                ? $menu_data->title : ''; ?>" />
                    </div>
                </div>
            </div>
            <!-- end of basic tab body -->

            <!-- start of advanced tab body -->
            <div class="tab-pane" id="advanced">
                <p>this is advanced tab pane</p>
            </div>
            <!-- end of advanced tab body -->

            <!-- start of settings tab body -->
            <div class="tab-pane" id="settings">
                <p>this is settings tab pane</p>
            </div>
            <!-- end of settings tab body -->
        </div>
        <!-- end of tab body -->

        <!-- start of form actions -->
        <div class="form-actions">
            <?php if (isset($menu_data) && !empty($menu_data)): ?>
                <input type="hidden" name="menu_id" id="menu_id" 
                    value="<?php echo $menu_data->id; ?>" />
            <?php endif ?>
            <button type="submit" name="save_menu" id="save_menu" class="btn btn-primary"> 
                <i class="icon-plus-sign icon-white"></i> Save 
            </button>

            <button type="reset" name="reset" id="reset" class="btn"> 
                <i class="icon-refresh"></i> Reset 
            </button>
        </div>
        <!-- end of form actions -->

        <?php echo form_fieldset_close(); ?>
        <?php echo form_close(); ?>
        <!-- end of menu create form -->
    </div>
</div>

<?php $this->load->view('admin/menu/js/entry_v_js.php'); ?>
<?php $this->load->view('admin/footer_v.php'); ?>