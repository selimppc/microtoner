<?php $this->load->view('admin/header_v.php'); ?>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6 offset3 well">
                    <h1>MicroToner</h1>                    
                    <hr>
                    <!-- start of login form -->
                    <?php echo form_open('', array('name' => 'login_form', 'class' => 'form-inline')); ?>
                    <div class="validation-msg"></div>
                    <input type="text" name="username" id="username" placeholder="Username">
                    <input type="password" name="password" id="password" placeholder="Password">
                    <button type="submit" name="do_login" id="do-login" class="btn btn-primary">Login</button>
                    <?php echo form_close(); ?>
                    <!-- end of login form -->
                    <hr>
                    <p>Designed and Developed by VisionAds</p>
                </div>
            </div>

        </div>

        <?php  $this->load->view('accounts/js/login_v_js.php'); ?>

        
    </body>
</html>