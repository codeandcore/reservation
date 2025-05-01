<?php
    $select_days = $this->input->post('select_days');
    $sel_attend_type = $this->input->post('sel_attend_type');
    $sel_status = $this->input->post('booking_status');
    $sel_property_type = $this->input->post('sel_property_type');
    $restaurants = $this->input->post('restaurants');
    $generic_columns = $this->input->post('generic_columns');
    $days_columns = $this->input->post('days_columns');
    $params=[];
    $restaurantsDB=$this->admin_model->get_restaurant_list($params);
    $static = '';
    $in_ary = [];
    if(!empty($select_days)){
        $def_dates = $this->admin_model->get_dates_list_booking();
         $day_txt = [];                                   
        foreach($select_days as $date){
            $k=1; 
            foreach ($def_dates as $key => $inndate) {
                if($inndate['date'] == $date){
                    $day = $k;
                    $day_txt[] = 'Day '.$day;
                }
                $k++;
            }
        }
        $day_ary = implode(' & ',$day_txt);
        $in_ary[] = $day_ary;
    }
    if(!empty($sel_attend_type)){
        $in_ary[] = implode(' & ',array_map('ucfirst', $sel_attend_type));
    }
    if(!empty($sel_status)){
        $in_ary[] = implode(' & ',array_map('ucfirst', $sel_status));
    }
    if(!empty($sel_property_type)){
        $in_ary[] = implode(' & ',array_map(function($value) {
            return ucfirst($value)  . ' Property';
        }, $sel_property_type));
    }
    if(!empty($restaurants)){
        if(count($restaurantsDB) == count($restaurants)){
            $in_ary[] = 'All Restaurants'; 
        }
        else{
            foreach ($restaurants as $key => $restid) {
                $rest_name = $this->admin_model->get_restaurant_name_byid($restid);
                $rest_text[] = $rest_name;
            }
            $in_ary[] = implode(' & ',$rest_text);
        }
    }
    $static = implode(', ',$in_ary);
