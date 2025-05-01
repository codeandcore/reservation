<div class="main-content">
    <div class="page-content">
        <h2 class="page-content-title">Edit Help Page</h2>
        <?php echo validation_errors(); ?>
        <a class="create-page" href="<?php echo site_url('admin/help_center'); ?>">Back to All Pages</a>
        <?php //echo form_open('admin/help_center/edit_page/'.$help_page['id']); ?>
        <form class="crete-page-form" method="post" action="<?php echo site_url('admin/help_center/edit_page/' . $help_page['id']); ?>" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" name="title" value="<?php echo $help_page['title']; ?>" /><br />

            <label for="summary">Summary</label>
            <textarea id="summary" name="summary"><?php echo $help_page['summary']; ?></textarea>

            <label for="image">Upload Image</label>
            <input type="file" id="image" name="image">
            <?php if ($help_page['image']) { ?>
                <img src="<?php echo base_url('uploads_help_center/'.$help_page['image']); ?>" width="100" /><br />
            <?php } ?>

            <!-- <label for="content_page_summary">Content</label>
            <textarea id="content_page_summary" name="content_page_summary"><?php //echo $page->content; ?></textarea> -->
            <div class="serch-input d-flex align-items-center">
                <input type="checkbox" name="is_new_feature" id="is_new_feature" value="1" <?php echo $help_page['is_new_feature'] ? 'checked' : ''; ?>><br />
                <label for="is_new_feature">Is new feature page</label>
                <!-- <input type="checkbox" name="exclude_from_search" id="exclude_from_search" value="1" <?php //echo $help_page['exclude_from_search'] ? 'checked' : ''; ?>><br />
                <label for="exclude_from_search">Exclude from Search</label> -->
            </div>
            <input type="submit" name="submit" value="Update" />
        </form>
    </div>
</div>