<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<?php $this->load->view('admin/page_header_v.php'); ?>


<div class="row-fluid">
    <div class="span2">
       <?php $this->load->view('admin/requestuser/sidebar_nav_v.php'); ?>
    </div>
    <div class="span10">
        <h2>Features</h2>
        <dl class="dl-horizontal">
            <dt>
            	Currently Order
            </dt>
            <dd>
                You will be able to all product order which are requested.
            </dd>

            <dt>List of Shipped order</dt>
            <dd>List of all order which are already shipped.</dd>
        </dl>       
    </div>
</div>

<?php $this->load->view('admin/footer_v.php'); ?>