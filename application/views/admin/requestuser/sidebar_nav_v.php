<ul class="nav nav-tabs nav-stacked">
    <li <?php echo ($this->uri->segment(2) == 'requestuser' && $this->uri->segment(3) == 'order') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/requestuser/order", "Currently Order"); ?></li>
    <li <?php echo ($this->uri->segment(2) == 'requestuser' && $this->uri->segment(3) == 'all_shipped') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/requestuser/all_shipped", "List of Shipped order"); ?>
    </li>
    <li <?php echo ($this->uri->segment(2) == 'requestuser' && $this->uri->segment(3) == 'all_archieve') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/requestuser/all_archieve", "List of Archive"); ?>
    </li>
    <li <?php echo ($this->uri->segment(2) == 'requestuser' && $this->uri->segment(3) == 'generate_excel') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/requestuser/generate_excel", "Generate Excel"); ?>

    </li>
    
</ul>
