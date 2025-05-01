<table class="table_class table-gorup" id="total_reservation1" width="100%">
                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Confirmation ID</th>
                                            <th>Invited Type</th>
                                            <th>User name</th>
                                            <th>User email</th>
                                            <th>Restaurant name</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Skip days</th>
                                            <th>No of People</th>
                                            <th>Deposit $</th>
                                            <th>Booked Date</th>
                                            <th>Booked Time</th>
                                            <th>Modified Date</th>
                                            <th>Admin Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($list)){
                                    $j=1;
                                        foreach ($list as $key => $data) {
                                            $bookings = $this->admin_model->get_booking_dates_list($data['id']);
                                            $k = 1;
                                            foreach($bookings as $book){
                                                $bid = '#'.$data['id'];
                                                $user_id = $data['user_id'];
                                                $udata = $this->admin_model->get_user_date_byid($user_id);
                                                $busname = $udata['full_name'];
                                                $bemail = $udata['email'];
                                                if($k==1){
                                                    // $bid = '#'.$data['id'];
                                                    // $user_id = $data['user_id'];
                                                    // $udata = $this->admin_model->get_user_date_byid($user_id);
                                                    // $busname = $udata['full_name'];
                                                    // $bemail = $udata['email'];
                                                    $bdate = date('m-d-Y',strtotime($book['created_date']));
                                                    $btime = date('h:ma',strtotime($book['created_date']));
                                                }
                                                else{
                                                    $bid = '';
                                                    // $busname = '';
                                                    // $bemail = '';
                                                    $bdate = '';
                                                    $btime = '';
                                                }
                                                if($book['ref_id'] == 0){
                                                    $type = 'Primary';
                                                }
                                                else{
                                                    $type = 'Guest';
                                                }
                                            $booking_time = $book['booking_time'];
                                            $booking_pax = $book['booking_pax'];
                                            $modify_date = date('m-d-Y',strtotime($book['modify_date']));
                                            $booking_date = date('m-d-Y',strtotime($book['booking_date']));
                                            $booking_deposite = '$'.$book['booking_deposite'];
                                            $booking_skip = '';
                                            $rest_name = $this->admin_model->get_restaurant_name_byid($book['booking_restid']);
                                            if($book['booking_status'] == 'skip'){
                                                $rest_name = '';
                                                $booking_time = '';
                                                $booking_pax = '';
                                                $booking_date = '<span class="skipText">'.date('m-d-Y',strtotime($book['booking_date'])).'</span>';
                                                $booking_deposite = '';
                                                $bdate = '';
                                                $btime = '';
                                                $modify_date = '';
                                                $booking_skip = '<span class="skipText">Skip</span>';
                                            }
                                            else if($book['booking_status'] == 'cancel'){
                                                $rest_name = '';
                                                $booking_time = '';
                                                $booking_pax = '';
                                                $booking_date = '<span class="skipText">'.date('m-d-Y',strtotime($book['booking_date'])).'</span>';
                                                $booking_deposite = '';
                                                $bdate = '';
                                                $btime = '';
                                                $modify_date = '';
                                                $booking_skip = '<span class="skipText">Cancel</span>';
                                            }
                                        ?>
                                        <tr class="<?php if($j % 2 == 0){ echo 'groupOdd';} else{ echo 'groupEven';}?>">
                                            <td></td>
                                            <td><?php echo $bid;?></td>
                                            <td><?php echo $type;?></td>
                                            <td><?php echo $busname;?></td>
                                            <td><?php echo $bemail;?></td>
                                            <td><?php echo $rest_name;?></td>
                                            <td><?php echo $booking_date;?></td>
                                            <td><?php echo $booking_time;?></td>
                                            <td><?php echo $booking_skip;?></td>
                                            <td><?php echo $booking_pax;?></td>
                                            <td><?php echo $booking_deposite;?></td>
                                            <td><?php echo $bdate;?></td>
                                            <td><?php echo $btime;?></td>
                                            <td><?php echo $modify_date;?></td>
                                            <td><?php echo $book['admin_note'];?></td>
                                            <td>
                                                <?php if($k==1){ ?>
                                                <a href="<?php echo site_url('admin/view_booking_detail/'.$data['id']);?>" class="view_btn">
                                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/eye_full.svg" alt="">
                                                    View
                                                </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php $k++; } $j++; }
                                        }
                                        else{?>
                                        <tr class="not-found">
                                            <td colspan="16" style="text-align:center;padding:10px;">No Records Found.</td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                    </table>
                    <?php echo $this->ajax_pagination->create_links();?>