<?php
/**help search result */
?>
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body> -->
    
    <!-- <div class="main-wrap">
        <h1>Search Results</h1> -->
        <?php if (!empty($results)) : ?>
            <ul>
                <?php foreach ($results as $result) : ?>
                    <li>
                        <?php if (!empty($result['summary'])): // Assuming pages have a summary field ?>
                            <a href="<?php echo site_url('admin/help/view/'.$result['id']); ?>">
                                <?php echo $result['title']; ?>
                            </a>
                            <!-- <p><?php //echo $result['summary']; ?></p> -->
                        <?php else: ?>
                            <a href="<?php echo site_url('admin/help/view/'.$result['page_id'].'#topic-'.$result['id']); // Assuming topics have page_id ?>">
                                <?php echo $result['title']; ?>
                            </a>
                            <!-- <p><?php //echo $result['content']; ?></p> -->
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No results found.</p>
        <?php endif; ?>
    <!-- </div> -->
<!-- </body>
</html> -->
