<?php 
$selected_date = '';
$selected_time = '';
$selected_pax = '';
if($this->input->get('book_date')){ $selected_date = $this->input->get('book_date'); }
if($this->input->get('book_time')){ $selected_time = $this->input->get('book_time'); }
if($this->input->get('book_persons')){ $selected_pax = $this->input->get('book_persons'); }

?>
<main class="no-overflow-hidden">
    <section class="banner" style="background-image: url(<?php echo base_url(); ?>/uploads/front/images//banner-bg.jpg);">
        <h1 class="d-none"><?php echo $this->settings['site_title'];?></h1>
    </section>

    <section class="booking-section">
        <div class="container">
            <div class="innerSearchForm">
                <form action="<?php echo site_url('reservation');?>" id="reservation_page_search_form"
                    class="bookingForm">
                    <div class="row">
                        <div class="col">
                            <div class="findInput dateInput">
                                <label class="inputlabel" for="book_date">Select Date</label>
                                <select name="book_date" id="book_date" class="form-control cmnSelect">
                                    <?php $dt = 1; foreach($dates_list as $list){ if($dt == 1 && $selected_date == ''){ $selected_date = date('d-m-Y',strtotime($list['date']));}?>
                                    <option value="<?php echo date('d-m-Y',strtotime($list['date']));?>"
                                        <?php if($selected_date == date('d-m-Y',strtotime($list['date']))){ echo 'selected';}?>>
                                        <?php echo date('m-d-Y',strtotime($list['date']));?></option>
                                    <?php $dt++; } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="findInput timeInput">
                                <label class="inputlabel" for="book_time">Select Time</label>
                                <select name="book_time" id="book_time" class="form-control cmnSelect">
                                    <option value="" <?php if($selected_time == ''){ echo 'selected';}?>>Any Time
                                    </option>
                                    <?php $dt = 1; foreach($time_list as $list){?>
                                    <option value="<?php echo $list['time'];?>"
                                        <?php if($selected_time == $list['time']){ echo 'selected';}?>>
                                        <?php echo $list['time'];?></option>
                                    <?php $dt++; } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="findInput personInput">
                            <label class="inputlabel" for="book_persons">Select People</label>
                                <select name="book_persons" id="book_persons" class="form-control cmnSelect">
                                    <?php $dt = 1; foreach($pax_list as $list){ if($dt == 1 && $selected_pax == ''){ $selected_pax = $list['size'];}?>
                                    <option value="<?php echo $list['size'];?>"
                                        <?php if($selected_pax == $list['size']){ echo 'selected';}?>>
                                        <?php echo $list['size'];?> People
                                    </option>
                                    <?php $dt++; } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn" data-target="findRestro">LET'S GO</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <form action="#" method="post" id="register_restaurant_booking_final">
    <input type="hidden" name="querytype" class="" value="makebooking">
        <section class="availableBooking">
            <div class="container">
                <div class="availableProgress">

                    <div class="topTitleRow">
                        <div class="titleText">
                            <h4>Available Restaurants for <span
                                    id="selected_date_string"><?php echo $this->user_model->get_string_from_date($selected_date);?></span>
                            </h4>
                            <p>You can skip today's reservation and still continue with other reservations.</p>
                        </div>
                        <div class="skipButton">
                            <a href="#" class="btn modal-button" data-target="skipDay">Skip booking for this day</a>
                        </div>
                    </div>

                    <div class="availableStep">
                        <ul class="availableDayList list-unstyled">
                            <?php $dt = 1; foreach($dates_list as $list){?>
                            <li class="availableDay <?php if($selected_date == date('d-m-Y',strtotime($list['date']))){ echo 'active';}?>"
                                data-step="step-<?php echo $dt;?>" data-time="<?php echo $selected_time;?>"
                                data-person="<?php echo $selected_pax;?>"
                                data-datetext="<?php echo $this->user_model->get_string_from_date($list['date']);?>"
                                data-date="<?php echo date('d-m-Y',strtotime($list['date']));?>"
                                <?php if($selected_date != date('d-m-Y',strtotime($list['date']))){ echo 'disabled="disabled"';}?>>
                                <input type="hidden" name="booking_date[]" class="input_booking_date"
                                    value="<?php echo date('d-m-Y',strtotime($list['date']));?>">
                                <input type="hidden" name="booking_time[]" class="input_booking_time" value="">
                                <input type="hidden" name="booking_pax[]" class="input_booking_pax" value="">
                                <input type="hidden" name="booking_restid[]" class="input_booking_restid" value="">
                                <input type="hidden" name="booking_reason[]" class="input_booking_reason" value="">
                                <input type="hidden" name="booking_deposite[]" class="input_booking_deposite" value="">
                                <div class="availablItem">
                                    <div class="restauranDayBlock">
                                        <div class="restauranIcon">
                                            <img src="<?php echo base_url(); ?>/uploads/front/images/restaurant-icon.svg"
                                                alt="">
                                            <span class="badgeIcon"></span>
                                            <span class="skipCommment">You haven`t reserved any restaurants for
                                                <?php echo $this->user_model->get_string_from_date(date('d-m-Y',strtotime($list['date'])));?></span>
                                        </div>
                                    </div>
                                    <div class="availableDayText">
                                        <h5><?php echo date('M d',strtotime($list['date']));?></h5>
                                        <span class="dayStatusText">
                                            <span class="notReserved">Not reserved</span>
                                            <span class="applyReserved">Reserved</span>
                                            <span class="skippedDay">Skipped day</span>
                                        </span>
                                    </div>

                                </div>
                            </li>
                            <?php $dt++; } ?>
                            <li class="availableDay confirmStep" data-step="step-<?php echo $dt;?>" disabled="disabled">
                                <div class="availablItem">
                                    <div class="restauranDayBlock">
                                        <div class="restauranIcon">
                                            <img src="<?php echo base_url(); ?>/uploads/front/images/confirm-icon.svg"
                                                alt="">
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

                    <div class="availableRestaurant availableStepListing">
                        <div class="innerLoader">
                            <div class="loaderBox"></div>
                        </div>
                        <div class="row">
                            <div class="col-4 filterApply">
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
                                                <!-- <div class="custom-radio">
                                                    <input type="radio" id="property_type_radio2" name="property_type"
                                                        value="on" class="radioInput">
                                                    <label class="radioLabel" for="property_type_radio2">On - Property
                                                        Restaurant</label>
                                                </div> -->
                                                <div class="custom-radio">
                                                    <input type="radio" id="property_type_radio3" name="property_type"
                                                        value="off" class="radioInput">
                                                    <label class="radioLabel" for="property_type_radio3">Off - Property
                                                        Restaurant</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if(!empty($filters)):
                                    foreach ($filters as $key => $filter) {
                                        $slug = $filter['filter_name'];
                                        $value = $filter['filter_value'];
                                        $explode = explode(',',$value);
                                        $title = str_replace('_',' ',$slug);
                                        $title = str_replace('-',' ',$title);
                                        if($slug == 'establishment_type' && $this->settings['restaurant_establishment_hide'] == 'yes'){
                                            continue;
                                        }
                                        if($slug == 'meals' && $this->settings['restaurant_meals_hide'] == 'yes'){
                                            continue;
                                        }
                                        if ($slug == 'fee' && $this->settings['restaurant_fee_hide'] == 'yes') {
                                            continue;
                                        }
                                        if($value != ''){?>
                                        <div class="filterItem">
                                            <div class="filterItemTitle"><?php echo ucfirst($title);?></div>
                                            <div class="filterItemList">
                                                <?php if(!empty($explode)):
                                            $vl=1; foreach($explode as $key => $val) {
                                            ?>
                                                <div class="custom-checkbox" data-type="<?php echo $slug;?>">
                                                    <input type="checkbox" class="checkboxInput"
                                                        name="filter[<?php echo $slug;?>]" id="<?php echo $slug.$vl;?>"
                                                        value="<?php echo $val;?>">
                                                    <label class="checkboxLabel"
                                                        for="<?php echo $slug.$vl;?>"><?php echo $val;?></label>
                                                </div>

                                                <?php $vl++; } endif; ?>
                                            </div>
                                        </div>
                                        <?php } } endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8 availableCol">
                                <div class="inner-time-and-people-section">
                                        <!-- <h3>Select time Select people</h3> -->
                                        <div class="d-flex wrap-time-people">   
                                                
                                            <div class="findInput timeInput">
                                                    <label class="inputlabel" for="">Select Time</label>
                                                    <select name="book_time_inner" id="book_time_inner" class="form-control cmnSelect">
                                                        <option value="" <?php if($selected_time == ''){ echo 'selected';}?>>Any Time
                                                        </option>
                                                        <?php $dt = 1; foreach($time_list as $list){?>
                                                        <option value="<?php echo $list['time'];?>"
                                                            <?php if($selected_time == $list['time']){ echo 'selected';}?>>
                                                            <?php echo $list['time'];?></option>
                                                        <?php $dt++; } ?>
                                                    </select>
                                            </div>
                                            
                                            
                                            <div class="findInput personInput">
                                                <label class="inputlabel" for="">Select People</label>
                                                    <select name="book_persons_inner" id="book_persons_inner" class="form-control cmnSelect">
                                                        <?php $dt = 1; foreach($pax_list as $list){ if($dt == 1 && $selected_pax == ''){ $selected_pax = $list['size'];}?>
                                                        <option value="<?php echo $list['size'];?>"
                                                            <?php if($selected_pax == $list['size']){ echo 'selected';}?>>
                                                            <?php echo $list['size'];?> People
                                                        </option>
                                                        <?php $dt++; } ?>
                                                    </select>
                                            </div>
                                            
                                            <div class="button-inner">
                                                <button type="button" class="btn inner-search-res-form">LET'S GO</button>
                                                <!-- <button type="button" class="btn" data-target="findRestro">LET'S GO</button> -->
                                            </div>
                                        </div>
                                    </div>
                                <div class="availableList">
                                    <?php $dt = 1; foreach($dates_list as $list){?>
                                    <div class="setupContent <?php if($selected_date == date('d-m-Y',strtotime($list['date']))){ echo 'active';}?>"
                                        data-person="<?php echo $selected_pax;?>"
                                        data-time="<?php echo $selected_time;?>"
                                        data-datetext="<?php echo $this->user_model->get_string_from_date($list['date']);?>"
                                        data-date="<?php echo date('d-m-Y',strtotime($list['date']));?>"
                                        id="step-<?php echo $dt;?>">
                                        <div id="ajax-response-restaurants">
                                            <?php
                                            $hotels = $this->user_model->get_hotels_list_with_filter($list['date'],$selected_time,$selected_pax);
                                            if(!empty($hotels)){
                                            foreach ($hotels as $hotel) { 
                                                $data['hotel'] = $hotel;
                                                $data['selected_pax'] = $selected_pax;
                                                $data['selected_time'] = $selected_time;
                                                $data['date'] = $list['date'];
                                                $data['booked'] = 'no';
                                                $this->load->view('front/restaurant-box',$data);    
                                            } } else{ ?>
                                            <div class="no-restaurant_found">
                                                <div class="text-center">
                                                    <img src="<?php echo base_url(); ?>/uploads/front/images/noSearch-icon.svg" alt="">
                                                    <h4>At The Moment, <br>There's No Restaurant Available</h4>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php $dt++; } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="availableRestaurant bookedRestaurant" id="step-5">
                        <div class="row">
                            <div class="col-7 borderRight">
                                <h4 class="creditcard_detail">Your restaurant reservations.</h4>
                                <div class="availableList" id="selected_restaurant_list_ajax">
                                    
                                </div>
                            </div>
                            <div class="col-5">
                                <h4 class="creditcard_detail">Credit Card information</h4>
                                <div class="creditInformation">
                                    <div class="row">
                                        <div class="col-12 creditcard_detail">
                                            <div class="form-group">
                                                <label class="fieldLabel">Card Number<sup>*</sup></label>
                                                <div class="card-type"></div>
                                                <input type="text" class="form-control" name="card_number" placeholder="Enter Card Number" id="card_number" required>
                                                <div class="card-valid">&#xea10;</div>
                                            </div>
                                        </div>
                                        <div class="col-12 creditcard_detail">
                                            <div class="form-group">
                                                <label class="fieldLabel">Expiry Date<sup>*</sup></label>
                                                <div class="row">
                                                    <div class="col-6">
                                                    <select class="form-control" name="exp_month" required>
                                                            <option value="">MM</option>
                                                            <?php for($i=01;$i<=12;$i++){?>
                                                                 <option value="<?php echo sprintf("%02d", $i);?>"><?php echo sprintf("%02d", $i);?></option>   
                                                           <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                    <select class="form-control" name="exp_year" value="<?php echo $card_year;?>" required>
                                                        <option value="">YYYY</option>
                                                        <?php $start = date('Y');
                                                        $end = date('Y', strtotime('+20 years'));
                                                        for($start;$start<=$end;$start++){?>
                                                            <option value="<?php echo $start;?>"><?php echo $start;?></option>   
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
                                                        <label class="fieldLabel">Security Code (Cvv)<sup>*</sup></label>
                                                        <input type="password" class="form-control" name="security_code" placeholder="CVV" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="fieldLabel">Card Holder<sup>*</sup></label>
                                                        <input type="text" class="form-control" name="card_holder" placeholder="Enter Here" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">                                            
                                            <button type="submit" class="btn w-100 mb-15">Confirm reservation</button>
                                            <p id="form-submit-error" class="text-danger text-left"><strong></strong></p>
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

<script>
    /*! js-cookie v3.0.1 | MIT */
    !function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e=e||self,function(){var n=e.Cookies,o=e.Cookies=t();o.noConflict=function(){return e.Cookies=n,o}}())}(this,(function(){"use strict";function e(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var o in n)e[o]=n[o]}return e}return function t(n,o){function r(t,r,i){if("undefined"!=typeof document){"number"==typeof(i=e({},o,i)).expires&&(i.expires=new Date(Date.now()+864e5*i.expires)),i.expires&&(i.expires=i.expires.toUTCString()),t=encodeURIComponent(t).replace(/%(2[346B]|5E|60|7C)/g,decodeURIComponent).replace(/[()]/g,escape);var c="";for(var u in i)i[u]&&(c+="; "+u,!0!==i[u]&&(c+="="+i[u].split(";")[0]));return document.cookie=t+"="+n.write(r,t)+c}}return Object.create({set:r,get:function(e){if("undefined"!=typeof document&&(!arguments.length||e)){for(var t=document.cookie?document.cookie.split("; "):[],o={},r=0;r<t.length;r++){var i=t[r].split("="),c=i.slice(1).join("=");try{var u=decodeURIComponent(i[0]);if(o[u]=n.read(c,u),e===u)break}catch(e){}}return e?o[e]:o}},remove:function(t,n){r(t,"",e({},n,{expires:-1}))},withAttributes:function(n){return t(this.converter,e({},this.attributes,n))},withConverter:function(n){return t(e({},this.converter,n),this.attributes)}},{attributes:{value:Object.freeze(o)},converter:{value:Object.freeze(n)}})}({read:function(e){return'"'===e[0]&&(e=e.slice(1,-1)),e.replace(/(%[\dA-F]{2})+/gi,decodeURIComponent)},write:function(e){return encodeURIComponent(e).replace(/%(2[346BF]|3[AC-F]|40|5[BDE]|60|7[BCD])/g,decodeURIComponent)}},{path:"/"})}));

    jQuery(document).mouseleave(function(){
        if(!Cookies.get('hide-div')){
             $('#notCompleted').addClass('modal-active');
        }
    });
    $(document).ready(function(){
        $(document).on('click','#notCompleted .modal-close,#notCompleted [data-target="modalClose"],#notCompleted .modal-backdrop',function(){
            Cookies.set('hide-div', true, { expires: 365 });
        });
    });

</script>