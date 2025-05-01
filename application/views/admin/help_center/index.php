<div class="main-content">
    <div class="page-content">
        <h2 class="page-content-title">Help Center</h2>
        <a class="create-page" href="<?php echo site_url('admin/help_center/create_page'); ?>">Create New Help Page</a>
        <!-- ul id "page-list" and li data attribute data-id is uesed for page reorder JS and Ajax-->
        <ul class="page-name" id="page-list">
            <?php foreach ($help_pages as $page): ?>
                <li data-id="<?php echo $page['id']; ?>">
                    <a href="<?php echo site_url('admin/help_center/view_page/'.$page['id']); ?>"><?php echo $page['title']; ?></a>
                    <a class="edit-page" href="<?php echo site_url('admin/help_center/edit_page/'.$page['id']); ?>">Edit</a>
                    <a class="delete-page delete_help_item" href="<?php echo site_url('admin/help_center/delete_page/'.$page['id']); ?>">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery("#page-list").sortable({
        update: function(event, ui) {
                var positions = {};
                jQuery("#page-list li").each(function(index) {
                    positions[$(this).data('id')] = index + 1;
                });

                $.post("<?php echo site_url('admin/help_center/update_positions'); ?>", {
                    positions: positions
                });
            }
        });
        $("#page-list").disableSelection();
    });
</script>