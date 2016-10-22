<ul class="nav nav-tabs nav-stacked">
    <li <?php echo ($this->uri->segment(2) == 'menu' && $this->uri->segment(3) == 'entry') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/menu/entry", "Create a new menu"); ?></li>
    <li <?php echo ($this->uri->segment(2) == 'menu' && $this->uri->segment(3) == 'all') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/menu/all", "List of menus"); ?>
    </li>
</ul>
