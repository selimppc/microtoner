<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>

<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/page/sidebar_nav_v.php'); ?>
    </div>


    <div class="span10">
        <h2>List of Pages</h2>
        <div class="delete-msg"></div>
        <table class="table">
            <caption></caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Page title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $row_count = 1; ?>
                <?php foreach ($page_q->result() as $page): ?>
                    <tr data-page-row="<?php echo $page->id; ?>">
                        <td><?php echo $row_count; ?></td>
                        <td>
                            <?php echo anchor("admin/page/all/{$page->id}", $page->title); ?>
                            <?php
                            // get all galleries
                            $gallery_r = $this->common_m->get_by_fields('', 'page_gallery_rel', array('page_id' => $page->id));
                            $gallery_r = "SELECT page_gallery_rel.gallery_id, gallery.title as gallery_title
                                FROM page_gallery_rel INNER JOIN gallery ON page_gallery_rel.gallery_id = gallery.id WHERE page_gallery_rel.page_id = $page->id";
                            $gallery_q = $this->db->query($gallery_r);
                            ?>
                            <?php if ($gallery_q->num_rows() != 0): ?>
                                <p>Galleries:</p>
                                <ul>
                                    <?php foreach ($gallery_q->result() as $page_gallery): ?>
                                        <?php echo "<li><i class='icon-picture'></i> " . anchor("admin/gallery/entry/{$page_gallery->gallery_id}", $page_gallery->gallery_title) . "</li>"; ?>
                                    <?php endforeach ?>
                                </ul>
                            <?php endif ?>

                            <?php
                            $segment_r = $this->common_m->get_by_fields(
                                    '', 'page', array(
                                'is_segment' => 1,
                                'segment_parent_id' => $page->id
                                    ), 'sort_order'
                            );
                            $segment_q = $segment_r['query'];
                            ?>
                            <?php if ($segment_r['num_rows'] != 0): ?>
                                <br><br>
                                <table class="table table-condensed">
                                    <tr>
                                        <th>Segment title</th>
                                        <th>Actions</th>
                                    </tr>
        <?php foreach ($segment_q->result() as $segment): ?>
                                        <tr data-page-row="<?php echo $segment->id; ?>">
                                            <td><?php echo $segment->title; ?> </td>
                                            <td>
                                                <div>
            <?php echo anchor("admin/page/entry/{$segment->id}", "<i class='icon-edit'></i> Update", array('class' => 'btn btn-mini')); ?>
            <?php echo anchor("admin/page/delete/{$segment->id}", "<i class='icon-trash'></i> Delete", array('class' => 'btn btn-mini btn-delete', 'data-page-id' => $segment->id)); ?>
                                                    <button class="btn btn-mini show-sort-and-menu-control"><i class="icon-arrow-down"></i></button>
                                                </div>
                                                <div class="sort-and-menu-control">
                                                    <b>Sort Order:</b> <div class="input-append">
                                                        <input type="text" class="input-mini sort-order-input" name="sort_order" id="page-sort-order" value="<?php echo $segment->sort_order; ?>" data-page-id="<?php echo $segment->id; ?>"><span class="add-on"></span>
                                                    </div>
                                                </div>
                                            </td> 
                                        </tr>
        <?php endforeach ?>
                                </table>
    <?php endif; ?>

                        </td>
                        <td>
                            <div>
    <?php echo anchor("admin/page/entry/{$page->id}", "<i class='icon-edit'></i> Update", array('class' => 'btn btn-mini')); ?>
    <?php echo anchor("admin/page/delete/{$page->id}", "<i class='icon-trash'></i> Delete", array('class' => 'btn btn-mini btn-delete', 'data-page-id' => $page->id)); ?>
                                <button class="btn btn-mini show-sort-and-menu-control"><i class="icon-arrow-down"></i></button>
                            </div>
                            <div class="sort-and-menu-control">
                                <input style="float:left;" type="checkbox" name="menu_checkbox" class="is_published_l" data-page-id="<?php echo $page->id; ?>" <?php echo (isset($page) && $page->published == 0) ? 'checked = "checked"' : ''; ?> > <span style="float:left;margin-left:5px;">Is Published?</span><br/>
                                <input style="float:left;" type="checkbox" name="menu_checkbox" class="show_in_product_list_l" data-page-id="<?php echo $page->id; ?>" <?php echo (isset($page) && $page->show_in_product_list == 0) ? 'checked = "checked"' : ''; ?> > <span style="float:left;margin-left:5px;">Show in Product list?</span><br/><br/>
                                <b>Sort Order:</b> 
                                <div class="input-append">
                                    <input type="text" class="input-mini sort-order-input" name="sort_order" id="page-sort-order" value="<?php echo $page->sort_order; ?>" data-page-id="<?php echo $page->id; ?>"><span class="add-on"></span>
                                </div>
                                <div>
                                    <b>Select menu:</b>
    <?php if ($menu_q->num_rows() != 0): ?>
        <?php foreach ($menu_q->result() as $menu): ?>
            <?php
            // find already assigned pages within this menu
            $menu_assigned_r = $this->common_m->get_by_fields('', 'menu_page_rel', array('menu_id' => $menu->id, 'page_id' => $page->id));
            ?>
                                            <label class="checkbox">
                                                <input type="checkbox" name="menu_checkbox" class="menu_checkbox" data-menu-id="<?php echo $menu->id; ?>" data-page-id="<?php echo $page->id; ?>" <?php echo ($menu_assigned_r['num_rows'] != 0) ? 'checked = "checked"' : ''; ?>> <span><?php echo $menu->title; ?></span>
                                            </label>

                                        <?php endforeach ?>
    <?php endif ?>
                                </div>

                            </div>
                        </td> 
                    </tr>
    <?php $row_count++; ?>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">

    // show / or hide sort and menu selection controls
    $('.show-sort-and-menu-control').click(function(){
        var thisObject = $(this);
        var targetObject = $(this).parent().next('div.sort-and-menu-control');

        if(targetObject.is(':hidden')) {
            targetObject.slideDown('fast');
        } else {
            targetObject.slideUp('fast');
        }
    })

    $('.update-sort-order').click(function(){
        var pageId = $(this).attr('data-page-id');
        var sortOrder = $(this).prev('input[type="text"]').val();
        $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/page/update_sort_order",
            data: {page_id: pageId, sort_order: sortOrder}
        }).done(function(msg){

        })
    })

    $('.sort-order-input').blur(function(){
        var objectRef = $(this);
        var pageId = $(this).attr('data-page-id');
        var sortOrder = $(this).val();
        $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/page/update_sort_order",
            data: {page_id: pageId, sort_order: sortOrder}
        }).done(function(msg){
            objectRef.next('.add-on').html('<i class="icon-ok"></i>')
        })
    })

    $('.menu_checkbox').click(function(){
        var objectRef = $(this);
        var pageId = $(this).attr('data-page-id');
        var menuId = $(this).attr('data-menu-id');

        if ($(this).is(':checked')) {
            var action = 'set';
        } else {
            var action = 'unset';
        };

        objectRef.next('span').addClass('muted');

        $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/page/set_page_menu_rel",
            data: {action: action, page_id: pageId, menu_id: menuId}
        }).done(function(msg){
            objectRef.next('span').removeClass('muted');
        })
    })

    $('.is_published_l').click(function(){
        var objectRef = $(this);
        var pageId = $(this).attr('data-page-id');
        

        if ($(this).is(':checked')) {
            var action = 'set';
        } else {
            var action = 'unset';
        };

        $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/page/set_page_is_published",
            data: {action: action, page_id: pageId}
        }).done(function(msg){
            
        })
    })

    $('.show_in_product_list_l').click(function(){
        var objectRef = $(this);
        var pageId = $(this).attr('data-page-id');
        

        if ($(this).is(':checked')) {
            var action = 'set';
        } else {
            var action = 'unset';
        };

        $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/page/set_page_is_product_list_l",
            data: {action: action, page_id: pageId}
        }).done(function(msg){
            
        })
    })
</script>

<?php $this->load->view('admin/page/js/all_v_js.php') ?>

<?php $this->load->view('admin/footer_v.php'); ?>
