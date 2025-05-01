/* Window Load functions */
jQuery(document).ready(function(){

    $.validator.addMethod('card_number_validate', function(value, element, param) {
        const result = $('#card_number').validateCreditCard();
        if (result.valid) {
            $(this).addClass('cc-valid');
            
            return true;    
        } else {
            $(this).removeClass('cc-valid');
            
            return false;    
        }
    });
    $.validator.addMethod('cvv_number_validate', function(value, element, param) {
        var cardInfo = $('#card_number').validateCreditCard();
        console.log(cardInfo);
        return cardInfo.card_type.name == 'amex' ? value.length == 4 : value.length == 3;
    });

    $.validator.addMethod('checkbox_all', function(value, element, param) {
        var err = 0;
        error_checkbox_valid();
        $('.confirmDetails .depositCharge').each(function(){
            if($(this).hasClass('error-arrow'))
            {
                err = 1
            }
        });
        if(err == 0){
            return true;
        }
        else{
            console.log('truwe')
            return false;
        }
    });

    var validator1 = $("#modify_restaurant_booking_final").validate({
        rules: {
            card_number: {
                card_number_validate: true
            },
            exp_month: {
                required: true
            },
            exp_year: {
                required: true
            },
            security_code: {
                cvv_number_validate: true,
            },
            card_holder: {
                required: true
            },
            "charge[]": {
                checkbox_all: true
            },
        },
        messages: {
            card_number : "Please enter a valid card number. It should be your personal credit card, not your Pfizer credit card."
        },
        errorPlacement: function(error, element) {
            // don't add the error labels
            console.log(error);
            return true;
        }
    });

    

    function error_checkbox_valid(){
        $('.confirmDetails .depositCharge').each(function(){
            if($(this).find('[type="checkbox"]').is(":checked"))
            {
                $(this).remove('label.error');
                $(this).removeClass('error-arrow');
            }else{
                $(this).addClass('error-arrow');
            }
        });
    }
    var validator2 = $("#register_restaurant_booking_final").validate({
        rules: {
            card_number: {
                card_number_validate: true
            },
            exp_month: {
                required: true
            },
            exp_year: {
                required: true
            },
            security_code: {
                cvv_number_validate: true,
            },
            card_holder: {
                required: true
            },
            "charge[]": {
                checkbox_all: true
            },
        },
        messages: {
            "charge[]": "",
            card_number : " Please enter a valid card number. It should be your personal credit card, not your Pfizer credit card."
        }
    });
    // Modal Popup jquery
    let site_url = $('#global_base_url').val();
    $(document).on('click', '.restaurant-modal-button', function(e) {
        var rest_id = $(this).attr('data-rest_id');
        $(".modal").removeClass('modal-active');
        e.preventDefault();
        var target = $(this).data('target');
        var url = $('#global_base_url').val();
        $.ajax({
            url: site_url+'get_restaurant_detail_byid',
            type: 'post',
            data: {rest_id:rest_id},
            success: function(response) {
                $('#ajax_restro_detail').html(response);
                $('.tabsContent .tabsItem').hide();
                $('.tabsContent .tabsItem:first').show();
                $('.tabs-nav li:first').addClass('tab-active');
                $('#' + target).addClass('modal-active');
                $("body").addClass('overflow-hidden');
                $(".modal-backdrop").fadeIn();
                popup_restaurant_slider_init();
            }
        });
    });
    $(document).on('change','.filterList .radioInput,.filterList .checkboxInput', function(e){
        $('.filterBtn').trigger('click');
    });

    $(document).on('click','.filterBtn', function(e){
        e.preventDefault();
        var _form = new FormData();
        var _type = $('input[name="property_type"]:checked').val();
        var _date = $('select#book_date').val();
        var _time = $('select#book_time').val();
        var _pax = $('select#book_persons').val();
       
        $('.custom-checkbox').each(function(){
            var _type = $(this).attr('data-type');
            if ($(this).find('input.checkboxInput').is(':checked')) {
                var _val = $(this).find('input.checkboxInput:checked').val();
                _form.append('filter_type[]', _type);
                _form.append('filter_value[]', _val);
            }
        });
        _form.append('property_type', _type);
        _form.append('book_date', _date);
        _form.append('book_time', _time);
        _form.append('book_pax', _pax);
        
        $.ajax({
            url: site_url+'filter_restaurant_list',
            type: 'post',
            data: _form,
            contentType: false,
            processData: false,
            beforeSend: function(res) {
                $('.innerLoader').show();
            },
            success: function(response) {
                $('.availableList .setupContent').removeClass('active');
                $('.availableDayList .availableDay').removeClass('active');
                $('.availableDayList .availableDay').each(function(){
                    var _dt = $(this).attr('data-date');
                    if(_dt == _date){
                        $(this).addClass('active');
                    }
                });
                $('.availableList .setupContent').each(function(){
                    var _dt = $(this).attr('data-date');
                    if(_dt == _date){
                        $(this).addClass('active');
                    }
                });
                $('.availableRestaurant.bookedRestaurant').hide();
                $('.availableStepListing').show();
                $('.innerLoader').hide();
                $('.setupContent.active:not(.invited) #ajax-response-restaurants').html(response);
            }
        });
    })
    $(document).on('click', '.selectRestaurant_btn', function(e) {
        var _time = $(this).text();
        $(this).parents('.availableItem').find('.selected_time_slot').text(_time);
        $(this).parents('.availableItem').find('.confirmRestaurant').attr('data-booktime',_time);
    });
    $(document).on('click', '.cancel-reserved_btn', function(e) {
        var list_id = $(this).attr('data-listid');
        var hotelimg = $(this).attr('data-hotelimg');
        var restname = $(this).attr('data-restname');
        var date = $(this).attr('data-date');
        var time = $(this).attr('data-time');
        var pax = $(this).attr('data-pax');
        var type = $(this).attr('data-type');
        $('#reservationCancel .feature_img img').attr('src',hotelimg);
        $('#reservationCancel .rest_desc h6').text(restname);
        $('#reservationCancel .rest_desc span.cancelindate').text(date);
        $('#reservationCancel .rest_desc span.cancelinpax').text(pax);
        $('#reservationCancel .rest_desc span.cancelintime').text(time);
        $('#reservationCancel .rest_desc span.cancelinhtltype').text(type);
        $('input#cancel_booking_listid').val(list_id);
    });
    $(document).on('click', '.invitation_approve_btn', function(e) {
        var invite_id = $(this).attr('data-invite-id');
        var status = $(this).attr('data-status');
        var _btn = $(this);
        var url = $('#global_base_url').val();
        $.ajax({
            url: site_url+'invitation_modify_byuser',
            type: 'post',
            data: {
                invite_id:invite_id,
                status:status
            },
            dataType: 'json',
            beforeSend: function(res) {
                $('.innerLoader').show();
                $('#invite_submit_error_text').text('');
                $(_btn).prop('disabled',true);
                $(_btn).addClass('loading');
            },
            success: function(result) {
                $(_btn).prop('disabled',false);
                $(_btn).removeClass('loading');
                $('.innerLoader').hide();
                if(result.response == 'success'){
                    window.location.href=site_url+"reservation_confirmed"
                }
                else{
                    $('#invite_submit_error_text').text(result.message);
                }
            }
        });
    });
    $(document).on('click', '.invitation_decline_btn', function(e) {
        var invite_id = $(this).attr('data-invite-id');
        $('input#decline_invite_id').val(invite_id); 
    });
    $(document).on('click', '.clear_filter_btn', function(e) {
        clear_filter_form_sidebar();
    });
    $(document).on('submit', '#cancel_reservation_form', function(e) {
        e.preventDefault();
        var form = $('#cancel_reservation_form');
        $.ajax({
            url:  site_url+'cancel_reservation_date',
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function(res) {
                $('#cancel_reservation_error').text('');
                $('#share_invite_success').text('');
                $('#cancel_reservation_form [type="submit"]').prop('disabled',true);
                $('#cancel_reservation_form [type="submit"]').addClass('loading');
            },
            success: function(result) {
                $('.innerLoader').hide();
                $('#cancel_reservation_form [type="submit"]').prop('disabled',false);
                $('#cancel_reservation_form [type="submit"]').removeClass('loading');
                if(result.response == 'success'){
                    $('#cancel_reservation_success').text(result.message);
                    window.location.href=site_url+'cancel_reservations';
                }
                else{
                    $('#cancel_reservation_error').text(result.message);
                }
            }
        });
    });
    $(document).on('click', '.modify_back_btn', function(e) {
        var _date = $(this).attr('data-date');
        $('ul.availableDayList li').each(function(){
            var _dt = $(this).attr('data-date');
            if(_dt == _date){
                $(this).trigger('click');
            }
        });
    });

    $(document).on('submit', '#decline_reservation_form', function(e) {
        e.preventDefault();
        var form = $('#decline_reservation_form');
        $.ajax({
            url:  site_url+'invitation_modify_byuser',
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function(res) {
                $('#cancel_reservation_error').text('');
                $('#share_invite_success').text('');
                $('#decline_reservation_form [type="submit"]').prop('disabled',true);
                $('#decline_reservation_form [type="submit"]').addClass('loading');
            },
            success: function(result) {
                $('.innerLoader').hide();
                $('#decline_reservation_form [type="submit"]').prop('disabled',false);
                $('#decline_reservation_form [type="submit"]').removeClass('loading');
                if(result.response == 'success'){
                    $('#cancel_reservation_success').text(result.message);
                    window.location.href=site_url+'cancel_reservations';
                }
                else{
                    $('#cancel_reservation_error').text(result.message);
                }
            }
        });
    });
    $(document).on('submit', '#share_invite_form', function(e) {
        e.preventDefault();
        var form = $('#share_invite_form');
        $.ajax({
            url:  site_url+'invitation_sendto_guest',
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function(res) {
                $('#share_invite_error').text('');
                $('#share_invite_success').text('');
                $('#share_invite_form [type="submit"]').prop('disabled',true);
                $('#share_invite_form [type="submit"]').addClass('loading');
            },
            success: function(result) {
                $('.innerLoader').hide();
                $('#share_invite_form [type="submit"]').prop('disabled',false);
                $('#share_invite_form [type="submit"]').removeClass('loading');
                if(result.response == 'success'){
                    $('#share_invite_success').text(result.message);
                    $('#inviteModal').removeClass('modal-active');
                }
                else{
                    $('#share_invite_error').text(result.message);
                }
            }
        });
    });
    $(document).on('submit', '#register_restaurant_booking_final', function(e) {
        e.preventDefault();
        var form = $('#register_restaurant_booking_final');
        $.ajax({
            url:  site_url+'final_restaurant_booking_detail',
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function(res) {
                $('.innerLoader').show();
                $('#register_restaurant_booking_final button[type="submit"]').addClass('loading');
                $('#register_restaurant_booking_final button[type="submit"]').prop('disabled',true);
            },
            success: function(result) {
                $('#register_restaurant_booking_final button[type="submit"]').removeClass('loading');
                $('#register_restaurant_booking_final button[type="submit"]').prop('disabled',false);
                $('.innerLoader').hide();
                if(result.response == 'success'){
                    window.location.href=site_url+'reservation_confirmed';
                }
                else{
                    
                }
            }
        });
    });
    $(document).on('submit', '#modify_restaurant_booking_final', function(e) {
        e.preventDefault();
        var form = $('#modify_restaurant_booking_final');
        $.ajax({
            url:  site_url+'modify_final_restaurant_booking_detail',
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function(res) {
                $('.innerLoader').show();
                $('#modify_restaurant_booking_final button[type="submit"]').addClass('loading');
                $('#modify_restaurant_booking_final button[type="submit"]').prop('disabled',true);
            },
            success: function(result) {
                $('#modify_restaurant_booking_final button[type="submit"]').removeClass('loading');
                $('#modify_restaurant_booking_final button[type="submit"]').prop('disabled',false);
                $('.innerLoader').hide();
                if(result.response == 'success'){
                    window.location.href=site_url+'reservation_confirmed';
                }
                else{
                    
                }
            }
        });
    });
    $(document).on('submit', '#reservation_page_search_form', function(e) {
        e.preventDefault();
        clear_filter_form_sidebar();
        var book_date = $('#book_date').val();
        var form = $(this);
        if($('li.confirmStep').hasClass('active')){
            return;
        }
        $.ajax({
            url:  site_url+'get_restaurant_list_search_form',
            type: 'post',
            data: form.serialize(),
            beforeSend: function(res) {
                $('.innerLoader').show();
            },
            success: function(response) {
                $('.availableList .setupContent').removeClass('active');
                $('.availableDayList .availableDay').removeClass('active');
                $('.availableDayList .availableDay').each(function(){
                    var _dt = $(this).attr('data-date');
                    if(_dt == book_date){
                        $(this).addClass('active');
                    }
                });
                $('.availableList .setupContent').each(function(){
                    var _dt = $(this).attr('data-date');
                    if(_dt == book_date){
                        $(this).addClass('active');
                    }
                });
                $('.availableRestaurant.bookedRestaurant').hide();
                $('.availableStepListing').show();
                $('.innerLoader').hide();
                $('.setupContent.active:not(.invited) #ajax-response-restaurants').html(response);
            }
        });
    });
});

function clear_filter_form_sidebar(){
    $("#property_type_radio1").prop("checked", true);
    $(".checkboxInput").prop("checked", false);
}
