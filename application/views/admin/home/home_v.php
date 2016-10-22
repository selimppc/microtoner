<?php $this->load->view('admin/header_v.php'); ?>
<?php $this->load->view('admin/navbar_v.php'); ?>
<div class="row-fluid">
    <div class="span12">
    </div>
</div>
<div class="row-fluid intro" style="display: none;">
    <div class="span12">
        <div class="hero-unit">
            <h1>MicroToner</h1>
            <h3>Welcome to admin panel for MicroToner Website</h3>
            
        </div>
    </div>
</div>
<script>
    // show intro after few seconds
    setTimeout(function(){$('.intro').slideDown();}, 500)
</script>
<?php $this->load->view('admin/footer_v.php'); ?>