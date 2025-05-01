<div class="main-content">
    <div class="page-content add_reservation">
        <div class="container-fluid bg_dark-white">
            <div class="bg_white wrap_reservation">
                <div class="head_top_reservation">
                    <h2><?php echo $this->admin_model->get_user_name_byid($detail['user_id']);?> Reservation details
                    </h2>
                    <h3>Confirmation ID: <span>#<?php echo $detail['id'];?></span></h3>
                </div>
                <div class="wrap_reservation_list">
                    <?php if(!empty($list)):
                        foreach ($list as $key => $data) {
                                if($data['booking_status'] == 'booked' || $data['booking_status'] == 'cancel'){
                                $hotel = $this->admin_model->get_restaurant_detail($data['booking_restid']);
                                if($hotel['feature_image'] != ''){
                                    $feature_image = base_url().'/uploads/assets/images/'.$hotel['feature_image'];
                                }
                                else{
                                    $feature_image = base_url().'/uploads/front/images/no-image.jpg';
                                }
                        ?>
                    <div class="reservation_box <?php if($data['booking_status'] == 'cancel'){ echo 'cancel';}?>">
                        <div class="res_info">
                            <div class="res_img">
                                <?php if($hotel['feature_image'] != ''){?>
                                <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $hotel['feature_image'];?>"
                                    alt="">
                                <?php } else{ ?>
                                <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg" alt="">
                                <?php } ?>
                            </div>
                            <h4><?php echo $hotel['restaurant_name'];?></h4>
                            <?php 
                            if($restaurant_address_hide != 'yes'):
                                if($hotel['address']!=''){
                                    ?>
                                    <span class="location_pin">
                                        <img src="<?php echo base_url(); ?>/uploads/front/images/marker_icon.svg" alt=""></i>
                                        <?php echo $hotel['address'];?></span>
                                    </span>
                                    <?php
                                }
                            endif;
                                ?>
                            <?php if($settings['restaurant_website_url_hide'] != 'yes'):?>
                                <?php
                                if($hotel['location_link']!=''){
                                    ?>
                                <a href="<?php echo $hotel['location_link'];?>" class="get_direction_btn" target="_blank">
                                    <img src="<?php echo base_url(); ?>/uploads/front/images/navigation-icon.svg" alt="">
                                    Get directions
                                </a>
                                    <?php
                                }
                            endif;
                            ?>

                        </div>
                        <div class="res_details">
                            <div class="res_available">
                                <div class="res_available_box">
                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/date.svg" alt="">
                                    <span><?php echo date('D, M d, Y',strtotime($data['booking_date']));?></span>
                                </div>
                                <div class="res_available_box">
                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/time.svg" alt="">
                                    <span><?php echo $data['booking_time'];?></span>
                                </div>
                                <div class="res_available_box">
                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/table.svg" alt="">
                                    <span>Table for <?php echo $data['booking_pax'];?></span>
                                </div>
                                <div class="res_available_box">
                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/property_status.svg"
                                        alt="">
                                    <span>
                                        <?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?>
                                    </span>
                                </div>
                            </div>
                            <div class="res_person_info">
                                <div class="user_info_col">
                                    <?php $udata = $this->admin_model->get_user_detail($data['user_id']);?>
                                    <div class="user_info">
                                        <label>Name:</label>
                                        <span><?php echo $udata['full_name'];?></span>
                                    </div>
                                    <div class="user_info">
                                        <label>Email:</label>
                                        <span><?php echo $udata['email'];?></span>
                                    </div>
                                    <div class="user_info">
                                        <label>User contact:</label>
                                        <span><?php echo $udata['mobile_number'];?></span>
                                    </div>
                                    <?php if($settings['restaurant_email_hide'] != 'yes'):?>
                                        <?php if($hotel['email']):?>
                                        <div class="user_info">
                                            <label>Restaurant email: </label>
                                            <span><?php echo $hotel['email'];?></span>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if($hide_hotel_contact != 'yes') { ?>
                                    <div class="user_info">
                                        <label>Restaurant contact:</label>
                                        <span><?php echo $hotel['contact'];?></span>
                                    </div>
                                    <?php } ?>
                                    <?php if($restaurant_website_url_hide != 'yes') { ?>
                                    <div class="user_info">
                                        <label>Restaurant website url:</label>
                                        <span><a href="<?php echo $hotel['website_link'];?>" target="_blank">Click here</a></span>
                                    </div>
                                    <?php } ?>
                                    <?php if($restaurant_fee_hide != 'yes') { ?>
                                    <div class="user_info">
                                        <label>Late Cancel/No-Show Fee: </label>
                                        <span>$<?php echo $hotel['deposite_amount'];?></span>
                                    </div>
                                    <?php } ?>
                                    <?php if($data['admin_note'] != ''){
                                                ?>
                                    <div class="user_info">
                                        <label>Admin Note:</label>
                                        <span><?php echo $data['admin_note'];?></span>
                                    </div>
                                    <?php 
                                                    } 
                                                ?>
                                </div>
                                <?php /* $noty = $this->admin_model->get_notification_list_bookid($data['id']);
                                            if(!empty($noty)):
                                                foreach($noty as $usr){ 
                                                    $udata = $this->admin_model->get_user_detail($usr['to_id']);
                                                    if($usr['status'] == 'accept'){
                                                        $status = 'Accepted';
                                                    }
                                                    else{
                                                        $status = $usr['status'];
                                                    }
                                                ?>
                                <div class="user_info_col">
                                    <div class="user_info">
                                        <label>Invite person email:</label>
                                        <span><?php echo $udata['email'];?></span>
                                    </div>
                                    <div class="user_info">
                                        <label>Invite person name:</label>
                                        <span><?php echo $udata['full_name'];?></span>
                                    </div>
                                    <div class="user_info">
                                        <label>Invite person contact:</label>
                                        <span><?php echo $udata['mobile_number'];?></span>
                                    </div>
                                    <div class="user_info">
                                        <label>Status of invitation:</label>
                                        <span><?php echo ucfirst($status);?></span>
                                    </div>
                                </div>
                                <?php } endif; */ ?>
                                <?php if($data['booking_status'] == 'booked'){?>
                                <div class="inviteblock">
                                    <h6>Invite your colleagues to join you!</h6>
                                    <div class="personList">
                                        <ul class="list-unstyled">
                                            <?php 
                                        $user_id = $data['user_id'];
                                                        if($data['ref_id'] == '0'){
                                                            $guests = $data['guests'];
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
                                                            $ref_booking = $this->user_model->get_booking_date_detail($data['ref_id']); 
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
                                            <li <?php if($key == 0){ echo 'class="presentUser"';} ?>>
                                                <div class="personImg">
                                                    <?php echo strtoupper(mb_substr($usr_dtl['full_name'], 0, 1));?>
                                                    <?php if($key == 0){?>
                                                    <span class="starIcon"><img
                                                            src="<?php echo base_url(); ?>/uploads/front/images/star-icon.svg"
                                                            alt=""></span>
                                                    <?php } else{ ?>
                                                    <?php if($data['ref_id'] == '0'){ ?>
                                                    <span
                                                        class="starIcon cursor-pointer modal-button bg-danger remove_guest_btn tooltipBtn"
                                                        data-username="<?php echo $usr_dtl['full_name'];?>"
                                                        data-user_id="<?php echo $usr;?>"
                                                        data-listid="<?php echo $data['id'];?>"
                                                        data-popup="deleteInvite"><img
                                                            src="<?php echo base_url(); ?>/uploads/front/images/cross-white-icon.svg"
                                                            alt=""> <span class="tooltipText">Remove Guest</span>
                                                    </span>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <div class="personName">
                                                    <span><?php echo $usr_dtl['full_name'];?></span>
                                                    <small><?php if($key == 0){ echo 'Primary';} else{ echo 'Guest'; }?></small>
                                                </div>
                                            </li>
                                            <?php } 
                                                        endif;
                                                        ?>
                                            <?php if(count($guests) < 4 && $data['ref_id'] == '0'){?>
                                            <li class="addUser modal-button" data-target="inviteModal"
                                                data-booking_listid="<?php echo $data['id'];?>">
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
                                <?php } ?>
                            </div>

                            <div class="action">
                                <?php if($data['booking_status'] == 'cancel'){?>
                                <a href="<?php echo site_url('admin/modify_booking_detail/'.$data['id']);?>"
                                    class="btn">Modify</a>
                                <a href="javascript:void(0)" data-reason="<?php echo $data['booking_reason'];?>"
                                    class="cancel-txt-btn btn-red btn modal-button"
                                    data-popup="cancel_reason_popup">View Cancel Reason</a>
                                <?php }
                                            else{?>
                                <a href="<?php echo site_url('admin/modify_booking_detail/'.$data['id']);?>"
                                    class="btn">Modify</a>
                                <a href="javascript:void(0);" data-listid="<?php echo $data['id'];?>"
                                    data-popup="reservationCancel" class="cancel-reserved_btn btn modal-button"
                                    data-hotelimg="<?php echo $feature_image;?>"
                                    data-restname="<?php echo $hotel['restaurant_name'];?>"
                                    data-date="<?php echo date('m-d-Y',strtotime($data['booking_date']));?>"
                                    data-time="<?php echo $data['booking_time'];?>"
                                    data-pax="<?php echo $data['booking_pax'];?>"
                                    data-type="<?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?>">Cancel</a>
                                <?php } ?>
                                <a href="javascript:void(0);" data-listid="<?php echo $data['id'];?>"
                                    data-popup="adminNote" class="adminNote_btn btn modal-button">Admin Note</a>
                            </div>
                        </div>
                    </div>
                    <?php }
                        else{ ?>
                    <div class="reservation_box">
                        <div class="res_info">
                            <div class="res_img">
                                <img src="<?php echo base_url(); ?>/uploads/assets/images/no_resorunt.svg" alt="">
                            </div>
                        </div>
                        <div class="res_details">
                            <div class="res_available">
                                <div class="res_available_box">
                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/date.svg" alt="">
                                    <span><?php echo date('D, M d, Y',strtotime($data['booking_date']));?></span>
                                </div>
                            </div>
                            <div class="skip_day_wrap">
                                <h2>Skip day</h2>
                            </div>
                            <div class="action">
                                <p><strong>Reason: </strong><?php echo $data['booking_reason'];?></p>
                                <a href="<?php echo site_url('admin/modify_booking_detail/'.$data['id']);?>"
                                    class="btn">Modify</a>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    }  endif;?>
                </div>
            </div>
        </div>
    </div>
</div>