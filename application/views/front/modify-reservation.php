<?php
$selected_date = '';
$selected_time = '';
$selected_pax = '';
if (!empty($booked_list)) {
    foreach ($booked_list as $list) {
        if ($list['booking_status'] == 'booked') {
            $selected_date = date('d-m-Y', strtotime($list['booking_date']));
            //Uncommented below line to resoulve modify reservation time next by cancel button on Restarant Box
            $selected_time = $list['booking_time'];
            //END

            $selected_pax = $list['booking_pax'];
            break;
        }
    }
}
if ($this->input->get('book_date')) {
    $selected_date = $this->input->get('book_date');
}
if ($this->input->get('book_time')) {
    $selected_time = $this->input->get('book_time');
}
if ($this->input->get('book_persons')) {
    $selected_pax = $this->input->get('book_persons');
}

?>
<main class="no-overflow-hidden">
    <section class="banner" style="background-image: url(<?php echo base_url(); ?>/uploads/front/images//banner-bg.jpg);">
        <div class="bannerContent">
            <div class="container">
                <div class="bannerTitle">
                    <h2><i><img src="<?php echo base_url(); ?>/uploads/front/images/editPen_icon.svg" alt=""></i> Modify reservation</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="booking-section">
        <div class="container">
            <div class="innerSearchForm">
                <form action="<?php echo site_url('reservation'); ?>" id="reservation_page_search_form"
                    class="bookingForm">
                    <input type="hidden" name="querytype" class="input_booking_timesa" value="modify">
                    <div class="row">
                        <div class="col">
                            <div class="findInput dateInput">
                                <label class="inputlabel" for="">Select Date</label>
                                <select name="book_date" id="book_date" class="form-control cmnSelect">
                                    <?php $dt = 1;
                                    foreach ($dates_list as $list) {
                                        if ($dt == 1 && $selected_date == '') {
                                            $selected_date = date('d-m-Y', strtotime($list['date']));
                                        } ?>
                                        <option value="<?php echo date('d-m-Y', strtotime($list['date'])); ?>"
                                            <?php if ($selected_date == date('d-m-Y', strtotime($list['date']))) {
                                                echo 'selected';
                                            } ?>>
                                            <?php echo date('m-d-Y', strtotime($list['date'])); ?></option>
                                    <?php $dt++;
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="findInput timeInput">
                                <label class="inputlabel" for="">Select Time</label>
                                <select name="book_time" id="book_time" class="form-control cmnSelect">
                                    <option value="" <?php if ($selected_time == '') {
                                                            echo 'selected';
                                                        } ?>>Any Time
                                    </option>
                                    <?php $dt = 1;
                                    foreach ($time_list as $list) { ?>
                                        <option value="<?php echo $list['time']; ?>"
                                            <?php if ($selected_time == $list['time']) {
                                                echo 'selected';
                                            } ?>>
                                            <?php echo $list['time']; ?></option>
                                    <?php $dt++;
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="findInput personInput">
                                <label class="inputlabel" for="">Select People</label>
                                <select name="book_persons" id="book_persons" class="form-control cmnSelect">
                                    <?php $dt = 1;
                                    foreach ($pax_list as $list) {
                                        if ($dt == 1 && $selected_pax == '') {
                                            $selected_pax = $list['size'];
                                        } ?>
                                        <option value="<?php echo $list['size']; ?>"
                                            <?php if ($selected_pax == $list['size']) {
                                                echo 'selected';
                                            } ?>>
                                            <?php echo $list['size']; ?> People
                                        </option>
                                    <?php $dt++;
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn" data-target="findRestro">Reserve</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <form action="" method="post" id="modify_restaurant_booking_final">
        <input type="hidden" name="querytype" class="input_booking_timesa" value="modify">
        <section class="availableBooking">
            <div class="container">
                <div class="availableProgress">

                    <div class="topTitleRow">
                        <div class="titleText">
                            <h4>Available Restaurants for <span
                                    id="selected_date_string"><?php echo $this->user_model->get_string_from_date($selected_date); ?></span>
                            </h4>
                            <p>You can skip today's reservation and still continue with other reservations.</p>
                        </div>
                        <div class="skipButton">
                            <!-- <a href="#" class="btn modal-button" data-target="skipDay">Skip booking for this day</a> -->
                            <a href="javascript:void();" class="btn ">Skip booking for this day</a>
                            <input type="hidden" name="booking_id" value="<?php echo $booking_detail['id']; ?>">
                        </div>
                    </div>

                    <div class="availableStep">
                        <div  class="available-paragraph">
                            
                            <ul class="availableDayList list-unstyled">
                            <?php $dt = 1;
                            foreach ($dates_list as $list) {
                                $final_booking_date = '';
                                $final_booking_time = '';
                                $final_booking_pax = '';
                                $final_booking_restid = '';
                                $final_booking_reason = '';
                                $final_booking_deposite = '';
                                $final_booking_status = '';
                                foreach ($booked_list as $bklist) {
                                    if ($list['date'] == $bklist['booking_date']) {
                                        $final_booking_date = $bklist['booking_date'];
                                        $final_booking_time = $bklist['booking_time'];
                                        $final_booking_pax = $bklist['booking_pax'];
                                        $final_booking_restid = $bklist['booking_restid'];
                                        $final_booking_reason = $bklist['booking_reason'];
                                        $final_booking_deposite = $bklist['booking_deposite'];
                                        $final_booking_status = $bklist['booking_status'];
                                    }
                                }
                            ?>
                                <li class="availableDay <?php
                                 if ($final_booking_status == 'booked') {
                                            echo ' completed';
                                        } else if ($final_booking_status == 'skip') {
                                            echo ' skipDay';
                                        } else if ($final_booking_status == 'cancel') {
                                            echo ' cancelDay';
                                        } 
                                        if ($selected_date == date('d-m-Y', strtotime($list['date']))) {echo ' active';} 
                                        
                                        ?>"
                                    data-step="step-<?php echo $dt; ?>" data-time="<?php echo $selected_time; ?>"
                                    data-person="<?php echo $selected_pax; ?>"
                                    data-datetext="<?php echo $this->user_model->get_string_from_date($list['date']); ?>"
                                    data-date="<?php echo date('d-m-Y', strtotime($list['date'])); ?>">
                                    <input type="hidden" name="booking_date[]" class="input_booking_date"
                                        value="<?php echo date('d-m-Y', strtotime($list['date'])); ?>">
                                    <input type="hidden" name="booking_time[]" class="input_booking_time"
                                        value="<?php echo $final_booking_time; ?>">
                                    <input type="hidden" name="booking_pax[]" class="input_booking_pax"
                                        value="<?php echo $final_booking_pax; ?>">
                                    <input type="hidden" name="booking_restid[]" class="input_booking_restid"
                                        value="<?php echo $final_booking_restid; ?>">
                                    <input type="hidden" name="booking_reason[]" class="input_booking_reason"
                                        value="<?php echo $final_booking_reason; ?>">
                                    <input type="hidden" name="booking_deposite[]" class="input_booking_deposite"
                                        value="<?php echo $final_booking_deposite; ?>">
                                    <input type="hidden" name="booking_status[]" class="input_booking_status"
                                        value="<?php echo $final_booking_status; ?>">
                                    <input type="hidden" name="booking_modified[]" class="input_booking_modified"
                                        value="no">
                                    <div class="availablItem">
                                        <div class="restauranDayBlock">
                                            <div class="restauranIcon">
                                                <img src="<?php echo base_url(); ?>/uploads/front/images/restaurant-icon.svg"
                                                    alt="">
                                                <span class="badgeIcon"></span>
                                                <span class="skipCommment">You haven`t reserved any restaurants for
                                                    <?php echo $this->user_model->get_string_from_date(date('d-m-Y', strtotime($list['date']))); ?></span>
                                            </div>
                                        </div>
                                        <div class="availableDayText">
                                            <h5><?php echo date('M d', strtotime($list['date'])); ?></h5>

                                            <span class="dayStatusText">
                                                <span class="applyReserved">Reserved</span>
                                                <span class="skippedDay">Skipped day</span>
                                                <span class="notReserved">Not reserved</span>
                                                <span class="cancelledDay">Cancelled Day</span>
                                            </span>
                                        </div>

                                    </div>
                                </li>
                            <?php $dt++;
                            } ?>
                            <li class="availableDay confirmStep" data-step="step-<?php echo $dt; ?>">
                                <div class="availablItem">
                                    <div class="restauranDayBlock">
                                        <div class="restauranIcon">
                                            <img src="<?php echo base_url(); ?>/uploads/front/images/confirm-icon.svg" alt="">
                                        </div>
                                    </div>
                                    <div class="availableDayText">
                                        <h5>Confirm</h5>
                                        <span>Reservations</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        </div>
                       
                    </div>

                    <div class="availableRestaurant availableStepListing">
                        <div class="innerLoader">
                            <div class="loaderBox"></div>
                        </div>
                        <div class="row">
                            <?php 
                            $hide_filter = false;
                                if($this->settings['on_property_hide'] == 'yes' || $this->settings['off_property_hide'] == 'yes'){
                                    if (empty($filters)){
                                        $hide_filter = true;
                                    }
                                    else{
                                        foreach ($filters as $key => $filter) {
                                            $slug = $filter['filter_name'];
                                            if ($slug == 'establishment_type' && $this->settings['restaurant_establishment_hide'] == 'yes') {
                                                $hide_filter = true;
                                            }
                                            else if ($slug == 'meals' && $this->settings['restaurant_meals_hide'] == 'yes') {
                                                $hide_filter = true;
                                            }
                                            else if ($slug == 'fee' && $this->settings['restaurant_fee_hide'] == 'yes') {
                                                $hide_filter = true;
                                            }
                                            else{
                                                $hide_filter = false;
                                            }
                                        }
                                    }
                                }
                            ?>
                            <div class="col-4 filterApply" <?php if($hide_filter){?>style="display:none;"<?php }?>>
                                <span class="filterIcon">
                                    <img src="<?php echo base_url(); ?>/uploads/front/images/filter_icon.svg" alt="">
                                </span>
                                <div class="filterBlock">
                                    <div class="filterTitle">
                                        <div class="filterTitleText">
                                            <h5>Filter</h5>
                                        </div>
                                        <div class="filterButtons">
                                            <a href="javascript:void(0);" class="btn filterBtn">Apply Filter</a>
                                            <a href="javascript:void(0);" class="clear_filter_btn">Clear all</a>
                                        </div>
                                    </div>
                                    <div class="filterList">
                                        <div class="filterItem">
                                            <div class="filterItemTitle">Property type</div>
                                            <div class="filterItemList">
                                                <div class="custom-radio">
                                                    <input type="radio" id="property_type_radio1" name="property_type"
                                                        class="radioInput" value="" checked>
                                                    <label class="radioLabel" for="property_type_radio1">All
                                                        Restaurants</label>
                                                </div>
                                                <?php if($this->settings['on_property_hide'] != 'yes'){?>
                                                <div class="custom-radio">
                                                    <input type="radio" id="property_type_radio2" name="property_type"
                                                        value="on" class="radioInput">
                                                    <label class="radioLabel" for="property_type_radio2">On - Property
                                                        Restaurant</label>
                                                </div>
                                                <?php } ?>
                                                <?php if($this->settings['off_property_hide'] != 'yes'){?>
                                                <div class="custom-radio">
                                                    <input type="radio" id="property_type_radio3" name="property_type"
                                                        value="off" class="radioInput">
                                                    <label class="radioLabel" for="property_type_radio3">Off - Property
                                                        Restaurant</label>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($filters)):
                                            foreach ($filters as $key => $filter) {
                                                $slug = $filter['filter_name'];
                                                $value = $filter['filter_value'];
                                                $explode = explode(',', $value);
                                                $title = str_replace('_', ' ', $slug);
                                                $title = str_replace('-', ' ', $title);
                                                if ($slug == 'establishment_type' && $this->settings['restaurant_establishment_hide'] == 'yes') {
                                                    continue;
                                                }
                                                if ($slug == 'meals' && $this->settings['restaurant_meals_hide'] == 'yes') {
                                                    continue;
                                                }
                                                if ($slug == 'fee' && $this->settings['restaurant_fee_hide'] == 'yes') {
                                                    continue;
                                                }
                                        ?>
                                                <div class="filterItem">
                                                    <div class="filterItemTitle"><?php echo ucfirst($title); ?></div>
                                                    <div class="filterItemList">
                                                        <?php if (!empty($explode)):
                                                            $vl = 1;
                                                            foreach ($explode as $key => $val) {
                                                        ?>
                                                                <div class="custom-checkbox" data-type="<?php echo $slug; ?>">
                                                                    <input type="checkbox" class="checkboxInput"
                                                                        name="filter[<?php echo $slug; ?>]" id="<?php echo $slug . $vl; ?>"
                                                                        value="<?php echo $val; ?>">
                                                                    <label class="checkboxLabel"
                                                                        for="<?php echo $slug . $vl; ?>"><?php echo $val; ?></label>
                                                                </div>

                                                        <?php $vl++;
                                                            }
                                                        endif; ?>
                                                    </div>
                                                </div>
                                        <?php }
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="<?php if($hide_filter){ echo "col-12"; } else{ echo "col-8";} ?> availableCol">
                                <div class="inner-time-and-people-section">
                                    <!-- <h3>Select time Select people</h3> -->
                                    <div class="d-flex wrap-time-people">
                                        <div class="findInput timeInput">
                                            <label class="inputlabel" for="">Select Time</label>
                                            <select name="book_time_inner" id="book_time_inner" class="form-control cmnSelect">
                                                <option value="" <?php if ($selected_time == '') {
                                                                        echo 'selected';
                                                                    } ?>>Any Time
                                                </option>
                                                <?php $dt = 1;
                                                foreach ($time_list as $list) { ?>
                                                    <option value="<?php echo $list['time']; ?>"
                                                        <?php if ($selected_time == $list['time']) {
                                                            echo 'selected';
                                                        } ?>>
                                                        <?php echo $list['time']; ?></option>
                                                <?php $dt++;
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="findInput personInput">
                                            <label class="inputlabel" for="">Select People</label>
                                            <select name="book_persons_inner" id="book_persons_inner" class="form-control cmnSelect">
                                                <?php $dt = 1;
                                                foreach ($pax_list as $list) {
                                                    if ($dt == 1 && $selected_pax == '') {
                                                        $selected_pax = $list['size'];
                                                    } ?>
                                                    <option value="<?php echo $list['size']; ?>"
                                                        <?php if ($selected_pax == $list['size']) {
                                                            echo 'selected';
                                                        } ?>>
                                                        <?php echo $list['size']; ?> People
                                                    </option>
                                                <?php $dt++;
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="button-inner">
                                            <button type="button" class="btn inner-search-res-form">Reserve</button>
                                            <!-- <button type="button" class="btn" data-target="findRestro">Reserve</button> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="availableList">
                                    <?php $dt = 1;
                                    foreach ($dates_list as $list) {
                                        $final_booking_date = $selected_date;
                                        $final_booking_time = $selected_time;
                                        $final_booking_pax = $selected_pax;
                                        $final_rest_id = '';
                                        $final_booking_status = '';
                                        $final_ref_id = 0;
                                        $final_id = 0;
                                        foreach ($booked_list as $bklist) {
                                            if ($list['date'] == $bklist['booking_date']) {
                                                $final_booking_date = $bklist['booking_date'];
                                                //  $final_booking_time = $bklist['booking_time'];
                                                $booked_time = $bklist['booking_time'];
                                                $final_booking_pax = $bklist['booking_pax'];
                                                $final_ref_id = $bklist['ref_id'];
                                                $final_id = $bklist['id'];
                                                if ($bklist['booking_restid'] != '') {
                                                    $final_rest_id = $bklist['booking_restid'];
                                                    $final_booking_status = $bklist['booking_status'];
                                                }
                                            }
                                        }

                                    ?>
                                        <div class="setupContent <?php if ($final_ref_id > 0) {
                                                                        echo ' invited';
                                                                    } ?> <?php if ($selected_date == date('d-m-Y', strtotime($list['date']))) {
                                                                                                                        echo 'active';
                                                                                                                    } ?>"
                                            data-person="<?php echo $final_booking_pax; ?>"
                                            data-time="<?php echo $final_booking_time; ?>"
                                            data-datetext="<?php echo $this->user_model->get_string_from_date($list['date']); ?>"
                                            data-date="<?php echo date('d-m-Y', strtotime($list['date'])); ?>"
                                            id="step-<?php echo $dt; ?>">
                                            <?php if ($final_rest_id != '' && $final_booking_status == 'booked') {
                                                $data['hotel'] = $this->user_model->get_restaurant_detail($final_rest_id);
                                                $data['selected_pax'] = $final_booking_pax;
                                                $data['selected_time'] = $final_booking_time;
                                                $data['booked_time'] = $booked_time;
                                                $data['date'] = $list['date'];
                                                $data['booked'] = 'yes';
                                                $data['list_id'] =  $final_id;
                                                $data['referer'] = 'modify';
                                                $this->load->view('front/restaurant-box', $data);
                                            } ?>
                                            <div id="ajax-response-restaurants">
                                                <?php
                                                $hotels = $this->user_model->get_hotels_list_with_filter($list['date'], $final_booking_time, $final_booking_pax);
                                                if (!empty($hotels)) {
                                                    foreach ($hotels as $hotel) {
                                                        $data['hotel'] = $hotel;
                                                        $data['selected_pax'] = $final_booking_pax;
                                                        $data['selected_time'] = $final_booking_time;
                                                        $data['date'] = $list['date'];
                                                        $data['booked'] = 'no';
                                                        $data['list_id'] = $final_id;
                                                        $data['referer'] = 'modify';
                                                        // if($final_rest_id != ''){
                                                        //     if($hotel['id'] == $final_rest_id && $final_booking_status == 'booked'){
                                                        //         $data['booked'] = 'yes';
                                                        //     }
                                                        // }
                                                        if ($final_ref_id > 0) { ?>
                                                            <div class="modifyNotice">
                                                                <h3>It seems like you are invited on this date by '<?php echo $this->user_model->get_hostname_byrefid($final_ref_id); ?>' and only Primary can modify the booking.</h3>
                                                            </div>
                                                    <?php break;
                                                        } else {
                                                            $this->load->view('front/restaurant-box', $data);
                                                        }
                                                    }
                                                } else { ?>
                                                    <div class="no-restaurant_found">
                                                        <div class="text-center">
                                                            <img src="<?php echo base_url(); ?>/uploads/front/images/noSearch-icon.svg" alt="">
                                                            <h4>At The Moment, <br>There's No Restaurant Available</h4>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php $dt++;
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="availableRestaurant bookedRestaurant" id="step-5">
                        <div class="row">
                            <div class="col-7 borderRight">
                                <h4>Your restaurant reservations.</h4>
                                <div class="availableList" id="selected_restaurant_list_ajax">

                                </div>
                            </div>
                            <div class="col-5">
                                <h4 class="creditcard_detail">Credit Card information</h4>
                                <div class="creditInformation">
                                    <?php
                                    $card_number = '';
                                    $card_month = '';
                                    $card_year = '';
                                    $card_cvv = '';
                                    $card_holder = '';
                                    if ($booking_detail['card_number'] != '') {
                                        $card_number = $this->encrypt->decode($booking_detail['card_number']);
                                        $card_month = $this->encrypt->decode($booking_detail['exp_month']);
                                        $card_year = $this->encrypt->decode($booking_detail['exp_year']);
                                        $card_cvv = $this->encrypt->decode($booking_detail['cvv']);
                                        $card_holder = $this->encrypt->decode($booking_detail['card_holder']);
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-12 creditcard_detail">
                                            <div class="form-group">
                                                <label class="fieldLabel">Card Number<sup>*</sup></label>
                                                <input type="text" class="form-control" name="card_number" id="card_number"
                                                    placeholder="Enter Card Number" value="<?php echo $card_number; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 creditcard_detail">
                                            <div class="form-group">
                                                <label class="fieldLabel">Expiry Date<sup>*</sup></label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <select class="form-control" name="exp_month">
                                                            <option value="">MM</option>
                                                            <?php for ($i = 01; $i <= 12; $i++) { ?>
                                                                <option value="<?php echo sprintf("%02d", $i); ?>" <?php if ($card_month == sprintf("%02d", $i)) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?php echo sprintf("%02d", $i); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" name="exp_year" value="<?php echo $card_year; ?>">
                                                            <option value="">YYYY</option>
                                                            <?php $start = date('Y');
                                                            $end = date('Y', strtotime('+20 years'));
                                                            for ($start; $start <= $end; $start++) { ?>
                                                                <option value="<?php echo $start; ?>" <?php if ($card_year == $start) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?php echo $start; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 creditcard_detail">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="fieldLabel">Security Code
                                                            (Cvv)<sup>*</sup></label>
                                                        <input type="password" class="form-control" name="security_code"
                                                            placeholder="CVV" value="<?php echo $card_cvv; ?>">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="fieldLabel">Card Holder<sup>*</sup></label>
                                                        <input type="text" class="form-control" name="card_holder"
                                                            placeholder="Enter Here" value="<?php echo $card_holder; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn w-100 mb-15">Confirm reservation</button>
                                            <p class="nots">You will not be charged at this time. Payment will be made in case of a no-show or late fee.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>