<?php $total = $this->user_model->get_total_ratings_byrestid($detail['id']);?>
<div class="tabs">
    <ul class="tabs-nav">
        <li><a href="#tab-1">Overview</a></li>
        <?php if($detail['menu_images'] != ''){?>
        <li><a href="#tab-2">Menu</a></li>
        <?php } ?>
        <?php if($total > 0){?>
        <li><a href="#tab-3">Reviews</a></li>
        <?php } ?>
    </ul>
    <div class="tabsContent">
        <div class="tabsItem" id="tab-1">
            <div class="overviewItem-content cmn-scroll">
                
                <?php  if($detail['gallery'] != '' || $detail['feature_image'] != ''):
                    $gallery = [];
                    if($detail['feature_image'] != ''){
                        array_push($gallery,$detail['feature_image']);
                    }
                    if($detail['gallery'] != ''){
                        $exp = explode(',',$detail['gallery']);
                        if(!empty($exp)){
                            foreach($exp as $img){
                                array_push($gallery,$img);
                            }
                        }
                    }
                    ?>
                <div class="overview-slider-section">
                    <div class="swiper-buttons">
                        <div class="swiper-button-next"><img
                                src="<?php echo base_url(); ?>/uploads/front/images/right-line-arrow.svg" alt=""></div>
                        <div class="swiper-button-prev"><img
                                src="<?php echo base_url(); ?>/uploads/front/images/left-line-arrow.svg" alt=""></div>
                    </div>
                    <div class="swiper overviewSlider">
                        <div class="swiper-wrapper">
                            <?php foreach($gallery as $img):?>
                            <div class="swiper-slide">
                                <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $img;?>" alt="">
                            </div>
                            <?php endforeach;?>
                            
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <h4><?php echo $detail['restaurant_name'];?></h4>
                <div class="overview-content ">
                    <?php if($detail['full_content'] != ''){?>
                    <?php echo $detail['full_content'];?>
                    <?php } 
                     else if($detail['description'] != ''){?>
                    <?php echo $detail['description'];?>
                    <?php } ?>
                </div>
            </div>
            <?php if(str_word_count($detail['full_content']) > 60 || str_word_count($detail['description']) > 60){?>
            <!-- <a href="#" class="readMore">Read More +</a> -->
            <?php } ?>
        </div>
        <div class="tabsItem" id="tab-2">
        <?php if($detail['menu_images'] != ''){?>
            <div class="menuDetails cmn-scroll">
                <div class="grid-main">
                    <?php $exp = explode(',',$detail['menu_images']);
                    $count = count($exp);
                    $remain = $count - 3; $i=1;
                    foreach($exp as $img){
                    ?>
                    <div class="grid-item <?php if($i == 3 && $remain > 0){ echo 'gallery-more';}?> <?php if($i > 3){ echo 'hidden-img';}?>" <?php if($i == 3 && $remain > 0){?>data-more="+<?php echo $remain;?> More"<?php } ?>>
                        <a data-fancybox="gallery" href="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $img;?>">
                            <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $img;?>" alt="">
                        </a>
                    </div>
                    <?php $i++; } ?>

                </div>
            </div>
            <?php } ?>
        </div>
        <div class="tabsItem" id="tab-3">
            <div class="review-main">
                <div class="row">
                    <div class="col-6">
                        <h4>Overall ratings and reviews</h4>
                        <p>Reviews can only be made by diners who have eaten at this restaurant</p>
                        <?php $avg_rating = $this->user_model->get_average_rating_restid($detail['id']);?>
                        <div class="star-ratings">
                            <div class="fill-ratings">
                                <?php if($avg_rating >= 0.5 && $avg_rating < 1){?>
                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating2.svg" alt=""></span>
                                <?php } else if($avg_rating >= 1) {?>
                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating1.svg" alt=""></span>
                                <?php } else{?>
                                    <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating3.svg" alt=""></span>
                                <?php } ?>
                                <?php if($avg_rating >= 1.5 && $avg_rating < 2){?>
                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating2.svg" alt=""></span>
                                <?php } else if($avg_rating >= 2) {?>
                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating1.svg" alt=""></span>
                                <?php } else{?>
                                    <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating3.svg" alt=""></span>
                                <?php } ?>
                                <?php if($avg_rating >= 2.5 && $avg_rating < 3){?>
                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating2.svg" alt=""></span>
                                <?php } else if($avg_rating >= 3) {?>
                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating1.svg" alt=""></span>
                                <?php } else{?>
                                    <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating3.svg" alt=""></span>
                                <?php } ?>
                                <?php if($avg_rating >= 3.5 && $avg_rating < 4){?>
                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating2.svg" alt=""></span>
                                <?php } else if($avg_rating >= 4) {?>
                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating1.svg" alt=""></span>
                                <?php } else{?>
                                    <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating3.svg" alt=""></span>
                                <?php } ?>
                                <?php if($avg_rating >= 4.5 && $avg_rating < 5){?>
                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating2.svg" alt=""></span>
                                <?php } else if($avg_rating >= 5) {?>
                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating1.svg" alt=""></span>
                                <?php } else{?>
                                    <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating3.svg" alt=""></span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        
                        <div class="fill-review-list">
                        <?php $count = $this->user_model->get_total_number_ratings_byrestid(5,$detail['id']);
                        if($count > 0 && $total > 0){
                            $math = round(($count / $total) * 100);
                        }
                        else{
                            $math = 0;
                        }
                        ?>
                            <div class="single-fill-review-list">
                                <span class="text">5</span>
                                <progress id="file" value="<?php echo $math;?>" max="100"> <?php echo $math;?>% </progress>
                            </div>
                        <?php $count = $this->user_model->get_total_number_ratings_byrestid(4,$detail['id']);
                        if($count > 0 && $total > 0){
                            $math = round(($count / $total) * 100);
                        }
                        else{
                            $math = 0;
                        }
                        ?>
                            <div class="single-fill-review-list">
                                <span class="text">4</span>
                                <progress id="file" value="<?php echo $math;?>" max="100"> <?php echo $math;?>% </progress>
                            </div>
                        <?php $count = $this->user_model->get_total_number_ratings_byrestid(3,$detail['id']);
                        if($count > 0 && $total > 0){
                            $math = round(($count / $total) * 100);
                        }
                        else{
                            $math = 0;
                        }
                        ?>
                            <div class="single-fill-review-list">
                                <span class="text">3</span>
                                <progress id="file" value="<?php echo $math;?>" max="100"> <?php echo $math;?>% </progress>
                            </div>
                        <?php $count = $this->user_model->get_total_number_ratings_byrestid(2,$detail['id']);
                        if($count > 0 && $total > 0){
                            $math = round(($count / $total) * 100);
                        }
                        else{
                            $math = 0;
                        }
                        ?>
                            <div class="single-fill-review-list">
                                <span class="text">2</span>
                                <progress id="file" value="<?php echo $math;?>" max="100"> <?php echo $math;?>% </progress>
                            </div>
                        <?php $count = $this->user_model->get_total_number_ratings_byrestid(1,$detail['id']);
                        if($count > 0 && $total > 0){
                            $math = round(($count / $total) * 100);
                        }
                        else{
                            $math = 0;
                        }
                        ?>
                            <div class="single-fill-review-list">
                                <span class="text">1</span>
                                <progress id="file" value="<?php echo $math;?>" max="100"> <?php echo $math;?>% </progress>
                            </div>
                        </div>
                    </div>
                    <?php $rating_list = $this->user_model->get_rating_list_by_restid($detail['id']);
                    if(!empty($rating_list)):
                    ?>
                    <div class="col-12">
                        <div class="ratingListing">
                            <?php foreach($rating_list as $data){?>
                            <div class="ratingItem">
                                <div class="ratingItemHeader">
                                    <div class="ratingItemUser">
                                        <div class="ratingUserImg">
                                            <?php if($data['person_pic']){?>
                                                <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $data['person_pic'];?>" alt="">
                                            <?php }
                                            else{?>
                                            <img src="<?php echo base_url(); ?>/uploads/front/images/no-user.jpg" alt="">
                                            <?php } ?>
                                        </div>
                                        <div class="ratingUserInfo"> 
                                            <h6><?php echo $data['person_name'];?></h6>
                                            <span class="ratingDate"><?php echo date('M d, Y',strtotime($data['review_date']));?></span>
                                        </div>
                                    </div>
                                    <div class="star-ratings">
                                        <div class="fill-ratings">
                                            <?php $rating = $data['rating'];?>
                                            <?php if($rating >= 0.5 && $rating < 1){?>
                                            <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating2.svg" alt=""></span>
                                            <?php } else if($rating >= 1) {?>
                                            <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating1.svg" alt=""></span>
                                            <?php } else{?>
                                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating3.svg" alt=""></span>
                                            <?php } ?>
                                            <?php if($rating >= 1.5 && $rating < 2){?>
                                            <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating2.svg" alt=""></span>
                                            <?php } else if($rating >= 2) {?>
                                            <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating1.svg" alt=""></span>
                                            <?php } else{?>
                                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating3.svg" alt=""></span>
                                            <?php } ?>
                                            <?php if($rating >= 2.5 && $rating < 3){?>
                                            <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating2.svg" alt=""></span>
                                            <?php } else if($rating >= 3) {?>
                                            <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating1.svg" alt=""></span>
                                            <?php } else{?>
                                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating3.svg" alt=""></span>
                                            <?php } ?>
                                            <?php if($rating >= 3.5 && $rating < 4){?>
                                            <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating2.svg" alt=""></span>
                                            <?php } else if($rating >= 4) {?>
                                            <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating1.svg" alt=""></span>
                                            <?php } else{?>
                                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating3.svg" alt=""></span>
                                            <?php } ?>
                                            <?php if($rating >= 4.5 && $rating < 5){?>
                                            <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating2.svg" alt=""></span>
                                            <?php } else if($rating >= 5) {?>
                                            <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating1.svg" alt=""></span>
                                            <?php } else{?>
                                                <span><img src="<?php echo base_url(); ?>/uploads/front/images/star-rating3.svg" alt=""></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="ratingItemContent">
                                    <p><?php echo $data['description'];?></p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="review-listing">
                <div class="single-review-list">
                    <div class="review-top">
                        <div class="review-profile">
                            <figure>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>