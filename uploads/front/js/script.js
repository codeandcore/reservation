/* Window Load functions */
jQuery(document).ready(function(){
    let site_url = $('#global_base_url').val();
    var headerHeight = $('header').outerHeight();
    $(window).scroll(function () {
        if ($(window).scrollTop() > headerHeight) {
            $('header').addClass('header-fixed');
        } else {
            $('header').removeClass('header-fixed');
        }
    });

    $(".hamburger").click(function(){
        $(this).toggleClass("active");
        $(this).parent().toggleClass("open-menu");
        $('body').toggleClass("overflow-hidden overlay");
    });


    // Modal Popup jquery
    $(document).on('click', '.modal-button', function(e) {
        $(".modal").removeClass('modal-active');
        e.preventDefault();
        var target = $(this).data('target');
        $('#' + target).addClass('modal-active');
        $("body").addClass('overflow-hidden');
        $(".modal-backdrop").fadeIn();
    });
    // Modal Popup jquery

    //On Modal Skip reason modal popup cancel click reser fields
    $(document).on('click', '[data-target="modalClose"]', function(event) {
        //$('.availableDayList .availableDay.active').find('.reason_for_skip').val();
        //console.log('blanck sel;ect');
    });


    $(document).on('click', '.modal-backdrop, [data-target="modalClose"]', function(event) {
        $(".modal").removeClass('modal-active');
        $("body").removeClass('overflow-hidden');
        $('input[name="email"]').val('');
        $('#share_invite_error').html('');
        $('#share_invite_success').html('');
    });

    //Reset Skip reason field value on Popup close
    $(document).on('click', '.modal-backdrop, [data-target="modalClose"]', function(event) {
        // $('.availableDayList .availableDay.active').find('input.input_booking_reason').val('');
        //console.log('fghfhfghf');
    });



    setTimeout(function() {
        $("#loadingDiv").addClass("remove");
    }, 300);

    setTimeout(() => {
        $('.innerLoader').fadeOut();
    }, 100);


    /*Animation js start*/
    //$("#loadingDiv").addClass("remove");

    setTimeout(function () {
        var $animation_elements = $('.animatable');
        var $window = $(window);
        function scrollAnimation() {
            var window_height = $window.height();
            var window_top_position = $window.scrollTop();
            var window_bottom_position = (window_top_position + window_height);
            jQuery.each($animation_elements, function () {
            var $element = $(this);
            var element_height = $element.outerHeight();
            var element_top_position = $element.offset().top;
            var element_bottom_position = (element_top_position + element_height);
            if ((element_bottom_position >= window_top_position) &&
                (element_top_position <= window_bottom_position)) {
                $element.addClass('animated');
            }
            });
        }
        $window.on('scroll resize', scrollAnimation);
        $window.trigger('scroll');
        var _has = window.location.hash.slice(1);
        if (_has) {
            jQuery('html, body').animate({
            scrollTop: jQuery('.' + _has).offset().top - 10
            }, 100);
        }
    }, 1000);
    /*Animation js end*/

    $(document).on('click','.dropdownClick', function(e){
        e.preventDefault();
        $('.dropdown').removeClass('active');
        $(this).parent().toggleClass('active');
    });

    jQuery(document).click(function(event) {
        if (!jQuery(event.target).closest(".dropdown").length ) {
            $('.dropdown').removeClass('active');
        }
    });

    var innerSearchFormHeight = $('.innerSearchForm').outerHeight();
    var halfHight = innerSearchFormHeight / 2;
    $('.booking-section').css('margin-top', -halfHight);

    $('.cmnSelect').select2();

   
    // Tabs
    // Show the first tab by default
    $('.tabsContent .tabsItem').hide();
    $('.tabsContent .tabsItem:first').show();
    $('.tabs-nav li:first').addClass('tab-active');
    // Change tab class and display content
    $(document).on('click','.tabs-nav a', function(e){
        event.preventDefault();
        $('.tabs-nav li').removeClass('tab-active');
        $(this).parent().addClass('tab-active');
        $('.tabsContent .tabsItem').hide();
        $($(this).attr('href')).show();
    });

    // Accordion
    $('.accordionItem:first-child .inner').addClass('show').css('display','block');
    $('.accordionItem:first-child').addClass('active');
    $('.toggle').click(function() {
        let $this = $(this);
        if($(this).parents('.accordionItem').hasClass('skip') || $(this).parents('.accordionItem').hasClass('cancel')){
            return;
        }
        $('.accordionItem').removeClass('active');
        if ($this.next().hasClass('show')) {
            $this.next().removeClass('show');
            $this.next().slideUp(350);
        } else {
            $this.parent().addClass('active');
            $this.parent().parent().find('.accordionItem .inner').removeClass('show');
            $this.parent().parent().find('.accordionItem .inner').slideUp(350);
            $this.next().toggleClass('show');
            $this.next().slideToggle(350);
        }
    });

    $('.overviewItem-content').css('overflow','hidden')
    $(document).on('click','.readMore', function(e){
        e.preventDefault();
        $(this).parents('.tabsItem').find('.overviewItem-content').css('overflow','auto')
        $(this).remove();
    });

    var idget;
    $('.availableDay').click(function(){
        $('.availableDay').removeClass('active');
        $('.setupContent').removeClass('active');
        $(this).addClass('active');
        idget = $(this).attr('data-step');
        var _datetext = $(this).attr('data-datetext');
        var _date = $(this).attr('data-date');
        var _time = $(this).attr('data-time');
        var _pax =  $(this).attr('data-person');
        if(_pax != ''){
            $("select#book_persons").val(_pax).trigger('change');
            /**Set Inner person option */
            $("select#book_persons_inner").val(_pax).trigger('change');
        }
        if(_date){
            $('#book_date').val(_date).trigger('change');
        }
        $('#book_time').val(_time).trigger('change');

        /**Set Inner time option */
        $('#book_time_inner').val(_time).trigger('change');

        $('#selected_date_string').html(_datetext);
        $('#'+idget).addClass('active');
        $('.availableStepListing').show();   
        $('.bookedRestaurant').hide()
        // alert(idget);
        
        if(!$(this).hasClass('confirmStep')){
            $(".skipButton").show();
            $('.topTitleRow').show();

        }

    })

    /**Trigger reservation search form on Inner search form submit */
    $('.inner-search-res-form').click(function(){
        //console.log('serach form submit');
        $('#reservation_page_search_form').trigger('submit');
    });

    $(document).on('click','a.cancel_booked_time_btn', function(e){
        $(this).parents('.booked_time').hide();
        $(this).parents('.restaurantDetails').find('.timeing').show();
        $(this).parents('.availableItem').removeClass('booked');
    });
    $(document).on('click','[data-target="selectRestaurant"]', function(e){
        e.preventDefault();
        $(this).parents('.setupContent').find('.selectedRestaurant').removeClass('active');
        $(this).parents('.availableItem').find('.selectedRestaurant').addClass('active');
    });

    $('.bookedRestaurant').hide()
   
    // $(document).on('click','.toconfirmationsection',function(e){
    //     confirm_restaurant_list_form_divshow(true);
    // });
    $(document).on('click','.booked_time ul li:first-child a', function(e){
        $('li.confirmStep').trigger('click');
      })
    $(document).on('click','[data-target="confirmRestaurant"]', function(e){
        e.preventDefault();
        clear_filter_form_sidebar();
        var cur_date = $(this).attr('data-bookdate');
        var cur_time = $(this).attr('data-booktime');
        var cur_pax = $(this).attr('data-bookpax');
        var cur_restid = $(this).attr('data-bookrestid');
        var cur_deposite = $(this).attr('data-deposite');
        var toConfirm = $(this).attr('data-targetToConfirm');
        assign_restaurant_to_perticular_date(cur_date,cur_time,cur_pax,cur_restid,cur_deposite);
        $(this).parents('.setupContent.active').find('.availableItem.booked').removeClass('booked');
        $(this).parents('.setupContent.active').find('.booked_time').hide();
        $(this).parents('.setupContent.active').find('.timeing').show();
        $([document.documentElement,document.body]).animate({scrollTop:$('.availableProgress').offset().top - 100},1000);
        if($(this).parents('.setupContent').next().length > 0){  
            if(toConfirm == "toconfirmation"){
                confirm_restaurant_list_form_divshow(true);
                return false;
            } 
            var current_tab_number = $(this).parents('.setupContent').index() + 1;
            $(this).parents('.setupContent').removeClass('active skinRestaurant');
            $(this).parents('.setupContent').next().addClass('active');
            var _date =  $(this).parents('.setupContent').next().attr('data-date');
            var _datetext =  $(this).parents('.setupContent').next().attr('data-datetext');
            var _pax =  $(this).parents('.setupContent').next().attr('data-person');
            var _time = $(this).parents('.setupContent').next().attr('data-time');
            var rest_id = $(this).attr('data-bookrestid');
            $("select#book_date").val(_date).trigger('change');
            $('#book_time').val(_time).trigger('change');
            // $('#reservation_page_search_form').submit();
            if(_pax != ''){
                // $("select#book_persons").val(_pax).trigger('change');
                $("select#book_persons_inner").val(_pax).trigger('change');
                $("select#book_persons").val(_pax).trigger('change');
            }
            $('#selected_date_string').html(_datetext);
            // console.log(current_tab_number);
            $('.availableDayList li:nth-child('+current_tab_number+')').addClass('completed').removeAttr('disabled').removeClass('active skipDay').next('li').removeAttr('disabled').addClass('active');
            //console.log(current_tab_number);
            $('.availableStepListing').show();
            $('.bookedRestaurant').hide()
            innerLoader()
            $(".skipButton").show();
            $('.topTitleRow').show();


        }else{
            confirm_restaurant_list_form_divshow();
            // console.log("dsfujksehfuihuisyhi");
            // var current_tab_number = $(this).parents('.setupContent').index() + 1;
            // $(this).parents('.setupContent').removeClass('active skinRestaurant');
            // $(this).parents('.setupContent').next().addClass('active');
            // $('.availableDayList li:nth-child('+current_tab_number+')').addClass('completed').removeAttr('disabled').removeClass('active skipDay').next('li').removeAttr('disabled').addClass('active');
            // $('.availableStepListing').hide();
            // $('.bookedRestaurant').show();
            // innerLoader()
        }
        var _time = '';
        $('#book_time_inner').val(_time).trigger('change');
       
        //$('.availableDayList .availableDay.active').removeClass('active').addClass('completed').next('.availableDay').click().addClass('active').removeAttr('disabled');
    });

    $(document).on('click','a.confirmdeleteInvite', function(e){
        e.preventDefault();
        var listid = $(this).attr('data-listid');
        var userid = $(this).attr('data-userid');
        var _btn = $(this);
        $.ajax({
            url: site_url+'confirm_delete_invite',
            type: 'post',
            data: {
                userid:userid,
                listid:listid
            },
            dataType: 'json',
            beforeSend: function(res) {
                $(_btn).prop('disabled',true);
                $(_btn).addClass('loading');
            },
            success: function(result) {
                $(_btn).prop('disabled',false);
                $(_btn).removeClass('loading');
                window.location.reload();
            }
        });
    });
    $(document).on('click','a.confirmcancelinvite', function(e){
        e.preventDefault();
        var listid = $(this).attr('data-listid');
        var userid = $(this).attr('data-userid');
        var _btn = $(this);
        $.ajax({
            url: site_url+'confirm_cancel_invite',
            type: 'post',
            data: {
                userid:userid,
                listid:listid
            },
            dataType: 'json',
            beforeSend: function(res) {
                $(_btn).prop('disabled',true);
                $(_btn).addClass('loading');
            },
            success: function(result) {
                $(_btn).prop('disabled',false);
                $(_btn).removeClass('loading');
                window.location.reload();
            }
        });
    });
    $(document).on('click','[data-target="NotConfirmRestaurant"]', function(e){
        e.preventDefault();
        var _date = $(this).attr('data-bookdate');
        $('.availableDayList .availableDay').each(function(){
            var _dt = $(this).attr('data-date');
            if(_date == _dt){
                $(this).removeClass('completed');
                $(this).removeClass('skip');
                $(this).find('.input_booking_time').val('');
                $(this).find('.input_booking_pax').val('');
                $(this).find('.input_booking_reason').val('');
                $(this).find('.input_booking_deposite').val('');
                $(this).find('.input_booking_restid').val('');
            }
        });
            
        $(this).parents('.availableItem').find('.selectedRestaurant').removeClass('active');
        //$([document.documentElement,document.body]).animate({scrollTop: ('.availableProgress').offset().top - 100},1000);
    });
    
    $(document).on('click','[data-target="findRestro"]', function(e){
        // e.preventDefault();
        //$(this).parents('.availableItem').find('.selectedRestaurant').removeClass('active');
        $([document.documentElement,document.body]).animate({scrollTop:$('.availableStep').offset().top - 100},1000);
    });

    $(document).on('click','.remove_guest_btn', function(e){
        var _listid = $(this).attr('data-listid');
        var userid = $(this).attr('data-user_id');
        var username = $(this).attr('data-username');
        $('span#guestname_span').text(username);
        $('a.confirmdeleteInvite').attr('data-listid',_listid);
        $('a.confirmdeleteInvite').attr('data-userid',userid);
    });
    $(document).on('click','.invitation_decline_btn', function(e){
        var _listid = $(this).attr('data-listid');
        var userid = $(this).attr('data-user_id');
        var username = $(this).attr('data-username');
        $('span#guestname_span').text(username);
        $('a.confirmcancelinvite').attr('data-listid',_listid);
        $('a.confirmcancelinvite').attr('data-userid',userid);
    });
    $(document).on('click','.removePendingGuest', function(e){
        var _listid = $(this).attr('data-listid');
        var userid = $(this).attr('data-user_id');
        var username = $(this).attr('data-username');
        $('span#guestname_span').text(username);
        $('a.confirmdeleteInvite').attr('data-listid',_listid);
        $('a.confirmdeleteInvite').attr('data-userid',userid);
    });
    $(document).on('click','[data-target="inviteModal"]', function(e){
        var _id = $(this).attr('data-booking_listid');
        $('input#share_booking_listid').val(_id);
    });
    $(document).on('click','[data-target="confirmSkipDay"]', function(e){
        e.preventDefault();
        
        clear_filter_form_sidebar();
        // $(this).parents('.modal').removeClass('modal-active');
        $("body").removeClass('overflow-hidden');
        var skip = $('.reason-to-skip-value').val();
        
        $('.availableDayList .availableDay.active').find('input.input_booking_time').val('');
        // $('.availableDayList .availableDay.active').find('input.input_booking_pax').val('');
        $('.availableDayList .availableDay.active').find('input.input_booking_pax').val($("#book_persons_inner").val());
        $('.availableDayList .availableDay.active').find('input.input_booking_restid').val('');
        $('.availableDayList .availableDay.active').find('input.input_booking_deposite').val('');
        $('.availableDayList .availableDay.active').find('input.input_booking_reason').val(skip);
        $('.availableDayList .availableDay.active').find('input.input_booking_status').val('skip');

        //Skip reason Drop Down validation
        //console.log('front JS');
        //console.log(jQuery('.reason_for_skip_booking').val());
        if(jQuery('.reason_for_skip_booking').val()){
            //console.log(jQuery('.reason_for_skip_booking').val());
            //console.log('hidden value', $('.availableDayList .availableDay.active').find('input.input_booking_reason').val());
        }else{
            //console.log('please select reasin');
            jQuery('.skipreason_error').html('Please select Skip Reason');
            jQuery('.skipreason_error').show();
            return false;
        }
        // return false;

        //Skip reason Drop Down validation END

        //Skip reason Text Area validation
        if(!jQuery('.reason-to-skip-value').val()){
            jQuery('.skipreason_error').html('Please provide a reason');
            jQuery('.skipreason_error').show();
            return false;
        }

        //Skip reason Text Area validation END


        $(this).parents('.modal').removeClass('modal-active');

        $('.availableDay.active').removeClass('active').addClass('skipDay completed');
        $('.setupContent.active').find('.selectedRestaurant').removeClass('active');

        if($('.setupContent.active').next().length > 0){   
            var current_tab_number = $('.setupContent.active').index() + 1;
            $('.setupContent.active .availableItem.booked').removeClass('booked');
            $('.setupContent.active').removeClass('active').addClass('skinRestaurant').next().addClass('active');
            $('.availableDayList li:nth-child('+current_tab_number+')').addClass('completed').removeAttr('disabled').removeClass('active').next('li').removeAttr('disabled').addClass('active');
            var _date =  $('.setupContent.active').attr('data-date');
            var _datetext =  $('.setupContent.active').attr('data-datetext');
            var _pax =  $('.setupContent.active').attr('data-person');
            var _time = $('.setupContent.active').attr('data-time');
            $("select#book_date").val(_date).trigger('change');
            $('#book_time').val(_time).trigger('change');
            if(_pax != ''){
                $("select#book_persons").val(_pax).trigger('change');
                $("select#book_persons_inner").val(_pax).trigger('change');
            }
            $('#selected_date_string').html(_datetext);
            //console.log(current_tab_number);
            $('.availableStepListing').show();
            $('.bookedRestaurant').hide()
            innerLoader()
            $(".skipButton").show();
            $('.topTitleRow').show();
            

        }else{
            confirm_restaurant_list_form_divshow();
        }
    });

    $(document).on('click','.confirmStep', function(e){
        e.preventDefault();
        // $('.availableStepListing').hide();   
        // $('.bookedRestaurant').show()
        confirm_restaurant_list_form_divshow();

    });

    $('span.filterIcon').on('click', function(){
        $(this).parent().toggleClass('open-filter');
    })

    $('[data-target="skipDay"]').click(function(){
        $('#reason_skip_input').val(''); 
        jQuery('.skipreason_error').html(''); 
        jQuery('.skipreason_error').hide(); 
    })


});

