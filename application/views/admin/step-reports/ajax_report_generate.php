<?php
$select_days = $posts['select_days'];
$sel_attend_type = $posts['sel_attend_type'];
$sel_status = $posts['sel_status'];
$sel_property_type = $posts['sel_property_type'];
$restaurants = $posts['restaurants'];
$generic_columns = $posts['generic_columns'];
$days_columns = $posts['days_columns'];
?>
<table class="table_class table-gorup" id="total_master_reservation1" width="100%">
                        <?php $dates = $select_days;
                        ?>
                        <thead>
                            <tr>
                                <th></th>
                                <?php if(in_array('first_name',$generic_columns)):?>
                                <th>First Name</th>
                                <?php endif;?>
                                <?php if(in_array('last_name',$generic_columns)):?>
                                <th>Last Name</th>
                                <?php endif;?>
                                <?php if(in_array('email',$generic_columns)):?>
                                <th>Email Address</th>
                                <?php endif;?>
                                <?php if(in_array('response_status',$generic_columns)):?>
                                <th>Response Status</th>
                                <?php endif;?>
                                <?php if(!empty($dates)){
                                    $k=1; 
                                    foreach($select_days as $date){
                                        $corrected_columns = array();
                                        foreach ($days_columns as $key => $value) {
                                            $corrected_key = trim($key, "'");
                                            $corrected_columns[$corrected_key] = $value;
                                        }
                                        ?>
                                <?php if(in_array('status',$corrected_columns[$date])):?>
                                <th>Day <?php echo $k;?> Status</th>
                                <?php endif;?>
                                <?php if(in_array('role',$corrected_columns[$date])):?>
                                <th>Day <?php echo $k;?> Role</th>
                                <?php endif;?>
                                <?php if(in_array('date',$corrected_columns[$date])):?>
                                <th>Day <?php echo $k;?> Date</th>
                                <?php endif;?>
                                <?php if(in_array('time',$corrected_columns[$date])):?>
                                <th>Day <?php echo $k;?> Time</th>
                                <?php endif;?>
                                <?php if(in_array('restaurant_name',$corrected_columns[$date])):?>
                                <th>Day <?php echo $k;?> Restaurant Name</th>
                                <?php endif;?>
                                <?php if(in_array('property_type',$corrected_columns[$date])):?>
                                <th>Day <?php echo $k;?> Property Type</th>
                                <?php endif;?>
                                <?php if(in_array('pax',$corrected_columns[$date])):?>
                                <th>Day <?php echo $k;?> Pax</th>
                                <?php endif;?>
                                <?php if(in_array('guests',$corrected_columns[$date])):?>
                                <th>Day <?php echo $k;?> Guests</th>
                                <?php endif;?>
                                <?php if(in_array('admin_note',$corrected_columns[$date])):?>
                                <th>Day <?php echo $k;?> Admin Note</th>
                                <?php endif;?>
                                <?php if(in_array('last_updated',$corrected_columns[$date])):?>
                                <th>Day <?php echo $k;?> Last Updated</th>
                                <?php endif;?>
                                <?php $k++;}
                                } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list)):
                            $j=1;
                            foreach ($list as $key => $data) {
                                $user_id = $data['id'];
                                $booking = $this->admin_model->get_booking_detail_byuserid($user_id);
                                $booking_status = 'No Response';
                                if(!empty($dates) && !empty($booking)){
                                    $booked = 1;
                                    foreach($dates as $date){
                                        $status = $this->admin_model->get_status_of_booking_date_byid($booking['id'],$date);
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
                                <?php if(in_array('first_name',$generic_columns)):?>
                                <td><?php echo $first_name;?></td>
                                <?php endif;?>
                                <?php if(in_array('last_name',$generic_columns)):?>
                                <td><?php echo $last_name;?></td>
                                <?php endif;?>
                                <?php if(in_array('email',$generic_columns)):?>
                                <td><?php echo $data['email'];?></td>
                                <?php endif;?>
                                <?php if(in_array('response_status',$generic_columns)):?>
                                <td><?php echo $booking_status;?></td>
                                <?php endif;?>
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
                                        $invite_status = $this->admin_model->get_invite_status_byuserid_bookdate($user_id,$date);
                                        if(!empty($invite_status)){
                                            if($invite_status['status'] == 'invite'){
                                                $reservation_status = 'Pending Acceptance';
                                            }
                                            $from_data = $this->admin_model->get_user_detail($invite_status['from_id']);
                                            $reservation_role = 'Guest of '.$from_data['full_name'];
                                        }
                                        if(!empty($booking)){
                                        $reserv_data = $this->admin_model->get_booking_dates_list_by_bookingid_date($booking['id'],$date);
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
                                        }
                                        ?>
                                <?php if(in_array('status',$corrected_columns[$date])):?>
                                <td><?php echo $reservation_status;?></td>
                                <?php endif;?>
                                <?php if(in_array('role',$corrected_columns[$date])):?>
                                <td><?php echo $reservation_role;?></td>
                                <?php endif;?>
                                <?php if(in_array('date',$corrected_columns[$date])):?>
                                <td><?php echo $reservation_date;?></td>
                                <?php endif;?>
                                <?php if(in_array('time',$corrected_columns[$date])):?>
                                <td><?php echo $reservation_time;?></td>
                                <?php endif;?>
                                <?php if(in_array('restaurant_name',$corrected_columns[$date])):?>
                                <td><?php echo $reservation_restname;?></td>
                                <?php endif;?>
                                <?php if(in_array('property_type',$corrected_columns[$date])):?>
                                <td><?php echo $reservation_resttype;?></td>
                                <?php endif;?>
                                <?php if(in_array('pax',$corrected_columns[$date])):?>
                                <td><?php echo $reservation_pax;?></td>
                                <?php endif;?>
                                <?php if(in_array('guests',$corrected_columns[$date])):?>
                                <td><?php echo $reservation_guests;?></td>
                                <?php endif;?>
                                <?php if(in_array('admin_note',$corrected_columns[$date])):?>
                                <td><?php echo $reservation_admin_note;?></td>
                                <?php endif;?>
                                <?php if(in_array('last_updated',$corrected_columns[$date])):?>
                                <td><?php echo $modify_date;?></td>
                                <?php endif;?>
                                <?php }
                                        } ?>

                            </tr>
                            <?php
                                    $j++; }
                            endif; ?>
                        </tbody>
                    </table>
                    <?php echo $this->ajax_pagination->create_links();?>