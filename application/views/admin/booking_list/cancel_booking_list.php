<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="heading_title">View All Cancel Reservation User(<?php echo count($list);?>)</h2>
            <div class="wrap_table withLeftButtons action_class">
                <form action="<?php echo site_url('admin/master_booking_list');?>" id="complete_booking" method="post">
                    <div class="leftButtonsRow">
                        <input type="hidden" value="cancel_reservation_user" name="exportfilename">
                        <button type="button" class="btn btn_add" id="export_excel_btn"><img
                                src="<?php echo base_url(); ?>/uploads/assets/images/download_sheet.svg" alt="">
                            Download Report</button>
                    </div>
                    <div id="top_filter">
                        <div class="dataTables_length" id="page_length">
                            <label>Show Entries:
                                <select name="length" aria-controls="page_length" id="page_length">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </label>
                        </div>
                        <div id="all_restaurants_filter" class="dataTables_filter">
                            <label>Search:<input type="search" name="search_keyword" placeholder="Please search here..."
                                    aria-controls="all_restaurants"></label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table_filter_wrap">

            </div>
            <div class="wrap_table">
                <div class="defaultDataTable" id="total_master_reservation">
                    <table class="table_class" id="total_reservation1" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Confirmation ID</th>
                                <th>User name</th>
                                <th>User email</th>
                                <th>Restaurant name</th>
                                <th>Date</th>
                                <th>Time (EST)</th>
                                <th>No of People</th>
                                <th>Deposit $</th>
                                <th>Cancelled Date</th>
                                <th>Cancelled Time (EST)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list)):
                                foreach ($list as $key => $data) {
                                    $user_id = $data['user_id'];
                                    $udata = $this->admin_model->get_user_date_byid($user_id);
                                    $busname = $udata['full_name'];
                                    $bemail = $udata['email'];
                                    $bdate = date('d-m-Y',strtotime($data['created_date']));
                                    $btime = date('h:ia',strtotime($data['created_date']));
                                    $rest_name = $this->admin_model->get_restaurant_name_byid($data['booking_restid']);
                                ?>
                            <tr>
                                <td></td>
                                <td>#<?php echo $data['booking_id'];?></td>
                                <td><?php echo $busname;?></td>
                                <td><?php echo $bemail;?></td>
                                <td><?php echo $rest_name;?></td>
                                <td><?php echo date('m-d-Y',strtotime($data['booking_date']));?></td>
                                <td><?php echo $data['booking_time'];?></td>
                                <td><?php echo $data['booking_pax'];?></td>
                                <td>$<?php echo $data['booking_deposite'];?></td>
                                <td><?php echo $bdate;?></td>
                                <td><?php echo $btime;?></td>
                                <td>

                                    <a href="<?php echo site_url('admin/view_booking_detail/'.$data['booking_id']);?>"
                                        class="view_btn">
                                        <img src="assets/images/eye_full.svg" alt="">View
                                    </a>
                                </td>
                            </tr>
                            <?php }
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
$(document).on('change', '#complete_booking input, #complete_booking select', function(e) {
    e.preventDefault();
    ajax_filter_form_complete_booking(0);
    return false;
});
$(document).on('click', '#export_excel_btn', function(e) {
    var form = $('#complete_booking')[0];
    var data = new FormData(form);
    $.ajax({
        url: site_url + 'admin/export_cancel_booking_list',
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
        url: site_url + 'admin/ajax_cancel_booking_list',
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