<div class="main-content">
    <div class="page-content">
        <h2 class="page-content-title">Edit Help Topic</h2>
        <a class="create-page" href="<?php echo site_url('admin/help_center/view_page/' . $help_topic['page_id']); ?>">Back to Page</a>
        <?php echo validation_errors(); ?>
        <form class="crete-page-form" action="<?php echo site_url('admin/help_center/edit_topic/' . $help_topic['id']); ?>" method="post">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $help_topic['title']; ?>" required><br><br>
                <label for="content">Content:</label>
                <textarea name="content" id="content"><?php echo $help_topic['content']; ?></textarea><br><br>
                <label for="include_in_popular">
                    <input type="checkbox" name="include_in_popular" id="include_in_popular" value="1" <?php echo $help_topic['include_in_popular'] ? 'checked' : ''; ?>>
                    Include in Popular list
                </label>
                <!-- <button type="submit">Update</button> -->
                <input type="submit" name="submit" value="Update">
        </form>

    </div>
</div>