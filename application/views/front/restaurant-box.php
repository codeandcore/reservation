<?php 
if(!isset($booking_modified)){ $booking_modified = 'no';}
$time_list = $this->user_model->time_list_table_restaurant($hotel['id'],$date,$selected_pax);
$dates_list = $this->user_model->get_dates_list_booking();
$end_date = end($dates_list);
 $incount = 0;
 if(!empty($time_list)):
 foreach($time_list as $time){
    if($selected_time == '' || $selected_time == $time['time']){
        $incount = 1;
    }
}
endif;
if($incount == 1 || $booked == 'yes'):?>
<div class="availableItem <?php if($booking_modified == 'yes'){ echo 'modifyItem';}?> <?php if($booked == 'yes'){ echo 'booked';}?>">
    <div class="restaurantImg">
    <?php 
    if($hotel['feature_image'] != ''){
        $feature_image = base_url().'/uploads/assets/images/'.$hotel['feature_image'];
    }
    else{
        $feature_image = base_url().'/uploads/front/images/no-image.jpg';
    }
    if($hotel['feature_image'] != ''){?>
        <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $hotel['feature_image'];?>"
            alt="">
        <?php } else{ ?>
            <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg"
            alt="">
        <?php } ?>
    </div>
    <div class="restaurantDetails frrrrr">
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
        <p><?php echo nl2br($hotel['description']);?></p>
        <?php } ?>
        <p class="propertyType"><?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?></p>
        <?php 
        $db_filters = $this->user_model->get_filters_listby_restid($hotel['id']);
        if(!empty($db_filters)){
            $uns = [];
            foreach($db_filters as $key => $ary) {
                $uns[$ary['filter_type']][] = $ary['filter_value'];
            }
            if(!empty($uns)){
                foreach($uns as $key => $val){
                    $icon = $this->user_model->get_icon_by_filterslug($key);
                    ?>
        <div class="eatingType"
            <?php if($icon != ''){ echo 'style="background-image: url('.base_url().'/uploads/assets/images/'.$icon.');"';}?>>
            <ul class="list-unstyled">
                <?php foreach($val as $dr){ 
            
                    if($key == 'establishment_type' && $this->settings['restaurant_establishment_hide'] == 'yes'){
                        continue;
                    }
                    if($key == 'meals' && $this->settings['restaurant_meals_hide'] == 'yes'){
                        continue;
                    }
                    
                    if ($key == 'fee' && $this->settings['restaurant_fee_hide'] == 'yes') {
                        continue;
                    }
                ?>
                <li><?php echo $dr;?></li>
                <?php } ?>
            </ul>
        </div>
        <?php } 
            }
        } ?>
        <?php if($hotel['website_link'] && $this->settings['restaurant_website_url_hide'] != 'yes'):?>
        <div class="eatingType restro_link"
            <?php echo 'style="background-image: url('.base_url().'/uploads/assets/images/global-2.svg);"';?>>
            <!-- <ul class="list-unstyled"> -->
                <!-- <li><a href="<?php //echo $hotel['website_link'];?>" target="_blank">Restaurant Portal</a></li> -->
                <a href="<?php echo $hotel['website_link'];?>" target="_blank">Menu link</a>
            <!-- </ul> -->
        </div>
        <?php endif; ?>
        <?php $time_list = $this->user_model->time_list_table_restaurant($hotel['id'],$date,$selected_pax);
        if(!empty($time_list)){                                            
        ?>
        <div class="timeing" <?php if($booked == 'yes'){ echo 'style="display:none;"';}?>>
            <ul class="list-unstyled">
                <?php foreach($time_list as $time){
                    if($selected_time == '' || $selected_time == $time['time']){
                    ?>
                <li><a href="javascript:void(0)" class="selectRestaurant_btn"
                        data-target="selectRestaurant"><?php echo $time['time'];?></a></li>
                <?php } } ?>
            </ul>
        </div>
        <?php } ?>
        <?php if($booked == 'yes'){ ?>
            <div class="booked_time">
            <ul class="list-unstyled">
                <li><a href="javascript:void(0)"><?php echo $selected_time;?></a></li>
                <?php 
                $today = date('Y-m-d');
                $cancel_date = $this->settings['cancel_date'];
                if($today <= $cancel_date){
                    ?>
                <li><a href="javascript:void(0)" data-listid="<?php echo $list_id;?>" data-target="reservationCancel" class="cancel-reserved_btn btn modal-button" data-hotelimg="<?php echo $feature_image;?>" data-restname="<?php echo $hotel['restaurant_name'];?>" data-date="<?php echo date('m-d-Y',strtotime($date));?>" data-time="<?php echo $selected_time;?>" data-pax="<?php echo $selected_pax;?>" data-type="<?php echo $this->user_model->get_property_type_text($hotel['property_type']);?>">Cancel</a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
       <?php }?>
    </div>
    <a href="#" class="btn viewBtn restaurant-modal-button" data-rest_id="<?php echo $hotel['id'];?>"
        data-target="viewDetails">View
        Details</a>

    <div class="selectedRestaurant">
        <div class="selectedContent">
            <h5>Do you want to select <u><?php echo $hotel['restaurant_name'];?></u> for 
                <u><?php echo $this->user_model->get_string_from_date($date);?></u>?
            </h5>
            <ul class="list-unstyled">
                <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/white_table-icon.svg" alt=""></i> Table
                    for
                    <?php echo $selected_pax;?></li>
                <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/white_building_icon.svg" alt=""></i>
                    <?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?></li>
                <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/white_clock_time_icon.svg" alt=""></i>
                    <span class="selected_time_slot">07:00pm</span></li>
            </ul>
            <?php if($hotel['deposite'] == 'yes'){
                $deposite = $hotel['deposite_amount'];
            }
            else{
                $deposite = $hotel['deposite_amount'];
            }
                ?>
            <div class="buttonRow">
                <!-- <a href="javascript:void(0)" class="btn toconfirmationsection" data-target="toconfirmation">Confirm and finish</a> -->
                <!-- <a href="javascript:void(0)" class="btn confirmRestaurant" data-target="confirmRestaurant" data-targetToConfirm="toconfirmation">Confirm and finish</a> -->
                <?php
                    if($referer == 'modify'){
                        ?>
                        <a href="javascript:void(0)" class="btn confirmRestaurant" data-target="confirmRestaurant" data-targetToConfirm="toconfirmation"
                            data-bookdate="<?php echo date('d-m-Y',strtotime($date));?>" data-booktime=""
                            data-bookpax="<?php echo $selected_pax;?>" data-deposite="<?php echo $deposite;?>"
                            data-bookrestid="<?php echo $hotel['id'];?>">Confirm and finish</a>
                        <?php
                    }
                ?>
                <?php
                    $bookingformatDate = date('d-m-Y',strtotime($date));
                    $formatted_date = DateTime::createFromFormat("d-m-Y", $bookingformatDate)->format("Y-m-d");
                    $end_date = $end_date['date'];
                    $bookingText = '';
                    if($formatted_date == $end_date){
                        // echo "Hello";
                        $bookingText = 'Confirm';
                    }else{
                        $bookingText = 'Confirm and next day';
                    }
                ?>
                <a href="javascript:void(0)" class="btn confirmRestaurant" data-target="confirmRestaurant"
                    data-bookdate="<?php echo date('d-m-Y',strtotime($date));?>" data-booktime=""
                    data-bookpax="<?php echo $selected_pax;?>" data-deposite="<?php echo $deposite;?>"
                    data-bookrestid="<?php echo $hotel['id'];?>"><?php echo $bookingText; ?></a>
                <a href="javascript:void(0)" class="btn" data-target="NotConfirmRestaurant" data-bookdate="<?php echo date('d-m-Y',strtotime($date));?>">CANCEL</a>
            </div>
            <div class="note_rest">
            <?php if($booked == 'yes'){?>
                <p><strong>Note: </strong>This section will modify your current booking for this date.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>