document.addEventListener('DOMContentLoaded', function() {
  const menuItems = document.querySelectorAll('.menu-item');

  menuItems.forEach(item => {
      item.addEventListener('click', function(event) {
          event.preventDefault();

          // Recalculate the header height on each click
          const headerHeight = document.querySelector('.top_bar').offsetHeight;
          const targetId = item.getAttribute('href').substring(1);
          const targetElement = document.getElementById(targetId);

          if (targetElement) {
              const elementPosition = targetElement.getBoundingClientRect().top + window.scrollY;
              const offsetPosition = elementPosition - headerHeight;

              window.scrollTo({
                  top: offsetPosition,
                  behavior: 'smooth'
              });

              // Optionally, update the active state of the menu items
              menuItems.forEach(el => el.classList.remove('active'));
              item.classList.add('active');
          }
      });
  });
});



let site_url = $('#global_base_url').val();
$(document).ready(function () {
  let upload_dir = $('#hidden_upload_dir').val();
    $(document).on('click', '[data-popup]', function(e) {
    /**
     * Send OTP to admin email if Send credi cart details is clicked
     */
    if($(this).attr("data-popup")=='send_creditcard_popup'){
      $parent_box = $(this).parent('.booking_list_box');
      
      $.ajax({
          url: site_url+'admin/send_otp_on_email',
          type: 'post',
          data: {'receiver':'setting_admin_email','type':'credit_card_info'},
          dataType: 'json',
          beforeSend: function(res) {
              $parent_box.addClass('opt_loader');
              $('.verify_scci_otp').val('');
              $('.verify_scci_otp').text('');
          },
          success: function(response) {
              if(response.status=='success'){
                $('div[data-id="send_creditcard_popup"]').addClass("show-modal");
              }else{
                Swal.fire('Something went wrong, please try after some time.', '', 'error');
              }
              $parent_box.removeClass('opt_loader');
          }
      });
    }else{
      $("[data-id]").removeClass("show-modal");
      $("[data-id=" + $(this).attr("data-popup") + "]").addClass("show-modal");
    }
  });


  
  $(".close_btn,.popup .popup_overlay").on("click", function () {
    $(".popup").removeClass("show-modal");
  });

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


  $(document).on('click', '#start_import_btn', function(e) {
		$('#report-step-start').hide();
		$('#report-step-form').show();
	});

  $(document).on('click', '.view_booked_slot_btn', function(e) {
    var rest_id = $(this).attr('data-restid');
    var date = $(this).attr('data-date');
    var time = $(this).attr('data-time');
    var size = $(this).attr('data-size');
    $.ajax({
      url: site_url+'admin/get_booking_slot_username_bookingid',
      type: 'post',
      data: {rest_id:rest_id,date:date,time:time,size:size},
      success: function(response) {
          $('#table_booked_list_For_slot').html(response);
      }
  });

  });
  $(document).on('change', '#booking_status_change', function(e) {
    var _val = $(this).val();
    if(_val != 'booked'){
      $('input[name="sel_property_type[]"]').prop('checked', true);
      $('select.cmnSelect').val('');
      $(".cmnSelect.multi-step-slect-rest-names").select2({
        placeholder: "By default all restaurant will be selected",
        allowClear: true
      });
      $('.reservation-hide').addClass('pointer-none');
    }
    else{
      $('.reservation-hide').removeClass('pointer-none');
    }
  });
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
  $(document).on('click', '.adminNote_btn', function(e) {
    var list_id = $(this).attr('data-listid');
    $('input#adminNote_booking_listid').val(list_id);
  });
  $(document).on('submit', '#add_admin_note', function(e) {
    e.preventDefault();
    var form = $('#add_admin_note');
    $.ajax({
        url:  site_url+'admin/add_admin_note',
        type: 'post',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function(res) {
            $('#cancel_reservation_error').text('');
            $('#share_invite_success').text('');
            $('#add_admin_note [type="submit"]').prop('disabled',true);
            $('#add_admin_note [type="submit"]').addClass('loading');
        },
        success: function(result) {
            $('.innerLoader').hide();
            $('#add_admin_note [type="submit"]').prop('disabled',false);
            $('#add_admin_note [type="submit"]').removeClass('loading');
            window.location.reload();
        }
    });
});
  $(document).on('click', '.btn.filterBtn', function(e) {
    e.preventDefault();
    filter_restaurant_form_ajax();
    return false;
  });
  $(document).on('submit', '#admin_restaurant_date_filter_form', function(e) {
      e.preventDefault();
      filter_restaurant_form_ajax();
      return false;
  });

  function filter_restaurant_form_ajax(){
    var _form = new FormData();
        var _type = $('input[name="property_type"]:checked').val();
        var _date = $('select#book_date').val();
        var _time = $('select#book_time').val();
        var _pax = $('select#book_persons').val();
        var bookid = $('#bookid').val();
       
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
        _form.append('bookid', bookid);
        
        $.ajax({
            url: site_url+'admin/filter_restaurant_list',
            type: 'post',
            data: _form,
            contentType: false,
            processData: false,
            beforeSend: function(res) {
                $('.innerLoader').show();
            },
            success: function(response) {
                $('#ajax-response-restaurants').html(response);
            }
        });
  }
  $(document).on('click', '#confirm_modify_booking_btn', function(e) {
    var bookid = $(this).attr('data-bookid');
    var restid = $(this).attr('data-restid');
    var date = $(this).attr('data-date');
    var time = $(this).attr('data-time');
    var pax = $(this).attr('data-pax');
    $.ajax({
      url: site_url+'admin/modify_restaurant_admin_book',
      type: 'post',
      dataType:'json',
      data: {bookid:bookid,restid:restid,date:date,time:time,pax:pax},
      success: function(response) {
        if(response.response == 'success'){
          window.location.href=response.href;
        }
      }
  });
  });

  $(document).on('click', '.selectRestaurant_btn', function(e) {
      var _time = $(this).text();
      var rest_id = $(this).attr('data-rest_id');
      var bookid = $(this).attr('data-bookid');
      var pax = $(this).attr('data-pax');
      $.ajax({
        url: site_url+'admin/modify_popup_booking_restaurant',
        type: 'post',
        data: {rest_id:rest_id,bookid: bookid,time: _time, pax: pax},
        success: function(response) {
            $('#modify_reservation_popup_admin_ajax').html(response);
        }
      });
  });

  $(document).on('click','.dropdownClick', function(e){
      e.preventDefault();
      $('.dropdown').removeClass('active');
      $(this).parent().toggleClass('active');
  });

  $(document).on('click','.filterIcon', function(e){
    e.preventDefault();
    $('.filterCol').toggleClass('active');
  });

  $(document).click(function(event) {
      if (!$(event.target).closest(".dropdown").length ) {
          $('.dropdown').removeClass('active');
      }
  });

  // Data Table
  var datatable = $("#total_reservation").DataTable({
    language: {
        sLengthMenu: "Show Entries: _MENU_",
        searchPlaceholder: "Please search here..."
    },
    dom: '<"#top_filter"lf>rt<"#bottom_page"ip><"clear">',  
    "responsive": true,
  });    

  var all_restaurants = $("#all_restaurants").DataTable({
    language: {
        sLengthMenu: "Show Entries: _MENU_",
        searchPlaceholder: "Please search here..."
    },
    'columnDefs': [ {
      'targets': [1,3,4,8], // column index (start from 0)
      'orderable': false, // set orderable false for selected columns
   }],
    dom: '<"#top_filter"lf>rt<"#bottom_page"ip><"clear">',
    "responsive": true,
    pageLength: 25,
  });

  var reviewsList
  reviewsList = $("#reviewsList").DataTable({
    language: {
      sLengthMenu: "Show Entries: _MENU_",
      searchPlaceholder: "Please search here..."
    },
    dom: '<"#top_filter"lf>rt<"#bottom_page"ip><"clear">',
    "responsive": true,
  });

  var all_restaurants_bookingList 
  all_restaurants_bookingList= $("#all_restaurants_bookingList").DataTable({
    language: {
        sLengthMenu: "Show Entries: _MENU_",
        searchPlaceholder: "Please search here..."
    },
    dom: '<"#top_filter"lf>rt<"#bottom_page"ip><"clear">',  
    "responsive": true,
    "bPaginate": false,
    "bInfo" : false,
    columnDefs: [
      {
          targets: 1, // column index (zero-based) to disable sorting
          orderable: false // disable sorting for this column
      }
    ]
  }); 


  $(document).on('click','#reviewsList',function(){
  });
  // setTimeout(function(){
  // },2200)

  
  //var table = $('#example').DataTable();
 
  $(document).on( 'click', '.restro_time_info [data-delete="delete"]', function () {
    all_restaurants.row($(this).parents('tr') ).remove().draw();
  });

  $(document).on( 'click', '#all_restaurants_bookingList [data-delete="delete"]', function () {
    var _booked = $(this).attr('data-booked');
    var _btn = $(this).parents('tr').find('.view_booked_slot_btn');
    if(_booked > 0){
      Swal.fire('It seems like the time slot you are trying to delete is already booked by some guest(s). Please cancel those bookings first to delete the time slot.', '', 'error');
      _btn.trigger('click');
    }
    else{
      all_restaurants_bookingList.row($(this).parents('tr') ).remove().draw();
    }
  });
  $(document).on( 'click', '#reviewsList [data-delete="delete"]', function () {
    reviewsList.row($(this).parents('tr') ).remove().draw();
  });

  var row_index;
  var rating_row_index;

  $(document).on('click','.restro_time_info [data-edit="edit"]', function(){
    // var reservation_time  = String($(this).parents('tr').find('td:nth-child(2)').text());
    //  var reservation_date  = $(this).parents('tr').find('td:nth-child(3)').text();
    // //  var pieces = reservation_date.split("-");
    // //  reservation_date = pieces[1] + "-" + pieces[0] + "-" + pieces[2];
    //  var table_size  = $(this).parents('tr').find('td:nth-child(4)').text();
    //  var table_capacity  = $(this).parents('tr').find('td:nth-child(5)').text();

    var reservation_time  = String($(this).parents('tr').find('td:nth-child(3)').text());
     var reservation_date  = $(this).parents('tr').find('td:nth-child(4)').text();
    //  var pieces = reservation_date.split("-");
    //  reservation_date = pieces[1] + "-" + pieces[0] + "-" + pieces[2];
     var table_size  = $(this).parents('tr').find('td:nth-child(5)').text();
     var table_capacity  = $(this).parents('tr').find('td:nth-child(6)').text();

     
     row_index  = $(this).parents('tr').index();
    $('#insert_duration_table_btn').text('update');
     $('#time_input').val(reservation_time).prop('selected',true);
     $('#time_input').trigger('change');          
     
     $("#date_select").datepicker('setDate', reservation_date);
     $('[name="table_size"]').val(table_size);
     $('[name="capacity"]').val(table_capacity);

     $([document.documentElement,document.body]).animate({scrollTop:$('.slotBooking').offset().top},1000);
     $('.addReservationForm').animate({scrollTop:$('.slotBooking').offset().top},1000);
     setTimeout(() => {
       $('#time_input').focus();
     }, 500);
     
     
  });
  $(document).on('click','.remove_guest_btn', function(e){
    var _listid = $(this).attr('data-listid');
    var userid = $(this).attr('data-user_id');
    var username = $(this).attr('data-username');
    $('span#guestname_span').text(username);
    $('a.confirmdeleteInvite').attr('data-listid',_listid);
    $('a.confirmdeleteInvite').attr('data-userid',userid);
  });
  $(document).on('click','a.confirmdeleteInvite', function(e){
    e.preventDefault();
    var listid = $(this).attr('data-listid');
    var userid = $(this).attr('data-userid');
    var _btn = $(this);
    $.ajax({
        url: site_url+'admin/confirm_delete_invite',
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
  $(document).on('click','#restaurant_filter_clear', function(){
    $('#sidebar_filterList_ajax [type="radio"]').removeAttr('checked');
    $('#sidebar_filterList_ajax .filterItem input:checkbox').removeAttr('checked');
  });







  var _slotCount = 0
  $(document).on('click','#insert_duration_table_btn', function(){
    //console.log($(this).text());
    //console.log('sdsdsdds');
    var _time = $("#time_input").val();
    var _date = $("input[name='date_select']").val();
    var _size = $("input[name='table_size']").val();
    var _capacity = $("input[name='capacity']").val();
    var _booked = 0;

    var isUpdate = false;

    if($(this).text()=='update'){
      isUpdate = true;
    }


   $(this).text('ADD');
    if(_time == '' || _date == '' || _size <= 0 || _capacity <= 0){
      return false;
    }
    if(!(typeof row_index === 'undefined' || row_index === null)){
      row_index = row_index + 1;
      _booked = $('#all_restaurants_bookingList tbody tr:nth-child('+row_index+')').find('td.booked').text();
      all_restaurants_bookingList.row($('#all_restaurants_bookingList tbody tr:nth-child('+row_index+')')).remove().draw();
    }
    var _remain = _capacity - _booked;
      $('#all_restaurants_bookingList').find('.dataTables_empty').parents('tr').remove();
      var _html_ = '<tr><td></td><td><div class="custom-checkbox"><input type="checkbox" name="multi_slotid[]" class="form-input checkboxInput sloat_input_cls" id="check'+_slotCount+'" value="'+_slotCount+'"><label class="checkboxLabel" for="check'+_slotCount+'"></label></div></td><td>'+_time+'<input type="hidden" name="tableli_time[]" value="'+_time+'"></td><td>'+_date+'<input type="hidden" name="tableli_date[]" value="'+_date+'"></td><td>'+_size+'<input type="hidden" name="tableli_size[]" value="'+_size+'"></td><td>'+_capacity+'<input type="hidden" name="tableli_capacity[]" value="'+_capacity+'"></td><td class="booked">'+_booked+'</td><td>'+_remain+'</td><td><a href="javascript:void(0)" class="drop_dots"><img src="'+upload_dir+'assets/images/three_dots.svg" alt=""></a><ul class="action_drop"><li><a href="javascript:void(0)" data-edit="edit"><img src="'+upload_dir+'assets/images/edit.svg" alt="">Edit</a></li><li><a href="javascript:void(0)" data-booked="'+_booked+'" data-delete="delete"><img src="'+upload_dir+'assets/images/trash.svg" alt="">Delete</a></li></ul></td></tr>';
      _slotCount = _slotCount+1;
      all_restaurants_bookingList.rows.add($(_html_)).draw();   
      $("#time_input").val('');
      $("input[name='date_select']").val('');
      $("input[name='table_size']").val('');
      $("input[name='capacity']").val('');  


      if(isUpdate){
        // console.log('to phph');
        if(jQuery('form').hasClass('edit_restaurant_form')){
        // var form = $('#myForm');
          var form = $('.edit_restaurant_form');
          $.ajax({
              // url:  site_url+'admin/invitation_sendto_guest',
              url:  site_url+'admin/update_restaurant_slots',
              type: 'post',
              data: form.serialize(),
              dataType: 'json',
              beforeSend: function(res) {
                // console.log('before end');
                  // $('#share_invite_error').text('');
                  // $('#share_invite_success').text('');
                  $('.innerLoader').show();
                  $('#myForm [type="submit"]').prop('disabled',true);
                  $('#myForm #insert_duration_table_btn').prop('disabled',true);
                  $('#myForm td').css('pointer-events','none')
                  // $('#share_invite_form [type="submit"]').addClass('loading');
              },
              success: function(result) {
                $('#myForm [type="submit"]').prop('disabled',false);
                $('#myForm #insert_duration_table_btn').prop('disabled',false);
                $('#myForm td').css('pointer-events','all')
                  $('.innerLoader').hide();
                  // $('#share_invite_form [type="submit"]').prop('disabled',false);
                  // $('#share_invite_form [type="submit"]').removeClass('loading');
                  // if(result.response == 'success'){
                  //     $('#share_invite_success').text(result.message);
                  //     $('#inviteModal').removeClass('modal-active');
                  //     window.location.reload();
                  // }
                  // else{
                  //     $('#share_invite_error').text(result.message);
                  // }
              }
          });
        }


      }
  });


      /**Select and Unselect all slots */
      // jQuery('.select-all-slots').change(function(){
      //   restaurantForm = jQuery('.admin_restaurant_from');
      //   if(this.checked){
      //       // .custom-checkbox.multi-user-select-wraper
      //       //console.log('Checked');
      //       // jQuery( 'div.custom-checkbox' ).not( ".select-all-users-psw-reset " );
      //       jQuery('#delete_bulk_slots').show();
      //       jQuery('.admin_restaurant_from input[name="multi_slotid[]"]').prop('checked', true);
      //   }else{
      //       //console.log('UnChecked');
      //       jQuery('#delete_bulk_slots').hide();
      //       jQuery('.admin_restaurant_from input[name="multi_slotid[]"]').prop('checked', false);

      //   }
      // });

            /**On change of individual select box of slots */
            jQuery(document).on('change','.sloat_input_cls',function(){
              if (this.checked){
                jQuery(this).closest('tr').addClass('remove_slot');
                jQuery('#delete_bulk_slots').show();
              }
              var checked = 0;
              var checkbox = [];
              $('#all_restaurants_bookingList tbody .checkboxInput').each(function(){
                  if ($(this).prop('checked')) {
                    $(this).closest('tr').addClass('remove_slot');
                      checkbox.push($(this).val());
                      checked++;
                  }
              })
              if(checked > 0){
                jQuery('#delete_bulk_slots').show();
              }else{
                jQuery('#delete_bulk_slots').hide();
              }


            });
    
      
            jQuery('.select-all-slots').change(function(e){
              e.stopPropagation();
              // console.log('OUT');
              if(this.checked){
                  // .custom-checkbox.multi-user-select-wraper
                  // console.log('Checked');
                  // jQuery( 'div.custom-checkbox' ).not( ".select-all-users-psw-reset " );
                  jQuery('#delete_bulk_slots').show();
                  all_restaurants_bookingList.$('input[name="multi_slotid[]"]').prop('checked', true);
              }else{
                  // console.log('UnChecked');
                  jQuery('#delete_bulk_slots').hide();
                  all_restaurants_bookingList.$('input[name="multi_slotid[]"]').prop('checked', false);
                  
              }
            });
      
            /**Delete selected slots from slot table */
             $(document).on('click', '#delete_bulk_slots', function(e) {

               var checked = 0;
               var checkbox = [];
               $('#all_restaurants_bookingList tbody .checkboxInput').each(function(){
                   if ($(this).prop('checked')) {
                     $(this).closest('tr').addClass('remove_slot');
                       checkbox.push($(this).val());
                       checked++;
                   }else{
                    $(this).closest('tr').removeClass('remove_slot');
                   }
               })
               if(checked == 0){
                   Swal.fire('Select slots first!', '', 'warning');
                   return false;
               }
               Swal.fire({
                   title: 'Do you want to delete bulk users?',
                   showDenyButton: true,
                   showCancelButton: false,
                   confirmButtonText: 'Yes',
                   denyButtonText: `No`,
                   }).then((result) => {
                   /* Read more about isConfirmed, isDenied below */
                   if (result.isConfirmed) {
                       //jQuery('.remove_slot').remove();
                       //all_restaurants_bookingList.draw(); 

                      //  console.log(jQuery(this).data('resto'));
                       if(jQuery(this).data('resto')=="edit"){
                        // $.ajax({
                        //         url: '<?php echo base_url();?>index.php/admin/delete_bulk_users',
                        //         type: "post",
                        //         data: {checkbox:checkbox},
                        //         success: function(data) {
                        //             $('.checkboxInput').each(function(){
                        //                 if ($(this).prop('checked')) {
                        //                     var _parent = $(this).parents('tr');
                        //                     userList.row(_parent).remove();
                        //                     $(_parent).remove();
                        //                 }
                        //             });
                                        //all_restaurants_bookingList.rows('.remove_slot').remove().draw( true );
                        //             Swal.fire('Deleted!', '', 'success')
                        //         }
                        //     });

                                      var form = $('.edit_restaurant_form');
                                      $.ajax({
                                          // url:  site_url+'admin/invitation_sendto_guest',
                                          url:  site_url+'admin/update_restaurant_slots',
                                          type: 'post',
                                          data: form.serialize(),
                                          dataType: 'json',
                                          beforeSend: function(res) {
                                            // console.log('before end');
                                              // $('#share_invite_error').text('');
                                              // $('#share_invite_success').text('');
                                              $('.innerLoader').show();
                                              $('#myForm [type="submit"]').prop('disabled',true);
                                              $('#myForm #insert_duration_table_btn').prop('disabled',true);
                                              $('#myForm td').css('pointer-events','none')
                                              // $('#share_invite_form [type="submit"]').addClass('loading');
                                          },
                                          success: function(result) {
                                            $('#myForm [type="submit"]').prop('disabled',false);
                                            $('#myForm #insert_duration_table_btn').prop('disabled',false);
                                            $('#myForm td').css('pointer-events','all')
                                            $('.innerLoader').hide();
                                            all_restaurants_bookingList.rows('.remove_slot').remove().draw( true );
                                            Swal.fire('Deleted!', '', 'success');
                                              // $('#share_invite_form [type="submit"]').prop('disabled',false);
                                              // $('#share_invite_form [type="submit"]').removeClass('loading');
                                              // if(result.response == 'success'){
                                              //     $('#share_invite_success').text(result.message);
                                              //     $('#inviteModal').removeClass('modal-active');
                                              //     window.location.reload();
                                              // }
                                              // else{
                                              //     $('#share_invite_error').text(result.message);
                                              // }
                                          }
                                      });


                       }else{
                                        all_restaurants_bookingList.rows('.remove_slot').remove().draw( true );
                       }

                   } else if (result.isDenied) {
                       // Swal.fire('Changes are not saved', '', 'info')
                   }
               })
             });




  // var review_val	=	$("#myForm").validate({
  //   // Specify validation rules
  //   rules: {
  //     person_photo: {
  //       required: true,
  //     },
  //     reviews_name: {
  //       required: true,
  //     },
  //     review_date_select: {
  //       required: true,
  //     },
  //     review_start: {
  //       required: true,
  //     },
  //     review_description: {
  //       required: true,
  //     },
      
  //   },

  //   errorPlacement: function(error, element) {
  //       if (element.hasClass('radio')) {
  //           $('.deposit_radio_wrap label').addClass('radio-error');
  //       }
  //       else {
  //           $('.deposit_radio_wrap label').removeClass('radio-error');
  //           return true;
  //       }
  //   }
  // });
  $(document).on('click','[data-target="inviteModal"]', function(e){
    var _id = $(this).attr('data-booking_listid');
    $('input#share_booking_listid').val(_id);
  });
  $(document).on('submit', '#share_invite_form', function(e) {
    e.preventDefault();
    var form = $('#share_invite_form');
    $.ajax({
        url:  site_url+'admin/invitation_sendto_guest',
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
                window.location.reload();
            }
            else{
                $('#share_invite_error').text(result.message);
            }
        }
    });
});

  // $(document).on('click','#add_reviews_btn', function(){
  //   var _photo = $("#rating_photo_file")[0].files[0];
  //   var _name = $("#reviews_name_input").val();
  //   var _date = $("#review_date_input").val();
  //   var _rating = $("#review_start_input").val();
  //   var _description = $("#review_description").val();
  //   //$('.profilePicture').removeClass('error_file');

    
  //   // if(_photo == '' || _name == '' || _date == '' || _rating == '' || _description == ''){
      
      
  //   //   return false;
  //   // }

  //   if(!(_photo == '' || _name == '' || _date == '' || _rating == '' || _description == '')){
  //     $(".add_restro .restro_info_row .form-group input").removeClass('error');
  //     $(".add_restro .restro_info_row .form-group textarea").removeClass('error');
  //     $(".add_restro .restro_info_row .form-group .cmnSelect ").removeClass('error');
  //     $(".add_restro .restro_info_row #rating_photo_file ").removeClass('error');

  //     if (_photo){
  //       let reader = new FileReader();
  //       reader.onload = function(event){
  //         var prev_photo = event.target.result;
  //         $('#reviewsList').find('.dataTables_empty').parents('tr').remove();
  //       var _html_ = '<tr><td></td><td><div class="restaurant_img"><img src="'+prev_photo+'" alt=""><input type="hidden" name="review_photo[]" value="'+prev_photo+'"></div></td><td>'+_name+'<input type="hidden" name="hide_review_name[]" value="'+_name+'"></td><td>'+_date+'<input type="hidden" name="hide_review_date[]" value="'+_date+'"></td><td>'+_rating+'<input type="hidden" name="hide_review_rating[]" value="'+_rating+'"></td><td><div class="reviewDescrip">'+_description+'</div><input type="hidden" name="hide_review_description[]" value="'+_description+'"></td><td><a href="javascript:void(0);" class="view_btn" data-delete="delete"><img src="'+upload_dir+'assets/images/trash.svg" alt="">Delete</a></td></tr>';
  //       reviewsList.rows.add($(_html_)).draw(); 
  //       }
  //       reader.readAsDataURL(_photo);
  //     }
  //   }else{
  //     $(".add_restro .restro_info_row .form-group input").addClass('error');
  //     $(".add_restro .restro_info_row .form-group textarea").addClass('error');
  //     $(".add_restro .restro_info_row .form-group .cmnSelect ").addClass('error');
  //     $(".add_restro .restro_info_row #rating_photo_file ").addClass('error');
      
  //     if($('.profilePicture .fileUploadInput').hasClass('error')){
  //       $('.profilePicture').addClass('error_file');
  //     }
  //   }
           
  // });

  $("#recent_booking").DataTable({
    "bInfo" : false,
    "bPaginate": false,
    "searching": false,
    "responsive": false,
  });
  
  $(document).on('keyup', '.search_input', function() {
      var value = $(this).val();
      // console.log(value);
      datatable.search(value).draw();
  });

  // $(document).on('click','#update_creditcard_btn',function(e){
  //   e.preventDefault();
  //   var email = $('#credit_admin_email').val();
  //   $.ajax({
  //     url:  site_url+'admin/send_creditcard_detail',
  //     type: 'post',
  //     data: {email:email},
  //     dataType: 'json',
  //     beforeSend: function(res) {
  //         $('#update_creditcard_btn').prop('disabled',true);
  //         $('#update_creditcard_btn').addClass('loading');
  //     },
  //     success: function(result) {
  //       $('#update_creditcard_btn').prop('disabled',false);
  //         $('#update_creditcard_btn').removeClass('loading');
  //         $('#credit_admin_email').val('');
  //         $('.popup').removeClass('show-modal');
  //         if(result.response == 'success'){
  //           Swal.fire('Mail Sent Successfully!', '', 'success')
  //         }
  //     }
  //   });
  // });

  $('#verify_otp_and_sned_mail_form').on('submit',function(e){
    e.preventDefault();
    var otp = $('.verify_scci_otp').val();
    if(!otp){
      Swal.fire('Please enter OTP', '', 'error');
      return false;
    }
    $.ajax({
      url:  site_url+'admin/send_creditcard_detail',
      type: 'post',
      data: {otp:otp},
      dataType: 'json',
      beforeSend: function(res) {
          $('#verify_creditcardinfo_btn').prop('disabled',true);
          $('#verify_creditcardinfo_btn').addClass('loading');
      },
      success: function(result) {
        $('#verify_creditcardinfo_btn').prop('disabled',false);
          $('#verify_creditcardinfo_btn').removeClass('loading');
          $('#credit_admin_email').val('');
          
          if(result.response == 'success'){
            Swal.fire(result.message, '', 'success');
            $('.verify_scci_otp').val('');
            $('.verify_scci_otp').text('');
            $('.popup').removeClass('show-modal');
          }else{
            Swal.fire(result.message, '', 'error');
            return false;
          }
      }
    });
  });
  $(document).on('click','.btn-dlt-rest',function(e){
    var rest_id = $(this).attr('data-restid');
    var _parent = $(this).parents('tr');
    var rest_book = $(this).attr('data-booked');

    if(rest_book){
      Swal.fire({
        title: 'Do you want to delete this restaurant?',
        showDenyButton: true,
        showCancelButton: true,
        cancelButtonText: 'Delete and notify users',
        confirmButtonText: 'Just Delete',
        denyButtonText: `No`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
              $.ajax({
                      url: site_url+'admin/delete_admin_restaurant',
                      type: "post",
                      data: {rest_id:rest_id,notify:'no'},
                      success: function(data) {
                          $(_parent).remove();
                          Swal.fire('Deleted!', '', 'success')
                      }
                  });
          } else if (result.isDenied) {
              // Swal.fire('Changes are not saved', '', 'info')
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Swal.fire('Button 2 clicked!');
            $.ajax({
              url: site_url+'admin/delete_admin_restaurant',
              type: "post",
              data: {rest_id:rest_id,notify:'yes'},
              success: function(data) {
                  $(_parent).remove();
                  Swal.fire('Deleted!', '', 'success')
              }
            });
          }
        })
    }else{
      Swal.fire({
        title: 'Do you want to delete this restaurant?',
        showDenyButton: true,
        showCancelButton: false,
        cancelButtonText: 'Delete and notify users',
        confirmButtonText: 'Just Delete',
        denyButtonText: `No`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
              $.ajax({
                      url: site_url+'admin/delete_admin_restaurant',
                      type: "post",
                      data: {rest_id:rest_id,notify:'no'},
                      success: function(data) {
                          $(_parent).remove();
                          Swal.fire('Deleted!', '', 'success')
                      }
                  });
          } else if (result.isDenied) {
              // Swal.fire('Changes are not saved', '', 'info')
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Handle button 2 click
            // console.log('ghhgggggg');
            // Swal.fire('Button 2 clicked!');
            $.ajax({
              url: site_url+'admin/delete_admin_restaurant',
              type: "post",
              data: {rest_id:rest_id,notify:'yes'},
              success: function(data) {
                  $(_parent).remove();
                  Swal.fire('Deleted!', '', 'success')
              }
            });
          }
        })
    }


  });

  $(document).on('click','#add_user_btn',function(e){
    var _href = $(this).attr('data-href');
    $('#edit_fname').val('');
    $('#edit_lname').val('');
    $('#edit_email').val('');
    $('#edit_phone').val('');
    $('#user_code').val('');
    $('#edit_alternate_email').val('');
    $('#add_user_popup_modal').find('figcaption').text('ADD NEW USER');
    $('#add_user_popup_modal').find('input[type="submit"]').val('ADD');
    $('#edit_fname').parents('form').attr('action',_href);
  })

  $(document).on('click','.edit_user_btn',function(e){
    var _href = $(this).attr('data-href');
    var _fname = $(this).attr('data-firstname');
    var _lname = $(this).attr('data-lastname');
    var _email = $(this).attr('data-email');
    var _phone = $(this).attr('data-phone');
    var altemail = $(this).attr('data-altemail');
    var user_code = $(this).attr('data-user_code');
    $('#edit_fname').val(_fname);
    $('#edit_lname').val(_lname);
    $('#edit_email').val(_email);
    $('#edit_phone').val(_phone);
    $('#edit_alternate_email').val(altemail);
    $('#user_code').val(user_code);
    $('#add_user_popup_modal').find('figcaption').text('EDIT USER');
    $('#add_user_popup_modal').find('input[type="submit"]').val('UPDATE');
    $('#edit_fname').parents('form').attr('action',_href);
    // $( "a.btn_add" ).each(function( index ) {
    //   if($(this).attr('data-popup') == 'addUser'){
    //     $(this).trigger('click');
    //   }
    // });
  });
  

  //Verify update admin setting OTP
  $('#verification_for_admin_settings_form').on('submit',function(e){
    e.preventDefault();
    var otp = $('.verify_admin_settings_otp').val();
    if(!otp){
      Swal.fire('Please enter OTP', '', 'error');
      return false;
    }
    $.ajax({
      url:  site_url+'admin/verify_otp_for_admin_settings',
      type: 'post',
      data: {otp:otp},
      dataType: 'json',
      beforeSend: function(res) {
          $('#verify_admin_settings_btn').prop('disabled',true);
          $('#verify_admin_settings_btn').addClass('loading');
      },
      success: function(result) {
        $('#verify_admin_settings_btn').prop('disabled',false);
          $('#verify_admin_settings_btn').removeClass('loading');
          $('#credit_admin_email').val('');
          
          if(result.response == 'success'){
            Swal.fire(result.message, '', 'success');
            $('.verify_admin_settings_otp').val('');
            $('.verify_admin_settings_otp').text('');
            $('.popup').removeClass('show-modal');
            jQuery('.update_settings_otp_status').val('true');
            jQuery('#theme_settings_form').submit();
          }else{
            Swal.fire(result.message, '', 'error');
            return false;
          }
      }
    });
  });

  

  $('#theme_settings_form').submit(function(e){
    e.preventDefault();
    var maxAllowedDate = $('.max_reservation_date').val();
    // var inputEndDate = $('.booking_end_date').val();
    // console.log(maxAllowedDate);
    if(maxAllowedDate){

      var secondDate = $('.booking_end_date').val();

      // Parse the second date components
      var parts = $('#booking_end_date').val().split('-');
      var month = parseInt(parts[0], 10); // Month is at index 0
      var day = parseInt(parts[1], 10); // Day is at index 1
      var year = parseInt(parts[2], 10); // Year is at index 2
      
      // Create a new Date object using the parsed components
      var parsedinputEndDate = new Date(year, month - 1, day); // Month is zero-based
      
      // Format the parsed second date to match the format of the first date
      var formattedinputEndDate = parsedinputEndDate.getFullYear() + "-" + 
                                ('0' + (parsedinputEndDate.getMonth() + 1)).slice(-2) + "-" + 
                                ('0' + parsedinputEndDate.getDate()).slice(-2);

                                // console.log(formattedinputEndDate); // Output: "2024-05-30"

      // Convert strings to Date objects
      var firstDateObj = new Date(maxAllowedDate);
      var secondDateObj = new Date(formattedinputEndDate);

      // Compare dates
      // if (firstDateObj < secondDateObj) {
      //   console.log("First date is earlier than the second date.");
      // }else if (firstDateObj > secondDateObj) {
      //   console.log("First date is later than the second date.");
      // } else {
      //     console.log("Both dates are the same.");
      // }


      if (firstDateObj < secondDateObj){
        // this.submit();
        // if(jQuery('.update_settings_otp_status').val()=='true'){

          this.submit(); // Programmatically submit the form
        // }else{

        //   send_otp_to_update_admin_settings();
        // }
        
      }else{
        // console.log('In vlaide END date');
        // Parse the date string using JavaScript's Date object
        var parsedDatemaxAllowedDate = new Date(maxAllowedDate);

        // Format the date to "mm-dd-yyyy" format
        var formattedDatemaxAllowedDate = ('0' + (parsedDatemaxAllowedDate.getMonth() + 1)).slice(-2) + "-" + 
                            ('0' + parsedDatemaxAllowedDate.getDate()).slice(-2) + "-" + 
                            parsedDatemaxAllowedDate.getFullYear();
        // Swal.fire('Invalide Booking End Date! Should be later than:'+formattedDatemaxAllowedDate, '', 'error');
        Swal.fire('reservation dates should not be greater than end date', '', 'error');
      }

    }else{
      //this.submit(); // Programmatically submit the form
      // if(jQuery('.update_settings_otp_status').val()=='true'){
        this.submit(); // Programmatically submit the form
      // }else{
      //   send_otp_to_update_admin_settings();
      // }
    }
    
  });

  //Send OTP before saving Admin settings
  function send_otp_to_update_admin_settings(){
    $('div[data-id="verification_for_admin_settings"]').addClass("show-modal");
    $.ajax({
      url: site_url+'admin/send_otp_on_email',
      type: 'post',
      data: {'receiver':'setting_admin_email','type':'admin_settings'},
      dataType: 'json',
      beforeSend: function(res) {
          //$parent_box.addClass('opt_loader');
          $('.verify_admin_settings_otp').val('');
          $('.verify_admin_settings_otp').text('');
      },
      success: function(response) {
          if(response.status=='success'){
            
          }else{
            $('div[data-id="verification_for_admin_settings"]').removeClass("show-modal");
            Swal.fire('Something went wrong, please try after some time.', '', 'error');
          }
          //$parent_box.removeClass('opt_loader');
      }
    });
  }


  jQuery(document).on('submit','#edituserCreditCardDetails_admin',function(e){
    e.preventDefault();
    // console.log('ssssssssss');
    var _edit_card_number = $('#edit_card_number').val();
    var _edit_cvv = $('#card_cvv').val();
    //check digit count of Card number
    inputCardVal = _edit_card_number;
    inputCardVal = inputCardVal.replace(/\D/g, '');
    let card = inputCardVal.trim();
    let cvv = _edit_cvv.replace(/\D/g, '').trim();
    // General numeric check
    if (!/^\d{15,16}$/.test(card)) {
      Swal.fire({
        title: "Invalid Card Number",
        text: "Card number must be 15 or 16 digits.",
        icon: "warning"
      });
      return false;
    }
  
    // Detect if the card is AMEX (starts with 34 or 37 and 15 digits)
    const isAmex = /^3[47]\d{13}$/.test(card);
  
    // Validate CVV based on card type
    if ((isAmex && cvv.length !== 4) || (!isAmex && cvv.length !== 3)) {
      Swal.fire({
        title: "Invalid CVV number",
        text: isAmex ? "AMEX cards require a 4-digit CVV." : "CVV must be 3 digits.",
        icon: "warning"
      });
      return false;
    }
    this.submit();

  });
  $(document).on('click','.edit_card_btn',function(e){
    var _href = $(this).attr('data-href');
    var _user_id = $(this).attr('data-user_id');
    var _card_number = $(this).attr('data-card_number');
    var _expiry_month = $(this).attr('data-expiry_month');
    var _expiry_year = $(this).attr('data-expiry_year');
    var _cvv = $(this).attr('data-cvv');
    var _card_holder = $(this).attr('data-card_holder');

    var value = _card_number;
    value = value.replace(/\D/g, ''); // Remove non-numeric characters
    var maskedValue = value.replace(/\d(?=\d{4})/g, 'X'); // Mask all but the last four digits
    maskedValue = maskedValue.replace(/(.{4})(?!$)/g, '$1-'); // Add "-" after every four characters, except at the end



    // $('#edit_card_number').val(_card_number);
    $('.editCardnumberLabel').html(maskedValue);
    $('#user_id').val(_user_id);
    $('#card_ex_month').val(_expiry_month);
    $('#card_ex_year').val(_expiry_year);
    $('#card_cvv').val(_cvv);
    $('#card_holder_name').val(_card_holder);
    $('#user_code').val(user_code);
    $('#edit_card_number').parents('form').attr('action',_href);
  });


  $(document).on('click','.edit_admin_btn',function(e){
    var _href = $(this).attr('data-href');
    var _fname = $(this).attr('data-firstname');
    var _lname = $(this).attr('data-lastname');
    var _email = $(this).attr('data-email');
    var _phone = $(this).attr('data-phone');
    var altemail = $(this).attr('data-altemail');
    $('#edit_admin_fname').val(_fname);
    $('#edit_admin_lname').val(_lname);
    $('#edit_admin_email').val(_email);
    $('#edit_contact_number').val(_phone);
    // $('#edit_admin_fname').parents('form').attr('action',_href);
    $('#edit_admin_email').parents('form').attr('action',_href);
  });
  $(document).on('click','.reset_user_password',function(e){
    var _href = $(this).attr('data-href');
    $('#edit_admin_fname').parents('form').attr('action',_href);
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
  $(document).on('click', '.modal-backdrop, [data-target="modalClose"]', function(event) {
    $(".modal").removeClass('modal-active');
    $("body").removeClass('overflow-hidden');
});
$(document).on('click', '.cancel-reserved_btn', function(e) {
  var list_id = $(this).attr('data-listid');
  $('input#cancel_booking_listid').val(list_id);
});
$(document).on('click', '.reason-txt-btn', function(e) {
  var reason = $(this).attr('data-reason');
  $('#reason_text_input').val(reason);
});
$(document).on('click', '.cancel-txt-btn', function(e) {
  var reason = $(this).attr('data-reason');
  $('#cancel_text_input').val(reason);
});
$(document).on('submit', '#cancel_reservation_form', function(e) {
  e.preventDefault();
  var form = $('#cancel_reservation_form');
  $.ajax({
      url:  site_url+'admin/cancel_reservation_date',
      type: 'post',
      data: form.serialize(),
      dataType: 'json',
      beforeSend: function(res) {
          $('#cancel_reservation_error').text('');
          $('#share_invite_success').text('');
          $('#cancel_reservation_form input[type="submit"]').prop('disabled',true);
          $('#cancel_reservation_form input[type="submit"]').addClass('loading');
      },
      success: function(result) {
        $('#cancel_reservation_form input[type="submit"]').prop('disabled',false);
          $('#cancel_reservation_form input[type="submit"]').removeClass('loading');
          $('.innerLoader').hide();
          if(result.response == 'success'){
              $('#cancel_reservation_success').text(result.message);
              location.reload();
          }
          else{
              $('#cancel_reservation_error').text(result.message);
          }
      }
  });
});

  $(document).on('click','.drop_dots',function(e){
    e.stopPropagation()
    $('.drop_dots').removeClass("active");
    $('.action_drop').removeClass('active');
    $(this).toggleClass('active');
    $(this).next('.action_drop').toggleClass('active');
  });

  $(document).on("click", function(e) {
    if ($(e.target).is(".action_drop") === false) {
      $(".action_drop").removeClass("active");
    }
    if ($(e.target).is(".drop_dots") === false) {
      $('.drop_dots').removeClass("active");
    }
  });

  // multiple from vaidation with step start
  $(document).on('change','.radio-group input.radio',function() {      
      $('.radio-group label').removeClass('label-selected radio-error');
      $(this).parents('label').addClass('label-selected');
      if($(this).val() == 'yes')
      {
        $('.amount_field').show();
      }else{
        $('.amount_field').hide();
      }
  });

  $.validator.addMethod('amount_validate', function(value, element, param) {
      if($('.add_restro form input:checked').val() == 'yes'){          
          if($('.amount_field').val().length)
          {
            return true;
          }else{
            return false;      
          }
      }else{
          // console.log('true')  
          return true;  
      }        
  });
    

  var val	=	{
    // Specify validation rules
    rules: {
      restaurants_name: {
        required: true,
        minlength: 2
      },
      website_link: {
        //required: true,
        url: true
      },
      restaurants_code: {
        //required: true,
        minlength: 2
      },
      location_link: {
        //required: true,
        url: true
      },
      contact_number: {
        //required: true,
        //number: true,
        // minlength:9,
        // maxlength:15,
        //digits:false
      },
      email: {
        //required: true,
        email: true,
        minlength: 2
      },
      description: {
        required: true,
        minlength: 2
      },
      address: {
        //required: true,
        minlength: 2
      },
      deposit: {
        required: true
      },
      amount: {
        amount_validate: true,
        // number: true,
        // minlength: 0,
        // maxlength:5,
      },
      // time_select: {
      //   required: function(){
      //     if($('#time_select').val() == '--:-- --'){
      //       //console.log($('#time_select').val())
      //         return false;                      
      //     }else{
      //       //console.log($('#time_select').val())
      //         return true;  
      //     }     
      //   }
      // },
      // date_select: {
      //   required: true
      // },
      // table_size: {
      //   required: true
      // },
      // capacity: {
      //   required: true
      // },

      admin_fname:{
        required: true,
        minlength: 2
      }
    },

    errorPlacement: function(error, element) {
        if (element.hasClass('radio')) {
            $('.deposit_radio_wrap label').addClass('radio-error');
        }
        else {
            $('.deposit_radio_wrap label').removeClass('radio-error');
            return true;
        }
    }
  }

  if($('#myForm').length > 0){
    $("#myForm").multiStepForm({
      // defaultStep:0,
      beforeSubmit : function(form, submit){
        // console.log("called before submiting the form");
        // console.log(form);
        // console.log(submit);
      },
      validations:val,
    }).navigateTo(0);
  // multiple from vaidation with step end
  }
  if($('#step_report_form').length > 0){
    $("#step_report_form").multiStepForm({
      // defaultStep:0,
      beforeSubmit : function(form, submit){
        // console.log("called before submiting the form");
        // console.log(form);
        // console.log(submit);
      },
      validations:val,
    }).navigateTo(0);
  // multiple from vaidation with step end
  }

  if($('.date_select, .reviews_date_select').length > 0){
    $( ".date_select, .reviews_date_select" ).datepicker({
        dateFormat: "dd/mm/yy",	
        duration: "fast"
    });
  }  

  if($('.cmnSelect').length > 0){
    $('.cmnSelect').select2();
  }

  // $(document).on('click','.add_value',function(){
  //     var table_array = $(this).parents('.addFilterItem').find(".form-item").val();
  //     if(!(table_array == ''))
  //     {
  //       $(this).parents('.addFilterItem').find(".form-item").removeClass('error');
  //       $(this).parents('.addFilterItem').find('.added_values').append('<div class="data_single"><img src="assets/images/close-icon.svg" alt="close" class="deleteItem"><span>'+table_array+'</span></div>');
  //     }else{
  //       $(this).parents('.addFilterItem').find(".form-item").addClass('error');
  //     }
  // });

  $(document).on('keyup',".addFilterItem input",function() { 
    //  console.log($(this).val());
      if($(this).val()){
        $(this).removeClass('error');
      }
  })

  $(document).on('click','.data_single svg, .data_single .deleteItem',function(){
      $(this).parents('.data_single').remove();
  });

  $(document).on('click','.addFilterLink',function(e){
      e.preventDefault();
      $([document.documentElement,document.body]).animate({scrollTop:$('.add_restro').offset().top - 100},1000);
      $('.add_fillter').addClass('active');
  });

  $(document).on('click','.add_fillter .close_btn',function(e){
      e.preventDefault();
      $(this).parents('.add_fillter').removeClass('active');
  });
  
  // Profile image Upload
  var readURL = function(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('.profilePic').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }

  $(".fileUploadInput").on('change', function(){
      readURL(this);
  });

  $(".uploadButton").on('click', function() {
    $(".fileUploadInput").click();
  });
  // Profile image Upload

  setTimeout(() => {
    $('.innerLoader').fadeOut();
  }, 1000);

  // Images upload Function inti
  ImgUpload();

  var importRestaurant = $('[name="excel_import_rest"]').val().split('\\').pop();


  $('.fileinput-button input[type="file"]').change(function(e) {
      var geekss = e.target.files[0].name;
      $(this).parent().next(".file_uploaded_name").text(geekss);
  });

  $('[data-popup="importRestaurant"]').click(function(){
    $('#excel_import_rest').val('');
    $('.file_uploaded_name').empty();
    $('.progress-bar').removeAttr('style');
  })

  $('.btn.close_btn').click(function(){
    $(this).parents('.popup_wrap').find('input').val('');
  })

});

 
// Images upload Function
function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.file_upload').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      var iterator = 0;
      filesArr.forEach(function (f, index) {

        if (!f.type.match('image.*')) {
          return;
        }

        if (imgArray.length > maxLength) {
          return false
        } else {
          var len = 0;
          for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i] !== undefined) {
              len++;
            }
          }
          if (len > maxLength) {
            return false;
          } else {
            imgArray.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
              var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
              imgWrap.append(html);
              iterator++;
            }
            reader.readAsDataURL(f);
          }
        }
      });
    });
  });

  $('body').on('click', ".upload__img-close", function (e) {
    var file = $(this).parent().data("file");
    for (var i = 0; i < imgArray.length; i++) {
      if (imgArray[i].name === file) {
        imgArray.splice(i, 1);
        break;
      }
    }
    $(this).parent().parent().remove();
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

var all_restaurants_table;
let rest_date = 0;

$(document).on('click','.wrap_reservation_list #nextBtn',function(){
  if(rest_date == 0){
    all_restaurants_table = $("#all_restaurants_table").DataTable({
      responsive: true,
      language: {
        sLengthMenu: "Show Entries: _MENU_",
        searchPlaceholder: "Please search here..."
      },
      dom: '<"#top_filter"lf>rt<"#bottom_page"ip><"clear">',
    });
    rest_date = 1;
  }
});


// $(document).on('click','.wrap_reservation_list #nextBtn',function(){
//   all_restaurants_table = $("#all_restaurants_table").DataTable({
//     responsive: true,
//     language: {
//       sLengthMenu: "Show Entries: _MENU_",
//       searchPlaceholder: "Please search here..."
//     },
//     dom: '<"#top_filter"lf>rt<"#bottom_page"ip><"clear">',
//   });
// });

$(document).ready(function () {
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
        }
        if(_date){
            $('#book_date').val(_date).trigger('change');
        }
        $('#book_time').val(_time).trigger('change');
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
   
    $(document).on('click','[data-target="confirmRestaurant"]', function(e){
        e.preventDefault();
        clear_filter_form_sidebar();
        var cur_date = $(this).attr('data-bookdate');
        var cur_time = $(this).attr('data-booktime');
        var cur_pax = $(this).attr('data-bookpax');
        var cur_restid = $(this).attr('data-bookrestid');
        var cur_deposite = $(this).attr('data-deposite');
        assign_restaurant_to_perticular_date(cur_date,cur_time,cur_pax,cur_restid,cur_deposite);
        $(this).parents('.setupContent.active').find('.availableItem.booked').removeClass('booked');
        $(this).parents('.setupContent.active').find('.booked_time').hide();
        $(this).parents('.setupContent.active').find('.timeing').show();
        $([document.documentElement,document.body]).animate({scrollTop:$('.availableProgress').offset().top - 100},1000);
        if($(this).parents('.setupContent').next().length > 0){   
          if(toConfirm == "toconfirmation"){
              confirm_restaurant_list_form_divshow(true);

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
            $('#reservation_page_search_form').submit();
            if(_pax != ''){
                // $("select#book_persons").val(_pax).trigger('change');
            }
            $('#selected_date_string').html(_datetext);
            $('.availableDayList li:nth-child('+current_tab_number+')').addClass('completed').removeAttr('disabled').removeClass('active skipDay').next('li').removeAttr('disabled').addClass('active');
            //console.log(current_tab_number);
            $('.availableStepListing').show();
            $('.bookedRestaurant').hide()
            innerLoader()
            $(".skipButton").show();
            $('.topTitleRow').show();

        }else{
            confirm_restaurant_list_form_divshow();
            // var current_tab_number = $(this).parents('.setupContent').index() + 1;
            // $(this).parents('.setupContent').removeClass('active skinRestaurant');
            // $(this).parents('.setupContent').next().addClass('active');
            // $('.availableDayList li:nth-child('+current_tab_number+')').addClass('completed').removeAttr('disabled').removeClass('active skipDay').next('li').removeAttr('disabled').addClass('active');
            // $('.availableStepListing').hide();
            // $('.bookedRestaurant').show();
            // innerLoader()
        }
        //$('.availableDayList .availableDay.active').removeClass('active').addClass('completed').next('.availableDay').click().addClass('active').removeAttr('disabled');
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

    function confirm_restaurant_list_form_divshow(){
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
                $('.availableStepListing').hide();
                $('.bookedRestaurant').show();
            }
        });
    }
  
    function clear_filter_form_sidebar(){
      $("#property_type_radio1").prop("checked", true);
      $(".checkboxInput").prop("checked", false);
  }

  $(document).on('click', '.clear_filter_btn', function(e) {
    clear_filter_form_sidebar();
  });

  $(document).on('submit', '#import_excel_restaurant', function(e) {
    e.preventDefault();
    $.ajax({
      xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
              if (evt.lengthComputable) {
                  var percentComplete = ((evt.loaded / evt.total) * 100);
                  $(".progress-bar").width(percentComplete + '%');
                  $(".progress-bar").html(percentComplete+'%');
              }
          }, false);
          return xhr;
      },
      type: 'POST',
      url: site_url+'admin/import_excel_restaurant',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      beforeSend: function(){
          $(".progress-bar").width('0%');
          $('#uploadStatus').html('<img src="images/loading.gif"/>');
      },
      error:function(){
          $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
          $('input[name="submit_upload_excel"]').prop('disbaled',true);
          $('input[name="submit_upload_excel"]').addClass('loading');
      },
      success: function(resp){
        $('.popup').removeClass('show-modal');
        $('input[name="submit_upload_excel"]').prop('disbaled',false);
          $('input[name="submit_upload_excel"]').removeClass('loading');
          Swal.fire('Imported Successfully!', '', 'success')
      }
    });
  });
  $(document).on('submit', '#import_excel_user', function(e) {
    e.preventDefault();
    $.ajax({
      xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
              if (evt.lengthComputable) {
                  var percentComplete = ((evt.loaded / evt.total) * 100);
                  $(".progress-bar").width(percentComplete + '%');
                  $(".progress-bar").html(percentComplete+'%');
              }
          }, false);
          return xhr;
      },
      type: 'POST',
      url: site_url+'admin/import_excel_users',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      beforeSend: function(){
          $(".progress-bar").width('0%');
          $('#uploadStatus').html('<img src="images/loading.gif"/>');
      },
      error:function(){
          $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
          $('input[name="submit_upload_excel"]').prop('disbaled',true);
          $('input[name="submit_upload_excel"]').addClass('loading');
      },
      success: function(resp){
        // console.log(resp);
        $('.popup').removeClass('show-modal');
        $('input[name="submit_upload_excel"]').prop('disbaled',false);
          $('input[name="submit_upload_excel"]').removeClass('loading');
          Swal.fire('Imported Successfully!', '', 'success')
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


  function assign_restaurant_to_perticular_date(book_date,book_time,book_pax,book_rest_id,cur_deposite){
    $('.availableDayList .availableDay').each(function(){
        var _dt = $(this).attr('data-date');
        if(_dt == book_date){
            $(this).removeClass('skipDay');
            $(this).find('input.input_booking_time').val(book_time);
            $(this).find('input.input_booking_pax').val(book_pax);
            $(this).find('input.input_booking_restid').val(book_rest_id);
            $(this).find('input.input_booking_deposite').val(cur_deposite);
        }
    });
  }

  $(document).on('click','[data-target="confirmSkipDay"]', function(e){
    e.preventDefault();
    // console.log('Upload JS');
    // return;
    clear_filter_form_sidebar();
    $(this).parents('.popup').removeClass('show-modal');
    $("body").removeClass('overflow-hidden');
    var skip = $('.reason-to-skip-value').val();
    $('.availableDayList .availableDay.active').find('input.input_booking_time').val('');
    // $('.availableDayList .availableDay.active').find('input.input_booking_pax').val('');
    $('.availableDayList .availableDay.active').find('input.input_booking_pax').val($("#book_persons_inner").val());
    $('.availableDayList .availableDay.active').find('input.input_booking_restid').val('');
    $('.availableDayList .availableDay.active').find('input.input_booking_deposite').val('');
    $('.availableDayList .availableDay.active').find('input.input_booking_reason').val(skip);
    $('.availableDayList .availableDay.active').find('input.input_booking_status').val('skip');

    
    $('.availableDay.active').removeClass('active').addClass('skipDay completed');
    $('.setupContent.active').find('.selectedRestaurant').removeClass('active');

    if($('.setupContent.active').next().length > 0){   
        var current_tab_number = $('.setupContent.active').index() + 1;
        $('.setupContent.active').removeClass('active').addClass('skinRestaurant').next().addClass('active');;
        $('.availableDayList li:nth-child('+current_tab_number+')').addClass('completed').removeAttr('disabled').removeClass('active').next('li').removeAttr('disabled').addClass('active');
        var _date =  $('.setupContent.active').attr('data-date');
        var _datetext =  $('.setupContent.active').attr('data-datetext');
        var _pax =  $('.setupContent.active').attr('data-person');
        var _time = $('.setupContent.active').attr('data-time');
        $("select#book_date").val(_date).trigger('change');
        $('#book_time').val(_time).trigger('change');
        if(_pax != ''){
            $("select#book_persons").val(_pax).trigger('change');
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

});
function innerLoader() {
  $('.innerLoader').fadeIn();
  setTimeout(() => {
      $('.innerLoader').fadeOut();
  }, 100);
}

$(document).keydown(function(event) { 
  if (event.keyCode == 27) { 
    $('.popup').removeClass('show-modal');
    $('.modal').removeClass('modal-active');
  }
});


/**SKIP Booking */
jQuery(document).ready(function(){
  $('.reason_for_skip_booking').select2();
  $('.reason_for_skip_booking').on('change', function() {
      // Get the selected value
      var selectedValue = $(this).val();
      jQuery('.reason-to-skip-value').val('');
      // Log the selected value to the console
      if(selectedValue=='other'){
          jQuery('.user-skip-textare').css('display','block');
      }else{
          jQuery('.user-skip-textare').css('display','none');
          jQuery('.reason-to-skip-value').val(selectedValue);
      }
  });

  $('.user-skip-textare').on('keyup',function(){
      jQuery('.reason-to-skip-value').val($(this).val());
  });

  /**Add skip reason Add mor button */
  jQuery('.admin_add_new_reason').click(function(){
    // console.log('click add more');
    // jQuery(this).before('<input type="text" name="admin_skip_resons[]" id="admin_skip_resons">');
    if(jQuery('#admin_skip_resons_input').val()!=''){
      jQuery('.admin_setting_skip_reasons').append('<li value="'+jQuery('#admin_skip_resons_input').val()+'">'+jQuery('#admin_skip_resons_input').val()+'<span class="remove-item">×</span></li>');
      jQuery('#admin_skip_resons_input').val('');

    }
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

  $(".cmnSelect.multi-step-slect-rest-names").select2({
    placeholder: "By default all restaurant will be selected",
    allowClear: true
  });

  jQuery('.save_reportfilter_fileds').click(function(e){
    //e.preventDefault();
    var filterForm = $('#complete_booking');
    $.ajax({
      url:  site_url+'admin/save_report_filter_fields',
      type: 'post',
      data: filterForm.serialize(),
      dataType: 'json',
      beforeSend: function(res) {
          $('.innerLoader').show();
          $('.save_reportfilter_fileds').prop('disabled',true);
          $('.save_reportfilter_fileds').addClass('loading');
      },
      success: function(result) {
        //console.log(result);
          $('.innerLoader').hide();
          $('.save_reportfilter_fileds').prop('disabled',false);
          $('.save_reportfilter_fileds').removeClass('loading');
          // window.location.reload();
      }
    });

  });

  jQuery('.predefined_report_filter_values').click(function(){
    jQuery('#predefine_filter_form').trigger('submit');
  });


});

$(document).ready(function() {
  $('#book_persons').select2({
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
});


