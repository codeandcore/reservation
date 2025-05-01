<div class="main-content">
    <div class="page-content add_restro">
        <div class="container-fluid bg_dark-white">
            <div class="bg_white wrap_reservation">
                <div class="head_top_reservation">
                    <h2>Edit Restaurant (<?php echo $data['restaurant_name'];?>)</h2>
                    <div class="filterIcon"><img src="<?php echo base_url(); ?>/uploads/assets/images/filter-icon.svg" alt=""></div>
                </div>
                <div class="addReservationForm wrap_reservation_list">
                    <form id="myForm" class="edit_restaurant_form" action="<?php echo site_url('admin/update_restaurant');?>" method="POST" enctype="multipart/form-data">
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
                                            <!-- <div class="stepItem">
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
                                            </div> -->
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
                                                    <label>Restaurant Name*</label>
                                                    <input type="text" name="restaurants_name"
                                                            placeholderrr="<?php if(!$data['restaurant_name']){echo 'Restaurant Name*';} ?>" value="<?php echo $data['restaurant_name'];?>"></div>
                                                            <input type="hidden" name="rest_id" value="<?php echo $data['id'];?>">
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                    <label>Restaurant Website URL</label>
                                                        <input type="url" name="website_link"
                                                            pattern="https://.*"
                                                            placeholderrr="<?php if(!$data['website_link']){echo 'Restaurant Website URL';} ?>" value="<?php echo $data['website_link'];?>"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                    <label>Restaurant Unique ID</label>
                                                        <input type="text" name="restaurants_code"
                                                            placeholderrr="<?php if(!$data['restaurant_code']){echo 'Restaurant Unique ID';} ?>" value="<?php echo $data['restaurant_code'];?>"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                    <label>Restaurant Map Link</label>
                                                    <input type="url" pattern="https://.*"
                                                            name="location_link"
                                                            placeholderrr="<?php if(!$data['location_link']){echo 'Restaurant Map Link';} ?>" value="<?php echo $data['location_link'];?>"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                    <label>Restaurant Phone Number</label>    
                                                    <input type="tel" name="contact_number"
                                                            placeholderrr="<?php if(!$data['contact']){echo 'Restaurant Phone Number';} ?>" value="<?php echo $data['contact'];?>"></div>
                                                </div>
                                                
                                                <div class="col-4">
                                                    <div class="form-group">
                                                    <label>Restaurant Email*</label>   
                                                        <input type="email" name="email"
                                                            placeholderrr="<?php if(!$data['email']){echo 'Restaurant Email*';} ?>" value="<?php echo $data['email'];?>"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                    <label>Restaurant Description*</label>  
                                                        <textarea
                                                            placeholderrr="<?php if(!$data['description']){echo 'Restaurant Description*';} ?>"
                                                            name="description" id="description"><?php echo $data['description'];?></textarea></div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                    <label>Restaurant Address</label>  
                                                    <textarea
                                                            placeholderrr="<?php if(!$data['address']){echo 'Restaurant Address';} ?>"
                                                            name="address" id="address"><?php echo $data['address'];?></textarea></div>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0 ">
                                                <div class="col-5 d-flex align-items-center">
                                                    <h5>deposit applicable:</h5>
                                                    <div class="radio-group d-flex deposit_radio_wrap">
                                                        <label for="deposit_yes" <?php if($data['deposite'] == 'yes'){ echo 'class="label-selected"';}?>><input type="radio" class="radio"
                                                                name="deposit" value="yes" id="deposit_yes" <?php if($data['deposite'] == 'yes'){ echo 'checked';}?>>yes</label>
                                                        <label for="deposit_no" <?php if($data['deposite'] == 'no' || $data['deposite'] == ''){ echo 'class="label-selected"';}?>><input
                                                                type="radio" class="radio" name="deposit" value="no"
                                                                id="deposit_no" <?php if($data['deposite'] == 'no'){ echo 'checked';}?>>no</label>
                                                    </div>
                                                </div>
                                                <div class="col-4"> 
                                                <label>Late Cancel/No-Show Fee</label>    
                                                <input type="number" name="amount"
                                                        class="amount_field" placeholderrr="<?php if(!$data['deposite_amount']){echo('Deposit Amount');} ?>" value="<?php echo $data['deposite_amount'];?>" <?php if($data['deposite'] == 'yes'){ echo 'style="display: inline-block;"';}?>> </div>
                                            </div>
                                        </div>
                                        <div class="restro_info_row restro_time_info">
                                            <div class="wrap_table all_restaurants_table action_class">
                                                <div class="leftButtonsRow btn_wrapper" id="add_slot_lists">
                                                    <button type="button" id="delete_bulk_slots" class="delete_bulk_slots_cls btn btn_add" data-resto="edit">Delete Slots</button>
                                                </div>
                                                <div class="defaultDataTable">
                                                    <table class="table_class" id="all_restaurants_bookingList" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th class="multi-user-select">
                                                                    <div class="custom-checkbox multi-user-select-wraper">
                                                                        <input class="form-input checkboxInput select-all-slots" type="checkbox" value="markAllSlots" id="markAllSlots" name="markAllSlots">
                                                                        <label class="checkboxLabel" for="markAllSlots">Select All</label>
                                                                    </div>
                                                                </th>
                                                                <th>Reservation Time</th>
                                                                <th>Reservation Date</th>
                                                                <th>Table Size</th>
                                                                <th>Capacity</th>
                                                                <th>Booked</th>
                                                                <th>Remaining</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(!empty($tables)){
                                                                foreach($tables as $td){
                                                                    $booked = $this->admin_model->count_booked_tablle_byrestid_date($data['id'],$td['date'],$td['time'],$td['size']);
                                                                    $remain = $td['capacity'] - $booked;
                                                                ?>
                                                        <tr >
                                                            <td></td>
                                                            <td><div class="custom-checkbox"><input type="checkbox" name="multi_slotid[]" class="form-input checkboxInput sloat_input_cls" id="editcheck<?php echo $td['id'];?>" value="<?php echo $td['id'];?>"><label class="checkboxLabel" for="editcheck<?php echo $td['id'];?>"></label></div></td>
                                                            <td><?php echo $td['time'];?><input type="hidden" name="tableli_time[]" value="<?php echo $td['time'];?>"></td><td><?php echo date('m-d-Y',strtotime($td['date']));?><input type="hidden" name="tableli_date[]" value="<?php echo date('m-d-Y',strtotime($td['date']));?>"></td><td><?php echo $td['size'];?><input type="hidden" name="tableli_size[]" value="<?php echo $td['size'];?>"></td><td><?php echo $td['capacity'];?><input type="hidden" name="tableli_capacity[]" value="<?php echo $td['capacity'];?>"></td>
                                                        <td class="booked">
                                                        <?php if($booked > 0){?>
                                                            <a href="javascript:void(0)" class="view_booked_slot_btn" data-popup="view_booked_slot" data-restid="<?php echo $td['restaurant_id'];?>" data-date="<?php echo $td['date'];?>"  data-time="<?php echo $td['time'];?>"  data-size="<?php echo $td['size'];?>">
                                                        <?php } ?>
                                                        <?php echo $booked;?>
                                                        <?php if($booked > 0){?>
                                                            </a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo $remain;?></td><td><a href="javascript:void(0)" class="drop_dots"><img src="<?php echo base_url(); ?>/uploads/assets/images/three_dots.svg" alt=""></a>
                                                        <ul class="action_drop">
                                                            <li><a href="javascript:void(0)" data-edit="edit"><img src="<?php echo base_url(); ?>/uploads/assets/images/edit.svg" alt="">Edit</a></li>
                                                            
                                                            <li><a href="javascript:void(0)" data-booked="<?php echo $booked;?>" data-delete="delete"><img src="<?php echo base_url(); ?>/uploads/assets/images/trash.svg" alt="">Delete</a></li>
                                                        </ul></td></tr>
                                                        <?php } } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="slotBooking">
                                                    <div class="form-group row">
                                                        <div class="col selectInput time_select">
                                                            <label>Reservation Time</label>
                                                            <!-- <input type="text" name="time_select" placeholderrr="Enter Reservation Time" id="time_input"
                                                                class="cmnSelect1"> -->
                                                            <input type="text" name="time_select" placeholderrr="" id="time_input"
                                                                class="cmnSelect1">
                                                        </div>
                                                        <div class="col">
                                                            <label>Reservation Date</label>
                                                            <!-- <input type="text" name="date_select"
                                                                placeholderrr="Enter Reservation Date" id="date_select"
                                                                class="form-item datepicker multiple"> -->
                                                            <input type="text" name="date_select"
                                                                placeholderrr="" id="date_select"
                                                                class="form-item datepicker multiple">
                                                            </div>
                                                        <div class="col">
                                                            <label>Table Size</label>
                                                            <!-- <input type="number" name="table_size"
                                                        min="1" placeholderrr="Enter Table Size"> -->
                                                            <input type="number" name="table_size"
                                                        min="1" placeholderrr="">
                                                        </div>
                                                        <div class="col">
                                                            <label>Capacity</label>
                                                            <!-- <input type="number" name="capacity"
                                                               min="1" placeholderrr="Enter Capacity" title="Enter Capacity"> -->
                                                            <input type="number" name="capacity"
                                                               min="1" placeholderrr="" title="Enter Capacity">
                                                            </div>
                                                        <div class="col addCol">
                                                            <button type="button" class="btn"
                                                                id="insert_duration_table_btn">ADD</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="restro_info_row">
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
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(!empty($reviews)){
                                                                foreach($reviews as $rate){?>
                                                                <tr><td></td><td><div class="restaurant_img"><img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $rate['person_pic'];?>" alt=""><input type="hidden" name="review_photo[]" value="<?php echo $rate['person_pic'];?>"></div></td><td><?php echo $rate['person_name'];?><input type="hidden" name="hide_review_name[]" value="<?php echo $rate['person_name'];?>"></td><td><?php echo date('m-d-Y',strtotime($rate['review_date']));?><input type="hidden" name="hide_review_date[]" value="<?php echo date('d-m-Y',strtotime($rate['review_date']));?>"></td><td><?php echo $rate['rating'];?><input type="hidden" name="hide_review_rating[]" value="<?php echo $rate['rating'];?>"></td><td><div class="reviewDescrip"><?php echo $rate['description'];?></div><input type="hidden" name="hide_review_description[]" value="<?php echo $rate['description'];?>"></td><td><a href="javascript:void(0);" class="view_btn" data-delete="delete"><img src="<?php echo base_url(); ?>/uploads/assets/images/trash.svg" alt="">Delete</a></td></tr>
                                                                <?php }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>   
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="profilePicture">
                                                        <div class="circle">
                                                            <img class="profilePic"
                                                                src="<?php echo base_url(); ?>/uploads/assets/images/user-profile-img.svg" />
                                                        </div>
                                                        <div class="uploadIcon">
                                                            <i class="uploadButton"><img
                                                                    src="<?php echo base_url(); ?>/uploads/assets/images/camera-icon.svg"
                                                                    alt=""></i>
                                                            <input class="fileUploadInput" type="file" id="rating_photo_file" name="person_photo" accept="image/*" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group"><input type="text" name="reviews_name" id="reviews_name_input" placeholderrr="Please Enter name*"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group"><input type="text" name="review_date_select"  placeholderrr="Please Enter Date*" id="review_date_input" class="form-item datepicker reviews_date_select"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <div class="selectInput">
                                                            <select class="cmnSelect" name="review_start" id="review_start_input">
                                                                <option value="">Select Reviews Stars*</option>
                                                                <option value="5">5</option>
                                                                <option value="4.5">4.5</option>
                                                                <option value="4">4</option>
                                                                <option value="3.5">3.5</option>
                                                                <option value="3">3</option>
                                                                <option value="2.5">2.5</option>
                                                                <option value="2">2</option>
                                                                <option value="1.5">1.5</option>
                                                                <option value="1">1</option>
                                                                <option value="0.5">0.5</option>
                                                                <option value="0">0</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <textarea placeholderrr="Please Enter Description*" rows="10"
                                                            name="review_description" id="review_description"></textarea>
                                                    </div>
                                                    <div class="text-right"><button type="button" class="btn" id="add_reviews_btn">ADD</button></div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="restro_info_row">
                                            <div class="restorContentBox">
                                                <h5>Upload RESTAURANTS Content:</h5>
                                                <textarea cols="80" id="defaultEditor" class="defaultEditor" name="editor1" rows="10"><?php echo $data['full_content'];?></textarea>
                                            </div>
                                            <div class="file_upload_section">
                                                <div class="form-group file_upload row">
                                                    <div class="col-6">
                                                        <h5>Upload Restaurant menu:</h5>
                                                        <div class="file_upload_wrapper fileinput-button">
                                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/g2158.svg"
                                                                alt="">
                                                            <h6>Drag & drop any file here</h6>
                                                            <span>or <strong>browse file</strong> from device</span>
                                                            <!-- <input type="file" name="files[]" id="files" class="files_in" multiple accept="image/jpeg, image/png, image/gif"> -->
                                                            <input type="file" name="menu_images[]" multiple="" data-max_length="20"
                                                                class="files_in upload__inputfile">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5>Preview Restaurant images:</h5>
                                                        <div class="upload__img-wrap">
                                                            <?php if($data['menu_images']){
                                                                $menu_ary = explode(',',$data['menu_images']);
                                                                foreach($menu_ary as $img){ ?>
                                                            <div class="upload__img-box">
                                                                <input type="hidden" name="hide_menu_images[]" value="<?php echo $img;?>">
                                                                <div style="background-image:url(<?php echo base_url(); ?>/uploads/assets/images/<?php echo $img;?>);" class="img-bg"><div class="upload__img-close"></div></div>
                                                            </div>
                                                            <?php }
                                                            }?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group file_upload row">
                                                    <div class="col-6">
                                                        <h5>Upload Restaurant Feature image:</h5>
                                                        <div class="file_upload_wrapper fileinput-button">
                                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/g2158.svg"
                                                                alt="">
                                                            <h6>Drag & drop any file here</h6>
                                                            <span>or <strong>browse file</strong> from device</span>
                                                            <!-- <input type="file" name="files[]" id="files" class="files_in" multiple accept="image/jpeg, image/png, image/gif"> -->
                                                            <input type="file" name="feature_images" data-max_length="20"
                                                                class="files_in upload__inputfile">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5>Preview Restaurant images:</h5>
                                                        <div class="upload__img-wrap">
                                                            <?php if($data['feature_image']){
                                                                    $menu_ary = explode(',',$data['feature_image']);
                                                                    foreach($menu_ary as $img){ ?>
                                                                <div class="upload__img-box">
                                                                    <input type="hidden" name="hide_feature_image" value="<?php echo $img;?>">
                                                                    <div style="background-image:url(<?php echo base_url(); ?>/uploads/assets/images/<?php echo $img;?>);" class="img-bg"><div class="upload__img-close"></div></div>
                                                                </div>
                                                                <?php }
                                                                }?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group file_upload row">
                                                    <div class="col-6">
                                                        <h5>Upload Restaurant images:</h5>
                                                        <div class="file_upload_wrapper fileinput-button">
                                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/g2158.svg"
                                                                alt="">
                                                            <h6>Drag & drop any file here</h6>
                                                            <span>or <strong>browse file</strong> from device</span>
                                                            <!-- <input type="file" name="files[]" id="files" class="files_in" multiple accept="image/jpeg, image/png, image/gif"> -->
                                                            <input type="file" name="gallery_images[]" multiple="" data-max_length="20"
                                                                class="files_in upload__inputfile">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5>Preview Restaurant images:</h5>
                                                        <div class="upload__img-wrap">
                                                            <?php if($data['gallery']){
                                                                $menu_ary = explode(',',$data['gallery']);
                                                                foreach($menu_ary as $img){ ?>
                                                            <div class="upload__img-box">
                                                                <input type="hidden" name="hide_gallery[]" value="<?php echo $img;?>">
                                                                <div style="background-image:url(<?php echo base_url(); ?>/uploads/assets/images/<?php echo $img;?>);" class="img-bg"><div class="upload__img-close"></div></div>
                                                            </div>
                                                            <?php }
                                                            }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="submitForm">
                                            <a href="<?php echo site_url('admin/restaurant_list');?>" class="btn btn-primary">Back To List</a>
                                            <button type="submit" class="submit1 btn btn-primary"
                                                id="submitBtn1">Save</button>
                                            <a href="javascript:;" class="btn btn-dark" id="prevBtn">Prev</a>
                                            <a href="javascript:;" class="btn btn-primary" id="nextBtn">Next</a>
                                            <button type="button" class="submit btn btn-primary"
                                                id="submitBtn">Submit</button>
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
                                            <a href="javascript:void(0)" id="restaurant_filter_clear">Clear all</a>
                                        </div>
                                        <div class="filter-body">
                                            <p>You haven't selected any filter yet you can add filter by using below link:</p>
                                            <div id="sidebar_filterList_ajax">
                                                <?php $this->load->view('admin/restaurant_list/filter-sidebar');?>
                                            </div>

                                            <a href="javascript:void(0);" class="addFilterLink">+ Add Filter</a>
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
                    ' </h5></div> <div class="col-8"> <div class="d-flex align-items-top"> <input type="text"  placeholderrr="Enter ' +
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
ClassicEditor.create(document.querySelector('.defaultEditor')).catch(error => {
    console.error(error);
    editor.resize('100%', '350')
});
$("#date_select").datepicker({
    dateFormat: "mm-dd-yy",
    duration: "fast"
});
$("#review_date_input").datepicker({
    dateFormat: "dd-mm-yy",
    duration: "fast"
});

// $('#time_input').timepicker({ 'timeFormat': 'g:i a' });

$('#time_input').timepicker({
    'timeFormat': 'g:i a',
    'step': 15  // Set the time step to 15 minutes
});


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