<?php
$noti = $data['notifications'];
$array = explode(',',$noti);
?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid checkbox_wrap">
            <h2 class="heading_title">Email Notification Settings</h2>
            <form action="<?php echo site_url('admin/update_email_notification');?>" method="post" enctype="multipart/form-data">
                <div class="row" style="margin-top:30px">
                    <div class="col-3" style="margin:10px 0">
                        <input type="checkbox" name="email_notification[]" class="checkbox form-control" id="admin_reservation_received" <?php if(in_array('admin_reservation_received',$array)){ echo 'checked';}?> value="admin_reservation_received">
                        <label for="admin_reservation_received">RECEIVED RESERVATION</label>
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <input type="checkbox" name="email_notification[]" class="checkbox form-control" id="admin_invitation_accepted" <?php if(in_array('admin_invitation_accepted',$array)){ echo 'checked';}?> value="admin_invitation_accepted">
                        <label for="admin_invitation_accepted">INVITATION ACCEPTED</label>
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <input type="checkbox" name="email_notification[]" class="checkbox form-control" id="admin_invitation_decline" <?php if(in_array('admin_invitation_decline',$array)){ echo 'checked';}?> value="admin_invitation_decline">
                        <label for="admin_invitation_decline">INVITATION DECLINE</label>
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <input type="checkbox" name="email_notification[]" class="checkbox form-control" id="admin_modification_reservation" <?php if(in_array('admin_modification_reservation',$array)){ echo 'checked';}?> value="admin_modification_reservation">
                        <label for="admin_modification_reservation">MODIFICATIONS RESERVATION</label>
                    </div>
                    <div class="col-3" style="margin:10px 0">
                        <input type="checkbox" name="email_notification[]" class="checkbox form-control" id="admin_canceled_reservation" <?php if(in_array('admin_canceled_reservation',$array)){ echo 'checked';}?>  value="admin_canceled_reservation">
                        <label for="admin_canceled_reservation">CANCELLED RESERVATION</label>
                    </div>
                    <!-- <div class="col-3" style="margin:10px 0">
                        <input type="checkbox" name="email_notification[]" class="checkbox form-control" id="restaurant_removed_admin_canceled_reservation" <?php //if(in_array('restaurant_removed_admin_canceled_reservation',$array)){ echo 'checked';}?>  value="restaurant_removed_admin_canceled_reservation">
                        <label for="restaurant_removed_admin_canceled_reservation">RESTAURANT REMOVED CANCELED RESERVATION</label>
                    </div> -->
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-12">
                        <div class="text-left"><input type="submit" class="btn btn-primary" value="Save"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>