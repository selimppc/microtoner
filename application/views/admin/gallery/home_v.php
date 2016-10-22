<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>


<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/gallery/sidebar_nav_v.php'); ?>
    </div>
    <div class="span10">
        <h2>Features</h2>
        <dl class="dl-horizontal">
            <dt>
            Create a new gallery
            </dt>
            <dd>
                You will be able to create a brand new gallery for your website. 
            </dd>

            <dt>List of galleries</dt>
            <dd>A list of all your created galleries will be there for modification.</dd>
        </dl>
    </div>
</div>

<?php $this->load->view('admin/footer_v.php'); ?>