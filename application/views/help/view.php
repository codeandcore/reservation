<?php $title = $help_page['title']; ?>
<?php $this->load->view('help/header', compact('title')); ?>
<!-- <h2><?php //echo $help_page['title']; ?></h2> -->

    <section class="menubar-section">
        <div class="container-default">
            <div class="row">
                <div class="col-3">
                    <div class="sidebar">
                    <div class="line"></div>
                    <ul>
                        <?php foreach ($help_topics as $topic): ?>
                            <li>
                                <a href="#topic-<?php echo $topic['id']; ?>"><?php echo $topic['title']; ?>
                                <span class="circle"></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    </div>
                </div>
                <div class="col-9">

                    <div class="content-main">
                            <?php foreach ($help_topics as $topic): ?>
                                <div id="topic-<?php echo $topic['id']; ?>">
                                    <!-- <h3><?php //echo $topic['title']; ?></h3> -->
                                    <?php echo nl2br($topic['content']); ?>
                                </div>
                            <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('help/footer'); ?>