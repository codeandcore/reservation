<?php $time_list = $this->admin_model->time_list_table_restaurant($hotel['id'],$date,$selected_pax);
 $incount = 0;
 if(!empty($time_list)):
 foreach($time_list as $time){
    if($selected_time == '' || $selected_time == $time['time']){
        $incount = 1;
    }
}
endif;
if($incount == 1 || $booked == 'yes'):?>
<div class="availableItem <?php if($booked == 'yes'){ echo 'booked';}?>">
    <div class="restaurantImg">
    <?php if($hotel['feature_image'] != ''){?>
        <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $hotel['feature_image'];?>"
            alt="">
        <?php } else{ ?>
            <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg"
            alt="">
        <?php } ?>
    </div>
    <div class="restaurantDetails tttdd">
        <div class="restaurantName">
            <?php if($hotel['restaurant_name'] != ''){?>
            <h5><?php echo $hotel['restaurant_name'];?></h5>
            <?php } ?>
            <?php if($hotel['deposite'] == 'yes' && $hotel['deposite_amount'] > 0){?>
            <div class="charges">
                <span class="chargeIcon"><img src="<?php echo base_url(); ?>/uploads/front/images/dollar-icon.svg" alt=""></span>
                <div class="chargesText">This restaurant will charge $<?php echo round($hotel['deposite_amount']);?> as Late Cancel/No-Show Fee for the booking.</div>
            </div>
            <?php } ?>
        </div>
        <?php if($hotel['description'] != ''){?>
        <p><?php echo $hotel['description'];?></p>
        <?php } ?>
        <p class="propertyType"><?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?></p>
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
        <?php $time_list = $this->admin_model->time_list_table_restaurant($hotel['id'],$date,$selected_pax);
        if(!empty($time_list)){                                            
        ?>
        <div class="timeing" <?php if($booked == 'yes'){ echo 'style="display:none;"';}?>>
            <ul class="list-unstyled">
                <?php foreach($time_list as $time){
                    if($selected_time == '' || $selected_time == $time['time']){
                    ?>
                <li><a href="javascript:void(0)" class="selectRestaurant_btn" data-rest_id="<?php echo $hotel['id'];?>" data-pax="<?php echo $selected_pax;?>" data-bookid="<?php echo $booked_list['id'];?>"
                        data-popup="selectedReservation"><?php echo $time['time'];?></a></li>
                <?php } } ?>
            </ul>
        </div>
        <?php } ?>
    </div>
    <a href="#" class="btn viewBtn restaurant-modal-button" data-rest_id="<?php echo $hotel['id'];?>"
        data-target="viewDetails">View
        Details</a>
</div>
<?php endif; ?>