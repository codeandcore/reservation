<table class="table_class table-gorup" id="total_reservation1" width="100%">
    <?php $dates = $this->admin_model->get_dates_list_booking();?>
    <thead>
        <tr>
            <th></th>
            <th>User Code</th>
            <th>Full Name</th>
            <th>User Email</th>
            <th>Alternate Email</th>
            <th>Booking Status</th>
            <?php if(!empty($dates)){
                foreach($dates as $date){?>
            <th><?php echo date('m-d-Y',strtotime($date['date']));?></th>
            <?php }
            } ?>
            <th>Modifed Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($list)){
        $j=1;
            foreach ($list as $key => $data) {
                $user_id = $data['id'];
                $booking = $this->admin_model->get_booking_detail_byuserid($user_id);
                $booking_status = 'No Response';
                // $reservation_status = 'Skipped';
                $reservation_status = 'No Response';
                if(!empty($dates) && !empty($booking)){
                    $booked = 1;
                    foreach($dates as $date){
                        $status = $this->admin_model->get_status_of_booking_date_byid($booking['id'],$date['date']);
                        if($status != 'Booked'){
                            $booked = 0;
                        }
                    }
                    if($booked == 0){
                        $booking_status = 'Partial';
                    }
                    if($booked == 1){
                        $booking_status = 'Completed';
                    }
                }
                ?>
        <tr>
            <td></td>
            <td><?php echo $data['user_code'];?></td>
            <td><?php echo $data['full_name'];?></td>
            <td><?php echo $data['email'];?></td>
            <td><?php echo $data['alternate_email'];?></td>
            <td><?php echo $booking_status;?></td>
            <?php if(!empty($dates)){
                foreach($dates as $date){
                    if(!empty($booking)){
                        $reserv_data = $this->admin_model->get_booking_dates_list_by_bookingid_date($booking['id'],$date['date']);
                            if(!empty($reserv_data)){
                                $reservation_status = ucfirst($reserv_data['booking_status']);
                                if($reserv_data['booking_status'] == 'skip'){
                                    $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
                                }
                                if($reserv_data['booking_status'] == 'cancel'){
                                    $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
                                }
                            }
            $status = $this->admin_model->get_status_of_booking_date_byid($data['id'],$date['date']);
                        }
            ?>
            <td><?php echo $reservation_status;?></td>
            <?php }
           } ?>
           <td><?php if(!empty($booking)){ echo date('m-d-Y',strtotime($booking['modify_date']));}?></td>
            <td>
                <?php if(!empty($booking)){?>
                <a href="<?php echo site_url('admin/view_booking_detail/'.$booking['id']);?>" class="view_btn">
                    <img src="<?php echo base_url(); ?>/uploads/assets/images/eye_full.svg" alt="">
                    View
                </a>
                <?php } ?>
            </td>
        </tr>
        <?php
        $j++; }
}
else{
    $col = 6;
        if(!empty($dates)){
            foreach($dates as $date){
                $col++;
            }
        }
        $col++;
        $col++;
?>
        <tr class="not-found">
            <td colspan="<?php echo $col;?>" style="text-align:center;padding:10px;">No Records Found.</td>
        </tr>
<?php } ?>
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links();?>