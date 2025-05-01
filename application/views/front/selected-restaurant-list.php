<?php if(!empty($booking_date)){
    
    foreach($booking_date as $key => $date){
        $book_status = '';
        if(isset($booking_status[$key])){
            $book_status = $booking_status[$key];
        }
        if(!isset($booking_modified[$key])){
            $booking_modified[$key] = 'no';
        }
        ?>
<div class="availableItem <?php if($booking_modified[$key] == 'yes'){ echo 'modifyItem';}?> <?php if($booking_restid[$key] == '' || $book_status == 'cancel'){ echo 'skippedItem';}?>">
    <?php if($booking_restid[$key] != ''){
        
        ?>
            <?php 
            if($book_status != 'cancel'){
            $rest_id = $booking_restid[$key];
                $hotel = $this->user_model->get_restaurant_detail($rest_id);
                ?>
            <div class="restaurantImg">
            <?php if($hotel['feature_image'] != ''){?>
                <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $hotel['feature_image'];?>"
                    alt="">
                <?php } else{ ?>
                    <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg"
                    alt="">
                <?php } ?>
            </div>
            <div class="restaurantDetails confirmDetails">
                <div class="restaurantName">
                    <h5><?php echo $hotel['restaurant_name'];?></h5>
                </div>
                <div class="confirmDay"><i><img src="<?php echo base_url(); ?>/uploads/front/images/calendar_check_icon.svg"
                            alt=""></i><?php echo date('m-d-Y',strtotime($booking_date[$key]));?></div>
                <div class="confirmTimePeople">
                    <ul class="list-unstyled">
                        <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/table-icon.svg" alt=""></i>
                            <?php echo $booking_pax[$key];?>
                        </li>
                        <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/clock_time_icon.svg" alt=""></i>
                            <?php echo $booking_time[$key];?></li>
                        <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/city_building_icon.svg" alt=""></i>
                            <?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?> </li>
                    </ul>
                </div>
                <div class="modifyRestaurant">
                    <a href="javascript:void(0)" data-date="<?php echo date('d-m-Y',strtotime($booking_date[$key]));?>"
                        class="modify_back_btn btn">Modify</a>
                    <?php if($hotel['deposite'] == 'yes' && $hotel['deposite_amount'] > 0){?>
                    <div class="depositCharge">
                        <input type="checkbox" name="charge[]" class="charge" id="charge<?php echo $key;?>">
                        <label class="chargelabel" for="charge<?php echo $key;?>">I acknowledge the Late Cancel/No-Show Fee is $<?php echo round($hotel['deposite_amount']);?>
                        for this restaurant.</label>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php 
            }
            else{?>
                <div class="selectedRestaurant">
                    <div class="selectedContent">
                        <h5><u><?php echo $this->user_model->get_string_from_date(date('d-m-Y',strtotime($booking_date[$key])));?></u>
                            has been cancelled</h5>
                        <div class="buttonRow">
                            <a href="javascript:void(0)" data-date="<?php echo $booking_date[$key];?>"
                                class="modify_back_btn btn">Click here to book</a>
                        </div>
                    </div>
                </div>
            <?php }
    } else{ ?>
    <div class="selectedRestaurant">
        <div class="selectedContent">
            <h5><u><?php echo $this->user_model->get_string_from_date(date('d-m-Y',strtotime($booking_date[$key])));?></u>
                has been skipped</h5>
            <div class="buttonRow">
                <a href="javascript:void(0)" data-date="<?php echo $booking_date[$key];?>"
                    class="modify_back_btn btn">Click here to book</a>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php
    }
}?>