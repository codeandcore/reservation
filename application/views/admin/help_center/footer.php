</div>
<footer>
    <?php if(array_key_exists('copyright_text',$this->settings) && $this->settings['copyright_text'] != ''){ ?>
    <p><?php echo $this->settings['copyright_text'];?></p>
    <?php } ?>
</footer>

<div class="popup" id="add_user_popup_modal" data-id="addUser">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/assets/images/addUser.svg" alt="addUser">
                <figcaption>Add NEW user</figcaption>
            </figure>
        </div>
        <form action="<?php echo site_url('admin/insert_user');?>" method="post">
            <div class="popup_body">
                <div class="form-group row">
                    <div class="col-6"><input type="text" name="admin_fname" id="edit_fname"
                            placeholder="User first name*" id="user_fname" maxlength="20" required /></div>
                    <div class="col-6"><input type="text" name="admin_lname" id="edit_lname"
                            placeholder="User last name*" id="user_lname" maxlength="20" required /></div>
                </div>
                <div class="form-group row">
                    <div class="col-6"><input type="text" name="user_code" id="user_code" placeholder="User Code"
                            >
                    </div>
                    <div class="col-6"><input type="email" name="admin_email" id="edit_email" placeholder="email *"
                            id="user_email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12"><input type="number" maxlength="10" name="contact_number" id="edit_phone"
                            placeholder="contact number" id="contact_number" ></div>
                </div>
                <div class="form-group row">
                    <div class="col-12"><input type="email" name="admin_alternate_email" id="edit_alternate_email"
                            placeholder="Alternate email">
                    </div>
                </div>
            </div>
            <div class="popup_footer btn_wrap">
                <a href="javascript:;" class="btn btn-dark close_btn">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Add">
            </div>
        </form>


    </div>
</div>


<div class="popup" id="edit_card_popup_modal" data-id="editCard">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/assets/images/addUser.svg" alt="addUser">
                <figcaption>Edit card details</figcaption>
            </figure>
        </div>
        <form id="edituserCreditCardDetails_admin" action="<?php echo site_url('admin/insert_user');?>" method="post">
            <div class="popup_body">
                <div class="form-group row">
                    <div class="col-12">
                        <p>Existing card number: <span class="editCardnumberLabel"></span></p>
                        <input type="hidden" name="user_id" id="user_id">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="edit_card_number">New Card number</label>
                        <input type="number" minlength="16" maxlength="16" name="card_number" id="edit_card_number"
                            placeholder="" id="card_number" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="edit_card_holder_name">Card holder name</label>
                        <input type="text" name="card_holder_name" id="card_holder_name"
                            placeholder="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <label for="edit_card_ex_month">Card expiry month</label>
                        <input type="number" maxlength="2" name="card_ex_month" id="card_ex_month"
                            placeholder="" required>
                    </div>
                    <div class="col-4">
                        <label for="edit_card_ex_year">Card expiry year</label>
                        <input type="number" maxlength="2" name="card_ex_year" id="card_ex_year"
                            placeholder="" required>
                    </div>
                    <div class="col-4">
                        <label for="edit_card_cvv">Card CVV</label>
                        <input type="password" minlength="3" minlength="3" name="card_cvv" id="card_cvv"
                            placeholder="" required>
                    </div>
                </div>
            </div>
            <div class="popup_footer btn_wrap">
                <a href="javascript:;" class="btn btn-dark close_btn">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>


    </div>
</div>

<div class="popup" data-id="importUser">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <figcaption>Import User</figcaption>
            </figure>
        </div>
        <form action="<?php echo site_url('admin/import_excel_users');?>" id="import_excel_user"  method="post" enctype="multipart/form-data">
            <div class="popup_body">
                <div class="file_upload_wrapper fileinput-button">
                    <img src="<?php echo base_url(); ?>uploads/assets/images/g2158.svg" alt="">
                    <h6>Drag & drop .xlsx file here</h6>
                    <span>or <strong>browse file</strong> from device</span>
                    <input type="file" name="import_users" required class="files_in upload__inputfile">
                </div>
                <h5 class="file_uploaded_name"></h5>
                <div class="progress">
                    <div class="progress-bar"></div>
                </div>
            </div>
            <div class="popup_footer">
                <div class="text-center"><input type="submit" class="btn" value="Import"></div>
            </div>
        </form>
    </div>
</div>

