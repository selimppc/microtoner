<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $page_title; ?></title>
        <link href='https://fonts.googleapis.com/css?family=Orienta' rel='stylesheet' type='text/css'>
        <?php echo link_tag('jqueryui/css/jquery-ui-1.8.23.custom.css'); ?>
        <?php echo link_tag('bootstrap/css/bootstrap.min.css'); ?>
        <?php echo link_tag('bootstrap/css/bootstrap-datetimepicker.min.css'); ?>
        <?php echo link_tag('bootstrap/css/bootstrap-responsive.min.css'); ?>
        <?php echo link_tag('styles/admin.css'); ?>
        <?php //echo link_tag('uploadify/uploadify.css'); ?>
        <script src="<?php echo base_url(); ?>scripts/jquery-1.8.0.min.js"></script>
        <script src="<?php echo base_url(); ?>scripts/jquery.scrollto.min.js"></script>
        <script src="<?php echo base_url(); ?>jqueryui/js/jquery-ui-1.8.23.custom.min.js"></script>
        <!--<script src="<?php //echo base_url(); ?>uploadify/jquery.uploadify-3.1.min.js"></script>-->
        <script src="<?php echo base_url(); ?>scripts/underscore-min.js"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script src="<?php echo base_url(); ?>scripts/gmaps.js"></script>
        <script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
        <script src="<?php echo base_url(); ?>ckeditor/adapters/jquery.js"></script>

        <script src="<?php echo base_url(); ?>scripts/jquery.ui.widget.js"></script> 
        <script src="<?php echo base_url(); ?>scripts/jquery.iframe-transport.js"></script> 
        <script src="<?php echo base_url(); ?>scripts/jquery.fileupload.js"></script> 

        <script>
            $(function() {
                $('textarea').ckeditor({
                    skin: 'office2003',
                    filebrowserBrowseUrl : '<?php echo base_url(); ?>kcfinder/browse.php?type=files',
                    filebrowserImageBrowseUrl : '<?php echo base_url(); ?>kcfinder/browse.php?type=images',
                    filebrowserFlashBrowseUrl : '<?php echo base_url(); ?>kcfinder/browse.php?type=flash',
                    filebrowserUploadUrl : '<?php echo base_url(); ?>kcfinder/upload.php?type=files',
                    filebrowserImageUploadUrl : '<?php echo base_url(); ?>kcfinder/upload.php?type=images',
                    filebrowserFlashUploadUrl : '<?php echo base_url(); ?>kcfinder/upload.php?type=flash'
                });
            })
        </script>
        <script type="text/javascript">
        var siteUrl = "<?php echo site_url(); ?>";
        var csrfTokenName = "<?php echo $this->security->get_csrf_token_name(); ?>";
        var csrfHash = "<?php echo $this->security->get_csrf_hash(); ?>";

        </script>
    </head>