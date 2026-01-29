<?php $settings = $this->admin_model->theme_setting(); ?>
<main class="defaultTopPadding">
    <section class="comfirmedPages">
        <div class="container">
            <div class="pageTitle">
                <img src="<?php echo base_url(); ?>/uploads/front/images/circle-check.svg" alt="">
                <h2>Reservation Confirmed</h2>
                <span class="subTitle">You will receive an email with your reservation details.</span>
            </div>
            <div class="head_top_reservation">
                <h4><?php echo $this->user_model->get_user_name_byid($booking['user_id']); ?> Reservation details</h4>
                <h6>Confirmation ID: <span>#<?php echo $booking['id']; ?></span></h6>
            </div>
            <?php $booking_id = $booking['id'];
            // $booking_list = $this->user_model->get_booking_datelist_byid($booking_id);
            $booking_list = $this->admin_model->get_booking_dates_list($booking_id);
           
            ?>
            <div class="reservationComfirmed">
                <?php if (!empty($booking_list)): ?>
                    <div class="accordion">
                        <?php foreach ($booking_list as $list) {
                            if ($list['booking_restid'] != '') {
                                if ($list['booking_status'] == 'booked') {
                                    $hotel = $this->user_model->get_restaurant_detail($list['booking_restid']);
                        ?>
                                    <div class="accordionItem">
                                        <div class="toggle">
                                            <div class="comfirmedName"><?php echo $hotel['restaurant_name']; ?></div>
                                            <div class="comfirmedDay"><i><img
                                                        src="<?php echo base_url(); ?>/uploads/front/images/calendar_check_icon.svg"
                                                        alt=""></i> <?php echo date('D, M d, Y', strtotime($list['booking_date'])); ?>
                                            </div>
                                        </div>
                                        <div class="inner">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="comfirmedDetails">
                                                        <div class="finalTimePeople">
                                                            <ul class="list-unstyled">
                                                                <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/time-icon.svg"
                                                                            alt=""></i> <?php echo $list['booking_time']; ?></li>
                                                                <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/food-icon.svg"
                                                                            alt=""></i> Table for <?php echo $list['booking_pax']; ?></li>
                                                                <li><i><img src="<?php echo base_url(); ?>/uploads/front/images/statistics-icon.svg"
                                                                            alt=""></i>
                                                                    <?php echo $this->admin_model->get_property_type_text($hotel['property_type']); ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="reservationAddress">
                                                            <div class="addressBox">
                                                                <div class="hotelImg">
                                                                    <?php
                                                                    if ($hotel['feature_image'] != '') {
                                                                        $feature_image = base_url() . '/uploads/assets/images/' . $hotel['feature_image'];
                                                                    } else {
                                                                        $feature_image = base_url() . '/uploads/front/images/no-image.jpg';
                                                                    }
                                                                    if ($hotel['feature_image'] != '') { ?>
                                                                        <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $hotel['feature_image']; ?>"
                                                                            alt="">
                                                                    <?php } else { ?>
                                                                        <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg"
                                                                            alt="">
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="hotelAddress">
                                                                    <h6><?php echo $hotel['restaurant_name']; ?></h6>
                                                                    <?php if ($settings['restaurant_address_hide'] != 'yes'): ?>
                                                                        <?php
                                                                        if ($hotel['address'] != '') {
                                                                        ?>
                                                                            <span class="addr"><i><img
                                                                                        src="<?php echo base_url(); ?>/uploads/front/images/marker_icon.svg"
                                                                                        alt=""></i> <?php echo $hotel['address']; ?></span>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    <?php endif; ?>
                                                                    <?php if ($settings['restaurant_location_hide'] != 'yes'): ?>
                                                                        <?php
                                                                        if ($hotel['location_link'] != '') {
                                                                        ?>
                                                                            <a href="<?php echo $hotel['location_link']; ?>" class="btn"
                                                                                target="_blank"><i><img
                                                                                        src="<?php echo base_url(); ?>/uploads/front/images/navigation-icon.svg"
                                                                                        alt=""></i> Get directions</a>
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
                                                                <?php
                                                                if ($settings['restaurant_email_hide'] != 'yes' || $settings['restaurant_contact_hide'] != 'yes' || $settings['restaurant_website_url_hide'] != 'yes' || $settings['restaurant_fee_hide'] != 'yes'):
                                                                ?>
                                                                    <ul class="list-unstyled">
                                                                        <!-- <li>
                                                                    <div class="detailLabel">Email:</div>
                                                                    <div class="detailInput"><?php echo $user_data['email']; ?></div>
                                                                </li>
                                                                <li>
                                                                    <div class="detailLabel">Name:</div>
                                                                    <div class="detailInput"><?php echo $user_data['full_name']; ?>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="detailLabel">User contact:</div>
                                                                    <div class="detailInput">
                                                                        <?php echo $user_data['mobile_number']; ?></div>
                                                                </li> -->
                                                                        <?php if ($settings['restaurant_email_hide'] != 'yes'): ?>
                                                                            <?php if ($hotel['email']): ?>
                                                                                <li>
                                                                                    <div class="detailLabel">Restaurant email:</div>
                                                                                    <div class="detailInput"><?php echo $hotel['email']; ?></div>
                                                                                </li>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                        <?php if ($settings['restaurant_contact_hide'] != 'yes'): ?>
                                                                            <!-- <li>
                                                                                <div class="detailLabel">Restaurant contact:</div>
                                                                                <div class="detailInput"><a
                                                                                        href="tel:<?php echo preg_replace('/(\W*)/', '', $hotel['contact']); ?>"><?php echo $hotel['contact']; ?></a>
                                                                                </div>
                                                                            </li> -->
                                                                        <?php endif; ?>
                                                                        <?php if ($settings['restaurant_website_url_hide'] != 'yes'): ?>
                                                                            <li>
                                                                                <div class="detailLabel">Restaurant Website:</div>
                                                                                <div class="detailInput"><a href="<?php echo $hotel['website_link']; ?>" target="_blank">Click Here</a></div>
                                                                            </li>
                                                                        <?php endif; ?>
                                                                        <?php if ($settings['restaurant_fee_hide'] != 'yes'): ?>
                                                                            <li>
                                                                                <div class="detailLabel">Late Cancel/No-Show Fee:</div>
                                                                                <div class="detailInput">
                                                                                    $<?php echo round($hotel['deposite_amount']); ?></div>
                                                                            </li>
                                                                        <?php endif; ?>
                                                                    </ul>
                                                                <?php
                                                                endif;
                                                                ?>
                                                                <div>
                                                                    <a href="<?php echo site_url('modify_reservation/?book_date=' . date('d-m-Y', strtotime($list['booking_date'])) . '&book_time=' . $list['booking_time'] . '&book_persons=' . $list['booking_pax']); ?>"
                                                                        class="btn sm-btn">Modify</a>
                                                                    <?php
                                                                    $today = date('Y-m-d');
                                                                    $cancel_date = $this->settings['cancel_date'];
                                                                    if ($today <= $cancel_date) {
                                                                    ?>
                                                                        <a href="#" data-listid="<?php echo $list['id']; ?>"
                                                                            data-target="reservationCancel"
                                                                            class="btn modal-button cancel-reserved_btn sm-btn"
                                                                            data-hotelimg="<?php echo $feature_image; ?>"
                                                                            data-restname="<?php echo $hotel['restaurant_name']; ?>"
                                                                            data-date="<?php echo date('m-d-Y', strtotime($list['booking_date'])); ?>"
                                                                            data-time="<?php echo $list['booking_time']; ?>"
                                                                            data-pax="<?php echo $list['booking_pax']; ?>"
                                                                            data-type="<?php echo $this->user_model->get_property_type_text($hotel['property_type']); ?>">Cancel</a>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="inviteblock">
                                                        <?php if ($list['ref_id'] == '0') { ?>
                                                            <h6>Invite your colleagues to join you!</h6>
                                                        <?php } ?>
                                                        <div class="personList">
                                                            <ul class="list-unstyled">
                                                                <?php
                                                                if ($list['ref_id'] == '0') {
                                                                    $guests = $list['guests'];
                                                                    if ($guests != '') {
                                                                        $exp = explode(',', $guests);
                                                                        array_unshift($exp, $user_id);
                                                                        $guests = $exp;
                                                                    } else {
                                                                        $guests = array($user_id);
                                                                    }

                                                                    $main_user_id = $user_id;
                                                                } else {
                                                                    $ref_booking = $this->user_model->get_booking_date_detail($list['ref_id']);
                                                                    $main_user_id = $ref_booking['user_id'];
                                                                    $guests = $ref_booking['guests'];
                                                                    if ($guests != '') {
                                                                        $exp = explode(',', $guests);
                                                                        array_unshift($exp, $main_user_id);
                                                                        $guests = $exp;
                                                                    } else {
                                                                        $guests = array($main_user_id);
                                                                    }
                                                                }
                                                                if (!empty($guests)):
                                                                    // echo($list['id'].'--'.$list['user_id']); 
                                                                    // echo('<pre>');
                                                                    // print_r($list);
                                                                    // echo('</pre>');


                                                                    foreach ($guests as $key => $usr) {
                                                                        $usr_dtl = $this->user_model->get_user_detail_byuserid($usr);
                                                                ?>
                                                                        <li <?php if ($key == 0) {
                                                                                echo 'class="presentUser"';
                                                                            } ?>>
                                                                            <div class="personImg">
                                                                                <?php echo strtoupper(mb_substr($usr_dtl['full_name'], 0, 1)); ?>
                                                                                <?php if ($key == 0) { ?>
                                                                                    <span class="starIcon"><img
                                                                                            src="<?php echo base_url(); ?>/uploads/front/images/star-icon.svg"
                                                                                            alt=""></span>
                                                                                <?php } else { ?>
                                                                                    <?php if ($list['ref_id'] == '0') { ?>
                                                                                        <!-- <span
                                                                                            class="starIcon cursor-pointer modal-button bg-danger remove_guest_btn tooltipBtn"
                                                                                            data-username="<?php //echo $usr_dtl['full_name']; ?>"
                                                                                            data-user_id="<?php //echo $usr; ?>"
                                                                                            data-listid="<?php //echo $list['id']; ?>"
                                                                                            data-target="deleteInvite"><img
                                                                                                src="<?php //echo base_url(); ?>/uploads/front/images/cross-white-icon.svg"
                                                                                                alt=""> <span class="tooltipText">Remove Guest</span>
                                                                                        </span> -->
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </div>
                                                                            <div class="personName">
                                                                                <span><?php echo $usr_dtl['full_name']; ?></span>
                                                                                <small><?php if ($key == 0) {
                                                                                            echo 'Primary';
                                                                                        } else {
                                                                                            echo 'Guest';
                                                                                        } ?></small>
                                                                                        <?php //if ($key != 0 && $user_id != $usr) { ?>
                                                                                        <?php if ($key != 0 && $main_user_id == $user_id) { ?>
                                                                                        <small class="text-danger cursor-pointer modal-button removeConfirmedGuest remove_guest_btn"
                                                                                        data-username="<?php echo $usr_dtl['full_name']; ?>"
                                                                                            data-user_id="<?php echo($usr); ?>"
                                                                                            data-listid="<?php echo $list['id']; ?>"
                                                                                            data-target="deleteInvite">Remove Guest</small>
                                                                                    <?php } ?>
                                                                            </div>
                                                                        </li>
                                                                <?php }

                                                                    $pendingInvites = $this->user_model->get_pending_invites_by_booking_and_organiser_id($list['id'], $list['user_id']);
                                                                    // echo('<pre>');
                                                                    // print_r($pendingInvites);
                                                                    // echo('</pre>');
                                                                    /**Pending invites */
                                                                    foreach ($pendingInvites as $usrs) {
                                                                        $usr_dtl = $this->user_model->get_user_detail_byuserid($usrs['to_id']);
                                                                ?>
                                                                        <li>
                                                                            <div class="personImg">
                                                                                <?php echo strtoupper(mb_substr($usr_dtl['full_name'], 0, 1)); ?>
                                                                              
                                                                                        <!-- <span
                                                                                            class="starIcon cursor-pointer modal-button bg-danger remove_guest_btn tooltipBtn"
                                                                                            data-username="<?php //echo $usr_dtl['full_name']; ?>"
                                                                                            data-user_id="<?php //echo($usrs['to_id']); ?>"
                                                                                            data-listid="<?php //echo $list['id']; ?>"
                                                                                            data-target="deleteInvite"><img
                                                                                                src="<?php //echo base_url(); ?>/uploads/front/images/cross-white-icon.svg"
                                                                                                alt=""> <span class="tooltipText">Remove Guest</span>
                                                                                        </span> -->
                                                                                
                                                                            </div>
                                                                            <div class="personName">
                                                                                <span><?php echo $usr_dtl['full_name']; ?></span>
                                                                                <small>Guest</small>
                                                                                <small class="text-warning">(Not accepted yet)</small>
                                                                                <!-- <small class="text-danger cursor-pointer modal-button invitation_decline_btn"
                                                                                data-username="<?php //echo $usr_dtl['full_name']; ?>"
                                                                                            data-user_id="<?php //echo($usrs['to_id']); ?>"
                                                                                            data-listid="<?php //echo $list['id']; ?>"
                                                                                            data-target="canclePendingInvite"
                                                                                            data-invite-id="<?php //echo($usrs['id']); ?>">Cancel invitation</small> -->
                                                                                <small class="text-danger cursor-pointer modal-button invitation_decline_btn"
                                                                                data-username="<?php echo $usr_dtl['full_name']; ?>"
                                                                                            data-user_id="<?php echo($usrs['to_id']); ?>"
                                                                                            data-listid="<?php echo $list['id']; ?>"
                                                                                            data-target="cancleInvite"
                                                                                            data-invite-id="<?php echo($usrs['id']); ?>">Cancel invitation</small>
                                                                            </div>
                                                                        </li>
                                                                <?php }


                                                                endif;
                                                                ?>
                                                                <?php if (count($guests) < 4 && $list['ref_id'] == '0') { ?>
                                                                    <li class="addUser modal-button" data-target="inviteModal"
                                                                        data-booking_listid="<?php echo $list['id']; ?>">
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
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="accordionItem <?php echo $list['booking_status']; ?>">
                                        <div class="toggle">
                                            <div class="comfirmedName">
                                                <?php echo $this->user_model->get_string_from_date($list['booking_date']); ?> has been
                                                cancelled <a
                                                    href="<?php echo site_url('modify_reservation/?book_date=' . date('d-m-Y', strtotime($list['booking_date']))); ?>">Click
                                                    here
                                                    to book</a></div>
                                            <div class="comfirmedDay"><i><img
                                                        src="<?php echo base_url(); ?>/uploads/front/images/calendar_check_icon.svg"
                                                        alt=""></i> <?php echo date('D, M d, Y', strtotime($list['booking_date'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="accordionItem <?php echo $list['booking_status']; ?>">
                                    <div class="toggle">
                                        <div class="comfirmedName">
                                            <?php echo $this->user_model->get_string_from_date($list['booking_date']); ?> has been
                                            skipped <a
                                                href="<?php echo site_url('modify_reservation/?book_date=' . date('d-m-Y', strtotime($list['booking_date']))); ?>">Click
                                                here
                                                to book</a></div>
                                        <div class="comfirmedDay"><i><img
                                                    src="<?php echo base_url(); ?>/uploads/front/images/calendar_check_icon.svg"
                                                    alt=""></i> <?php echo date('D, M d, Y', strtotime($list['booking_date'])); ?>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                <?php endif; ?>
                <div class="text-center pageLastButton">
                    <a href="<?php echo base_url(); ?>" class="btn">Back To Home</a>
                </div>
            </div>
        </div>
    </section>
</main>