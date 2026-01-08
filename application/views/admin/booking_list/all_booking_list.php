<?php $status = $this->input->get('book_status');
$link = '';
if($status = "Partial"){
    $link = '/?book_status='.$status;
}

?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-between">
                <h2 class="heading_title">View All Booking List(<?php echo $total_rows;?>)</h2>
                <div class="viewGridButton">
                    <a href="<?php echo site_url('admin/all_booking_list'.$link);?>" class="btn btn_add active"><img src="<?php echo base_url(); ?>/uploads/assets/images/list.svg">List View</a>
                    <a href="<?php echo site_url('admin/all_booking_detail_list'.$link);?>" class="btn btn_add"><img src="<?php echo base_url(); ?>/uploads/assets/images/grid.svg">Detail View</a>
                </div>
            </div>
            <div class="wrap_table withLeftButtons action_class">
                <form action="<?php echo site_url('admin/master_booking_list');?>" id="complete_booking" method="post">
                    <div class="leftButtonsRow">
                    <input type="hidden" value="all_booking_list" name="exportfilename">
                    
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
                        <!-- New Sort Dropdown -->
                        <div class="dataTables_sort dataTables_length " id="date_sort">
                            <label>Sort By:
                                <select name="sort_order" id="sort_order" style="width:150px;">
                                    <option value="" selected>Select</option>
                                    <option value="newest">Most Recent</option>
                                    <option value="oldest">Oldest</option>
                                </select>
                            </label>
                        </div>
                        <div class="dataTables_length" id="book_status">
                            <label>Status:
                                <select name="book_status" aria-controls="book_status" id="book_status"
                                    style="width:160px;">
                                    <option value="">All Status</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Partial">Partial</option>
                                    <option value="No Response">No Response</option>
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
                <div class="defaultDataTable" id="total_master_reservation">
                    <table class="table_class table-gorup" id="total_reservation1" width="100%">
                        <?php $dates = $this->admin_model->get_dates_list_booking();?>
                        <thead>
                            <tr>
                                <th></th>
                                <th>User Code</th>
                                <th>Full Name</th>
                                <th>User Email</th>
                                <th>Alternate Email</th>
                                <th>Booking Status</th>
                                <?php if(!empty($dates)){
                                    foreach($dates as $date){?>
                                <th><?php echo date('m-d-Y',strtotime($date['date']));?></th>
                                    <?php }
                                } ?>
                                <th>Modifed Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list)):
                                    $j=1;
                                        foreach ($list as $key => $data) {
                                            $user_id = $data['id'];
                                            $booking = $this->admin_model->get_booking_detail_byuserid($user_id);
                                            $booking_status = 'No Response';
                                            // $reservation_status = 'Skipped';
                                            $reservation_status = 'No Response';
                                            if(!empty($dates) && !empty($booking)){
                                                $booked = 1;
                                                foreach($dates as $date){
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
                                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $data['user_code'];?></td>
                                <td><?php echo $data['full_name'];?></td>
                                <td><?php echo $data['email'];?></td>
                                <td><?php echo $data['alternate_email'];?></td>
                                <td><?php echo $booking_status;?></td>
                                <?php if(!empty($dates)){
                                                        foreach($dates as $date){
                                                            if(!empty($booking)){
                                                                $reserv_data = $this->admin_model->get_booking_dates_list_by_bookingid_date($booking['id'],$date['date']);
                                                                    if(!empty($reserv_data)){
                                                                        $reservation_status = ucfirst($reserv_data['booking_status']);
                                                                        if($reserv_data['booking_status'] == 'skip'){
                                                                            // $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
                                                                            $reservation_status = $reserv_data['booking_reason'];
                                                                        }
                                                                        if($reserv_data['booking_status'] == 'cancel'){
                                                                            $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
                                                                        }
                                                                    }
                                                                }
                                                    ?>
                                <td><?php echo $reservation_status;?></td>
                                <?php }
                                } ?>
                                <td><?php if(!empty($booking)){ echo date('m-d-Y',strtotime($booking['modify_date']));}?></td>
                                <td>
                                    <?php if(!empty($booking)){?>
                                    <a href="<?php echo site_url('admin/view_booking_detail/'.$booking['id']);?>"
                                        class="view_btn">
                                        <img src="<?php echo base_url(); ?>/uploads/assets/images/eye_full.svg" alt="">
                                        View
                                    </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                                             $j++; }
                                        endif; ?>
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
        url: site_url + 'admin/export_all_booking_list',
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
        url: site_url + 'admin/ajax_all_booking_list',
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
</script>