?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        <div class="notice"><h4>Currently you are seeing the report for this query:</h4> <?php echo $static;?></div>
            <?php
            if($total_rows == 0){
                ?>
                <!-- <p>No bookings found with that selection, please try to generate <a href="<?php //echo site_url('admin/reports_steps');?>" class="">New report</a></p> -->
                <div class="no-report-found d-flex">
                    <div class="image-area"><img src="<?php echo base_url(); ?>/uploads/assets/images/no-found.svg" alt=""></div>
                   <div class="rt-content"><h2 class="mb-33">No booking was found with that selection. Please try generating it again.</h2><a href="<?php echo site_url('admin/reports_steps');?>" class="btn"><img src="<?php echo base_url(); ?>/uploads/assets/images/file-icon.svg" alt=""> New report</a></div>
                </div>
                <?php
            }else{
                ?>
<form action="" id="complete_booking" method="post">
    <?php
              
                if(!empty($select_days)){
                    foreach ($select_days as $key => $value) {
                        echo '<input type="hidden" name="select_days[]" value="'.$value.'">';
                    }
                }
                if(!empty($sel_attend_type)){
                    foreach ($sel_attend_type as $key => $value) {
                        echo '<input type="hidden" name="sel_attend_type[]" value="'.$value.'">';
                    }
                }
                if(!empty($sel_status)){
                    foreach ($sel_status as $key => $value) {
                        echo '<input type="hidden" name="booking_status[]" value="'.$value.'">';
                    }
                }
                if(!empty($sel_property_type)){
                    foreach ($sel_property_type as $key => $value) {
                        echo '<input type="hidden" name="sel_property_type[]" value="'.$value.'">';
                    }
                }
                if(!empty($restaurants)){
                    foreach ($restaurants as $key => $value) {
                        echo '<input type="hidden" name="restaurants[]" value="'.$value.'">';
                    }
                }
                if(!empty($generic_columns)){
                    foreach ($generic_columns as $key => $value) {
                        echo '<input type="hidden" name="generic_columns[]" value="'.$value.'">';
                    }
                }
                if(!empty($days_columns)){
                    foreach ($days_columns as $date => $dtvalue) {
                        foreach ($dtvalue as $key => $value) {
                        echo '<input type="hidden" name="days_columns['.$date.'][]" value="'.$value.'">';
                        }
                    }
                }
    ?>
            </form>
                <?php

                ?>
                <div class="wrap_table withLeftButtons action_class wrap_table final-report-view">
                    <div class="data-wraper">
                        <div class="leftButtonsRow btn_wrapper">
                            <div class="top-title">
                                <h2 class="heading_title">View Master Booking List(<?php echo $total_rows;?>)</h2>
                            </div>
                        </div>
                        <?php 
                        $select_days = $this->input->post('select_days');
                        $sel_attend_type = $this->input->post('sel_attend_type');
                        $sel_status = $this->input->post('sel_status');
                        $sel_property_type = $this->input->post('sel_property_type');
                        $restaurants = $this->input->post('restaurants');
                        $generic_columns = $this->input->post('generic_columns');
                        $days_columns = $this->input->post('days_columns');
                        ?>
                        <div class="defaultDataTable master_reservation" id="total_master_reservation">
                            <table class="table_class table-gorup" id="all_report_list" width="100%">
                                <?php $dates = $select_days;
                                ?>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <?php if(in_array('first_name',$generic_columns)):?>
                                        <th>First Name</th>
                                        <?php endif;?>
                                        <?php if(in_array('last_name',$generic_columns)):?>
                                        <th>Last Name</th>
                                        <?php endif;?>
                                        <?php if(in_array('email',$generic_columns)):?>
                                        <th>Email Address</th>
                                        <?php endif;?>
                                        <?php if(in_array('response_status',$generic_columns)):?>
                                        <th>Response Status</th>
                                        <?php endif;?>
                                        <?php if(!empty($dates)){
                                            
                                            $def_dates = $this->admin_model->get_dates_list_booking();
                                            
                                            foreach($select_days as $date){
                                                $k=1; 
                                                foreach ($def_dates as $key => $inndate) {
                                                    if($inndate['date'] == $date){
                                                        $day = $k;
                                                    }
                                                    $k++;
                                                }
                                                $corrected_columns = array();
                                                foreach ($days_columns as $key => $value) {
                                                    $corrected_key = trim($key, "'");
                                                    $corrected_columns[$corrected_key] = $value;
                                                }
                                                ?>
                                        <?php if(in_array('status',$corrected_columns[$date])):?>
                                        <th>Day <?php echo $day;?> Status</th>
                                        <?php endif;?>
                                        <?php if(in_array('role',$corrected_columns[$date])):?>
                                        <th>Day <?php echo $day;?> Role</th>
                                        <?php endif;?>
                                        <?php if(in_array('date',$corrected_columns[$date])):?>
                                        <th>Day <?php echo $day;?> Date</th>
                                        <?php endif;?>
                                        <?php if(in_array('time',$corrected_columns[$date])):?>
                                        <th>Day <?php echo $day;?> Time</th>
                                        <?php endif;?>
                                        <?php if(in_array('restaurant_name',$corrected_columns[$date])):?>
                                        <th>Day <?php echo $day;?> Restaurant Name</th>
                                        <?php endif;?>
                                        <?php if(in_array('property_type',$corrected_columns[$date])):?>
                                        <th>Day <?php echo $day;?> Property Type</th>
                                        <?php endif;?>
                                        <?php if(in_array('pax',$corrected_columns[$date])):?>
                                        <th>Day <?php echo $day;?> Pax</th>
                                        <?php endif;?>
                                        <?php if(in_array('guests',$corrected_columns[$date])):?>
                                        <th>Day <?php echo $day;?> Guests</th>
                                        <?php endif;?>
                                        <?php if(in_array('admin_note',$corrected_columns[$date])):?>
                                        <th>Day <?php echo $day;?> Admin Note</th>
                                        <?php endif;?>
                                        <?php if(in_array('last_updated',$corrected_columns[$date])):?>
                                        <th>Day <?php echo $day;?> Last Updated</th>
                                        <?php endif;?>
                                        <?php }
                                        } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($list)):
                                    $j=1;
                                    foreach ($list as $key => $data) {
                                        $user_id = $data['id'];
                                        $booking = $this->admin_model->get_booking_detail_byuserid($user_id);
                                        $booking_status = 'No Response';
                                        if(!empty($dates) && !empty($booking)){
                                            $default_dates = $this->admin_model->get_dates_list_booking();
                                            $booked = 1;
                                            foreach($default_dates as $date){
                                                $status = $this->admin_model->get_status_of_booking_date_byid($booking['id'],$date['date']);
                                                if($status != 'Booked'){
                                                    $booked = 0;
                                                }
                                            }
                                            if($booked == 0){
                                                $booking_status = 'Partial';
                                            }
                                            if($booked == 1){
                                                $booking_status = 'Completed';
                                            }
                                        }
                                        $username = $data['full_name'];
                                        $exp = explode(' ',$username);
                                        $first_name = $exp[0];
                                        $last_name = $exp[1];
                                        ?>
                                    <tr>
                                        <td></td>
                                        <?php if(in_array('first_name',$generic_columns)):?>
                                        <td><?php echo $first_name;?></td>
                                        <?php endif;?>
                                        <?php if(in_array('last_name',$generic_columns)):?>
                                        <td><?php echo $last_name;?></td>
                                        <?php endif;?>
                                        <?php if(in_array('email',$generic_columns)):?>
                                        <td><?php echo $data['email'];?></td>
                                        <?php endif;?>
                                        <?php if(in_array('response_status',$generic_columns)):?>
                                        <td><?php echo $booking['booking_status'];?></td>
                                        <?php endif;?>
                                        <?php 
                                            if(!empty($dates)){
                                                foreach($dates as $date){
                                                // $reservation_status = 'Skipped';
                                                $reservation_status = 'No Response';
                                                $reservation_role = '';
                                                $reservation_date = '';
                                                $reservation_time = '';
                                                $reservation_restname = '';
                                                $reservation_resttype = '';
                                                $reservation_pax = '';
                                                $reservation_guests = '';
                                                $reservation_admin_note = '';
                                                $modify_date = '';
                                                $invite_status = $this->admin_model->get_invite_status_byuserid_bookdate($user_id,$date);
                                                if(!empty($invite_status)){
                                                    if($invite_status['status'] == 'invite'){
                                                        $reservation_status = 'Pending Acceptance';
                                                    }
                                                    $from_data = $this->admin_model->get_user_detail($invite_status['from_id']);
                                                    $reservation_role = 'Guest of '.$from_data['full_name'];
                                                }
                                                if(!empty($booking)){
                                                $reserv_data = $this->admin_model->get_booking_dates_list_by_bookingid_date($booking['id'],$date);
                                                    if(!empty($reserv_data)){
                                                        $reservation_admin_note = $reserv_data['admin_note'];
                                                        $reservation_status = ucfirst($reserv_data['booking_status']);
                                                        if($reserv_data['booking_status'] == 'skip'){
                                                            // $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
                                                            $reservation_status = $reserv_data['booking_reason'];
                                                        }
                                                        if($reserv_data['booking_status'] == 'cancel'){
                                                            $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
                                                        }
                                                        if($reserv_data['ref_id'] == 0){
                                                            $reservation_role = 'Primary';
                                                        }
                                                        $reservation_date = date('m-d-Y',strtotime($reserv_data['booking_date']));
                                                        $reservation_time = $reserv_data['booking_time'];
                                                        $reservation_pax = $reserv_data['booking_pax'];
                                                        $reservation_restname  = $this->admin_model->get_restaurant_name_byid($reserv_data['booking_restid']);
                                                        $property_type  = $this->admin_model->get_restaurant_type_byid($reserv_data['booking_restid']);
                                                        $reservation_resttype = $this->admin_model->get_property_type_text($property_type);
                                                        if($reserv_data['guests'] != ''){
                                                            $gexp = explode(',',$reserv_data['guests']);
                                                            $guest = [];
                                                            foreach($gexp as $gid){
                                                                $guest[] = $this->admin_model->get_user_name_byid($gid);
                                                            }
                                                            $reservation_guests = implode(', ',$guest);
                                                        }
                                                        if($reserv_data['booking_status'] == 'cancel' || $reserv_data['booking_status'] == 'skip'){
                                                            $reservation_role = '';
                                                            $reservation_date = '';
                                                            $reservation_time = '';
                                                            $reservation_restname = '';
                                                            $reservation_resttype = '';
                                                            $reservation_pax = '';
                                                            $reservation_guests = '';
                                                        }
                                                    }
                                                    $modify_date = date('m-d-Y H:i:s',strtotime($booking['modify_date']));
                                                }
                                                ?>
                                        <?php if(in_array('status',$corrected_columns[$date])):?>
                                        <td><?php echo $reservation_status;?></td>
                                        <?php endif;?>
                                        <?php if(in_array('role',$corrected_columns[$date])):?>
                                        <td><?php echo $reservation_role;?></td>
                                        <?php endif;?>
                                        <?php if(in_array('date',$corrected_columns[$date])):?>
                                        <td><?php echo $reservation_date;?></td>
                                        <?php endif;?>
                                        <?php if(in_array('time',$corrected_columns[$date])):?>
                                        <td class="<?php echo $reservation_time;?>">
                                            <?php 
                                            if (str_contains($reservation_time, 'pm')){
                                                echo(str_replace("pm"," pm",$reservation_time));
                                            }elseif(str_contains($reservation_time, 'am')){
                                                echo(str_replace("am"," am",$reservation_time));
                                            }else{
                                                echo $reservation_time;
                                            }
                                            ?>
                                            <?php //echo $reservation_time;?>
                                        </td>
                                        <?php endif;?>
                                        <?php if(in_array('restaurant_name',$corrected_columns[$date])):?>
                                        <td><?php echo $reservation_restname;?></td>
                                        <?php endif;?>
                                        <?php if(in_array('property_type',$corrected_columns[$date])):?>
                                        <td><?php echo $reservation_resttype;?></td>
                                        <?php endif;?>
                                        <?php if(in_array('pax',$corrected_columns[$date])):?>
                                        <td><?php echo $reservation_pax;?></td>
                                        <?php endif;?>
                                        <?php if(in_array('guests',$corrected_columns[$date])):?>
                                        <td><?php echo $reservation_guests;?></td>
                                        <?php endif;?>
                                        <?php if(in_array('admin_note',$corrected_columns[$date])):?>
                                        <td><?php echo $reservation_admin_note;?></td>
                                        <?php endif;?>
                                        <?php if(in_array('last_updated',$corrected_columns[$date])):?>
                                        <td><?php echo $modify_date;?></td>
                                        <?php endif;?>
                                        <?php }
                                                } ?>

                                    </tr>
                                    <?php
                                            $j++; }
                                    endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="btn-group">
                                <a href="<?php echo site_url('admin/reports_steps');?>" class="btn btn_add right-arrow">
                                <img src="<?php echo base_url(); ?>/uploads/assets/images/arrow-rt.svg" alt="">                        
                                New report</a>
                                <button type="button" class="btn btn_add" id="export_excel_btn"><img
                                        src="<?php echo base_url(); ?>/uploads/assets/images/download_sheet.svg" alt="">
                                    Download Report</button>
                                <!-- <button type="button" class="btn btn_add save_reportfilter_fileds">Save Report Filter</button> -->
                                
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
</div>
<script>
        var userList = $("#all_report_list").DataTable({
    language: {
        sLengthMenu: "Show Entries: _MENU_",
        searchPlaceholder: "Please search here..."
    },
    'columnDefs': [ {
      'targets': [1], // column index (start from 0)
      'orderable': false, // set orderable false for selected columns
   }],
    dom: '<"#top_filter"lf>rt<"#bottom_page"ip><"clear">',
    "responsive": false,
  });
