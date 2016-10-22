<ul class="nav nav-tabs nav-stacked">
    <li <?php echo ($this->uri->segment(2) == 'page' && $this->uri->segment(3) == 'entry') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/page/entry", "Create a new page"); ?></li>
    <li <?php echo ($this->uri->segment(2) == 'page' && $this->uri->segment(3) == 'all') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/page/all", "List of pages"); ?>

    </li>
    
</ul>
