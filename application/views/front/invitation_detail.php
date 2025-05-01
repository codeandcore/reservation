<?php $settings = $this->admin_model->theme_setting();?>
<main class="defaultTopPadding">
    <section class="comfirmedPages">
        <div class="container">
            <div class="pageTitle">
                <img src="<?php echo base_url(); ?>/uploads/front/images/invited_icon.svg" alt="">
                <h2><?php echo $this->user_model->get_hostname_byrefid($invite['booking_list_id']);?>`S INVITATION</h2>
                
            </div>
            
            <div class="invitationDetails">
                <?php if(!empty($booking)):?>
                    <?php
                        if($booking['booking_restid'] != ''){
                            $hotel = $this->user_model->get_restaurant_detail($booking['booking_restid']);
                        ?>
                        <div class="comfirmedDetails">
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
                                </div>

                                <?php 
                                    $user_id = $this->session->userdata('mes_user_id');
                                    $user_data = $this->user_model->get_user_detail_byuserid($user_id);
                                ?>
                                <div class="userDetailsBox">
                                    <h3><?php echo $hotel['restaurant_name'];?></h3>

                                    <div class="comfirmedDay"><i><img src="<?php echo base_url();?>/uploads/front/images/calendar_check_icon.svg" alt=""></i> <?php echo date('D,M d, Y',strtotime($booking['booking_date']));?> </div>

                                    <div class="finalTimePeople">
                                        <ul class="list-unstyled">
                                            <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/clock_time_icon.svg"
                                                        alt=""></i> <?php echo $booking['booking_time'];?></li>
                                            <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/table-icon_2.svg"
                                                        alt=""></i> Table for <?php echo $booking['booking_pax'];?></li>
                                            <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/city_building_icon.svg"
                                                        alt=""></i>
                                                <?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php if($settings['restaurant_address_hide'] != 'yes'):?>
                                        <?php
                                        if($hotel['address']!=''){
                                            ?>
                                        <span class="addr" style="display:none;"><i><img src="<?php echo base_url();?>/uploads/front/images/marker_icon2.svg" alt=""></i> <?php echo $hotel['address'];?></span>
                                            <?php
                                        }
                                        ?>
                                    <?php endif; ?>
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="detailLabel">Name:</div>
                                            <div class="detailInput"><?php echo $user_data['full_name'];?>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detailLabel">Email:</div>
                                            <div class="detailInput"><?php echo $user_data['email'];?></div>
                                        </li>
                                        <li style="display:none;">
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
                                        <li>
                                            <div class="detailLabel">Restaurant contact:</div>
                                            <div class="detailInput"><a href="tel:<?php echo preg_replace('/(\W*)/', '', $hotel['contact'] ); ?>"><?php echo $hotel['contact'];?></a></div>
                                        </li>
                                        <?php endif; ?>
                                        <?php if($settings['restaurant_website_url_hide'] != 'yes'):?>
                                        <li>
                                            <div class="detailLabel">Restaurant Website:</div>
                                            <div class="detailInput"><a href="<?php echo $hotel['website_link']; ?>" target="_blank">Click Here</a></div>
                                        </li>
                                        <?php endif; ?>
                                        <?php if($settings['restaurant_fee_hide'] != 'yes'):?>
                                        <li style="display:none;">
                                            <div class="detailLabel">Late Cancel/No-Show Fee:</div>
                                            <div class="detailInput">
                                                $<?php echo round($hotel['deposite_amount']);?></div>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                    <div class="btn_group">
                                        <a href="javascript:void(0);" class="invitation_approve_btn btn" data-invite-id="<?php echo $invite_id;?>" data-status="accept"><img src="<?php echo base_url();?>/uploads/front/images/white-check-icon.svg" alt=""> Accept</a>
                                        <a href="javascript:void(0);" class="invitation_decline_btn btn modal-button" data-target="invitationDecline" data-invite-id="<?php echo $invite_id;?>" data-status="decline"><img src="<?php echo base_url();?>/uploads/front/images/white-cross-icon.svg" alt=""> Decline</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php endif; ?>
                <p class="error error-text" id="invite_submit_error_text"></p>
                <div class="text-center pageLastButton">
                    <a href="<?php echo base_url();?>" class="btn">Back To Home</a>
                </div>
            </div>
        </div>
    </section>
</main>