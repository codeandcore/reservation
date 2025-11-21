<?php
if(array_key_exists('trip_title',$this->settings) && $this->settings['trip_title'] != ''){ 
    $trip_title = $this->settings['trip_title'];
} else {
    $trip_title = 'Bahamas trip';
}
$today = date('Y-m-d h:m:s');
$modify_date = $this->settings['modify_end_date'];
$modify_time = $this->settings['modify_end_time'];
$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
?>
<main>
    <section class="banner"
        style="background-image: url(<?php echo base_url(); ?>/uploads/front/images/banner-bg.jpg);"></section>

    <section class="booking-section">
        <div class="container">
            <div style="display: none;">
                <?php
                    echo date_default_timezone_get();

                ?>
            </div>
            <div class="innerSearchForm text-center">
                <?php if(($today >= $booking_end)){?>
                    <h3>Welcome to the <?php echo $trip_title;?> restaurant reservation request portal. <br>
                    Please request your restaurant reservations below.</h3>
                <?php                     
                }
                else{?>
                <h3>Welcome to the <?php echo $trip_title;?> restaurant reservation request portal. <br>
                    You have already completed your reservation request(s).</h3>
                
                <div class="btn-grp text-center">
                    <a href="<?php echo site_url('reservation_confirmed');?>" title="" class="btn">
                        View Reservation Request
                    </a>
                    <a href="<?php echo site_url('modify_reservation');?>" title="" class="btn">
                        Modify Reservation Request
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php $booking_id = $booking['id'];
        $booking_list = $this->user_model->get_booking_datelist_byid($booking_id);
        $settings = $this->admin_model->theme_setting();
    ?>
    <?php if(!empty($booking_list)):?>
    <section class="relevantRestaurant">
        <div class="container">
            <div class="sliderTitle">
                <h2>Your Reservations</h2>

                <div class="swiper-buttons">
                    <div class="swiper-button-next"><img
                            src="<?php echo base_url(); ?>/uploads/front/images/right-line-arrow.svg" alt=""></div>
                    <div class="swiper-button-prev"><img
                            src="<?php echo base_url(); ?>/uploads/front/images/left-line-arrow.svg" alt=""></div>
                </div>
            </div>

            <div class="swiper booked-slider">
                <div class="swiper-wrapper">
                    <?php 
                    $dates = $this->user_model->get_dates_list_booking();
                    $i=1; foreach($dates as $date){
                        $user_id = $this->session->userdata('mes_user_id');
                        $list = $this->user_model->get_dates_list_booking_byuserid_date($user_id,$date['date']);
                        if(!empty($list)){
                            if($list['booking_status'] == 'booked'){
                                $hotel = $this->user_model->get_restaurant_detail($list['booking_restid']);
                    ?>
                            <div class="swiper-slide">
                                <div class="slideItem">
                                    <div class="comfirmedDetails">
                                        <h5><strong>Day <?php echo $i;?></strong>: <u>
                                                <?php echo date('M d, Y',strtotime($list['booking_date']));?></u></h5>
                                        <div class="finalTimePeople">
                                            <ul class="list-unstyled">
                                                <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/time-icon.svg"
                                                            alt=""></i> <?php echo $list['booking_time'];?></li>
                                                <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/food-icon.svg"
                                                            alt=""></i> Table for <?php echo $list['booking_pax'];?></li>
                                                <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/statistics-icon.svg"
                                                            alt=""></i>
                                                    <?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="reservationAddress">
                                            <div class="addressBox">
                                                <div class="hotelImg">
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
                                                <div class="hotelAddress">
                                                    <h6><?php echo $hotel['restaurant_name'];?></h6>
                                                        <?php if($settings['restaurant_address_hide'] != 'yes'):?>
                                                        <?php 
                                                        if($hotel['address']!=''){
                                                            ?>
                                                        <span class="addr"><i><img src="<?php echo base_url(); ?>/uploads/front/images/marker_icon.svg" alt=""></i>
                                                            <?php echo $hotel['address'];?></span>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php endif; ?>
                                                        <?php if($settings['restaurant_location_hide'] != 'yes'):?>
                                                            <?php
                                                            if($hotel['location_link']!=''){
                                                                ?>
                                                                <a href="<?php echo $hotel['location_link'];?>" class="btn" target="_blank"><i><img
                                                                    src="<?php echo base_url(); ?>/uploads/front/images/navigation-icon.svg" alt=""></i>
                                                            Get directions</a>
                                                                <?php
                                                            }
                                                            ?>
                                                        <?php endif; ?>
                                                  
                                                </div>
                                            </div>
                                            <?php 
                                                $user_id = $this->session->userdata('mes_user_id');
                                                $user_data = $this->user_model->get_user_detail_byuserid($user_id);
                                                ?>
                                            <div class="userDetailsBox">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <div class="detailLabel">Booking Role:</div>
                                                        <div class="detailInput"><?php if($list['ref_id'] == '0'){ echo 'Primary'; } else { echo 'Guest'; }?></div>
                                                    </li>
                                                    <?php if($list['ref_id'] > '0'){?>
                                                    <li>
                                                        <div class="detailLabel">Invited by:</div>
                                                        <div class="detailInput"><?php echo $this->user_model->get_hostname_byrefid($list['ref_id']);?></div>
                                                    </li>
                                                    <?php } ?>
                                                    <!-- <li>
                                                        <div class="detailLabel">Email:</div>
                                                        <div class="detailInput"><?php echo $user_data['email'];?></div>
                                                    </li>
                                                    <li>
                                                        <div class="detailLabel">Name:</div>
                                                        <div class="detailInput"><?php echo $user_data['full_name'];?></div>
                                                    </li>
                                                    <li>
                                                        <div class="detailLabel">User contact:</div>
                                                        <div class="detailInput"><?php echo $user_data['mobile_number'];?></div>
                                                    </li> -->
                                                    <?php if($settings['restaurant_email_hide'] != 'yes'):?>
                                                        <?php if($hotel['email']):?>
                                                        <li>
                                                            <div class="detailLabel">Restaurant email:</div>
                                                            <div class="detailInput"><?php echo $hotel['email'];?></div>
                                                        </li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if($settings['restaurant_contact_hide'] != 'yes'):?>
                                                    <!-- <li>
                                                        <div class="detailLabel">Restaurant contact:</div>
                                                        <div class="detailInput"><a href="tel:<?php echo preg_replace('/(\W*)/', '', $hotel['contact'] ); ?>"><?php echo $hotel['contact'];?></a></div>
                                                    </li> -->
                                                    <?php endif; ?>
                                                    <?php if($settings['restaurant_website_url_hide'] != 'yes'):?>
                                                    <li>
                                                        <div class="detailLabel">Restaurant Website:</div>
                                                        <div class="detailInput"><a href="<?php echo $hotel['website_link']; ?>" target="_blank">Click Here</a></div>
                                                    </li>
                                                    <?php endif; ?>
                                                    <?php if($settings['restaurant_fee_hide'] != 'yes'):?>
                                                    <li>
                                                        <div class="detailLabel">Late Cancel/No-Show Fee:</div>
                                                        <div class="detailInput">$<?php echo round($hotel['deposite_amount']);?>
                                                        </div>
                                                    </li>
                                                    <?php endif; ?>
                                                </ul>
                                                <?php if($today < $modify_date){?>
                                                <div>
                                                <?php if($list['ref_id'] == '0'){?>
                                                    <a href="<?php echo site_url('modify_reservation/?book_date='.date('d-m-Y',strtotime($list['booking_date'])));?>" class="btn sm-btn">Modify</a>
                                                <?php } ?>

                                                <?php
                                                        $today = date('Y-m-d');
                                                        $cancel_date = $this->settings['cancel_date'];
                                                        if($today <= $cancel_date){
                                                            ?>
                                                    <a href="#" data-listid="<?php echo $list['id'];?>" data-target="reservationCancel" class="btn modal-button cancel-reserved_btn sm-btn" data-hotelimg="<?php echo $feature_image;?>" data-restname="<?php echo $hotel['restaurant_name'];?>" data-date="<?php echo date('m-d-Y',strtotime($list['booking_date']));?>" data-time="<?php echo $list['booking_time'];?>" data-pax="<?php echo $list['booking_pax'];?>" data-type="<?php echo $this->user_model->get_property_type_text($hotel['property_type']);?>">Cancel</a>

                                                            <?php
                                                        }
                                                            ?>

                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php   }
                            else{?>
                            <div class="swiper-slide">
                                <div class="slideItem">
                                    <div class="comfirmedDetails skippedItem">
                                        <div class="selectedRestaurant">
                                            <div class="selectedContent">
                                                <h5><strong>Day <?php echo $i;?></strong>: <u><?php echo date('M d, Y',strtotime($list['booking_date']));?></u> has been <?php if($list['booking_status'] == 'skip'){ echo 'skipped';} else { echo 'cancelled';}?></h5>
                                                <div class="buttonRow">
                                                    <a href="<?php echo site_url('modify_reservation/?book_date='.date('d-m-Y',strtotime($list['booking_date'])));?>" class="btn" target="_blank">Click here to book</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php   }
                     } 
                    else{?>
                            <div class="swiper-slide">
                                <div class="slideItem">
                                    <div class="comfirmedDetails skippedItem">
                                        <div class="selectedRestaurant">
                                            <div class="selectedContent">
                                                <h5><strong>Day <?php echo $i;?></strong>: <u><?php echo date('M d, Y',strtotime($date['date']));?></u> has been skipped</h5>
                                                <div class="buttonRow">
                                                    <a href="<?php echo site_url('modify_reservation/?book_date='.date('d-m-Y',strtotime($date['date'])));?>" class="btn">Click here to book</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    $i++; }?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>