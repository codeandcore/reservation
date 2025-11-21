<?php $status = $this->input->get('book_status');
$link = '';
if($status){
    $head = $status;
    if($status = "Partial"){

        $link = '/?book_status='.$status;
    }
}
else{
    $head = 'Accepted';
}
?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-between">
                <h2 class="heading_title"><?php echo $head;?> Reservations(<?php echo $total_rows;?>)</h2>
                <div class="viewGridButton">
                    <a href="<?php echo site_url('admin/all_booking_list'. $link);?>" class="btn btn_add"><img src="<?php echo base_url(); ?>/uploads/assets/images/list.svg">List View</a>
                    <a href="<?php echo site_url('admin/all_booking_detail_list'. $link);?>" class="btn active btn_add"><img src="<?php echo base_url(); ?>/uploads/assets/images/grid.svg">Detail View</a>
                </div>    
            </div>
            <div class="wrap_table withLeftButtons action_class">
                <form action="<?php echo site_url('admin/master_booking_list');?>" id="complete_booking" method="post">
                    <div class="leftButtonsRow">
                    <input type="hidden" value="accepted_reservations" name="exportfilename">
                        <button type="button" class="btn btn_add" id="export_excel_btn"><img
                                src="<?php echo base_url(); ?>/uploads/assets/images/download_sheet.svg" alt="">
                            Download Report</button>
                        <div class="startToendSearch">

                            <div class="innerSearchDate">
                                <div class="searchDate">
                                    <span class="searchDateTitle">Start Date:</span>
                                    <div class="searchDateInput">
                                        <input type="text" id="from_date_select" name="min" placeholder="--/--/----">
                                    </div>
                                </div>
                                <div class="searchDate">
                                    <span class="searchDateTitle">End Date:</span>
                                    <div class="searchDateInput">
                                        <input type="text" id="to_date_select" name="max" placeholder="--/--/----">
                                    </div>
                                </div>
                                <div class="searchDateButton">
                                    <input type="submit" value="search" class="btn">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="top_filter">
                        <div class="dataTables_length" id="book_status">
                            <label>Status:
                                <select name="book_status" aria-controls="book_status" id="book_status"
                                    style="width:160px;">
                                    <option value="">All Status</option>
                                    <option value="Completed" <?php if($status == 'Completed'){ echo 'selected';}?>>
                                        Completed</option>
                                    <option value="Partial" <?php if($status == 'Partial'){ echo 'selected';}?>>Partial
                                    </option>
                                </select>
                            </label>
                        </div>
                        <div class="dataTables_length" id="page_length">
                            <label>Show Entries:
                                <select name="length" aria-controls="page_length" id="page_length" style="width:60px;">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </label>
                        </div>
                        <div id="all_restaurants_filter" class="dataTables_filter">
                            <label>Search:<input type="search" name="search_keyword" placeholder="Please search here..."
                                    aria-controls="all_restaurants" style="width:230px;"></label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table_filter_wrap">

            </div>
            <div class="wrap_table">
                <div class="defaultDataTable cmn-scroll" id="total_master_reservation">
                    <table class="table_class table-gorup" id="total_reservation1" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Confirmation ID</th>
                                <th>Invited Type</th>
                                <th>User name</th>
                                <th>User email</th>
                                <th>Restaurant name</th>
                                <th>Date</th>
                                <th>Time (EST)</th>
                                <th>Skip days</th>
                                <th>No of People</th>
                                <th>Deposit $</th>
                                <th>Booked Date</th>
                                <th>Booked Time (EST)</th>
                                <th>Modified Date</th>
                                <th>Admin Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($list)){
                            $j=1;
                                foreach ($list as $key => $data) {
                                    $bookings = $this->admin_model->get_booking_dates_list($data['id']);
                                    $k = 1;
                                    foreach($bookings as $book){
                                        $bid = '#'.$data['id'];
                                        $user_id = $data['user_id'];
                                        $udata = $this->admin_model->get_user_date_byid($user_id);
                                        $busname = $udata['full_name'];
                                        $bemail = $udata['email'];
                                        if($k==1){
                                            // $bid = '#'.$data['id'];
                                            // $user_id = $data['user_id'];
                                            // $udata = $this->admin_model->get_user_date_byid($user_id);
                                            // $busname = $udata['full_name'];
                                            // $bemail = $udata['email'];
                                            $bdate = date('m-d-Y',strtotime($book['created_date']));
                                            $btime = date('h:ia',strtotime($book['created_date']));
                                        }
                                        else{
                                            $bid = '';
                                            // $busname = '';
                                            // $bemail = '';
                                            $bdate = '';
                                            $btime = '';
                                        }
                                        if($book['ref_id'] == 0){
                                            $type = 'Primary';
                                        }
                                        else{
                                            $type = 'Guest';
                                        }
                                    $booking_time = $book['booking_time'];
                                    $booking_pax = $book['booking_pax'];
                                    $modify_date = date('m-d-Y',strtotime($book['modify_date']));
                                    $booking_date = date('m-d-Y',strtotime($book['booking_date']));
                                    $booking_deposite = '$'.$book['booking_deposite'];
                                    $booking_skip = '';
                                    $rest_name = $this->admin_model->get_restaurant_name_byid($book['booking_restid']);
                                    if($book['booking_status'] == 'skip'){
                                        $rest_name = '';
                                        $booking_time = '';
                                        $booking_pax = '';
                                        $booking_date = '<span class="skipText">'.date('m-d-Y',strtotime($book['booking_date'])).'</span>';
                                        $booking_deposite = '';
                                        $bdate = '';
                                        $btime = '';
                                        $modify_date = '';
                                        $booking_skip = '<span class="skipText">Skip</span>';
                                    }
                                    else if($book['booking_status'] == 'cancel'){
                                        $rest_name = '';
                                        $booking_time = '';
                                        $booking_pax = '';
                                        $booking_date = '<span class="skipText">'.date('m-d-Y',strtotime($book['booking_date'])).'</span>';
                                        $booking_deposite = '';
                                        $bdate = '';
                                        $btime = '';
                                        $modify_date = '';
                                        $booking_skip = '<span class="skipText">Cancel</span>';
                                    }
                                ?>
                                <tr class="<?php if($j % 2 == 0){ echo 'groupOdd';} else{ echo 'groupEven';}?>">
                                    <td></td>
                                    <td><?php echo $bid;?></td>
                                    <td><?php echo $type;?></td>
                                    <td><?php echo $busname;?></td>
                                    <td><?php echo $bemail;?></td>
                                    <td><?php echo $rest_name;?></td>
                                    <td><?php echo $booking_date;?></td>
                                    <td><?php echo $booking_time;?></td>
                                    <td><?php echo $booking_skip;?></td>
                                    <td><?php echo $booking_pax;?></td>
                                    <td><?php echo $booking_deposite;?></td>
                                    <td><?php echo $bdate;?></td>
                                    <td><?php echo $btime;?></td>
                                    <td><?php echo $modify_date;?></td>
                                    <td><?php echo $book['admin_note'];?></td>
                                    <td>
                                        <?php if($k==1){ ?>
                                        <a href="<?php echo site_url('admin/view_booking_detail/'.$data['id']);?>" class="view_btn">
                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/eye_full.svg" alt="">
                                            View
                                        </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php $k++; } $j++; }
                                }
                                else{?>
                                <tr class="not-found">
                                    <td colspan="14" style="text-align:center;padding:10px;">No Records Found.</td>
                                </tr>
                                <?php
                                }
                                ?>
                        </tbody>
                    </table>
                    <?php echo $this->ajax_pagination->create_links();?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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
        url: site_url + 'admin/export_all_booking_detail_list',
        type: 'post',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function(res) {},
        success: function(result) {
            var $a = $("<a>");
            $a.attr("href", result.data);
            $("body").append($a);
            $a.attr("download", result.filename);
            $a[0].click();
            $a.remove();
        }
    });
});
$(document).on('submit', '#complete_booking', function(e) {
    e.preventDefault();
    ajax_filter_form_complete_booking(0);
});

function ajax_filter_form_complete_booking(paged) {
    var form = $('#complete_booking')[0];
    var data = new FormData(form);
    data.append('page', paged);
    $.ajax({
        url: site_url + 'admin/ajax_all_booking_detail_list',
        type: 'post',
        data: data,
        dataType: 'html',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function(res) {},
        success: function(result) {
            $('#total_master_reservation').html(result);
        }
    });
}
$(document).ready(function() {
    // ajax_filter_form_complete_booking(0);
});
</script>