<!-- model -->
<div class="popup" data-id="addAdmin">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/assets/images/addAdmin.svg" alt="addAdmin">
                <figcaption>Add NEW admin</figcaption>
            </figure>
        </div>
        <form action="<?php echo site_url('admin/insert_admin');?>" method="post" id="add_admin_form">
            <div class="popup_body">
                <div class="form-group row">
                    <div class="col-6"><input type="text" name="admin_fname" placeholder="admin first name*"
                            id="admin_fname" maxlength="20" required></div>
                    <div class="col-6"><input type="text" name="admin_lname" placeholder="admin last name*"
                            id="admin_lname" maxlength="20" required></div>
                </div>
                <div class="form-group row">
                    <div class="col-12"><input type="email" name="admin_email" placeholder="email *" id="admin_email"
                            required>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <div class="col-12"><input type="number" name="contact_number" placeholder="contact number*"
                            id="contact_number" required></div>
                </div> -->
            </div>
            <div class="popup_footer btn_wrap">
                <a href="javascript:;" class="btn btn-dark close_btn">Cancel</a>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>

    </div>
</div>
<!-- model -->
<div class="popup" data-id="resetpasswordAdmin">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/assets/images/addAdmin.svg" alt="addAdmin">
                <figcaption>Reset Password</figcaption>
            </figure>
        </div>
        <form action="<?php echo site_url('admin/reset_password_admin');?>" method="post" id="add_admin_form">
            <div class="popup_body">
                <div class="form-group row">
                    <div class="col-6"><input type="password" name="password" placeholder="Password*"
                            id="edit_admin_fname" required></div>
                    <div class="col-6"><input type="password" name="reset_password" placeholder="Reset Password*"
                            id="edit_admin_lname" required></div>
                </div>
                
            </div>
            <div class="popup_footer btn_wrap">
                <a href="javascript:;" class="btn btn-dark">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>

    </div>
</div>
<!-- model -->
<div class="popup" data-id="editAdmin">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/assets/images/addAdmin.svg" alt="addAdmin">
                <figcaption>Update admin</figcaption>
            </figure>
        </div>
        <form action="<?php echo site_url('admin/update_admin');?>" method="post" id="add_admin_form">
            <div class="popup_body">
                <div class="form-group row">
                    <div class="col-6"><input type="text" name="admin_fname" placeholder="admin first name*"
                            id="edit_admin_fname" required></div>
                    <div class="col-6"><input type="text" name="admin_lname" placeholder="admin last name*"
                            id="edit_admin_lname" required></div>
                </div>
                <div class="form-group row">
                    <div class="col-12"><input type="email" name="admin_email" placeholder="email *"
                            id="edit_admin_email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12"><input type="number" name="contact_number" placeholder="contact number*"
                            id="edit_contact_number" required></div>
                </div>
            </div>
            <div class="popup_footer btn_wrap">
                <a href="javascript:;" class="btn btn-dark">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>

    </div>
</div>

<div class="popup" data-id="importRestaurant">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <figcaption>Import Restaurant</figcaption>
            </figure>
        </div>
        <form action="<?php echo site_url('admin/import_excel_restaurant');?>" method="post" id="import_excel_restaurant" enctype="multipart/form-data">
            <div class="popup_body">
                <div class="file_upload_wrapper fileinput-button">
                    <img src="<?php echo base_url(); ?>uploads/assets/images/g2158.svg" alt="">
                    <div class="drogContent">
                        <h6>Drag & drop .xlsx file here</h6>
                        <span>or <strong>browse file</strong> from device</span>
                    </div>
                    <input type="file" name="excel_import_rest" id="excel_import_rest" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="files_in upload__inputfile" required />
                </div>
                <h5 class="file_uploaded_name"></h5>
                <div class="progress">
                    <div class="progress-bar"></div>
                </div>
            </div>
            <div class="popup_footer">
                <input type="submit" class="btn btn-primary" name="submit_upload_excel" value="Import">
            </div>
        </form>
    </div>
</div>

<div class="popup" data-id="reservationCancel">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/assets/images/cancellation.svg" alt="">
                <figcaption>Are you sure you want to cancel this reservation?</figcaption>
            </figure>
        </div>
        <form action="" id="cancel_reservation_form">
            <div class="popup_body">
                <textarea class="form-control" name="cancellation" placeholder="Add reason for cancellation"
                    required></textarea>
                <input type="hidden" name="cancel_booking_listid" id="cancel_booking_listid">
            </div>
            <div class="popup_footer btn_wrap">
                <a href="javascript:;" class="btn btn-dark close_btn">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Confirm">
            </div>
        </form>
    </div>
</div>

<div class="modal" id="inviteModal">
    <div class="modal-backdrop"></div>
    <div class="modal-wrapper modal-transition">
        <button class="modal-close" data-target="modalClose">
            <img src="<?php echo base_url(); ?>uploads/front/images/cross-icon.svg" alt="Close Icon">
        </button>
        <div class="modal-body cmn-scroll">
            <h4>Invite your colleagues to join you!</h4>
            <p>Enter their email to send an invitation:</p>
            <form action="#" class="form-inline" id="share_invite_form">
                <input type="email" class="form-control" name="email" placeholder="Enter e-mail" required>
                <input type="hidden" name="share_booking_listid" id="share_booking_listid">                
                <button type="submit" class="btn">Send</button>
            </form>
            <p class="error error-text" id="share_invite_error"></p>
            <p class="success-text" id="share_invite_success"></p>
        </div>
    </div>
