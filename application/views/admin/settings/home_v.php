<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>


<div class="row-fluid">
    <div class="span2">
        <?php $this->load->view('admin/settings/sidebar_nav_v.php'); ?>
    </div>
    <div class="span10">
        <h2>Features</h2>
        <dl class="dl-horizontal">
            <dt>
            Primary contact<br>information
            </dt>
            <dd>
                Set primary contact information of your company. In front-end if
                <br>only a single contact info is required, this one will be used. 
            </dd>

        </dl>

    </div>
</div>

<?php $this->load->view('admin/footer_v.php'); ?>