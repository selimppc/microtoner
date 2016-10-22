<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>

<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/page/sidebar_nav_v.php'); ?>
    </div>

    <div class="span10">
        <!-- <form class="form-horizontal"> -->
        <?php echo form_open('', array('class' => 'form-horizontal')); ?>
        <?php if (isset($page_data) && !empty($page_data)): ?>
            <?php echo form_fieldset("Update page - " . $page_data->title); ?>
        <?php else: ?>
            <?php echo form_fieldset("Create A New Page"); ?>
        <?php endif; ?>

        <div class="validation-msg"></div>

        <ul class="nav nav-tabs" id="myTab">
            <li><a href="#basic" data-toggle="tab">Basic fields</a></li>
            <?php if (isset($page_data) && !empty($page_data)): ?>
                <li><a href="#photos" data-toggle="tab">Photos</a></li>
            <?php endif; ?>
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
            <?php if (isset($page_data) && !empty($page_data)): ?>
                <li><a href="#relations" data-toggle="tab">Relations</a></li>
            <?php endif; ?>
        </ul>

        <div class="tab-content">
            <div class="tab-pane" id="basic">
               
                <?php if (!isset($page_data)): ?>
                    
                    <div class="control-group">
                        <label class="control-label" for="create_segment">Create page <br>as SEGMENT</label>
                        <div class="controls">
                            <input type="checkbox" name="create_segment" id="create_segment" value="1">
                            <p class="help-block">Multiple segments will be merged as full page content.</p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="parent_page">Parent page</label>
                        <div class="controls">
                            <div class="input-append">
                                <select name="parent_page" id="parent_page">
                                    <option value="">Select parent page</option>
                                        <?php foreach ($all_pages_q->result() as $page): ?>
                                            <optgroup label="<?php echo $page->title; ?>" >
                                                <option value="<?php echo $page->id; ?>">
                                                    <?php echo $page->title; ?>
                                                </option>
                                                <?php
                                                    $first_menu_q = $this->common_m->sub_menu($page->id);
                                                    print_r($first_menu_q); 
                                                    foreach($first_menu_q->result() as $first_menu):                       
                                                ?>

                                                    <option value="<?php echo $first_menu->page_id; ?>">
                                                        <?php echo '&nbsp;&nbsp;&nbsp;';?>
                                                        <?php echo $first_menu->title; ?>
                                                    </option>

                                                    <?php
                                                        $second_menu_q = $this->common_m->sub_menu($first_menu->page_id); 
                                                        foreach($second_menu_q->result() as $second_menu):                       
                                                    ?>

                                                        <option value="<?php echo $second_menu->page_id; ?>">
                                                            <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
                                                            <?php echo $second_menu->title; ?>
                                                        </option>

                                                        <?php
                                                            $third_menu_q = $this->common_m->sub_menu($second_menu->page_id); 
                                                            foreach($third_menu_q->result() as $third_menu):                       
                                                        ?>

                                                            <option value="<?php echo $third_menu->page_id;?> ">
                                                                <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
                                                                <?php echo $third_menu->title; ?>
                                                            </option>

                                                            <?php
                                                                $fourth_menu_q = $this->common_m->sub_menu($third_menu->page_id); 
                                                                foreach($fourth_menu_q->result() as $fourth_menu):                       
                                                            ?>
                                                                <option value="<?php echo $fourth_menu->page_id ?>">
                                                                    <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
                                                                    <?php echo $fourth_menu->title; ?>
                                                                </option>

                                                                <?php
                                                                    $fifth_menu_q = $this->common_m->sub_menu($fourth_menu->page_id); 
                                                                    foreach($fifth_menu_q->result() as $fifth_menu):                       
                                                                ?>

                                                                    <option value="<?php echo $fifth_menu->page_id; ?>">
                                                                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
                                                                        <?php echo $fifth_menu->title; ?>
                                                                    </option>

                                                                <?php endforeach; ?>
                                                            <?php endforeach; ?>

                                                        <?php endforeach; ?>

                                                    <?php endforeach; ?>

                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endforeach;?>
                                    </select>
                                </select>
                            </div>
                        </div>
                    </div>

<?php endif ?>

                
                <div class="control-group">
                    <label class="control-label" for="is-home-page">Is Published?</label>
                    <div class="controls">
                        <input type="checkbox" name="" id="is-published" <?php echo (isset($page_data) && $page_data->published == 0) ? 'checked = "checked"' : ''; ?>>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="is-home-page">Show in Printer list?</label>
                    <div class="controls">
                        <input type="checkbox" name="" id="is-show-in-printer-list" <?php echo (isset($page_data) && $page_data->show_in_product_list == 0) ? 'checked = "checked"' : ''; ?>>
                    </div>
                </div>
                <div class="control-group">