</div>

<!-- <div class="modal" id="reason_skip_popup">
    <div class="modal-backdrop"></div>
    <div class="modal-wrapper modal-transition">
        <button class="modal-close" data-target="modalClose">
            <img src="<?php echo base_url(); ?>uploads/front/images/cross-icon.svg" alt="Close Icon">
        </button>
        <div class="modal-body cmn-scroll">
            <h4>Reason For Skip Day!</h4>
            <textarea class="form-control" name="reason_skip" id="reason_text_input" placeholder="Reason For Skip Day"
                readonly></textarea>
        </div>
    </div>
</div> -->

<div class="popup" id="skipDay">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none" stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none" stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </g>
                </svg>                  
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/assets/images/skipDay.svg" alt="skipDay">
                <figcaption>Reason for skip day</figcaption>
            </figure>
        </div>
        <div class="popup_body">
            <div class="content">
                <textarea class="form-control" name="reason_skip" id="reason_text_input" placeholder="Reason For Skip Day"
            readonly></textarea>
            </div>
        </div>
    </div>
</div>

<div class="popup" data-id="cancel_reason_popup">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/assets/images/cancellation.svg" alt="">
                <figcaption>Cancellation Reason</figcaption>
            </figure>
        </div>
        <div class="popup_body">
            <textarea class="form-control" name="cancel_reason" id="cancel_text_input" placeholder="Cancellation Reason"
                readonly></textarea>
        </div>
    </div>
</div>

<div class="popup" data-id="view_booked_slot">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/assets/images/success-icon.svg" alt="">
                <figcaption>Table occupied by:</figcaption>
            </figure>
            <div class="popup_body">
                <div id="table_booked_list_For_slot"></div>
            </div>
        </div>
    </div>
</div>

<div class="popup" data-id="adminNote">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>/uploads/assets/images/success-icon.svg" alt="">
                <figcaption>Are you sure you want to add Admin Note?</figcaption>
            </figure>
        </div>
        <form action="" id="add_admin_note">
            <div class="popup_body">
                <textarea class="form-control" name="admin_note" placeholder="Add Admin Note"
                    required></textarea>
                <input type="hidden" name="adminNote_booking_listid" id="adminNote_booking_listid">
            </div>
            <div class="popup_footer btn_wrap">
                <a href="javascript:;" class="btn btn-dark close_btn">Cancel</a>
                <button type="submit" class="btn btn-primary" value="Confirm">Confirm</button>
            </div>
        </form>
    </div>
</div>

<div class="popup" data-id="selectedReservation">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/assets/images/success-icon.svg" alt="">
                <figcaption>Your selected reservation</figcaption>
            </figure>
        </div>
        <div id="modify_reservation_popup_admin_ajax">
            <div class="popup_body">
                <div class="selectedRestroInfo">
                    <div class="selectedRestroContent">
                        <div class="selectedImg">
                            <img src="<?php echo base_url(); ?>uploads/assets/images/res1.jpg" alt="">
                        </div>
                        <div class="selectedContent">
                            <h6>1609 Bar & Restaurant</h6>
                            <div class="innerselectedContent">
                            <p>This is what vacation dining is all about. A delicious meal enjoyed in the open air as
                                the soft tropical breeze wafts by and colourful </p>
                            </div>
                            <div class="eatingType">
                                <ul class="list-unstyled">
                                    <li>International</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="selectedMenu">
                        <ul class="list-unstyled">
                            <li>
                                <img src="<?php echo base_url(); ?>uploads/assets/images/date.svg" alt="">
                                <span>Thursday, Nov 15 2023</span>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>uploads/assets/images/table.svg" alt="">
                                <span>Table for 8 People</span>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>uploads/assets/images/time.svg" alt="">
                                <span>06:00 pm</span>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>uploads/assets/images/property_status.svg" alt="">
                                <span>On - Property Restaurant </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="popup_footer btn_wrap">
                <input type="submit" class="btn btn-primary" value="Confirm modification">
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg" id="viewDetails">
    <div class="modal-backdrop"></div>
    <div class="modal-wrapper modal-transition">
        <div class="modal-header">
            <h4>RESTAURANT DETAILS</h4>
            <button class="modal-close" data-target="modalClose">
                <img src="<?php echo base_url(); ?>uploads/front/images/cross-icon.svg" alt="Close Icon">
            </button>
        </div>
        <div class="modal-body" id="ajax_restro_detail">

        </div>
    </div>
