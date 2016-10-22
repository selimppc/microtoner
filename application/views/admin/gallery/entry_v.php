<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>

<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/gallery/sidebar_nav_v.php'); ?>
    </div>

    <div class="span10">
        <!-- <input type="file" name="file_upload" id="file_upload" /> -->
        <?php echo form_open('', array('class' => 'form-horizontal')); ?>
        <?php if (isset($gallery_data) && !empty($gallery_data)): ?>
            <?php echo form_fieldset("Update gallery - " . $gallery_data->title); ?>
        <?php else: ?>
            <?php echo form_fieldset("Create A New Gallery"); ?>
        <?php endif; ?>

        <div class="validation-msg"></div>

        <ul class="nav nav-tabs" id="myTab">
            <li><a href="#basic" data-toggle="tab">Basic fields</a></li>
            <li><a href="#advanced" data-toggle="tab">Advanced fields</a></li>
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
            <?php if (isset($gallery_data) && !empty($gallery_data)): ?>
                <li><a href="#photos" data-toggle="tab">Photos</a></li>
            <?php endif; ?>

            <?php if (isset($gallery_data) && !empty($gallery_data)): ?>
                <li><a href="#relations" data-toggle="tab">Relations</a></li>
            <?php endif; ?>
        </ul>   

        <div class="tab-content">
            <div class="tab-pane" id="basic">
                <div class="control-group">
                    <?php echo form_label('Gallery title', 'gallery_title', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="gallery_title" id="gallery_title" value="<?php echo (isset($gallery_data) && !empty($gallery_data)) ? $gallery_data->title : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <?php echo form_label('Gallery description', 'gallery_description', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <textarea name="gallery_description" id="gallery_description"><?php echo (isset($gallery_data) && !empty($gallery_data)) ? $gallery_data->description : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="advanced">
                <p>this is advanced tab pane</p>
            </div>

            <div class="tab-pane" id="settings">
                <p>this is settings tab pane</p>
            </div>

            <?php if (isset($gallery_data) && !empty($gallery_data)): ?>
                <div class="tab-pane" id="photos">
                    <input type="file" name="file_upload" id="file_upload" />
                    <div class="gallery-photos">
                        <?php if (($gallery_photo_q->num_rows != 0)): ?>
                            <?php foreach ($gallery_photo_q->result() as $gallery_photo): ?>
                                <div class="gallery-photo" data-gallery-photo-id="<?php echo $gallery_photo->id; ?>">
                                    <a href="#" class="">
                                        <img src="<?php echo base_url(); ?>uploads/gallery_photos/<?php echo $gallery_photo->photo_raw_name; ?>_thumb<?php echo $gallery_photo->photo_file_ext; ?>">
                                    </a>
                                    <span class="delete-photo-link" data-gallery-photo-id="<?php echo $gallery_photo->id; ?>">Delete</span>
                                    <div class="photo-details">
                                    </div>
                                    <div class="photo-settings">
                                        <!-- <input type="checkbox" name="is_banner_photo" id="is_banner_photo"> -->
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($gallery_data) && !empty($gallery_data)): ?>
                <div class="tab-pane" id="relations">
                    <h4>Page relations</h4>
                    <div class="input-append">
                        <select id="set-page-gallery-rel">
                            <option value="0" data-current-gallery-id="<?php echo $gallery_data->id; ?>">
                                Select parent page
                            </option>
                            <?php foreach ($all_pages_q->result() as $page): ?>
                                <option value="<?php echo $page->id; ?>" data-current-gallery-id="<?php echo $gallery_data->id; ?>" data-page-label="<?php echo $page->title; ?>">
                                    <?php //echo $page->title; ?>
                                    <?php
                                    //echo $page->title; 
                                    $this->common_m->get_all_parent_pages($page->id);
                                    ?>
                                </option>
                            <?php endforeach; ?> 
                        </select>
                    </div>

                    <div class="parent-pages">
                        <h4>Parent pages</h4>
                        <?php foreach ($all_page_gallery_rel_q->result() as $page_gallery_rel): ?>
                            <span class="label label-info parent-page-label" data-current-gallery-id="<?php echo $gallery_data->id; ?>" data-parent-page-id="<?php echo $page_gallery_rel->page_id; ?>">
                                <?php echo $page_gallery_rel->page_title; ?> <i class="icon-remove-sign icon-white"></i>
                            </span>&nbsp;
                        <?php endforeach; ?>

                    </div>


                </div>
            <?php endif; ?>
        </div> 
        <!-- /.tab-content -->
        <div class="form-actions">
            <?php if (isset($gallery_data) && !empty($gallery_data)): ?>
                <input type="hidden" name="gallery_id" id="gallery_id" value="<?php echo $gallery_data->id; ?>" />
            <?php endif ?>
            <button type="submit" name="save_gallery" id="save_gallery" class="btn btn-primary"> <i class="icon-plus-sign icon-white"></i> Save </button>

            <button type="reset" name="reset" id="reset" class="btn"> <i class="icon-refresh"></i> Reset </button>
        </div>
        <!-- /.form-actions -->

    </div>
</div>
<?php $this->load->view('admin/gallery/js/entry_v_js.php'); ?>

<?php $this->load->view('admin/footer_v.php'); ?>