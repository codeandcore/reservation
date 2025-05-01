<div class="main-content">
    <div class="page-content">
        <h2 class="page-content-title"><?php echo $help_page['title']; ?></h2>
        <a class="create-page" href="<?php echo site_url('admin/help_center/create_topic/'.$help_page['id']); ?>">Create New Topic</a>
        <div class="main-topic-wrapper" style="display: flex;">
            <div style="width: 20%;">
                <ul class="page-name">
                    <?php foreach ($help_topics as $topic): ?>
                        <li>
                            <a href="#topic-<?php echo $topic['id']; ?>"><?php echo $topic['title']; ?></a>
                            <a class="edit-page" href="<?php echo site_url('admin/help_center/edit_topic/'.$topic['id']); ?>">Edit</a>
                            <a class="delete-page delete_help_item" href="<?php echo site_url('admin/help_center/delete_topic/'.$topic['id']); ?>">Delete</a>
                        </li>
                    <?php endforeach; ?>
                        <li>
                            <a href="<?php echo site_url('admin/help_center'); ?>">Back to All Pages</a>
                        </li>
                </ul>
            </div>
            <div class="topic-content" style="width: 80%;">
                <?php foreach ($help_topics as $topic): ?>
                    <div id="topic-<?php echo $topic['id']; ?>">
                        <h3><?php echo $topic['title']; ?></h3>
                        <p><?php echo nl2br($topic['content']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
