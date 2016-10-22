<div class="row-fluid">
    <div class="span12 muted">
        <p>
            &copy; <?php echo date('Y'); ?>. Micro Toner Website
            <br />
            Developed by <?php echo anchor('http://www.visionads.com.au/', 'VisionAds', array('target' => '_blank')); ?>
        </p>
    </div>
</div>
</div>

<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">
    // $('textarea').redactor();
    // $('.redactor_editor').css('font-family', 'orienta');
</script>
<script type="text/javascript">
    
	$('.form_date').datetimepicker({
        language:  'en',
		format: 'yyyy-mm-dd',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });

    $('.out_date').datetimepicker({
        language:  'en',
		format: 'yyyy-mm-dd',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	
</script>
</body>
</html>
