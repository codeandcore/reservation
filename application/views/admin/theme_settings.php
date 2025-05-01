<?php echo $message = $this->session->flashdata('message');?>
<div class="main-content themeSettingPage">
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="heading_title">Theme Settings</h2>
            <?php
                $maxTableDate = $this->admin_model->get_max_reservation_date_from_ms_rest_tables();
                ?>
                <input type="hidden" class="max_reservation_date" name="max_reservation_date" value="<?php echo $maxTableDate; ?>">
                <input type="hidden" class="update_settings_otp_status" name="update_settings_otp_status" value="false">
            <form action="<?php echo site_url('admin/update_theme_setting');?>" id="theme_settings_form" method="post" enctype="multipart/form-data">

                <div class="row" style="margin-top:30px">
                    <div class="col-3" style="margin:10px 0">
                        <div class="file_upload">
                            <label class="fluidLabel" for="theme_logo">Logo</label>
                            <div class="upload__img-wrap"></div>
                            <input type="file" name="theme_logo" id="theme_logo" class="upload__inputfile">
                        </div>
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <div class="file_upload">
                            <label class="fluidLabel" for="site_preview_image">site preview image <span>Image Size: (1200 X 630)</span></label>
                            <div class="upload__img-wrap"></div>
                            <input type="file" name="site_preview_image" id="site_preview_image" class="upload__inputfile">
                        </div>
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="site_title">Site Title</label>
                        <input type="text" name="site_title" id="site_title" value="<?php echo $setting['site_title'];?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="site_meta_title">Site Meta Title</label>
                        <input type="text" name="site_meta_title" id="site_meta_title"  value="<?php echo $setting['site_meta_title'];?>">
                    </div>
                  
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="trip_title">Trip Title</label>
                        <input type="text" name="trip_title" id="trip_title"  value="<?php echo $setting['trip_title'];?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="admin_email">Admin Email</label>
                        <input type="email" name="admin_email" id="admin_email"  value="<?php echo $setting['admin_email'];?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="copyright_text">Copyright Text</label>
                        <input type="text" name="copyright_text" id="copyright_text"  value="<?php echo $setting['copyright_text'];?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="admin_email">SMTP From Email</label>
                        <input type="email" name="smtp_from_email" id="smtp_from_email"  value="<?php echo $setting['smtp_from_email'];?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <!-- <label class="fluidLabel" for="admin_email">SMTP To Email</label> -->
                        <label class="fluidLabel" for="admin_email">Reply To Email</label>
                        <input type="email" name="smtp_to_email" id="smtp_to_email"  value="<?php echo $setting['smtp_to_email'];?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="booking_end_date">Booking End Date</label>
                        <?php 
                        $booking_end_date = '';
                        if($setting['booking_end_date'] != ''){
                            $booking_end_date = date('m-d-Y',strtotime($setting['booking_end_date']));
                        }
                        ?>
                        <!-- <input type="date" name="booking_end_date" id="booking_end_date" class="datepicker" value="<?php //echo $setting['booking_end_date'];?>"> -->
                        <input type="text" name="booking_end_date" id="booking_end_date" class="datepicker" value="<?php echo $booking_end_date;?>">
                        <!-- <input type="text" name="booking_end_date" id="booking_end_date" value="<?php echo $setting['booking_end_date'];?>" placeholder="MM/DD/YYYY"  class="form-item datepicker multiple"> -->
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="booking_end_time">Booking End Time</label>
                        <?php 
                        $booking_end_time = '';
                        if($setting['booking_end_time'] != ''){
                            $booking_end_time = $setting['booking_end_time'];
                        }
                        else{
                            $booking_end_time = '11:59pm';
                        }
                        ?>
                        <!-- Ensure a unique id -->
                        <input type="text" name="booking_end_time" id="booking_end_time" class="timepicker" value="<?php echo $booking_end_time; ?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="modify_end_date">modify End Date</label>
                        <?php 
                        $modify_end_date = '';
                        if($setting['modify_end_date'] != ''){
                            $modify_end_date = date('m-d-Y',strtotime($setting['modify_end_date']));
                        }
                        ?>
                        <!-- <input type="date" name="modify_end_date" id="modify_end_date"  class="datepicker" value="<?php //echo $setting['modify_end_date'];?>"> -->
                        <input type="text" name="modify_end_date" id="modify_end_date"  class="datepicker" value="<?php echo $modify_end_date;?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="modify_end_time">modify End Time</label>
                        <?php 
                        $modify_end_time = '';
                        if($setting['modify_end_time'] != ''){
                            $modify_end_time = $setting['modify_end_time'];
                        }
                        else{
                            $modify_end_time = '11:59pm';
                        }
                        ?>
                        <!-- Ensure a unique id -->
                        <input type="text" name="modify_end_time" id="modify_end_time" class="timepicker" value="<?php echo $modify_end_time; ?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="cancel_date">Cancel Date</label>
                        <?php 
                        $cancel_date = '';
                        if($setting['cancel_date'] != ''){
                            $cancel_date = date('m-d-Y',strtotime($setting['cancel_date']));
                        }
                        ?>
                        <input type="text" name="cancel_date" id="cancel_date"  class="datepicker" value="<?php echo $cancel_date;?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel" for="contactus_link">Contactus Link</label>
                        <input type="text" name="contactus_link" id="contactus_link"  value="<?php echo $setting['contactus_link'];?>">
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <label class="fluidLabel">Skip reasons </label>

                        <label for="inputtags" class="admin_setting_skip_reasons">
                        <?php
                            $reasonsUnserialize = unserialize($setting['admin_skip_resons']);
                            if($reasonsUnserialize){
                                foreach($reasonsUnserialize as $reason){ ?>
                                    <span class="tag"><?php echo $reason; ?><input type="hidden" name="admin_skip_resons[]" value="<?php echo $reason; ?>"> <span class="remove-item">×</span></span>
                                <?php
                                }
                            }
                            ?>
                            <input class="reasons-type" id="inputtags" type="text" size="1">
                        </label>
                        (<sub>Press Entry Key after adding each reason</sub>)
                    </div>
                </div>
                <h2 class="heading_title">Restaurant Settings (Hide/Show)</h2>
                <div class="row" style="margin-top:30px">
                    <div class="col-3 custom-checkbox" style="margin:10px 0">
                        <input type="checkbox" name="restaurant_address_hide" class="checkboxInput" id="restaurant_address_hide" <?php echo ($setting['restaurant_address_hide'] == 'yes')?"checked":"";?> value="yes">
                        <label class="fluidLabel checkboxLabel" for="restaurant_address_hide">Restaurant Address Hide</label>
                    </div>
                    <div class="col-3 custom-checkbox" style="margin:10px 0">
                        <input type="checkbox" name="restaurant_contact_hide" class="checkboxInput" id="restaurant_contact_hide" <?php echo ($setting['restaurant_contact_hide'] == 'yes')?"checked":"";?> value="yes">
                        <label class="fluidLabel checkboxLabel" for="restaurant_contact_hide">Restaurant Contact Hide</label>
                    </div>
                    <div class="col-3 custom-checkbox" style="margin:10px 0">
                        <input type="checkbox" name="restaurant_fee_hide" class="checkboxInput" id="restaurant_fee_hide" <?php echo ($setting['restaurant_fee_hide'] == 'yes')?"checked":"";?> value="yes">
                        <label class="fluidLabel checkboxLabel" for="restaurant_fee_hide">Restaurant Fee Hide</label>
                    </div>
                    <div class="col-3 custom-checkbox" style="margin:10px 0">
                        <input type="checkbox" name="restaurant_establishment_hide" class="checkboxInput" id="restaurant_establishment_hide" <?php echo ($setting['restaurant_establishment_hide'] == 'yes')?"checked":"";?> value="yes">
                        <label class="fluidLabel checkboxLabel" for="restaurant_establishment_hide">Restaurant Establishment Hide</label>
                    </div>
                    <div class="col-3 custom-checkbox" style="margin:10px 0">
                        <input type="checkbox" name="restaurant_meals_hide" class="checkboxInput" id="restaurant_meals_hide" <?php echo ($setting['restaurant_meals_hide'] == 'yes')?"checked":"";?> value="yes">
                        <label class="fluidLabel checkboxLabel" for="restaurant_meals_hide">Restaurant Meals Hide</label>
                    </div>
                    <div class="col-3 custom-checkbox" style="margin:10px 0">
                        <input type="checkbox" name="restaurant_website_url_hide" class="checkboxInput" id="restaurant_website_url_hide" <?php echo ($setting['restaurant_website_url_hide'] == 'yes')?"checked":"";?> value="yes">
                        <label class="fluidLabel checkboxLabel" for="restaurant_website_url_hide">Restaurant Website URL Hide</label>
                    </div>
                    <div class="col-3 custom-checkbox" style="margin:10px 0">
                        <input type="checkbox" name="restaurant_location_hide" class="checkboxInput" id="restaurant_location_hide" <?php echo ($setting['restaurant_location_hide'] == 'yes')?"checked":"";?> value="yes">
                        <label class="fluidLabel checkboxLabel" for="restaurant_location_hide">Restaurant Location Hide</label>
                    </div>
                    <div class="col-3 custom-checkbox" style="margin:10px 0">
                        <input type="checkbox" name="restaurant_email_hide" class="checkboxInput" id="restaurant_email_hide" <?php echo ($setting['restaurant_email_hide'] == 'yes')?"checked":"";?> value="yes">
                        <label class="fluidLabel checkboxLabel" for="restaurant_email_hide">Restaurant Email Hide</label>
                    </div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-12">
                        <div class="text-right"><input type="submit" class="btn btn-primary" value="Save"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .admin_setting_skip_reasons{border-radius:5px;border:1px solid var(--green);padding:5px 13px;min-height:48px;display:flex;flex-wrap:wrap;align-items:center;}
    .admin_setting_skip_reasons .tag{padding:3px 20px 2px 8px;background-color:var(--grey-shade);text-transform:uppercase;font-size:13px;font-weight:600;color:var(--green);border-radius:5px;display:inline-block;margin:2px 5px 2px 0;position:relative;}
    .admin_setting_skip_reasons .tag .remove-item{font-weight:bold;padding:0 4px;position:absolute;top:auto;right:0;font-size:16px;line-height:0.9;color:var(--green); cursor: pointer;}
    .admin_setting_skip_reasons .reasons-type{border:none;box-shadow:none;outline:none;background-color:transparent;padding:0 6px;margin:0;width:auto;max-width:inherit;}

