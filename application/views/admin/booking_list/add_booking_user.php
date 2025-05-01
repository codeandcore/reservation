<?php
$selected_date = '';
$selected_time = '';
$selected_pax = '';
?>
<div class="main-content addBookingUser">
    <div class="page-content">
        <div class="container-fluid bg_dark-white">
            <div class="bg_white wrap_reservation">
                <div class="head_top_reservation">
                    <h2>Add Booking</h2>
                </div>
                <div class="wrapContentContainer">
                    <div class="modifyForm">
                        <form action="#" method="post" id="admin_restaurant_date_filter_form">
                            <input type="hidden" name="bookid" id="bookid" value="">
                            <div class="form-group row">
                                <div class="col">
                                    <div class="findInput dateInput">
                                        <label class="inputlabel" for="book_date">Select Date</label>
                                        <div class="selectInput">
                                            <select name="book_date" id="book_date" class="form-control date_select form-item datepicker cmnSelect input">
                                            <?php $dt = 1; foreach($dates_list as $list){ if($dt == 1 && $selected_date == ''){ $selected_date = date('d-m-Y',strtotime($list['date']));}?>
                                            <option value="<?php echo date('d-m-Y',strtotime($list['date']));?>"
                                                <?php if($selected_date == date('d-m-Y',strtotime($list['date']))){ echo 'selected';}?>>
                                                <?php echo date('m-d-Y',strtotime($list['date']));?></option>
                                            <?php $dt++; } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="findInput timeInput">
                                        <label class="inputlabel" for="book_time">Select Time</label>
                                        <div class="selectInput">
                                            <select name="book_time" id="book_time" class="form-control cmnSelect1 timeInput input">
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
                                </div>
                                <div class="col">
                                    <div class="findInput personInput">
                                        <label class="inputlabel" for="">Select People</label>
                                        <div class="selectInput">
                                            <select name="book_persons" id="book_persons" class="form-control personInput cmnSelect input">
                                            <?php $dt = 1; foreach($pax_list as $list){ if($dt == 1 && $selected_pax == ''){ $selected_pax = $list['size'];}?>
                                            <option value="<?php echo $list['size'];?>"
                                                <?php if($selected_pax == $list['size']){ echo 'selected';}?>>
                                                <?php echo $list['size'];?> People
                                            </option>
                                            <?php $dt++; } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn">Let's go</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="availableProgress">
                        <div class="topTitleRow">
                            <div class="titleText">
                                <h4>Available Restaurants for <span id="selected_date_string">May 24<sup>th</sup></span>
                                </h4>
                                <p>You can skip today's reservation and still can continue with other reservations.</p>
                            </div>
                            <div class="skipButton">
                                <a href="#" class="btn modal-button" data-popup="skipDay">Skip booking for this day</a>
                                <input type="hidden" name="booking_id" value="3">
                            </div>
                        </div>

                        <div class="availableStep">
                            <ul class="availableDayList list-unstyled">
                                <li class="availableDay active" data-step="step-1" data-time="6:00pm" data-person="2" data-datetext="May 21<sup>st</sup>" data-date="21-05-2023">
                                    <input type="hidden" name="booking_date[]" class="input_booking_date" value="21-05-2023">
                                    <input type="hidden" name="booking_time[]" class="input_booking_time" value="7:45 pm">
                                    <input type="hidden" name="booking_pax[]" class="input_booking_pax" value="2">
                                    <input type="hidden" name="booking_restid[]" class="input_booking_restid" value="4">
                                    <input type="hidden" name="booking_reason[]" class="input_booking_reason" value="Primary removed you.">
                                    <input type="hidden" name="booking_deposite[]" class="input_booking_deposite" value="0.00">
                                    <input type="hidden" name="booking_status[]" class="input_booking_deposite" value="cancel">
                                    <div class="availablItem">
                                        <div class="restauranDayBlock">
                                            <div class="restauranIcon">
                                                <img src="http://192.168.1.110/restro//uploads/front/images/restaurant-icon.svg" alt="">
                                                <span class="badgeIcon"></span>
                                                <span class="skipCommment">You haven`t reserved any restaurants for
                                                    May 21<sup>st</sup></span>
                                            </div>
                                        </div>
                                        <div class="availableDayText">
                                            <h5>May 21</h5>

                                            <span class="dayStatusText">
                                                <span class="applyReserved">Reserved</span>
                                                <span class="skippedDay">Skipped day</span>
                                                <span class="notReserved">Not reserved</span>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="availableDay" data-step="step-2" data-time="6:00pm" data-person="2" data-datetext="May 24<sup>th</sup>" data-date="24-05-2023">
                                    <input type="hidden" name="booking_date[]" class="input_booking_date" value="24-05-2023">
                                    <input type="hidden" name="booking_time[]" class="input_booking_time" value="6:00pm">
                                    <input type="hidden" name="booking_pax[]" class="input_booking_pax" value="2">
                                    <input type="hidden" name="booking_restid[]" class="input_booking_restid" value="2">
                                    <input type="hidden" name="booking_reason[]" class="input_booking_reason" value="">
                                    <input type="hidden" name="booking_deposite[]" class="input_booking_deposite" value="0.00">
                                    <input type="hidden" name="booking_status[]" class="input_booking_deposite" value="booked">
                                    <div class="availablItem">
                                        <div class="restauranDayBlock">
                                            <div class="restauranIcon">
                                                <img src="http://192.168.1.110/restro//uploads/front/images/restaurant-icon.svg" alt="">
                                                <span class="badgeIcon"></span>
                                                <span class="skipCommment">You haven`t reserved any restaurants for
                                                    May 24<sup>th</sup></span>
                                            </div>
                                        </div>
                                        <div class="availableDayText">
                                            <h5>May 24</h5>

                                            <span class="dayStatusText">
                                                <span class="applyReserved">Reserved</span>
                                                <span class="skippedDay">Skipped day</span>
                                                <span class="notReserved">Not reserved</span>
                                            </span>
                                        </div>

                                    </div>
                                </li>
                                <li class="availableDay confirmStep" data-step="step-3">
                                    <div class="availablItem">
                                        <div class="restauranDayBlock">
                                            <div class="restauranIcon">
                                                <img src="http://192.168.1.110/restro//uploads/front/images/confirm-icon.svg" alt="">
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
                            <div class="row">
                                <div class="col-4 borderRight">
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
                                                    <div class="custom-radio">
                                                        <input type="radio" id="property_type_radio2" name="property_type"
                                                            value="on" class="radioInput">
                                                        <label class="radioLabel" for="property_type_radio2">On - Property
                                                            Restaurant</label>
                                                    </div>
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
                                <div class="col-8">
                                    <div class="availableList">
                                        <div class="setupContent active" id="step-1">
                                            <div class="availableItem">
                                                <div class="restaurantImg">
                                                    <img src="http://192.168.1.110/restro//uploads/assets/images/5dfb49592a82850edae8d4862ff4ddfc.jpg" alt="">
                                                </div>
                                                <div class="restaurantDetails">
                                                    <div class="restaurantName">
                                                        <h5>DUO Steak and Seafood</h5>
                                                    </div>
                                                    <p>DUO Steak and Seafood at Four Seasons Maui offers expertly prepared steak and seafood by our award-winning chefs against a luxurious poolside backdrop. Suggested Attire:Resort Casual Cancellation Policy:$75 per person cancellation fee for changes made less than 48 hours in advance.</p>
                                                    <p class="propertyType">Off - Property Restaurant</p>
                                                    <div class="eatingType">
                                                        <ul class="list-unstyled">
                                                            <li>Dinner</li>
                                                        </ul>
                                                    </div>
                                                    <div class="timeing">
                                                        <ul class="list-unstyled">
                                                            <li><a href="javascript:void(0)" class="selectRestaurant_btn" data-target="selectRestaurant">6:00pm</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
        
                                                <a href="#" class="btn viewBtn restaurant-modal-button" data-rest_id="2" data-target="viewDetails">View Details</a>
        
                                                <div class="selectedRestaurant">
                                                    <div class="selectedContent">
                                                        <h5>Do you want to select <u>DUO Steak and Seafood</u> for <u>May 24<sup>th</sup></u>? </h5>
                                                        <ul class="list-unstyled">
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_table-icon.svg" alt=""></i> Table
                                                            for
                                                            2 People</li>
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_building_icon.svg" alt=""></i>
                                                            Off - Property Restaurant</li>
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_clock_time_icon.svg" alt=""></i>
                                                            <span class="selected_time_slot">07:00pm</span></li>
                                                        </ul>
                                                        <div class="buttonRow">
                                                            <a href="javascript:void(0)" class="btn confirmRestaurant" data-target="confirmRestaurant" data-bookdate="24-05-2023" data-booktime="" data-bookpax="2" data-deposite="0.00" data-bookrestid="2">Confirm this
                                                            restaurant</a>
                                                            <a href="javascript:void(0)" class="btn" data-target="NotConfirmRestaurant" data-bookdate="24-05-2023">CANCEL</a>
                                                        </div>
                                                        <div class="note_rest">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="availableItem ">
                                                <div class="restaurantImg">
                                                    <img src="http://192.168.1.110/restro//uploads/assets/images/f4693c9b1915108f721227297e798075.jpg" alt="">
                                                </div>
                                                <div class="restaurantDetails">
                                                    <div class="restaurantName">
                                                        <h5>Ko at Fairmont Kea Lani</h5>
                                                    </div>
                                                    <p>DUO Steak and Seafood at Four Seasons Maui offers expertly prepared steak and seafood by our award-winning chefs against a luxurious poolside backdrop. Suggested Attire:Resort Casual Cancellation Policy:$75 per person cancellation fee for changes made less than 48 hours in advance.</p>
                                                    <p class="propertyType">Off - Property Restaurant</p>
                                                    <div class="eatingType">
                                                        <ul class="list-unstyled">
                                                            <li>Dinner</li>
                                                        </ul>
                                                    </div>
                                                    <div class="timeing">
                                                        <ul class="list-unstyled">
                                                            <li><a href="javascript:void(0)" class="selectRestaurant_btn" data-target="selectRestaurant">6:00pm</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
        
                                                <a href="#" class="btn viewBtn restaurant-modal-button" data-rest_id="2" data-target="viewDetails">View Details</a>
        
                                                <div class="selectedRestaurant">
                                                    <div class="selectedContent">
                                                        <h5>Do you want to select <u>DUO Steak and Seafood</u> for <u>May 24<sup>th</sup></u>? </h5>
                                                        <ul class="list-unstyled">
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_table-icon.svg" alt=""></i> Table
                                                            for
                                                            2 People</li>
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_building_icon.svg" alt=""></i>
                                                            Off - Property Restaurant</li>
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_clock_time_icon.svg" alt=""></i>
                                                            <span class="selected_time_slot">07:00pm</span></li>
                                                        </ul>
                                                        <div class="buttonRow">
                                                            <a href="javascript:void(0)" class="btn confirmRestaurant" data-target="confirmRestaurant" data-bookdate="24-05-2023" data-booktime="" data-bookpax="2" data-deposite="0.00" data-bookrestid="2">Confirm this
                                                            restaurant</a>
                                                            <a href="javascript:void(0)" class="btn" data-target="NotConfirmRestaurant" data-bookdate="24-05-2023">CANCEL</a>
                                                        </div>
                                                        <div class="note_rest">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="setupContent" id="step-2">
                                            <div class="availableItem">
                                                <div class="restaurantImg">
                                                    <img src="http://192.168.1.110/restro//uploads/assets/images/f4693c9b1915108f721227297e798075.jpg" alt="">
                                                </div>
                                                <div class="restaurantDetails">
                                                    <div class="restaurantName">
                                                       <h5>Ko at Fairmont Kea Lani</h5>
                                                    </div>
                                                    <p>DUO Steak and Seafood at Four Seasons Maui offers expertly prepared steak and seafood by our award-winning chefs against a luxurious poolside backdrop. Suggested Attire:Resort Casual Cancellation Policy:$75 per person cancellation fee for changes made less than 48 hours in advance.</p>
                                                    <p class="propertyType">Off - Property Restaurant</p>
                                                    <div class="eatingType">
                                                        <ul class="list-unstyled">
                                                            <li>Dinner</li>
                                                        </ul>
                                                    </div>
                                                    <div class="timeing">
                                                        <ul class="list-unstyled">
                                                            <li><a href="javascript:void(0)" class="selectRestaurant_btn" data-target="selectRestaurant">6:00pm</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
        
                                                <a href="#" class="btn viewBtn restaurant-modal-button" data-rest_id="2" data-target="viewDetails">View Details</a>
        
                                                <div class="selectedRestaurant">
                                                    <div class="selectedContent">
                                                        <h5>Do you want to select <u>DUO Steak and Seafood</u> for <u>May 24<sup>th</sup></u>? </h5>
                                                        <ul class="list-unstyled">
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_table-icon.svg" alt=""></i> Table
                                                            for
                                                            2 People</li>
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_building_icon.svg" alt=""></i>
                                                            Off - Property Restaurant</li>
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_clock_time_icon.svg" alt=""></i>
                                                            <span class="selected_time_slot">07:00pm</span></li>
                                                        </ul>
                                                        <div class="buttonRow">
                                                            <a href="javascript:void(0)" class="btn confirmRestaurant" data-target="confirmRestaurant" data-bookdate="24-05-2023" data-booktime="" data-bookpax="2" data-deposite="0.00" data-bookrestid="2">Confirm this
                                                            restaurant</a>
                                                            <a href="javascript:void(0)" class="btn" data-target="NotConfirmRestaurant" data-bookdate="24-05-2023">CANCEL</a>
                                                        </div>
                                                        <div class="note_rest">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="availableItem ">
                                                <div class="restaurantImg">
                                                    <img src="http://192.168.1.110/restro//uploads/assets/images/5dfb49592a82850edae8d4862ff4ddfc.jpg" alt="">
                                                </div>
                                                <div class="restaurantDetails">
                                                    <div class="restaurantName">
                                                        <h5>DUO Steak and Seafood</h5>
                                                    </div>
                                                    <p>DUO Steak and Seafood at Four Seasons Maui offers expertly prepared steak and seafood by our award-winning chefs against a luxurious poolside backdrop. Suggested Attire:Resort Casual Cancellation Policy:$75 per person cancellation fee for changes made less than 48 hours in advance.</p>
                                                    <p class="propertyType">Off - Property Restaurant</p>
                                                    <div class="eatingType">
                                                        <ul class="list-unstyled">
                                                            <li>Dinner</li>
                                                        </ul>
                                                    </div>
                                                    <div class="timeing">
                                                        <ul class="list-unstyled">
                                                            <li><a href="javascript:void(0)" class="selectRestaurant_btn" data-target="selectRestaurant">6:00pm</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
        
                                                <a href="#" class="btn viewBtn restaurant-modal-button" data-rest_id="2" data-target="viewDetails">View Details</a>
        
                                                <div class="selectedRestaurant">
                                                    <div class="selectedContent">
                                                        <h5>Do you want to select <u>DUO Steak and Seafood</u> for <u>May 24<sup>th</sup></u>? </h5>
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <i><img src="http://192.168.1.110/restro//uploads/front/images/white_table-icon.svg" alt=""></i> Table for 2 People</li>
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_building_icon.svg" alt=""></i>
                                                            Off - Property Restaurant</li>
                                                            <li><i><img src="http://192.168.1.110/restro//uploads/front/images/white_clock_time_icon.svg" alt=""></i>
                                                            <span class="selected_time_slot">07:00pm</span></li>
                                                        </ul>
                                                        <div class="buttonRow">
                                                            <a href="javascript:void(0)" class="btn confirmRestaurant" data-target="confirmRestaurant" data-bookdate="24-05-2023" data-booktime="" data-bookpax="2" data-deposite="0.00" data-bookrestid="2">Confirm this restaurant</a>
                                                            <a href="javascript:void(0)" class="btn" data-target="NotConfirmRestaurant" data-bookdate="24-05-2023">CANCEL</a>
                                                        </div>
                                                        <div class="note_rest">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="availableRestaurant bookedRestaurant" id="step-5">
                        <div class="row">
                            <div class="col-7 borderRight">
                                <h4>Your restaurant reservations.</h4>
                                <div class="availableList">
                                    <div class="availableItem ">
                                        <div class="restaurantImg">
                                            <img src="http://192.168.1.110/restro//uploads/assets/images/5dfb49592a82850edae8d4862ff4ddfc.jpg" alt="">
                                        </div>
                                        <div class="restaurantDetails confirmDetails">
                                            <div class="restaurantName">
                                                <h5>DUO Steak and Seafood</h5>
                                            </div>
                                            <div class="confirmDay"><i><img src="http://192.168.1.110/restro//uploads/front/images/calendar_check_icon.svg" alt=""></i>05-24-2023</div>
                                            <div class="confirmTimePeople">
                                                <ul class="list-unstyled">
                                                    <li><i><img src="http://192.168.1.110/restro//uploads/front/images/table-icon.svg" alt=""></i>
                                                        2 People
                                                    </li>
                                                    <li><i><img src="http://192.168.1.110/restro//uploads/front/images/clock_time_icon.svg" alt=""></i>
                                                        6:00pm</li>
                                                    <li><i><img src="http://192.168.1.110/restro//uploads/front/images/city_building_icon.svg" alt=""></i>
                                                        Off - Property Restaurant </li>
                                                </ul>
                                            </div>
                                            <div class="modifyRestaurant">
                                                <a href="javascript:void(0)" data-date="24-05-2023" class="modify_back_btn btn">Modify</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <button type="submit" class="btn w-100 mb-15">Confirm reservation</button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>