<?php echo form_label('Page title', 'page_title', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="page_title" id="page_title" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->title : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Page slug', 'page_slug', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="page_slug" id="page_slug" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->page_slug : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Brand', 'printer', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="printer" id="brand" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->brand : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Product No', 'product_no', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="product_no" id="product_no" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->product_no : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Alternate Name 1', 'alternate_name1', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="alternate_name1" id="alternate_name1" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->alternate_name1 : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Alternate Name 2', 'alternate_name2', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="alternate_name2" id="alternate_name2" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->alternate_name2 : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Alternate Name 3', 'alternate_name3', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="alternate_name3" id="alternate_name3" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->alternate_name3 : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Additional Type', 'additionaltype', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="additionaltype" id="additionaltype" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->additionaltype : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Meta Title', 'meta_title', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="meta_title" id="meta_title" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->meta_title : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Meta Description / Short Description', 'Manufacter', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="manufacter" id="manufacter" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->manufacter : ''; ?>" />
                    </div>
                </div>

                 <div class="control-group">
<?php echo form_label('Price', 'price', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="price" id="price" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->price : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Product Type', 'printer_type', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="printer_type" id="printer_type" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->printer_type : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Printer Technology', 'printer_technology', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="printer_technology" id="printer_technology" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->printer_technology : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Color', 'color', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="color" id="color" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->color : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Page Yield', 'page_yield', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="page_yield" id="page_yield" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->page_yield : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Condition', 'condition', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="condition" id="condition" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->condition : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('SKU', 'sku', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="sku" id="sku" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->sku : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Another', 'short_description', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input name="short_description" id="short_description" 
                        value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->short_description : ''; ?>">
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Another', 'meta_description', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <input type="text" name="meta_description" id="meta_description" value="<?php echo (isset($page_data) && !empty($page_data)) ? $page_data->meta_description : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Description 1', 'page_description', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <textarea name="page_description" id="page_description"><?php echo (isset($page_data) && !empty($page_data)) ? $page_data->description : ''; ?></textarea>
                    </div>
                </div>

                <div class="control-group">
<?php echo form_label('Description 2', 'printer_description', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <textarea name="printer_description" id="printer_description"><?php echo (isset($page_data) && !empty($page_data)) ? $page_data->printer_description : ''; ?></textarea>
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
                                    <div class="photo-details">
                                    </div>
                                    <div class="photo-settings">
                                        <p>

                                            <label class="checkbox"><input type="checkbox" name="is_primary_photo" class="is_primary_photo" value="1" data-page-photo-id="<?php echo $page_photo->id; ?>" data-page-id="<?php echo $page_photo->page_id; ?>"  <?php echo ($page_photo->is_primary_photo == 1) ? 'checked="checked"' : ''; ?>> <span>Is primary photo?</span></label>
                                        </p>

                                        <p>

                                            <label class="checkbox">
                                                <input type="checkbox" name="is_banner_photo" class="is_banner_photo" value="1" data-page-photo-id="<?php echo $page_photo->id; ?>" data-page-id="<?php echo $page_photo->page_id; ?>" <?php echo ($page_photo->is_banner_photo == 1) ? 'checked="checked"' : ''; ?>> <span>Is banner photo?</span>
                                            </label>
                                        </p>
                                        <p>
                                            <input type='text' name='pri_sort_title' placeholder='Sort Title' class='pri_sort_title' value='<?php echo (isset($page_photo) && !empty($page_photo)) ? $page_photo->sort_title : ''; ?>' data-page-photo-id="<?php echo $page_photo->id; ?>" data-page-id="<?php echo $page_photo->page_id; ?>">
                                        </p>
                                        <p>
                                            <input type='text' name='pri_sort_description' class='pri_sort_description' placeholder='Sort Description' value='<?php echo (isset($page_photo) && !empty($page_photo)) ? $page_photo->sort_description : ''; ?>' data-page-photo-id="<?php echo $page_photo->id; ?>" data-page-id="<?php echo $page_photo->page_id; ?>">
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
    <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
<?php endif; ?>

            <div class="tab-pane" id="settings">

                <div class="control-group">
                    <label class="control-label" for="is-home-page">Is home us page?</label>
                    <div class="controls">
                        <input type="checkbox" name="is_home_page" id="is-home-page" <?php echo (isset($page_data) && $page_data->is_home_page == 1) ? 'checked = "checked"' : ''; ?>>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="is-contact-page">Is contact us page?</label>
                    <div class="controls">
                        <input type="checkbox" name="is_contact_page" id="is-contact-page" <?php echo (isset($page_data) && $page_data->is_contact_page == 1) ? 'checked = "checked"' : ''; ?>>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="is-service-page">Is product type page?</label>
                    <div class="controls">
                        <input type="checkbox" name="is_service_page" id="is-service-page" <?php echo (isset($page_data) && $page_data->is_service_page == 1) ? 'checked = "checked"' : ''; ?>>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="is-project">Is product?</label>
                    <div class="controls">
                        <input type="checkbox" name="is_project" id="is-project" <?php echo (isset($page_data) && $page_data->is_project == 1) ? 'checked = "checked"' : ''; ?>>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="is-featured-project">Is main project?</label>
                    <div class="controls">
                        <input type="checkbox" name="is_featured_project" id="is-featured-project" <?php echo (isset($page_data) && $page_data->is_featured_project == 1) ? 'checked = "checked"' : ''; ?>>
                    </div>
                </div>
                
                    
            </div> <!-- /.tab-pane -->

        <?php if (isset($page_data) && !empty($page_data)): ?>
                <div class="tab-pane" id="relations">
                    <h4>Page relations</h4>

                    <select id="set-page-rel">
                        <option value="0" data-current-page-id="<?php echo $page_data->id; ?>">
                            Select parent page
                        </option>
                            <?php foreach ($all_pages_not_this_q->result() as $page): ?>
                            <option value="<?php echo $page->id; ?>" data-current-page-id="<?php echo $page_data->id; ?>" data-page-label="<?php echo $page->title; ?>">
                                <?php
                                //echo $page->title; 
                                $this->common_m->get_all_parent_pages($page->id);
                                ?>
                            </option>
    <?php endforeach; ?> 
                    </select>


                    <div class="parent-pages">
                        <h4>Parent pages</h4>
                            <?php foreach ($all_page_rel_q->result() as $page_rel): ?>
                            <span class="label label-info parent-page-label" data-current-page-id="<?php echo $page_data->id; ?>" data-parent-page-id="<?php echo $page_rel->parent_page_id; ?>">
                            <?php echo $page_rel->parent_page_title; ?> <i class="icon-remove-sign icon-white"></i>
                            </span>&nbsp;
    <?php endforeach; ?>
                    </div>

                    <hr>
                    <h4>Gallery relations</h4>
                    <select id="set-gallery-rel">
                        <option value="0" data-current-page-id="<?php echo $page_data->id; ?>">
                            Select parent gallery
                        </option>
                            <?php foreach ($all_galleries_q->result() as $gallery): ?>
                            <option value="<?php echo $gallery->id; ?>" data-current-page-id="<?php echo $page_data->id; ?>">
                            <?php echo $gallery->title; ?>
                            </option>
                            <?php endforeach; ?>
                    </select>

                    <div class="parent-galleries">
                        <h4>Parent galleries</h4>
                            <?php foreach ($page_gallery_rel_q->result() as $page_gallery_rel): ?>
                            <span class="label label-info parent-gallery-label" data-current-page-id="<?php echo $page_data->id; ?>" data-parent-gallery-id="<?php echo $page_gallery_rel->gallery_id; ?>">
                            <?php echo $page_gallery_rel->gallery_title; ?> <i class="icon-remove-sign icon-white"></i>
                            </span>&nbsp;
                <?php endforeach; ?>
                    </div>

                    <hr>
                    <h4>Printer relations</h4>
                    
                    <select id="set-printer-rel">
                        <option value="0" data-current-page-id="<?php echo $page_data->id; ?>">
                            Select printer for product
                        </option>
                            <?php
                                if(!empty($all_printer_q)){
                                    foreach ($all_printer_q->result() as $all_printer):
                            ?>
                            <option value="<?php echo $all_printer->id; ?>" data-current-page-id="<?php echo $page_data->id; ?>">
                                <?php echo $all_printer->printer_name; ?>
                            </option>                       
                            <?php
                                    endforeach;
                                }
                            ?>
                    </select>

                    <div class="parent-printer">
                        <h4>Assign Printer</h4>
                        <?php foreach ($page_printer_rel_q->result() as $page_printer_rel): ?>
                            <span class="label label-info parent-printer-label" data-current-page-id="<?php echo $page_data->id; ?>" data-parent-printer-id="<?php echo $page_printer_rel->printer_id; ?>">
                            <?php echo $page_printer_rel->printer_name; ?> <i class="icon-remove-sign icon-white"></i>
                            </span>&nbsp;
                        <?php endforeach; ?>
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

<?php $this->load->view('admin/page/js/entry_v_js.php'); ?>

<?php $this->load->view('admin/footer_v.php'); ?>