</div>

<div class="popup" data-id="skipDay">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/front/images/circle-check.svg" alt="">
                <figcaption>Reason for skip day</figcaption>
            </figure>
        </div>
        <div class="popup_body cmn-scroll text-center">
            <textarea name="reason_skip_input" class="form-control" id="reason_skip_input" rows="7" placeholder="Please Explain" required></textarea>
            <div class="popup_footer btn_wrap">
                <a href="javascript:;" class="btn btn-dark close_btn">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Confirm" data-target="confirmSkipDay">
            </div>
        </div>
    </div>
</div>
<div class="popup" data-id="send_creditcard_popup">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <form id="verify_otp_and_sned_mail_form">
            <div class="popup_header">
                <a href="javascript:;" class="close_btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                        <g id="cross" transform="translate(0.951 1.414)">
                            <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                                stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                                stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </g>
                    </svg>
                </a>
                <figure>
                    <img src="<?php echo base_url(); ?>uploads/front/images/circle-check.svg" alt="">
                    <figcaption>Send Credit Card Information</figcaption>
                    <p>We have sent an OTP on below mwntioned email address</p>
                    <?php 
                        // Split the email into local part and domain part
                        //list($localPart, $domainPart) = explode('@', $settingsData['admin_email']);
                        list($localPart, $domainPart) = explode('@',$settingsData['admin_email']);

                        // Get the first four characters of the local part
                        $visiblePart = substr($localPart, 0, 4);
                    
                        // Calculate the number of asterisks needed
                        $numAsterisks = max(0, strlen($localPart) - 4);
                    
                        // Replace the remaining characters of the local part with asterisks
                        $maskedPart = str_repeat('*', $numAsterisks);
                    
                        // Combine the visible part and the masked part with the domain part
                        $encryptedAdminEmail = $visiblePart . $maskedPart . '@' . $domainPart;
                    ?>
                    <?php echo($encryptedAdminEmail); ?>
                </figure>
            </div>
            <div class="popup_body cmn-scroll text-center">
                <!-- <input type="email" name="admin_email" id="credit_admin_email" class="form-control" placeholder="Enter Email Address"> -->
                <input type="text" name="verify_scci_otp" class="verify_scci_otp" placeholder="Enter OTP">
                <div class="popup_footer btn_wrap">
                    <a href="javascript:;" class="btn btn-dark close_btn">Cancel</a>
                    <!-- <button type="button" class="btn btn-primary" id="update_creditcard_btn">Update</button> -->
                    <button type="submit" class="btn btn-primary" id="verify_creditcardinfo_btn">Verify OTP & Download</button>
                </div>
            </div>
        </form>

    </div>
</div>
<div class="popup" data-id="deleteInvite">
    <div class="popup_overlay"></div>
    <div class="popup_wrap text-center">
        <div class="popup_header">
            <a href="javascript:;" class="close_btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.828" height="24.828" viewBox="0 0 24.828 24.828">
                    <g id="cross" transform="translate(0.951 1.414)">
                        <line id="Line_1" data-name="Line 1" x2="22" y2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line id="Line_2" data-name="Line 2" y1="22" x2="22" transform="translate(0.463)" fill="none"
                            stroke="#00434e" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
            </a>
            <figure>
                <img src="<?php echo base_url(); ?>uploads/front/images/delete-user.svg" alt="">
                <figcaption>Are you sure you want to remove <span id="guestname_span"></span> from your guest list?</figcaption>
            </figure>
        </div>
        <div class="popup_footer btn_wrap">
            <a href="javascript:void(0);" class="btn btn-dark close_btn" data-target="modalClose">Cancel</a>
            <a href="javascript:void(0);" class="btn confirmdeleteInvite" data-target="confirmdeleteInvite">Confirm</a>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>uploads/assets/js/multi-form.js"></script>
<script src="<?php echo base_url(); ?>uploads/assets/js/script.js"></script>
</body>
<script>
$("#add_admin_form").validate();
</script>
<!--CKEditor-->
<script src="<?php echo base_url('application/assets/ckeditor/ckeditor.js'); ?>"></script>
<script src="<?php echo base_url('application/assets/ckfinder/ckfinder.js'); ?>"></script>

<script>
    CKEDITOR.replace('content', {
        extraPlugins: 'clipboard,uploadimage,image',
        filebrowserBrowseUrl: '<?php echo base_url('application/assets/ckfinder/ckfinder.html'); ?>',
        filebrowserUploadUrl: '<?php echo base_url('application/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'); ?>',
        filebrowserImageUploadUrl: '<?php echo base_url('application/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'); ?>'
    });
    CKFinder.setupCKEditor();
</script>
<!--CKEditor END-->
</html>