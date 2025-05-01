<?php $title = "Help Center"; ?>
<?php //$this->load->view('help/header', compact('title')); ?>
        <section class="portal-section">
            <div class="container-default">
                <?php
                $new_feature_page = array_filter($help_pages, function($page) {
                    return $page['is_new_feature'] == 1;
                });
                if($new_feature_page){
                    // we'll get the first element from the filtered result.
                    $new_feature_page = reset($new_feature_page);
                    ?>
                    <div class="portal-main-info">
                        <h4>Discover the New Features of This Year (2024) for <a href="<?php echo base_url('admin/help/view/'.$new_feature_page['id']); ?>">Restaurant portal</a></h4>
                    </div>
                    <?php
                }
                ?>

                <div class="row">
                    <?php foreach ($help_pages as $page): ?>
                        <?php
                        if(!$page['is_new_feature']){
                            ?>
                                <div class="col-6">
                                    <a href="<?php echo site_url('admin/help/view/'.$page['id']); ?>" class="portal-card pos_rel"> 
                                        <?php if($page['image']){ ?> <?php //echo base_url('uploads_help_center/'.$help_page['image']); ?> <span><img src="<?php echo  base_url('uploads_help_center/'.$page['image']); ?>"></span> <?php } ?>
                                        <h3><?php echo $page['title']; ?></h3>
                                        <?php if($page['summary']){ ?> <p><?php echo $page['summary'] ?></p> <?php } ?>
                                    </a>
                                </div>
                            <?php
                        }    
                        ?>
                    <?php endforeach; ?>
                </div>
            </div>
     </section>
      <!-- start :: faq-section -->
       <?php
        if($popular_topics){
            ?>
            <section class="faq-section">
                <div class="container-default">
                    <div class="row">
                        <div class="col-3">
                            <div class="faq-left">
                                <h2>Popular resources</h2>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="faq-main-info">
                                <?php
                                foreach($popular_topics as $popular_topic){
                                    ?>
                                            <div class="faq-info d-flex align-items-center justify-between flex-wrap">
                                                <h5><?php echo $popular_topic['page_title'].': '.$popular_topic['title']; ?></h5> 
                                                <div class="explore-now pos_rel">
                                                    <a class="btn btn_add" href="<?php echo site_url('admin/help/view/'.$popular_topic['page_id'].'#topic-'.$popular_topic['id']); ?>">Explore now</a>
                                                </div>
                                            </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
       ?>
    <!-- start :: faq-section -->
<?php //$this->load->view('help/footer'); ?>