<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>

<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/gallery/sidebar_nav_v.php'); ?>
    </div>


    <div class="span10">
        <h2>List of Galleries</h2>
        <div class="delete-msg"></div>
        <table class="table table-striped table-hover">
            <caption></caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Gallery title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $row_count = 1; ?>
                <?php foreach ($gallery_q->result() as $gallery): ?>
                    <tr data-gallery-row="<?php echo $gallery->id; ?>">
                        <td><?php echo $row_count; ?></td>
                        <td>
                            <?php echo anchor("admin/gallery/all/{$gallery->id}", $gallery->title); ?>


                            <?php
                            $page_gallery_rel_r = $this->common_m->get_by_fields('', 'page_gallery_rel', array('gallery_id' => $gallery->id));
                            ?>
                            <?php if ($page_gallery_rel_r['num_rows'] != 0): ?>
                                <?php $page_gallery_rel_q = $page_gallery_rel_r['query']; ?>
                                <p><b>Assigned under following links:</b></p>


                                <?php foreach ($page_gallery_rel_q->result() as $pg_rel): ?>
                                    <?php $this->common_m->get_all_parent_pages($pg_rel->page_id); ?>
                                    <br>
                                <?php endforeach ?>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php echo anchor("admin/gallery/entry/{$gallery->id}", "<i class='icon-edit'></i> Update", array('class' => 'btn btn-mini')); ?>
                            <?php echo anchor("admin/gallery/delete/{$gallery->id}", "<i class='icon-trash'></i> Delete", array('class' => 'btn btn-mini btn-delete', 'data-gallery-id' => $gallery->id)); ?>
                        </td> 
                    </tr>
                    <?php $row_count++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    function Gallery(gallery_id) {
        this.delete = $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/gallery/delete",
            data: {gallery_id: gallery_id}
        }).done(function(msg){
            this.reply = jQuery.parseJSON(msg);
            $('.delete-msg').html(this.reply.message);
            setTimeout(function() {$('.delete-msg').html('');}, 1000);
            $('tr[data-gallery-row="'+this.reply.deleted_gallery_id+'"]').hide();
        });
    }

    $(".btn-delete").click(function(){
        var gallery_id = $(this).attr('data-gallery-id');
        var confirmation = bootbox.confirm('Are you sure, you want to delete that item?', function(result){
            if(result) {
                var gallery = new Gallery(gallery_id);
                gallery.delete;
            }
        });
        return false;
    })
</script>

<?php $this->load->view('admin/footer_v.php'); ?>
