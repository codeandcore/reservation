<div class="popup_body">
    <div class="selectedRestroInfo">
        <div class="selectedRestroContent">
            <div class="selectedImg">
            <?php if($hotel['feature_image'] != ''){?>
            <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $hotel['feature_image'];?>"
                alt="">
            <?php } else{ ?>
                <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg"
                alt="">
            <?php } ?>
            </div>
            <div class="selectedContent">
            <?php if($hotel['restaurant_name'] != ''){?>
            <h6><?php echo $hotel['restaurant_name'];?></h6>
            <?php } ?>
            <?php if($hotel['description'] != ''){?>
            <div class="innerselectedContent">
            <p><?php echo $hotel['description'];?></p>
            </div>
            <?php } ?>
            <?php 
                $db_filters = $this->admin_model->get_filters_listby_restid($hotel['id']);
                if(!empty($db_filters)){
                    $uns = [];
                    foreach($db_filters as $key => $ary) {
                        $uns[$ary['filter_type']][] = $ary['filter_value'];
                    }
                    if(!empty($uns)){
                        foreach($uns as $key => $val){
                            $icon = $this->admin_model->get_icon_by_filterslug($key);
                            ?>
                <div class="eatingType"
                    <?php if($icon != ''){ echo 'style="background-image: url('.base_url().'/uploads/assets/images/'.$icon.');"';}?>>
                    <ul class="list-unstyled">
                        <?php foreach($val as $dr){ ?>
                        <li><?php echo $dr;?></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } 
                    }
                } ?>
            </div>
        </div>
        <div class="selectedMenu">
            <ul class="list-unstyled">
                <li>
                    <img src="<?php echo base_url(); ?>/uploads/assets/images/date.svg" alt="">
                    <span><?php echo $this->user_model->get_string_from_date($book['booking_date']);?></span>
                </li>
                <li>
                    <img src="<?php echo base_url(); ?>/uploads/assets/images/table.svg" alt="">
                    <span>Table for <?php echo $pax;?></span>
                </li>
                <li>
                    <img src="<?php echo base_url(); ?>/uploads/assets/images/time.svg" alt="">
                    <span><?php echo $time;?></span>
                </li>
                <li>
                    <img src="<?php echo base_url(); ?>/uploads/assets/images/property_status.svg" alt="">
                    <span><?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?> </span>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="popup_footer btn_wrap">
    <a href="javascript:void(0)" class="btn btn-primary" id="confirm_modify_booking_btn" data-bookid="<?php echo $book['id'];?>" data-restid="<?php echo $hotel['id'];?>" data-date="<?php echo $book['booking_date'];?>" data-time="<?php echo $time;?>" data-pax="<?php echo $pax;?>">Confirm modification</a>
</div>