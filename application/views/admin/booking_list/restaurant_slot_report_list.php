<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="heading_title">View Restaurant Slot Reservation List(<?php echo $total_rows;?>)</h2>
            <div class="wrap_table withLeftButtons action_class">
                <form action="<?php echo site_url('admin/master_booking_list');?>" id="complete_booking" method="post">
                    <div class="leftButtonsRow">
                        <input type="hidden" value="restaurant_slot_reservation_list" name="exportfilename">
                        <button type="button" class="btn btn_add" id="export_excel_btn"><img
                                src="<?php echo base_url(); ?>/uploads/assets/images/download_sheet.svg" alt="">
                            Download Report</button>
                    </div>
                    <div id="top_filter">
                        <input type="hidden" name="order" id="order">
                        <input type="hidden" name="orderby" id="orderby">
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
                    <table class="table_class table-gorup" id="total_reservation34" width="100%">
                        <?php $dates = $this->admin_model->get_dates_list_booking();?>
                        <thead>
                            <tr>
                                <th class="sorting"></th>
                                <th class="sorting" data-column="name">Restaurant Name</th>
                                <th>Property type</th>
                                <th class="sorting" data-column="time">Reservation Time (EST)</th>
                                <th class="sorting" data-column="date">Reservation Date</th>
                                <th class="sorting" data-column="size">Table Size</th>
                                <th class="sorting" data-column="capacity">Capacity</th>
                                <th class="sorting" data-column="booked">Booked</th>
                                <th class="sorting" data-column="remaining">Remaining</th>
                                <th class="" data-column="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(!empty($list)):
                                foreach ($list as $key => $data) {
                                    $booked = $this->admin_model->count_booked_tablle_byrestid_date($data['restaurant_id'],$data['date'],$data['time'],$data['size']);
                                    $remain = $data['capacity'] - $booked;
                                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $data['restaurant_name'];?></td>
                                <td><?php echo $this->admin_model->get_property_type_text($data['property_type']);?></td>
                                <td><?php echo $data['time'];?></td>
                                <td><?php echo date('m-d-Y',strtotime($data['date']));?></td>
                                <td><?php echo $data['size'];?></td>
                                <td><?php echo $data['capacity'];?></td>
                                <td><?php echo $booked;?></td>
                                <td><?php echo $remain;?></td>
                                <td>
                                    <?php if($booked > 0){?>
                                    <a href="javascript:void(0)" class="view_booked_slot_btn" data-popup="view_booked_slot" data-restid="<?php echo $data['restaurant_id'];?>" data-date="<?php echo $data['date'];?>"  data-time="<?php echo $data['time'];?>"  data-size="<?php echo $data['size'];?>">
                                        <img src="<?php echo base_url(); ?>/uploads/assets/images/eye_full.svg" alt="">
                                        View
                                    </a>
                                    <?php } ?>
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
        url: site_url + 'admin/export_restaurant_slot_report_list',
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
        url: site_url + 'admin/ajax_restaurant_slot_report_list',
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

$(document).on('click','#total_master_reservation table th',function(){
    var _this = $(this);
    var _text = $(this).text();
    $('#total_master_reservation table th').each(function(){
        if($(this).text() != _text ){
            $(this).addClass('sorting').removeClass('sorting_asc').removeClass('sorting_desc');    
        }
    });
    var table_column = $(this).attr('data-column');
    var _order = 'DESC';

    if(_this.hasClass('sorting'))
    {
        _this.removeClass('sorting sorting_desc').addClass('sorting_asc');

    }else if(_this.hasClass('sorting_asc')){
        var _order = 'ASC';
        _this.removeClass('sorting sorting_asc').addClass('sorting_desc');

    }else if(_this.hasClass('sorting_desc')){
        _this.removeClass('sorting sorting_desc').addClass('sorting_asc');
    }
    $('#order').val(table_column);
    $('#orderby').val(_order);
    ajax_filter_form_complete_booking(0);
});
</script>