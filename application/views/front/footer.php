<footer>
    <div class="footerInner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <a href="#" class="footer-logo"><img
                                src="<?php echo base_url(); ?>uploads/front/images/white-logo.svg" alt=""></a>
                    </div>
                    <div class="footer-menu">
                        <ul class="list-unstyled">
                            <li><a href="<?php echo $this->settings['contactus_link'];?>">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(array_key_exists('copyright_text',$this->settings) && $this->settings['copyright_text'] != ''){ ?>
    <div class="copyRight"><?php echo $this->settings['copyright_text'];?></div>
    <?php } ?>
</footer>
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

<div class="modal" id="skipDay">
    <div class="modal-backdrop"></div>
    <div class="modal-wrapper modal-transition">
        <button class="modal-close" data-target="modalClose">
            <img src="<?php echo base_url(); ?>uploads/front/images/cross-icon.svg" alt="Close Icon">
        </button>
        <div class="modal-body cmn-scroll text-center">
            <div class="popupIcon">
                <img src="<?php echo base_url(); ?>uploads/front/images/circle-check.svg" alt="">
            </div>
            <h4>Reason for skipping </h4>
            <div class="selectInput skip-reasons-container">
                <p class="skipreason_error" style="display:none">Error Message</p>
                <select name="reason_for_skip" class="form-control  reason_for_skip_booking">
                    <option value="">Select reason</option>
                    <?php
                        $reasonsUnserialize = unserialize($this->settings['admin_skip_resons']);
                        if($reasonsUnserialize){
                            foreach($reasonsUnserialize as $reason){
                                ?>
                                <option value="<?php echo $reason; ?>"><?php echo $reason; ?></option>
                            <?php
                            }
                        }
                    ?>
                    <option value="other">Other</option>
                </select>
            </div>
            <input type="hidden" class="reason-to-skip-value" name="reason_skip_input">
            <textarea class="form-control user-skip-textare" id="reason_skip_input" rows="7"
                placeholder="Please Explain" required></textarea>
            <div class="modalButtonRow">
                <a href="#" class="btn btn-black" data-target="modalClose">Cancel</a>
                <input type="submit" class="btn" value="Confirm" data-target="confirmSkipDay">
            </div>
        </div>
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
            <p>Enter their Pfizer email to send an invitation:</p>
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

<div class="modal" id="reservationCancel">
    <div class="modal-backdrop"></div>
    <div class="modal-wrapper modal-transition">
        <button class="modal-close" data-target="modalClose">
            <img src="<?php echo base_url(); ?>uploads/front/images/cross-icon.svg" alt="Close Icon">
        </button>
        <div class="modal-body cmn-scroll text-center">
            <div class="popupIcon">
                <img src="<?php echo base_url(); ?>uploads/front/images/cancel-title-icon.svg" alt="">
            </div>
            <h4>Are you sure you want to cancel this reservation?</h4>
            <div class="cancelRestoDetails">
                <div class="feature_img">
                    <img src="<?php echo base_url(); ?>uploads/assets/images/5dfb49592a82850edae8d4862ff4ddfc.jpg" alt="">
                </div>
                <div class="rest_desc">
                    <h6>DUO Steak and Seafood</h6>
                    <ul class="list-unstyled">
                        <li><i><img src="<?php echo base_url(); ?>uploads/front/images/calendar_check_icon.svg" alt=""></i><span class="cancelindate">05-21-2023</span></li>
                        <li><i><img src="<?php echo base_url(); ?>uploads/front/images/table-icon.svg" alt=""></i>
                        <span class="cancelinpax">2</span>&nbsp;
                        </li>
                        <li><i><img src="<?php echo base_url(); ?>uploads/front/images/clock_time_icon.svg" alt=""></i>
                        <span class="cancelintime">6:00pm</span></li>
                        <li><i><img src="<?php echo base_url(); ?>uploads/front/images/city_building_icon.svg" alt=""></i>
                        <span class="cancelinhtltype">Off - Property Restaurant</span> </li>
                    </ul>
                </div>
            </div>
            <form action="#" id="cancel_reservation_form">
                <textarea class="form-control" name="cancellation" placeholder="Add reason for cancellation" required></textarea>
                <input type="hidden" name="cancel_booking_listid" id="cancel_booking_listid">
                
                <div class="modalButtonRow">
                    <a href="#" class="btn btn-black" data-target="modalClose">Nevermind</a>
                    <button type="submit" class="btn">Confirm Cancellation</button>
                </div>
            </form>
            <p class="error error-text" id="cancel_reservation_error"></p>
            <p class="success-text" id="cancel_reservation_success"></p>
        </div>
    </div>
