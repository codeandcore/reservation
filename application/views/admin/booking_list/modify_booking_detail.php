<div class="main-content modifyBookingDetail">
    <div class="page-content">
        <div class="container-fluid bg_dark-white">
            <div class="bg_white wrap_reservation">
                <div class="head_top_reservation">
                    <h2><?php echo $this->admin_model->get_user_name_byid($booked_list['user_id']);?> (modify Reservation)</h2>
                    <h3>Confirmation ID :#<?php echo $booked_list['booking_id'];?></h3>
                </div>
                <div class="wrapContentContainer">
                    <div class="modifyForm">
                        <form action="#" method="post" id="admin_restaurant_date_filter_form">
                            <input type="hidden" name="bookid" id="bookid" value="<?php echo $booked_list['id'];?>">
                            <div class="form-group row">
                                <div class="col">
                                    <div class="findInput dateInput">
                                        <label class="inputlabel" for="">Select Date</label>
                                        <div class="selectInput">
                                            <select name="book_date" id="book_date" class="form-control date_select form-item datepicker cmnSelect input" disabled>
                                                <?php $dt = 1; foreach($dates_list as $list){ if($dt == 1 && $selected_date == ''){ $selected_date = date('d-m-Y',strtotime($list['date']));}?>
                                                <option value="<?php echo date('d-m-Y',strtotime($list['date']));?>"
                                                    <?php if($selected_date == date('Y-m-d',strtotime($list['date']))){ echo 'selected';}?>>
                                                    <?php echo date('d-m-Y',strtotime($list['date']));?></option>
                                                <?php $dt++; } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="findInput timeInput">
                                        <label class="inputlabel" for="">Select Time</label>
                                        <div class="selectInput">
                                            <select name="book_time" id="book_time" class="form-control cmnSelect1 timeInput input">
                                                <option value="" <?php if($selected_time == ''){ echo 'selected';}?>>Any
                                                    Time
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
                    <div class="availableRestaurant">
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
                                        if ($slug == 'establishment_type' && $this->settings['restaurant_establishment_hide'] == 'yes') {
                                            continue;
                                        }
                                        if ($slug == 'meals' && $this->settings['restaurant_meals_hide'] == 'yes') {
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
                            <div class="col-8">
                                <div class="availableList">
                                    <div id="ajax-response-restaurants">
                                        <?php
                                            if(!empty($hotels_list)):
                                            foreach ($hotels_list as $hotel) { 
                                                $data['hotel'] = $hotel;
                                                $data['book_id'] = $hotel;
                                                $data['selected_pax'] = $selected_pax;
                                                $data['selected_time'] = $selected_time;
                                                $data['date'] = $selected_date;
                                                $data['booked'] = 'no';
                                                $data['referer'] = 'modify';
                                                $this->load->view('admin/restaurant-box',$data);    
                                            } endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>