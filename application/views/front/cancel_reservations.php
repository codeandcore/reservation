<?php $settings = $this->admin_model->theme_setting();?>
<main class="defaultTopPadding">
    <section class="comfirmedPages">
        <div class="container">
            <div class="pageTitle">
                <img src="<?php echo base_url(); ?>/uploads/front/images/cancel-title-icon.svg" alt="">
                <h2>Reservation Cancelled</h2>
            </div>
            <div class="reservationCancelled">
                <?php if(!empty($cancel_list)):?>
                    <?php foreach($cancel_list as $list){
                        if($list['booking_restid'] != ''){
                            $hotel = $this->user_model->get_restaurant_detail($list['booking_restid']);
                            ?>
                            <div class="row disabled cancelled">
                                <div class="col-6">
                                    <div class="comfirmedDetails">
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
                                                <?php if($hotel['feature_image'] != ''){?>
                                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $hotel['feature_image'];?>"
                                                        alt="">
                                                    <?php } else{ ?>
                                                        <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg"
                                                        alt="">
                                                    <?php } ?>
                                                </div>
                                                <?php if($settings['restaurant_address_hide'] != 'yes'):?>
                                                    <div class="hotelAddress">
                                                        <h6><?php echo $hotel['restaurant_name'];?></h6>
                                                    
                                                            <?php 
                                                            if($hotel['address']!=''){
                                                                ?>
                                                            <span class="addr"><i><img
                                                                        src="<?php echo base_url(); ?>/uploads/front/images/marker_icon.svg"
                                                                        alt=""></i> <?php echo $hotel['address'];?></span>
                                                                <?php
                                                            }
                                                            ?>
                                                    
                                                        <!-- <a href="javascript:void(0);" class="btn"
                                                            target="_blank"><i><img
                                                                    src="<?php //echo base_url(); ?>/uploads/front/images/navigation-icon.svg"
                                                                    alt=""></i> Get directions</a> -->
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php 
                                                    $user_id = $this->session->userdata('mes_user_id');
                                                    $user_data = $this->user_model->get_user_detail_byuserid($user_id);
                                                    ?>
                                            <div class="userDetailsBox">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <div class="detailLabel">Email:</div>
                                                        <div class="detailInput"><?php echo $user_data['email'];?></div>
                                                    </li>
                                                    <li>
                                                        <div class="detailLabel">Name:</div>
                                                        <div class="detailInput"><?php echo $user_data['full_name'];?>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="detailLabel">User contact:</div>
                                                        <div class="detailInput"><a href="tel:+tel:<?php echo preg_replace('/(\W*)/', '', $user_data['mobile_number'] ); ?>"><?php echo $user_data['mobile_number'];?></a></div>
                                                    </li>
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
                                                        <div class="detailInput">
                                                            $<?php echo round($hotel['deposite_amount']);?></div>
                                                    </li>
                                                    <?php endif; ?>
                                                </ul>
                                                <div>
                                                    <a href="javascript:void(0);" class="btn sm-btn">Modify</a>
                                                    <a href="javascript:void(0);" class="btn modal-button sm-btn">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="inviteblock">
                                        <h6>Invite your colleagues to join you!</h6>
                                        <div class="personList">
                                            <ul class="list-unstyled">
                                                <?php 
                                                if($list['ref_id'] == '0'){
                                                    $guests = $list['guests'];
                                                    if($guests != ''){
                                                        $exp = explode(',',$guests);
                                                        array_unshift($exp,$user_id);
                                                        $guests = $exp;
                                                    }
                                                    else{
                                                        $guests = array($user_id);
                                                    }
                                                }
                                                else{
                                                    $ref_booking = $this->user_model->get_booking_date_detail($list['ref_id']); 
                                                    $main_user_id = $ref_booking['user_id'];
                                                    $guests = $ref_booking['guests'];
                                                    if($guests != ''){
                                                        $exp = explode(',',$guests);
                                                        array_unshift($exp,$main_user_id);
                                                        $guests = $exp;
                                                    }
                                                    else{
                                                        $guests = array($main_user_id);
                                                    }
                                                }
                                                if(!empty($guests)):
                                                foreach($guests as $key => $usr){
                                                    $usr_dtl = $this->user_model->get_user_detail_byuserid($usr);
                                                    ?>
                                                <li <?php if($key == 0){ echo 'class="presentUser"';}?>>
                                                    <div class="personImg"><?php echo strtoupper(mb_substr($usr_dtl['full_name'], 0, 1));?> <?php if($key == 0){?><span class="starIcon"><img
                                                                src="<?php echo base_url(); ?>/uploads/front/images/star-icon.svg"
                                                                alt=""></span><?php } ?></div>
                                                    <div class="personName">
                                                        <span><?php echo $usr_dtl['full_name'];?></span>
                                                        <small><?php if($key == 0){ echo 'Primary';} else{ echo 'Guest'; }?></small>
                                                    </div>
                                                </li>
                                                <?php } 
                                                endif;
                                                ?>
                                                <?php if(count($guests) < 4 && $list['ref_id'] == '0'){?>
                                                <li class="addUser modal-button">
                                                    <div class="personImg">+</div>
                                                    <div class="personName">
                                                        <span></span>
                                                        <small></small>
                                                    </div>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php } 
                        else{?>
                    <div class="toggle">
                        <div class="comfirmedName">
                            <?php echo $this->user_model->get_string_from_date($list['booking_date']);?> has been
                            skipped <a href="#">Click here
                                to book</a></div>
                        <div class="comfirmedDay"><i><img
                                    src="<?php echo base_url(); ?>/uploads/front/images/calendar_check_icon.svg"
                                    alt=""></i> <?php echo date('D, M d, Y',strtotime($list['booking_date']));?>
                        </div>
                    </div>
                    <?php }
                    } ?>
                <?php endif; ?>
                <div class="text-center pageLastButton">
                    <a href="<?php echo base_url();?>" class="btn">Back To Home</a>
                </div>
            </div>
        </div>
    </section>
</main>