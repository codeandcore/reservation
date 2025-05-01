<div class="main-content">
    <div class="page-content">
        <h2 class="page-content-title">Create Help Page</h2>
        <a class="create-page" href="<?php echo site_url('admin/help_center'); ?>">Back to All Pages</a>
        <?php echo validation_errors(); ?>
        <?php //echo form_open('admin/help_center/create_page'); ?>
        <form class="crete-page-form" method="post" action="<?php echo site_url('admin/help_center/create_page'); ?>" enctype="multipart/form-data">

            <label for="title">Title</label>
            <input type="text" name="title" /><br />

            <label for="summary">Summary</label>
            <textarea name="summary"></textarea><br />

            <label for="image">Image</label>
            <input type="file" name="image" /><br />

            <div class="serch-input d-flex align-items-center">
                <input type="checkbox" name="is_new_feature" id="is_new_feature" value="1">
                <label for="is_new_feature">Is new feature page</label>
                <!-- <input type="checkbox" name="exclude_from_search" id="exclude_from_search" value="1">
                <label for="exclude_from_search">Exclude from Search</label> -->
            </div><br />

            <input type="submit" name="submit" value="Create" />

        </form>
    </div>
</div>
