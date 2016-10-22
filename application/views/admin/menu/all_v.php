<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>

<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/menu/sidebar_nav_v.php'); ?>
    </div>


    <div class="span10">
        <h2>List of Menus</h2>
        <div class="delete-msg"></div>
        <table class="table table-striped table-hover">
            <caption></caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Menu title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $row_count = 1; ?>
                <?php foreach ($menu_q->result() as $menu): ?>
                    <tr data-menu-row="<?php echo $menu->id; ?>">
                        <td><?php echo $row_count; ?></td>
                        <td>
                            <?php 
                                echo anchor(
                                        "admin/menu/all/{$menu->id}", $menu->title
                                    ); 
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo anchor(
                                        "admin/menu/entry/{$menu->id}", 
                                        "<i class='icon-edit'></i> Update", 
                                        array('class' => 'btn btn-mini')
                                    ); 
                            ?>
                            <?php 
                                echo anchor(
                                        "admin/menu/delete/{$menu->id}", 
                                        "<i class='icon-trash'></i> Delete", 
                                        array(
                                                'class' => 'btn btn-mini btn-delete', 
                                                'data-menu-id' => $menu->id
                                            )
                                    ); 
                            ?>
                        </td> 
                    </tr>
                    <?php $row_count++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    function Menu(menu_id) {
        this.menu_id = menu_id;

        this.postData = {
            menu_id: this.menu_id
        }
        // get csrf data from global variable
        this.postData[csrfTokenName] = csrfHash;

        this.delete = $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>admin/menu/delete",
            data: this.postData
        }).done(function(msg){
            this.reply = jQuery.parseJSON(msg);
            $('.delete-msg').html(this.reply.message);
            setTimeout(function() {$('.delete-msg').html('');}, 1000);
            $('tr[data-menu-row="'+this.reply.deleted_menu_id+'"]').hide();
        });
    }

    $(".btn-delete").click(function(){
        var menu_id = $(this).attr('data-menu-id');
        var confirmation = bootbox.confirm('Are you sure, you want to delete that item?', function(result){
            if(result) {
                var menu = new Menu(menu_id);
                menu.delete;
            }
        });
        return false;
    })
</script>

<?php $this->load->view('admin/footer_v.php'); ?>