$(document).keydown(function(event) { 
    if (event.keyCode == 27) { 
        $('.modal').removeClass('modal-active');
    }
});



// $(window).load(function () {
//     setTimeout(function() {
//         $("#loadingDiv").addClass("remove");
//     }, 1000);
// });

// Slider Script
if($('.restaurantSlider').length > 0){
    var servicesSlider = new Swiper(".restaurantSlider", {
        slidesPerView: 1,
        slidesPerView: 1,
        spaceBetween: 30,
        breakpoints: {
            576:{
                slidesPerView: 2,
            },
            992:{
                slidesPerView: 3,
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
}

// Slider Script
if($('.booked-slider').length > 0){
    var servicesSlider = new Swiper(".booked-slider", {
        slidesPerView: 1,
        slidesPerView: 1,
        spaceBetween: 30,
        breakpoints: {
            992:{
                slidesPerView: 2,
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
}
function popup_restaurant_slider_init(){
if($('.overviewSlider').length > 0){
    var swiper = new Swiper(".overviewSlider", {
        navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
        },
    });
}
}

function assign_restaurant_to_perticular_date(book_date,book_time,book_pax,book_rest_id,cur_deposite){
    $('.availableDayList .availableDay').each(function(){
        var _dt = $(this).attr('data-date');
        if(_dt == book_date){
            $(this).removeClass('skipDay');
            $(this).find('input.input_booking_time').val(book_time);
            $(this).find('input.input_booking_pax').val(book_pax);
            $(this).find('input.input_booking_restid').val(book_rest_id);
            $(this).find('input.input_booking_deposite').val(cur_deposite);
            $(this).find('input.input_booking_status').val('booked');
            $(this).find('input.input_booking_modified').val('yes');
        }
    });
}

function confirm_restaurant_list_form_divshow(toConfirmation=false){
    // console.log('toConfirmation',toConfirmation);
    $('.skipButton').hide();
    $('.topTitleRow').hide();
    if($('#register_restaurant_booking_final').length > 0){
        var form = $('#register_restaurant_booking_final');
    }
    else{
        var form = $('#modify_restaurant_booking_final');
    }
    var _url = $('#global_base_url').val();
    $.ajax({
        url: _url+'get_selected_restaurant_list_for_booking',
        type: 'post',
        data: form.serialize(),
        beforeSend: function(res) {
            $('.innerLoader').show();
        },
        success: function(response) {
            $('#selected_restaurant_list_ajax').html(response);
            var checked = 0;
            $('#selected_restaurant_list_ajax .charge').each(function(){
                checked = 1;
            })
            if(checked == 0){
                $('.creditcard_detail').hide();
                $('.creditInformation p.nots').hide();
                $("#card_number").rules( 'remove' );
                $('input[name="security_code"]').rules( 'remove' );
                $('input[name="card_holder"]').rules( 'remove' );
                $('select[name="exp_month"]').rules( 'remove' );
                $('select[name="exp_year"]').rules( 'remove' );
            }
            else{
                $('.creditcard_detail').show();
                $('.creditInformation p.nots').show();
            }
            $('.innerLoader').hide();
            var current_tab_number = $('.setupContent.active').index() + 1;
            $('.setupContent.active').removeClass('active').addClass('skinRestaurant').next().addClass('active');;
            $('.availableDayList li:nth-child('+current_tab_number+')').addClass('completed').removeAttr('disabled').removeClass('active').next('li').removeAttr('disabled').addClass('active');
            if(toConfirmation){
                console.log('toConfirmation1',toConfirmation);
                $('.availableDay').removeClass('active');
                $('.confirmStep').addClass('active');
                $('li.confirmStep').trigger('click');
            }
            else{
                $('.availableStepListing').hide();
                $('.bookedRestaurant').show();
            }
        }
    });
}

function innerLoader() {
    $('.innerLoader').fadeIn();
    setTimeout(() => {
        $('.innerLoader').fadeOut();
    }, 100);
}

$('.filterItemTitle').on('click', function(){
    $(this).toggleClass('close');
    $(this).next().slideToggle();
})



/**SKIP Booking */
jQuery(document).ready(function(){
    var selectedValue = '';
    $('.reason_for_skip_booking').select2();
    $('.reason_for_skip_booking').on('change', function() {
        // Get the selected value
        selectedValue = $(this).val();
        var resonPrefix = '';

        jQuery('.reason-to-skip-value').val('');

        if(selectedValue){
            jQuery('.skipreason_error').html('');
            jQuery('.skipreason_error').hide();
        }else{
            jQuery('.skipreason_error').html('Please select Skip Reason');
            jQuery('.skipreason_error').show(); 
        }

        // Log the selected value to the console
        // if(selectedValue=='other'){
        if(selectedValue){
            jQuery('.user-skip-textare').css('display','block');
        }else{
            jQuery('.user-skip-textare').css('display','none');
            jQuery('.reason-to-skip-value').val(selectedValue);
        }
    });

    $('.user-skip-textare').on('keyup',function(){
        var reasonTextHolder = '';
        // jQuery('.reason-to-skip-value').val($(this).val());
        reasonTextHolder = $(this).val();
        jQuery('.reason-to-skip-value').val(selectedValue+' ('+reasonTextHolder+')');
    });

    /**Main Time and People chnage events on Reservation and Modify reservation page, set the values in inner Search form */
    jQuery('#book_time').on('select2:closing',function(e){
        $("select#book_time_inner").val(jQuery(this).val()).trigger('change');

    });
    jQuery('#book_persons').on('select2:closing',function(e){
        $("select#book_persons_inner").val(jQuery(this).val()).trigger('change');
    });
    /**Inner Time and People chnage events on Reservation and Modify reservation page, set the values in Main Search form */
    jQuery('#book_time_inner').on('select2:closing',function(e){
        $("select#book_time").val(jQuery(this).val()).trigger('change');

    });
    jQuery('#book_persons_inner').on('select2:closing',function(e){
        $("select#book_persons").val(jQuery(this).val()).trigger('change');
    });

    $(function(){          
        $(document).on('click','.fa-eye, .fa-eye-slash', function(){       
            var inputFields = $(this).closest('.input-group-text').siblings('input[type="text"], input[type="password"]');
            if($(this).hasClass('fa-eye-slash')){           
                $(this).removeClass('fa-eye-slash');          
                $(this).addClass('fa-eye');          
                inputFields.attr('type','password');            
            } else {         
                $(this).removeClass('fa-eye');          
                $(this).addClass('fa-eye-slash');            
                inputFields.attr('type','text');
            }
        });
      });

});
$(document).ready(function() {
    $('#book_persons,#book_persons_inner,#book_time_inner,#book_time,#book_date').select2({
        minimumResultsForSearch: Infinity
    });

    // Sort options by numerical value
    var select = $('#book_persons');
    var options = select.find('option');
    var arr = options.map(function(_, o) { return { t: $(o).text(), v: o.value }; }).get();
    arr.sort(function(o1, o2) { return o1.v - o2.v; });
    options.each(function(i, o) {
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });

    var selectbook_persons_inner = $('#book_persons_inner');
    var optionsbook_persons_inner = selectbook_persons_inner.find('option');
    var arrbook_persons_inner = optionsbook_persons_inner.map(function(_, o) { return { t: $(o).text(), v: o.value }; }).get();
    arrbook_persons_inner.sort(function(o1, o2) { return o1.v - o2.v; });
    optionsbook_persons_inner.each(function(i, o) {
        o.value = arrbook_persons_inner[i].v;
        $(o).text(arrbook_persons_inner[i].t);
    });

    $(".header .topSiteTitle").html(function (_, html) {
        return html.replace(
            "Restaurant Reservation Request Portal",
            "<span>Restaurant Reservation Request Portal</span>"
        );
    });
    
  });