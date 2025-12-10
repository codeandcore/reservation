<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        <div class="d-flex align-items-center justify-between">
                <h2 class="heading_title">View All Modify Logs(<?php echo $total_rows;?>)</h2>
</div>
            <div class="wrap_table withLeftButtons action_class">
                <form action="<?php echo site_url('admin/master_booking_list');?>" id="complete_booking" method="post">
                    <div class="leftButtonsRow">
                    <input type="hidden" value="all_modify_logs" name="exportfilename">

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
                                    aria-controls="all_restaurants" style="width:330px;"></label>
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
                                <th>Time Stamp </th>
                                <th>Booking ID</th>
                                <th>Action Performed</th>
                                <th>By</th>
                                <th>By Email</th>
                                <th>For User</th>
                                <th>To User</th>
                                <th>Restaurent Name</th>
                                <th>Restaurent Date</th>
                                <th>Restaurent Time (EST)</th>
                                <th>No of People</th>
                                <th>Reason Note</th>
                                <th>Admin Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list)):
                                    $j=1;
                                        foreach ($list as $key => $data) { ?>
                            <tr>
                                <td></td>
                                <?php
                                $modify_date = date('m-d-Y h:i:s A',strtotime($data['timestamp']));

                                //Convert time stamp to NY time zone
                                // Create a DateTime object from the timestamp string
                                // $date = DateTime::createFromFormat('Y-m-d H:i:s', $data['timestamp'], new DateTimeZone('UTC'));

                                // Set the target time zone (New York)
                                // $date->setTimezone(new DateTimeZone('America/New_York'));

                                // Format the date in the target time zone
                                // $new_york_time = $date->format('Y-m-d H:i:s');
                                // $modify_date = date('m-d-Y h:i:s A',strtotime($new_york_time));
                                ?>
                                <!-- <td><?php //echo date('m-d-Y h:i:s',strtotime($data['timestamp']));?></td> -->
                                <td><?php echo $modify_date;?></td>
                                <td><?php echo $data['booking_id'];?></td>
                                <td><?php echo $data['action'];?></td>
                                <td><?php echo $data['added_by'];?></td>
                                <td><?php echo $data['by_email'];?></td>
                                <td><?php echo $data['for_user'];?></td>
                                <td><?php echo $data['to_user'];?></td>
                                <td><?php echo $data['restaurant_name'];?></td>
                                <td><?php echo date('m-d-Y',strtotime($data['restaurant_date']));?></td>
                                <td><?php echo $data['restaurant_time'];?></td>
                                <td><?php echo $data['no_of_people'];?></td>
                                <td><?php echo $data['reason'];?></td>
                                <td><?php echo $data['admin_note'];?></td>
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
        url: site_url + 'admin/export_master_modification_logs',
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
        url: site_url + 'admin/ajax_master_modification_logs',
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