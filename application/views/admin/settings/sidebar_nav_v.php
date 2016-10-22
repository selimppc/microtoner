<ul class="nav nav-tabs nav-stacked">
    <li <?php echo ($this->uri->segment(2) == 'settings' && $this->uri->segment(3) == 'entry') ? 'class="active"' : ''; ?>>
        <?php echo anchor("admin/settings/primary_contact_info", "Primary contact information"); ?></li>
</ul>
