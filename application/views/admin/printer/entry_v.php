<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>

<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/printer/sidebar_nav_v.php'); ?>
    </div>
    <div class="span10">
        <?php echo form_open('', array('class' => 'form-horizontal')); ?>
        
            <?php if (isset($page_data) && !empty($page_data)): ?>
                <?php echo form_fieldset("Update printer - " . $page_data->printer_name); ?>
            <?php else: ?>
                <?php echo form_fieldset("Create A New Printer"); ?>
            <?php endif; ?>

            <div class="validation-msg"></div>

            <ul class="nav nav-tabs" id="myTab">
                <li><a href="#basic" data-toggle="tab">Basic fields</a></li>

                <?php if (isset($page_data) && !empty($page_data)): ?>
                    <li><a href="#photos" data-toggle="tab">Photos</a></li>
                <?php endif; ?>
            </ul>

            <div class="tab-content">
                <div class="tab-pane" id="basic">
                    <div class="control-group">
                        <label class="control-label" for="is-home-page">Is Published?</label>
                        <div class="controls">
                            <input type="checkbox" name="" id="is-published" <?php echo (isset($page_data) && $page_data->published == 0) ? 'checked = "checked"' : ''; ?>>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo form_label('Printer Name', 'printer_name', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <input type="text" name="printer_name" id="printer_name" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->printer_name : ''; ?>" />
                            </div>
                    </div>
                    <div class="control-group">
                        <?php echo form_label('Printer Slug', 'printer_slug', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <input type="text" name="printer_slug" id="printer_slug" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->printer_slug : ''; ?>" />
                            </div>
                    </div>
                    <div class="control-group">
                        <?php echo form_label('Meta Title', 'meta_title', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <input type="text" name="meta_title" id="meta_title" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->meta_title : ''; ?>" />
                            </div>
                    </div>
                    <div class="control-group">
                        <?php echo form_label('Alternative Name 1', 'alternative_name1', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <input type="text" name="alternative_name1" id="alternative_name1" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->alternative_name1 : ''; ?>" />
                            </div>
                    </div>
                    <div class="control-group">
                        <?php echo form_label('Alternative Name 2', 'alternative_name2', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <input type="text" name="alternative_name2" id="alternative_name2" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->alternative_name2 : ''; ?>" />
                            </div>
                    </div>
                    <div class="control-group">
                        <?php echo form_label('Alternative Name 3', 'alternative_name3', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <input type="text" name="alternative_name3" id="alternative_name3" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->alternative_name3 : ''; ?>" />
                            </div>
                    </div>
                    <div class="control-group">
                        <?php echo form_label('Additionaly Type', 'additionaltype', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <input type="text" name="additionaltype" id="additionaltype" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->additionaltype : ''; ?>" />
                            </div>
                    </div>
                    <div class="control-group">
                        <?php echo form_label('Parent Printer', 'parent_printer', array('class' => 'control-label')); ?>
                            <div class="controls">

                                <select name="parent_printer" id="parent_printer">
                                    <?php
                                        if(isset($page_data)){
                                    ?>
                                        <option <?php echo $page_data->parent_printer; ?>><?php echo $page_data->parent_printer ?></option>
                                    <?php }else{
                                    ?>
                                        <option>Please select</option>
                                    <?php 
                                        }
                                    ?>                                    
                                    <?php 
                                        foreach($parent_printer_list_r->result() as $parent_printer_list){
                                    ?> 
                                        <option value="<?php echo $parent_printer_list->page_slug; ?>"><?php echo $parent_printer_list->title; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                <!-- <input type="text"  value="<?php //echo (isset($page_data) && !empty($page_data)) ? $page_data->parent_printer : ''; ?>" /> -->
                            </div>
                    </div>
                    <div class="control-group">
                        <?php echo form_label('Printer description', 'printer_description', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <textarea name="printer_description" id="printer_description">
                                    <?php echo (isset($page_data) && !empty($page_data)) ? $page_data->printer_description : ''; ?>
                                </textarea>
                            </div>
                    </div>
                    
                </div>

                <?php if (isset($page_data) && !empty($page_data)): ?>
                    <div class="tab-pane" id="photos">
                        <span class="btn_r btn-success-r fileinput-button-r"> 
                            <span>Select Files</span>                      
                            <input type="file" class="resource_class" name="files[]" id="file_upload" data-url="<?php echo base_url(); ?>server/php/" multiple />
                        </span>
                        <div id="progress">
                            <div class="bar" style="width: 0%;"></div>
                        </div>
                        <div class="page-photos">
                            <?php if (($page_photo_q->num_rows != 0)): ?>
                                <?php foreach ($page_photo_q->result() as $page_photo): ?>
                                    <div class="gallery-photo" data-page-photo-id="<?php echo $page_photo->id; ?>">
                                        <a href="#" class="">
                                            <img src="<?php echo base_url(); ?>server/php/files/thumbnail/<?php echo $page_photo->photo_file_name; ?>">
                                        </a>
                                        <span class="delete-photo-link" data-page-photo-id="<?php echo $page_photo->id; ?>">Delete</span>
                                        <p>
                                            <input type='text' name='pri_short_title' placeholder='Short Title' class='pri_short_title' value='<?php echo (isset($page_photo) && !empty($page_photo)) ? $page_photo->short_title : ''; ?>' data-page-photo-id="<?php echo $page_photo->id; ?>" data-page-id="<?php echo $page_photo->printer_id; ?>">
                                        </p>
                                        <p>
                                            <input type='text' name='pri_short_description' class='pri_short_description' placeholder='Short Description' value='<?php echo (isset($page_photo) && !empty($page_photo)) ? $page_photo->short_description : ''; ?>' data-page-photo-id="<?php echo $page_photo->id; ?>" data-page-id="<?php echo $page_photo->printer_id; ?>">
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
                <div class="form-actions">
                    <?php if (isset($page_data) && !empty($page_data)): ?>
                        <input type="hidden" name="page_id" id="page_id" value="<?php echo $page_data->id; ?>" />
                    <?php endif ?>
                    <button type="submit" name="save_page" id="save_page" class="btn btn-primary"> <i class="icon-plus-sign icon-white"></i> Save </button>
                    <button type="reset" name="reset" id="reset" class="btn"> <i class="icon-refresh"></i> Reset </button>  
                </div>
            

            <?php echo form_fieldset_close(); ?>
        </form>
    </div>
</div>

<?php $this->load->view('admin/printer/js/entry_v_js.php'); ?>
<?php $this->load->view('admin/footer_v.php'); ?>