<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="heading_title">View Non-Responders(<?php echo count($list);?>)</h2>
            <div class="wrap_table withLeftButtons action_class">
                <form action="<?php echo site_url('admin/master_booking_list');?>" id="complete_booking" method="post">
                    <div class="leftButtonsRow">
                    <input type="hidden" value="non_responders" name="exportfilename">
                        <button type="button" class="btn btn_add" id="export_excel_btn"><img
                                src="<?php echo base_url(); ?>/uploads/assets/images/download_sheet.svg" alt="">
                            Download Report</button>
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
                                <select name="length" aria-controls="page_length" id="page_length" >
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
                    <table class="table_class" id="total_reservation2" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>User name</th>
                                <th>User email</th>
                                <th>User contact</th>
                                <th>Reservervation status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list)):
                                foreach ($list as $key => $data) {
                                ?>
                            <tr>
                                <td></td>
                                <td><?php echo $data['full_name'];?></td>
                                <td><?php echo $data['email'];?></td>
                                <td><?php echo $data['mobile_number'];?></td>
                                <td><a href="<?php echo site_url('add_booking_user/?email='.$data['email']);?>" target="_blank" class="edit_user_btn1">No Response</a></td>
                            </tr>
                            <?php } endif; ?>
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
        url: site_url + 'admin/export_pending_booking_list',
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
        url: site_url + 'admin/ajax_pending_booking_list',
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