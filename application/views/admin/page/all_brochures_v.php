<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>

<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/page/sidebar_nav_v.php'); ?>
    </div>

    <div class="span10">
        <h3>Upload brochure</h3>
        <?php echo $brochure_error; ?>
        <?php echo $this->session->flashdata('brochure_error'); ?>
        <?php echo form_open_multipart('admin/page/upload_brochure', array('class' => 'form-inline')); ?>
        Title: <input type="text" name="title" id="title" value="">
        <input type="file" name="brochure" id="brochure"> 
        <input type="submit" name="submit" id="submit" value="Upload" class="btn">
        <br>
        <span>Allowed file types: pdf</span>
        <?php echo form_close(); ?>

        <hr>
        <h3>All brochures</h3>
        <?php if ($brochure_q->num_rows() != 0): ?>
            <table class="table">
                <tr>
                    <th>Title</th>
                    <th>Filename</th>
                    <th>Actions</th>
                </tr>
            <?php foreach ($brochure_q->result() as $brochure): ?>
                <tr>
                    <td><?php echo $brochure->title; ?></td>
                    <td><?php echo $brochure->file_name; ?></td>
                    <td>
                        <?php echo anchor("admin/page/delete_brochure/{$brochure->id}", "Delete", array('class' => 'btn btn-mini delete-link')); ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </table>
        <?php endif ?>

    </div>
</div>





<?php $this->load->view('admin/footer_v.php'); ?>
