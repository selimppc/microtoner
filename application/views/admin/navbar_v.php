<body>
    <div class="navbar navbar-inverse navbar-static-top">
        <div class="navbar-inner">
            <?php echo anchor("admin/home", "Microtner", array('class' => 'brand')); ?>

            <ul class="nav">
                <li <?php echo ($this->uri->segment(2) == 'page') ? 'class="active"' : ''; ?>>
                    <?php echo anchor("admin/page/home", "Page Module"); ?></li>
                <li <?php echo ($this->uri->segment(2) == 'gallery') ? 'class="active"' : ''; ?>>
                    <?php echo anchor("admin/gallery", "Gallery Module"); ?></li>
                <li <?php echo ($this->uri->segment(2) == 'menu') ? 'class="active"' : ''; ?>>
                    <?php echo anchor("admin/menu", "Menu Module"); ?></li>
                <li <?php echo ($this->uri->segment(2) == 'printer_list') ? 'class="active"' : ''; ?>>
                    <?php echo anchor("admin/printer_list", "Printer List"); ?></li>
                <li <?php echo ($this->uri->segment(2) == 'requestuser') ? 'class="active"' : ''; ?>>
                    <?php echo anchor("admin/requestuser", "Order Administration"); ?></li>
            </ul>

            <ul class="nav pull-right">
               
                <li>
                    <?php echo anchor("logout", "Logout"); ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="container-fluid">