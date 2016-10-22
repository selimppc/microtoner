<ul class="nav nav-tabs nav-stacked">
    <li <?php echo ($this->uri->segment(2) == 'printer_list' && $this->uri->segment(3) == 'entry') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/printer_list/entry", "Create a new printer"); ?></li>
    <li <?php echo ($this->uri->segment(2) == 'printer_list' && $this->uri->segment(3) == 'all') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/printer_list/all", "List of printer list"); ?>

    </li>
    
</ul>
