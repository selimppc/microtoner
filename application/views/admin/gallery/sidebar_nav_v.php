<ul class="nav nav-tabs nav-stacked">
    <li <?php echo ($this->uri->segment(2) == 'gallery' && $this->uri->segment(3) == 'entry') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/gallery/entry", "Create a new gallery"); ?></li>
    <li <?php echo ($this->uri->segment(2) == 'gallery' && $this->uri->segment(3) == 'all') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/gallery/all", "List of galleries"); ?>
    </li>
</ul>