</style>
<script>
$(document).ready(function() {
    $('.timepicker').timepicker({
        minTime: '12:00am',
        step: 1,
        timeFormat: 'g:ia',
        closeOnWindowScroll: true,
        disableTextInput: true,
        });
    });
$("#booking_end_date,#modify_end_date,#cancel_date").datepicker({
    // dateFormat: "mm-dd-yy",
    dateFormat: "mm-dd-yy",
    // duration: "fast"
});
    $('.admin_setting_skip_reasons #inputtags').on('input', function(){
        var charLength = $(this).val().length;
        $(this).attr('size', charLength);
    });
    $(".admin_setting_skip_reasons").on('keydown', addTag);
    function addTag(evt) {
        const tag = evt.target.value;
        if(evt.key =='Enter' || evt.key == 13) {
            const tagTrim = tag.trim() 
            if(tagTrim != "") {
                $(".admin_setting_skip_reasons #inputtags").before("<span class='tag'>"+tagTrim+"<input type='hidden' name='admin_skip_resons[]' value='"+tagTrim+"'> <span class='remove-item'>×</span></span>");
                evt.target.value = '';
            }
            $('.admin_setting_skip_reasons #inputtags').attr('size', '1');
            event.preventDefault();
            return false;
        }
    }
    $(document).on("click",".admin_setting_skip_reasons .tag .remove-item",function() {
        $(this).parent().remove();
    });
</script>