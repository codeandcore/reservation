<div class="main-content">
    <div class="page-content">
        <h2 class="page-content-title">Create Help Topic</h2>
        <?php echo validation_errors(); ?>
        <form class="crete-page-form" action="<?php echo site_url('admin/help_center/create_topic/' . $page_id); ?>" method="post">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required><br><br>
            <label for="content">Content:</label>
            <textarea name="content" id="content"></textarea><br><br>
            <label for="include_in_popular">
                <input type="checkbox" name="include_in_popular" id="include_in_popular" value="1">
                Include in Popular list
            </label>
            <!-- <button type="submit">Create</button> -->
            <input type="submit" name="submit" value="Create">
        </form>
    <div>
</div>