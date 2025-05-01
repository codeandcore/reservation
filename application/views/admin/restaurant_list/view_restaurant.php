<div class="main-content">
    <div class="page-content add_restro">
        <div class="container-fluid bg_dark-white">
            <div class="bg_white wrap_reservation">
                <div class="head_top_reservation">
                    <h2>View Restaurant (<?php echo $data['restaurant_name'];?>)</h2>
                    <div class="filterIcon"><img src="<?php echo base_url(); ?>/uploads/assets/images/filter-icon.svg" alt=""></div>
                </div>
                <div class="addReservationForm wrap_reservation_list">
                    <form id="myForm" action="<?php echo site_url('admin/update_restaurant');?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-9">
                                <div class="restroBookRight">
                                    <!-- restroBookProgress -->
                                    <div class="restroBookProgress">
                                        <div class="progressStep">
                                            <div class="stepItem active">
                                                <div class="stepItemInner">
                                                    <div class="stepImgbox">
                                                        <div class="stepImg">
                                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/chart-icon.svg"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="stepText">
                                                        <h5>restaurants info</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="stepItem">
                                                <div class="stepItemInner">
                                                    <div class="stepImgbox">
                                                        <div class="stepImg">
                                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/slot-icon.svg"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="stepText">
                                                        <h5>booking slot</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="stepItem">
                                                <div class="stepItemInner">
                                                    <div class="stepImgbox">
                                                        <div class="stepImg">
                                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/review-icon.svg"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="stepText">
                                                        <h5>Reviews</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="stepItem">
                                                <div class="stepItemInner">
                                                    <div class="stepImgbox">
                                                        <div class="stepImg">
                                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/picture-upload-icon.svg"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="stepText">
                                                        <h5>Upload menu & images <span class="tooltip"
                                                                data-toggle="tooltip"><span class="tooltipBtn">?</span>
                                                                <span class="tooltipText">Images need to upload
                                                                    manually.</span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- restroBookProgress -->
                                    <div class="restro_info">
                                        <div class="restro_info_row active">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="fluidLabel">Restaurants Name</label>
                                                        <div class="view_description"><?php echo $data['restaurant_name'];?></div>
                                                    </div>
                                                    <input type="hidden" name="rest_id" value="<?php echo $data['id'];?>">
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="fluidLabel">Website Link</label>
                                                        <div class="view_description"><?php echo $data['website_link'];?></div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="fluidLabel">Restaurant Unique ID</label>
                                                        <div class="view_description"><?php echo $data['restaurant_code'];?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="fluidLabel">Location Link</label>
                                                        <div class="view_description"><?php echo $data['location_link'];?></div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="fluidLabel">Contact Number</label>
                                                        <div class="view_description"><?php echo $data['contact'];?></div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="fluidLabel">Email Id</label>
                                                        <div class="view_description"><?php echo $data['email'];?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="fluidLabel">Restaurants Description</label>
                                                        <div class="view_description"><?php echo $data['description'];?></div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="fluidLabel">Restaurants Address</label>
                                                        <div class="view_description"><?php echo $data['address'];?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0 ">
                                                <div class="col-5 d-flex align-items-center">
                                                    <h5>deposit applicable:</h5>
                                                    <div class="radio-group d-flex deposit_radio_wrap">
                                                        <label for="deposit_yes" class="label-selected" <?php if($data['deposite'] == 'yes'){ echo 'class="label-selected"';}?>><input type="radio" class="radio"
                                                                name="deposit" value="yes" id="deposit_yes" <?php if($data['deposite'] == 'yes'){ echo 'checked';}?> checked readonly><?php echo ucfirst($data['deposite']);?></label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-4"> <input type="number" name="amount"
                                                        class="amount_field" placeholder="Please Enter Amount" value="<?php echo $data['deposite_amount'];?>" <?php if($data['deposite'] == 'yes'){ echo 'style="display: inline-block;"';}?> readonly> </div>
                                            </div>
                                        </div>
                                        <div class="restro_info_row restro_time_info">
                                            <div class="wrap_table all_restaurants_table action_class">
                                                <div class="defaultDataTable">
                                                    <table class="table_class" id="all_restaurants_bookingList" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Reservation Time</th>
                                                                <th>Reservation Date</th>
                                                                <th>Table Size</th>
                                                                <th>Capacity</th>
                                                                <th>Booked</th>
                                                                <th>Remaining</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(!empty($tables)){
                                                                foreach($tables as $td){
                                                                    $booked = $this->admin_model->count_booked_tablle_byrestid_date($data['id'],$td['date'],$td['time'],$td['size']);
                                                                    $remain = $td['capacity'] - $booked;
                                                                ?>
                                                        <tr ><td></td><td><?php echo $td['time'];?><input type="hidden" name="tableli_time[]" value="<?php echo $td['time'];?>"></td><td><?php echo date('m-d-Y',strtotime($td['date']));?><input type="hidden" name="tableli_date[]" value="<?php echo date('d-m-Y',strtotime($td['date']));?>"></td><td><?php echo $td['size'];?><input type="hidden" name="tableli_size[]" value="<?php echo $td['size'];?>"></td><td><?php echo $td['capacity'];?><input type="hidden" name="tableli_capacity[]" value="<?php echo $td['capacity'];?>"></td><td class="booked"><?php echo $booked;?></td><td><?php echo $remain;?></td></tr>
                                                        <?php } } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="restro_info_row">
                                            <div class="wrap_table">
                                                <div class="defaultDataTable">
                                                    <table class="table_class" id="reviewsList" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>User Image</th>
                                                                <th>Name</th>
                                                                <th>Date</th>
                                                                <th>Reviews</th>
                                                                <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(!empty($reviews)){
                                                                foreach($reviews as $rate){?>
                                                                <tr><td></td><td><div class="restaurant_img"><img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $rate['person_pic'];?>" alt=""><input type="hidden" name="review_photo[]" value="<?php echo $rate['person_pic'];?>"></div></td><td><?php echo $rate['person_name'];?><input type="hidden" name="hide_review_name[]" value="<?php echo $rate['person_name'];?>"></td><td><?php echo date('m-d-Y',strtotime($rate['review_date']));?><input type="hidden" name="hide_review_date[]" value="<?php echo date('d-m-Y',strtotime($rate['review_date']));?>"></td><td><?php echo $rate['rating'];?><input type="hidden" name="hide_review_rating[]" value="<?php echo $rate['rating'];?>"></td><td><div class="reviewDescrip"><?php echo $rate['description'];?></div><input type="hidden" name="hide_review_description[]" value="<?php echo $rate['description'];?>"></td></tr>
                                                                <?php }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>                                               
                                        </div>
                                        <div class="restro_info_row">
                                            <div class="restorContentBox">
                                                <h5>RESTAURANTS Content:</h5>
                                                <div class="view_description"><?php echo $data['full_content'];?></div>
                                            </div>
                                            <div class="file_upload_section">
                                                <div class="form-group file_upload row">
                                                    <div class="col-6">
                                                        <h5>Restaurant menu images:</h5>
                                                        <div class="upload__img-wrap">
                                                            <?php if($data['menu_images']){
                                                                $menu_ary = explode(',',$data['menu_images']);
                                                                foreach($menu_ary as $img){ ?>
                                                            <div class="upload__img-box">
                                                                <input type="hidden" name="hide_menu_images[]" value="<?php echo $img;?>">
                                                                <div style="background-image:url(<?php echo base_url(); ?>/uploads/assets/images/<?php echo $img;?>);" class="img-bg"></div>
                                                            </div>
                                                            <?php }
                                                            }?>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5>Restaurant Feature image:</h5>
                                                        <div class="upload__img-wrap">
                                                            <?php if($data['feature_image']){
                                                                    $menu_ary = explode(',',$data['feature_image']);
                                                                    foreach($menu_ary as $img){ ?>
                                                                <div class="upload__img-box">
                                                                    <input type="hidden" name="hide_feature_image" value="<?php echo $img;?>">
                                                                    <div style="background-image:url(<?php echo base_url(); ?>/uploads/assets/images/<?php echo $img;?>);" class="img-bg"></div>
                                                                </div>
                                                                <?php }
                                                                }?>
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="form-group file_upload row">
                                                    <div class="col-6">
                                                        <h5>Restaurant images:</h5>
                                                        <div class="upload__img-wrap">
                                                            <?php if($data['gallery']){
                                                                $menu_ary = explode(',',$data['gallery']);
                                                                foreach($menu_ary as $img){ ?>
                                                            <div class="upload__img-box">
                                                                <input type="hidden" name="hide_gallery[]" value="<?php echo $img;?>">
                                                                <div style="background-image:url(<?php echo base_url(); ?>/uploads/assets/images/<?php echo $img;?>);" class="img-bg"></div>
                                                            </div>
                                                            <?php }
                                                            }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="submitForm">
                                            <a href="javascript:;" class="btn btn-dark" id="prevBtn">Prev</a>
                                            <a href="javascript:;" class="btn btn-primary" id="nextBtn">Next</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 filterCol">
                                <div class="filterLeft">
                                    <div class="filterBlock">
                                        <h3>FILTER</h3>
                                        <div class="filter-header">
                                            <h5>All Filter</h5>
                                        </div>
                                        <div class="filter-body">
                                            <p>You haven't selected any filter yet you can add filter by using below link:</p>
                                            <div id="sidebar_filterList_ajax">
                                                <?php $this->load->view('admin/restaurant_list/filter-sidebar');?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Add Filter form -->
                <div id="add_filter_form_ajax">
                    <?php $this->load->view('admin/restaurant_list/add_filter');?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var slug = function(str) {
    var $slug = '';
    var trimmed = $.trim(str);
    $slug = trimmed.replace(/[^a-z0-9-]/gi, '_').
    replace(/-+/g, '_').
    replace(/^-|-$/g, '');
    return $slug.toLowerCase();
}
$(document).on('submit', '#restro_admin_filter_form', function(e) {
    e.preventDefault();
    var form_data = new FormData(document.getElementById('restro_admin_filter_form'));
    $.ajax({
        url: '<?php echo base_url();?>index.php/admin/insert_filter',
        type: "post",
        data: form_data,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        success: function(data) {
            $('#sidebar_filterList_ajax').html(data.view_filter);
            $('#add_filter_form_ajax').html(data.add_filter);
            $('#add_filter_form_ajax a.close_btn').trigger('click');
        }
    });
});
$(document).on('click', '.add_new_fillte', function(e) {
    e.preventDefault();
    var table_array1 = $(".form-item1").val();
    if(table_array1 == ''){
        Swal.fire('Incorrect...', 'Empty Field!', 'error');
        return false;
    }
    var table_array1 = table_array1.replace(/([-,.€~!@#$%^&*()_+=`{}\[\]\|\\:;'<>])+/g, '');
    var table_text_slug = slug(table_array1);
    var form_data = new FormData(document.getElementById('restro_admin_filter_form'));
    form_data.append('table_text_slug', table_text_slug);
    $.ajax({
        url: '<?php echo base_url();?>index.php/admin/filter_icon_upload',
        type: "post",
        data: form_data,
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        success: function(data) {

            if (!(table_array1 == '')) {
                var _img = '';
                if (data != '') {
                    var _img = '<i><img src="<?php echo base_url(); ?>/uploads/assets/images/' +
                        data + '" alt=""></i>';
                }

                $('.addFilterItem:last-child').after(
                    '<div class="form-group row addFilterItem"> <div class="col-4"> <h5>' +
                    _img + table_array1 +
                    ' </h5></div> <div class="col-8"> <div class="d-flex align-items-top"> <input type="text"  placeholder="Enter ' +
                    table_array1 + '" class="form-item" data-type=' + table_text_slug +
                    '> <input type="button" value="ADD" class="add_value btn"> </div> <div class="added_values d-flex no-listed" id="add_table_list"> </div> </div> </div>'
                );
            } else {
                alert('Please Enter value');
            }
        }
    });

});
$(document).on('click', '.add_value', function() {
    var table_array = $(this).parent().find(".form-item").val();
    var input_name = $(this).parent().find(".form-item").attr('data-type');
    if (!(table_array == '')) {
        $(this).parents('.addFilterItem').find('.added_values').append(
            '<div class="data_single"><img src="<?php echo base_url(); ?>/uploads/assets/images/close-icon.svg" alt="close" class="deleteItem"><span>' +
            table_array + '<input type="hidden" name="filter_name[]" value="' + input_name +
            '"><input type="hidden" name="filter_value[]" value="' + table_array + '"></span></div>');
        $(this).parent().find(".form-item").val('');
    } else {
        alert('Please Enter value');
    }
});
// ClassicEditor.create(document.querySelector('.defaultEditor')).catch(error => {
//     console.error(error);
//     editor.resize('100%', '350')
// });
$("#date_select").datepicker({
    dateFormat: "dd-mm-yy",
    duration: "fast"
});
$("#review_date_input").datepicker({
    dateFormat: "dd-mm-yy",
    duration: "fast"
});
$('#time_input').timepicker();
$(document).on('click', '#add_date_multiple', function() {
    var date_array = moment($("#date_select").val()).format('DD/MM/YYYY');
    console.log(date_array);
    if (!(date_array == 'Invalid date')) {
        $('#add_dates_list').append(
            '<div class="data_single"><svg width="8" height="8" viewBox="0 0 8 8"> <path id="_211651_close_round_icon" data-name="211651_close_round_icon" d="M71.7,70.645l-2.72-2.72,2.72-2.72a.75.75,0,0,0-1.06-1.06l-2.72,2.72-2.72-2.72a.75.75,0,0,0-1.06,1.06l2.72,2.72-2.72,2.72a.75.75,0,0,0,1.06,1.06l2.72-2.72,2.72,2.72a.75.75,0,1,0,1.06-1.06Z" transform="translate(-63.925 -63.925)"></path></svg><span>' +
            date_array + '</span></div>');
    } else {
        alert('Please select Date');
    }
});

// time slot animation


$(document).on('click', '#add_time_multiple', function() {
    var time_slot = $('#time_select').val();

    if (!(time_slot == '')) {
        // convert time
        var timeSplit = time_slot.split(':'),
            hours,
            minutes,
            meridian;
        hours = timeSplit[0];
        minutes = timeSplit[1];
        if (hours > 12) {
            meridian = 'PM';
            hours -= 12;
        } else if (hours < 12) {
            meridian = 'AM';
            if (hours == 0) {
                hours = 12;
            }
        } else {
            meridian = 'PM';
        }

        $('#add_time_list').append(
            '<div class="data_single"><svg width="8" height="8" viewBox="0 0 8 8"> <path id="_211651_close_round_icon" data-name="211651_close_round_icon" d="M71.7,70.645l-2.72-2.72,2.72-2.72a.75.75,0,0,0-1.06-1.06l-2.72,2.72-2.72-2.72a.75.75,0,0,0-1.06,1.06l2.72,2.72-2.72,2.72a.75.75,0,0,0,1.06,1.06l2.72-2.72,2.72,2.72a.75.75,0,1,0,1.06-1.06Z" transform="translate(-63.925 -63.925)"></path></svg><span>' +
            hours + ':' + minutes + ' ' + meridian + '</span></div>');
    } else {
        alert('Please select Time slot');
    }
});

$(document).on('click', '#add_table_multiple', function() {
    var table_array = $("#table_size").val();
    if (!(table_array == '')) {
        $('#add_table_list').append(
            '<div class="data_single"><svg width="8" height="8" viewBox="0 0 8 8"> <path id="_211651_close_round_icon" data-name="211651_close_round_icon" d="M71.7,70.645l-2.72-2.72,2.72-2.72a.75.75,0,0,0-1.06-1.06l-2.72,2.72-2.72-2.72a.75.75,0,0,0-1.06,1.06l2.72,2.72-2.72,2.72a.75.75,0,0,0,1.06,1.06l2.72-2.72,2.72,2.72a.75.75,0,1,0,1.06-1.06Z" transform="translate(-63.925 -63.925)"></path></svg><span>' +
            table_array + '</span></div>');
    } else {
        alert('Please select Table number');
    }
});

$(document).on('click', '.data_single svg', function() {
    $(this).parents('.data_single').remove();
});
</script>