<?php $dates = $this->admin_model->get_dates_list_booking();?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <?php echo $message = $this->session->flashdata('message');?>
            <h2 class="heading_title">User list</h2>
            <?php $success_message = $this->session->flashdata('success');
            if ($success_message) {
                echo '<div class="alert alert-success">' . $success_message . '</div>';
            }
            ?>

            <div class="wrap_table withLeftButtons action_class">
                <div class="leftButtonsRow btn_wrapper" id="user_lists">
                    <a href="#" class="btn btn_add" id="add_user_btn" data-href="<?php echo site_url('admin/insert_user');?>" data-popup="addUser">Add User</a>
                    <a href="<?php echo site_url('admin/export_users');?>" class="btn btn_add" download=""><img
                            src="<?php echo base_url(); ?>/uploads/assets/images/download_sheet.svg" alt=""> Download sheet</a>
                    <a href="#" class="btn btn_add" data-popup="importUser"><img src="<?php echo base_url(); ?>/uploads/assets/images/file_import.svg"
                            alt=""> Import sheet</a>
                    <button type="button" id="delete_bulkusers" class="delete_value btn btn_add">Delete Bulk</button>
                    <button type="button" id="reset_bulkusers_passwords" class="reset_bulk_passwords btn btn_add">Send Temp P/W To All</button>
                </div>
                <div class="defaultDataTable">
                    <table class="table_class" id="all_user_list" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="multi-user-select">
                                    <div class="custom-checkbox multi-user-select-wraper">
                                        <input class="form-input checkboxInput select-all-users-psw-reset" type="checkbox" value="markAllUsers" id="markAllUsers" name="markAllUsers">
                                        <label class="checkboxLabel" for="markAllUsers">Select All</label>
                                    </div>
                                </th>
                                <th>User Code</th>
                                <th>User name</th>
                                <th>User email</th>
                                <th>Alternate email</th>
                                <th>User contact</th>
                                <!-- <th>Password</th> -->
                                <th>Temporary Password</th>
                                <th>Booking Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($list)){
                            foreach($list as $data){
                                $explode = explode(' ',$data['full_name']);
                                if(!empty($explode)){
                                    $first_name = $explode[0];
                                    $last_name = $explode[1];
                                   
                                }
                                $booking_status = '<span class="text-danger">Non Responders</span>';
                                $bookdata = $this->admin_model->get_booking_detail_byuserid($data['id']);
                                if(!empty($bookdata)){
                                    $booking_id = $bookdata['id'];
                                    if(!empty($dates)){
                                        $booked = 1;
                                        foreach($dates as $date){
                                            $status = $this->admin_model->get_status_of_booking_date_byid($booking_id,$date['date']);
                                            if($status != 'Booked'){
                                                $booked = 0;
                                            }
                                        }
                                        if($booked == 0){
                                            $booking_status = '<a href="'.site_url('admin/view_booking_detail/'.$booking_id).'" target="_blank">Partial</a>';
                                        }
                                        if($booked == 1){
                                            $booking_status = '<a href="'.site_url('admin/view_booking_detail/'.$booking_id).'" target="_blank">Completed</a>';
                                        }
                                    }
                                }
                                else{
                                    $booking_status = '<span class="text-danger">Non Responders</span>';
                                }

                                $status = $this->admin_model->get_booking_status_byuserid($data['id']);
                                if($status != ''){
                                    $booking_status = '<a href="'.site_url('admin/view_booking_detail/'.$booking_id).'" target="_blank">'.$status.'</a>';
                                }
                                else{
                                    $booking_status = '<span class="text-danger">Non Responders</span>';
                                }
                            ?>
                        <tr>
                            <td></td>
                            <td>
                                <div class="custom-checkbox">
                                    <input type="checkbox" class="form-input checkboxInput" name="multi_userid[]" id="check<?php echo $data['id'];?>" value="<?php echo $data['id'];?>">
                                    <label class="checkboxLabel" for="check<?php echo $data['id'];?>"></label>
                                </div>
                            </td>
                            <td><?php echo $data['user_code'];?></td>
                            <td><?php echo $data['full_name'];?> </td>
                            <td><?php echo $data['email'];?></td>
                            <td><?php echo $data['alternate_email'];?></td>
                            <td><?php echo $data['mobile_number'];?></td>
                            <!-- <td><?php //echo $data['password'];?></td> -->
                            <!-- <td>
                                <?php 
                                // if($data['temp_password_status'] == 0){
                                //     echo $data['password'];
                                // }
                                ?>
                            </td> -->
                            <td>
                                <?php //echo $data['temp_password'];?>
                                <?php 
                                if($data['temp_password_status'] == 0){
                                    echo $data['password'];
                                }elseif($data['temp_password_status'] == 1){
                                    ?>
                                        Password has been reset
                                    <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $booking_status;?></td>
                            <td>
                                <a href="javascript:void(0)" class="drop_dots">
                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/three_dots.svg" alt="">
                                </a>
                                <ul class="action_drop">
                                    <li>
                                        <a href="javascript:void(0);" class="edit_user_btn" data-popup="addUser" data-user_code="<?php echo $data['user_code'];?>" data-firstname="<?php echo $first_name;?>" data-lastname="<?php echo $last_name;?>" data-email="<?php echo $data['email'];?>" data-altemail="<?php echo $data['alternate_email'];?>" data-phone="<?php echo $data['mobile_number'];?>" data-href="<?php echo site_url('admin/update_user/'.$data['id']);?>">
                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/edit.svg" alt="">
                                            Edit
                                        </a>
                                    </li>
                                    <?php $cnt = $this->admin_model->get_booking_detail_byuserid($data['id']);
                                    if(empty($cnt)){
                                    ?>
                                    <li>
                                        <a href="<?php echo site_url('add_booking_user/?email='.$data['email']);?>" target="_blank" class="edit_user_btn1">
                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/edit.svg" alt="">
                                            Add Booking
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li>
                                        <a href="javascript:void(0);" data-userid="<?php echo $data['id'];?>" class="deleteRow deleteuseradmin">
                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/trash.svg" alt="">
                                            Delete
                                        </a>
                                    </li>
                                    <?php if($status != ''):?>
                                    <li>
                                        <a href="<?php echo site_url('/admin/resend_booking_email_user/?user_id='.$data['id']);?>" class="edit_user_btn1">
                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/email_icon.svg" alt="">
                                            Re-Send Confirmation
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php
                                    // if($data['temp_password_status'] == 1){
                                        ?>
                                        <li>
                                            <a href="javascript:void(0);" data-userid="<?php echo $data['id'];?>" data-useremail="<?php echo $data['email'];?>" class="reset_user_password">
                                                <img src="<?php echo base_url(); ?>/uploads/assets/images/setting_active.svg" alt="">
                                                Send Temporary Password
                                            </a>
                                        </li>
                                        <?php
                                    // }
                                    ?>
                                    <li>
                                        <?php 
                                            $cardDetails = $this->admin_model->get_credit_card_details($data['id']);
                                            // echo('<pre>');
                                            // print_r($cardDetails);
                                            // echo('</pre>');
                                            if($cardDetails){
                                                ?>
                                                <a href="javascript:void(0);" class="edit_card_btn" data-user_id="<?php echo $data['id']; ?>" data-popup="editCard" data-card_number="<?php echo $cardDetails['card_number'];?>" data-expiry_month="<?php echo $cardDetails['expiry_month'];?>" data-expiry_year="<?php echo $cardDetails['expiry_year'];?>" data-cvv="<?php echo $cardDetails['cvv'];?>" data-card_holder="<?php echo  $cardDetails['card_holder'];?>" data-href="<?php echo site_url('admin/update_user_credit_card_details/'.$data['id']);?>">
                                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/edit.svg" alt="">
                                                    Edit Card Details
                                                </a>
                                                <?php
                                            }else{
                                                ?>
                                                <a href="javascript:void(0);" class="edit_card_btn" data-href="<?php echo site_url('admin/update_user/'.$data['id']);?>">
                                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/edit.svg" alt="">
                                                    Card Details Not Available
                                                </a>
                                                <?php
                                            }
                                        ?>


                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="loader" id="loadingDiv" style="display:none;opacity:0.5">
        <div class="loader_wrapper">
            <div class="left_side">
                <img src="<?php echo base_url(); ?>uploads/front/images/logo-white-icon.png" alt="logo">
            </div>
        </div>
    </div>
<script>
    var userList = $("#all_user_list").DataTable({
    language: {
        sLengthMenu: "Show Entries: _MENU_",
        searchPlaceholder: "Please search here..."
    },
    stateSave: true,
    "pageLength": 25,
    'columnDefs': [ {
      'targets': [4,1], // column index (start from 0)
      'orderable': false, // set orderable false for selected columns
   }],
    dom: '<"#top_filter"lf>rt<"#bottom_page"ip><"clear">',
    "responsive": false,
    "order": [[5, "asc"]]
  });
  // Set default sorting order after DataTable initialization
userList.order([[5, "asc"]]).draw();
    $(document).on('click', '#delete_bulkusers', function(e) {
        var checked = 0;
        var checkbox = [];
        $('.checkboxInput').each(function(){
            if ($(this).prop('checked')) {
                checkbox.push($(this).val());
                checked++;
            }
        })
        if(checked == 0){
            Swal.fire('Checkbox select first!', '', 'danger');
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
                $.ajax({
                        url: '<?php echo base_url();?>index.php/admin/delete_bulk_users',
                        type: "post",
                        data: {checkbox:checkbox},
                        success: function(data) {
                            $('.checkboxInput').each(function(){
                                if ($(this).prop('checked')) {
                                    var _parent = $(this).parents('tr');
                                    userList.row(_parent).remove();
                                    $(_parent).remove();
                                }
                            });
                            
                            Swal.fire('Deleted!', '', 'success')
                        }
                    });
            } else if (result.isDenied) {
                // Swal.fire('Changes are not saved', '', 'info')
            }
        })
    });
    $(document).on('click', '.deleteuseradmin', function(e) {
        var user_id = $(this).attr('data-userid');
        var _parent = $(this).parents('tr');
        Swal.fire({
            title: 'Do you want to delete this user?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                        url: '<?php echo base_url();?>index.php/admin/delete_user_admin',
                        type: "post",
                        data: {user_id:user_id},
                        success: function(data) {
                            userList.row(_parent).remove();
                            $(_parent).remove();
                            Swal.fire('Deleted!', '', 'success')
                        }
                    });
            } else if (result.isDenied) {
                // Swal.fire('Changes are not saved', '', 'info')
            }
        })
    });

    /**Reset User Password */
    $(document).on('click', '.reset_user_password', function(e) {
        var user_id = $(this).attr('data-userid');
        var user_email = $(this).attr('data-useremail');
        var _parent = $(this).parents('tr');
        Swal.fire({
            title: 'Do you want to reset this user\'s password?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
            }).then((result) => {
            if (result.isConfirmed) {
                console.log('SWL YES');
                $.ajax({
                        url: '<?php echo base_url();?>index.php/admin/reset_user_password',
                        type: "post",
                        dataType: "json",
                        data: {user_id:user_id,user_email:user_email},
                        beforeSend: function(){
                            $('#loadingDiv').toggle();
                        },
                        success: function(data) {
                            console.log(data,'reset');
                            console.log(data.message,'ppp pp reset');
                            $('#loadingDiv').toggle();
                            if(data.response == 'success'){
                                console.log('in success');
                                Swal.fire(data.message, '', 'success').then(function(){location.reload();});
                                
                            }else if(data.response == 'failure'){
                                console.log('in failure');
                                $('#loadingDiv').toggle();
                                Swal.fire(data.message, '', 'error');
                                
                            }
                        }
                    });
            } else if (result.isDenied) {
                console.log('SWL NO');
                // Swal.fire('Changes are not saved', '', 'info')
            }
        })
    });

    /**Bulk Password reset */
    jQuery(document).ready(function(){
        /**Select and Unselct all users */
        jQuery('.select-all-users-psw-reset').change(function(){
            if(this.checked){
                // .custom-checkbox.multi-user-select-wraper
                //console.log('Checked');
                // jQuery( 'div.custom-checkbox' ).not( ".select-all-users-psw-reset " );
                jQuery('#reset_bulkusers_passwords').show();
                userList.$('input[name="multi_userid[]"]').prop('checked', true);
            }else{
                //console.log('UnChecked');
                jQuery('#reset_bulkusers_passwords').hide();
                userList.$('input[name="multi_userid[]"]').prop('checked', false);

            }
        });

        /**Trigger Bulk Password Reset */
        $(document).on('click', '#reset_bulkusers_passwords', function(e) {
        var checked = 0;
        var checkbox = [];
        $('.checkboxInput').each(function(){
            if ($(this).prop('checked')) {
                checkbox.push($(this).val());
                checked++;
            }
        })
        if(checked == 0){
            Swal.fire('Checkbox select first!', '', 'danger');
            return false;
        }
        Swal.fire({
            title: 'Do you want to reset bulk user password?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                        url: '<?php echo base_url();?>index.php/admin/reset_bulk_users_passwords',
                        type: "post",
                        dataType: "json",
                        data: {checkbox:checkbox},
                        beforeSend: function(){
                            $('#loadingDiv').toggle();
                        },
                        success: function(data) {
                            $('#loadingDiv').toggle();
                            if(data.response == 'success'){
                                //console.log('in success');
                                //Swal.fire(data.message, '', 'success').then(function(){location.reload();});
                                Swal.fire('Bulk password reset successful!', '', 'success');
                                userList.$('input[name="multi_userid[]"]').prop('checked', false);
                                jQuery('#reset_bulkusers_passwords').hide();
                                
                            }else if(data.response == 'failure'){
                                //console.log('in failure');
                                $('#loadingDiv').toggle();
                                Swal.fire(data.message, '', 'error');
                                
                            }

                            
                            // Swal.fire('Bulk password reset successful!', '', 'success')
                        }
                    });
            } else if (result.isDenied) {
                // Swal.fire('Changes are not saved', '', 'info')
            }
        })
    });
    /**Trigger Bulk Password Reset END*/






    });
    /**Bulk Password reset END*/

</script>