$("#from_date_select").datepicker({
    dateFormat: "dd-mm-yy",
    duration: "fast",
    onSelect: function(selected) {
          $("#to_date_select").datepicker("option","minDate", selected)
    }
});
$("#to_date_select").datepicker({
    dateFormat: "dd-mm-yy",
    duration: "fast"
});
$(document).on('change', '#complete_booking input, #complete_booking select', function(e) {
    e.preventDefault();
    ajax_filter_form_complete_booking(0);
    return false;
});
$(document).on('click', '#export_excel_btn', function(e) {
    var form = $('#complete_booking')[0];
    var data = new FormData(form);
    $.ajax({
        url: site_url + 'admin/export_master_report_generate',
        type: 'post',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function(res) {
        },
        success: function(result) {
            var $a = $("<a>");
            $a.attr("href",result.data);
            $("body").append($a);
            $a.attr("download",result.filename);
            $a[0].click();
            $a.remove();
        }
    });
});
$(document).on('submit', '#complete_booking', function(e) {
    e.preventDefault();
    ajax_filter_form_complete_booking(0);
});
function ajax_filter_form_complete_booking(paged){
    var form = $('#complete_booking')[0];
    var data = new FormData(form);
    data.append('page',paged);
    $.ajax({
        url: site_url + 'admin/ajax_master_report_generate',
        type: 'post',
        data: data,
        dataType: 'html',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function(res) {
        },
        success: function(result) {
            $('#total_master_reservation').html(result);
        }
    });
}
</script>