</div>

<div class="modal" id="invitationDecline">
    <div class="modal-backdrop"></div>
    <div class="modal-wrapper modal-transition">
        <button class="modal-close" data-target="modalClose">
            <img src="<?php echo base_url(); ?>uploads/front/images/cross-icon.svg" alt="Close Icon">
        </button>
        <div class="modal-body cmn-scroll">
            <h4>Are you sure you want to decline this reservation!</h4>
            <form action="#" class="form-inline" id="decline_reservation_form">
                <textarea class="form-control" name="decline_reason" placeholder="Add reason for decline" required></textarea>
                <input type="hidden" name="invite_id" id="decline_invite_id">
                <input type="hidden" name="status" value="decline">
                <button type="submit" class="btn">Send</button>
            </form>
            <p class="error error-text" id="decline_reservation_error"></p>
            <p class="success-text" id="decline_reservation_success"></p>
        </div>
    </div>
</div>

<div class="modal" id="notCompleted">
    <div class="modal-backdrop"></div>
    <div class="modal-wrapper modal-transition">
        <button class="modal-close" data-target="modalClose">
            <img src="<?php echo base_url(); ?>uploads/front/images/cross-icon.svg" alt="Close Icon">
        </button>
        <div class="modal-body text-center cmn-scroll">
            <div class="popupIcon">
                <img src="<?php echo base_url(); ?>uploads/front/images/notCompleted-icon.svg" alt="">
            </div>
            <h4>Reservations Not Complete </h4>
            <p>Your restaurant reservations are still pending. Please confirm all your reservations before leaving.</p>
            <div class="modalButtonRow">
                <a href="#" class="btn btn-black" data-target="modalClose">Close</a>                
            </div>
        </div>
    </div>
</div>


<div class="modal" id="deleteInvite">
    <div class="modal-backdrop"></div>
    <div class="modal-wrapper modal-transition">
        <button class="modal-close" data-target="modalClose">
            <img src="<?php echo base_url(); ?>uploads/front/images/cross-icon.svg" alt="Close Icon">
        </button>
        <div class="modal-body cmn-scroll text-center">
            <div class="popupIcon">
                <img src="<?php echo base_url(); ?>uploads/front/images/delete-user.svg" alt="">
            </div>
            <h4>Are you sure you want to remove <span id="guestname_span"></span> from your guest list?</h4>
            
            <div class="modalButtonRow">
                <a href="javascript:void(0);" class="btn btn-black" data-target="modalClose">Cancel</a>
                <a href="javascript:void(0);" class="btn confirmdeleteInvite" data-target="confirmdeleteInvite">Confirm</a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->

<script src="<?php echo base_url(); ?>uploads/front/js/swiper-bundle.min.js"></script>
<script src="<?php echo base_url(); ?>uploads/front/js/validate.min.js"></script>
<script src="<?php echo base_url(); ?>uploads/front/js/creditCardValidator.js"></script>
<script src="<?php echo base_url(); ?>uploads/front/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>uploads/front/js/fancy-box.js"></script>
<script src="<?php echo base_url(); ?>uploads/front/js/script.js"></script>
<script src="<?php echo base_url(); ?>uploads/front/js/ajax.js"></script>
</body>

</html>