<table class="table_class table-gorup" id="total_master_reservation1" width="100%">
    <?php $dates = $this->admin_model->get_dates_list_booking();?>
    <thead>
        <tr>
            <th></th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th>
            <th>Response Status</th>
            <?php if(!empty($dates)){
                                    $k=1; 
                                    foreach($dates as $date){?>
            <th>Day <?php echo $k;?> Status</th>
            <th>Day <?php echo $k;?> Role</th>
            <th>Day <?php echo $k;?> Date</th>
            <th>Day <?php echo $k;?> Time</th>
            <th>Day <?php echo $k;?> Restaurant Name</th>
            <th>Day <?php echo $k;?> Property Type</th>
            <th>Day <?php echo $k;?> Pax</th>
            <th>Day <?php echo $k;?> Guests</th>
            <th>Day <?php echo $k;?> Admin Note</th>
            <th>Day <?php echo $k;?> Last Updated</th>
            <?php $k++;}
                                } ?>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($list)){
        $j=1;
        foreach ($list as $key => $data) {
            $user_id = $data['id'];
            $booking = $this->admin_model->get_booking_detail_byuserid($user_id);
            $booking_status = 'No Response';
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
            $username = $data['full_name'];
            $exp = explode(' ',$username);
            $first_name = $exp[0];
            $last_name = $exp[1];
            ?>
        <tr>
            <td></td>
            <td><?php echo $first_name;?></td>
            <td><?php echo $last_name;?></td>
            <td><?php echo $data['email'];?></td>
            <td><?php echo $booking_status;?></td>
            <?php 
        if(!empty($dates)){
            foreach($dates as $date){
            // $reservation_status = 'Skipped';
            $reservation_status = 'No Response';
            $reservation_role = '';
            $reservation_date = '';
            $reservation_time = '';
            $reservation_restname = '';
            $reservation_resttype = '';
            $reservation_pax = '';
            $reservation_guests = '';
            $reservation_admin_note = '';
            $modify_date = '';
            $invite_status = $this->admin_model->get_invite_status_byuserid_bookdate($user_id,$date['date']);
            if(!empty($invite_status)){
                if($invite_status['status'] == 'invite'){
                    $reservation_status = 'Pending Acceptance';
                }
                $from_data = $this->admin_model->get_user_detail($invite_status['from_id']);
                $reservation_role = 'Guest of '.$from_data['full_name'];
            }
            if(!empty($booking)){
            $reserv_data = $this->admin_model->get_booking_dates_list_by_bookingid_date($booking['id'],$date['date']);
                if(!empty($reserv_data)){
                    $reservation_admin_note = $reserv_data['admin_note'];
                    $reservation_status = ucfirst($reserv_data['booking_status']);
                    if($reserv_data['booking_status'] == 'skip'){
                        // $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
                        $reservation_status = $reserv_data['booking_reason'];
                    }
                    if($reserv_data['booking_status'] == 'cancel'){
                        $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
                    }
                    if($reserv_data['ref_id'] == 0){
                        $reservation_role = 'Primary';
                    }
                    $reservation_date = date('m-d-Y',strtotime($reserv_data['booking_date']));
                    $reservation_time = $reserv_data['booking_time'];
                    $reservation_pax = $reserv_data['booking_pax'];
                    $reservation_restname  = $this->admin_model->get_restaurant_name_byid($reserv_data['booking_restid']);
                    $property_type  = $this->admin_model->get_restaurant_type_byid($reserv_data['booking_restid']);
                    $reservation_resttype = $this->admin_model->get_property_type_text($property_type);
                    if($reserv_data['guests'] != ''){
                        $gexp = explode(',',$reserv_data['guests']);
                        $guest = [];
                        foreach($gexp as $gid){
                            $guest[] = $this->admin_model->get_user_name_byid($gid);
                        }
                        $reservation_guests = implode(', ',$guest);
                    }
                    if($reserv_data['booking_status'] == 'cancel' || $reserv_data['booking_status'] == 'skip'){
                        $reservation_role = '';
                        $reservation_date = '';
                        $reservation_time = '';
                        $reservation_restname = '';
                        $reservation_resttype = '';
                        $reservation_pax = '';
                        $reservation_guests = '';
                    }
                }
                $modify_date = date('m-d-Y H:i:s',strtotime($booking['modify_date']));

                //Convert time stamp to NY time zone
                // Create a DateTime object from the timestamp string
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $booking['modify_date'], new DateTimeZone('UTC'));

                // Set the target time zone (New York)
                $date->setTimezone(new DateTimeZone('America/New_York'));

                // Format the date in the target time zone
                $new_york_time = $date->format('Y-m-d H:i:s');
                $modify_date = date('m-d-Y H:i:s',strtotime($new_york_time));
                //Convert time stamp to NY time zone END

                // Separate date and time
                list($date_part, $time_part) = explode(' ', $modify_date, 2);

                // Concatenate with <br> in between
                $modify_date = $date_part . "<br>" . $time_part;
            }
            ?>
            <td><?php echo $reservation_status;?></td>
            <td><?php echo $reservation_role;?></td>
            <td><?php echo $reservation_date;?></td>
            <td><?php echo $reservation_time;?></td>
            <td><?php echo $reservation_restname;?></td>
            <td><?php echo $reservation_resttype;?></td>
            <td><?php echo $reservation_pax;?></td>
            <td><?php echo $reservation_guests;?></td>
            <td><?php echo $reservation_admin_note;?></td>
            <td><?php echo $modify_date;?></td>
            <?php }
        } ?>

        </tr>
        <?php
        $j++; }
    }
    else{
        $col = 5;
        if(!empty($dates)){
            foreach($dates as $date){
                $col = $col + 8;
            }
        }
    ?>
    <tr class="not-found">
            <td colspan="<?php echo $col;?>" style="text-align:center;padding:10px;">No Records Found.</td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links();?>