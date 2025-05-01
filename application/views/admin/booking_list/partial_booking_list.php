<div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <h2 class="heading_title">View Total Partial Reservation (<?php echo count($list);?>)</h2>
                        <div class="table_filter_wrap">
                            
                        </div>
                        <div class="wrap_table">
                            <div class="defaultDataTable">
                                <table class="table_class table-gorup" id="total_reservation" width="100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Confirmation ID</th>
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
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($list)):
                                    $j=1;
                                        foreach ($list as $key => $data) {
                                            $bookings = $this->admin_model->get_booking_dates_list($data['id']);
                                            $k = 1;
                                            foreach($bookings as $book){
                                                if($k==1){
                                                    $bid = '#'.$data['id'];
                                                    $user_id = $data['user_id'];
                                                    $udata = $this->admin_model->get_user_date_byid($user_id);
                                                    $busname = $udata['full_name'];
                                                    $bemail = $udata['email'];
                                                    $bdate = date('d-m-Y',strtotime($book['created_date']));
                                                    $btime = date('h:ia',strtotime($book['created_date']));
                                                }
                                                else{
                                                    $bid = '';
                                                    $busname = '';
                                                    $bemail = '';
                                                    $bdate = '';
                                                    $btime = '';
                                                }
                                            $booking_time = $book['booking_time'];
                                            $booking_pax = $book['booking_pax'];
                                            $booking_date = date('d-m-Y',strtotime($book['booking_date']));
                                            $booking_deposite = $book['booking_deposite'].'$';
                                            $booking_skip = '';
                                            $rest_name = $this->admin_model->get_restaurant_name_byid($book['booking_restid']);
                                            if($book['booking_status'] == 'skip'){
                                                $rest_name = '';
                                                $booking_time = '';
                                                $booking_pax = '';
                                                $booking_date = '<span class="skipText">'.date('d-m-Y',strtotime($book['booking_date'])).'</span>';
                                                $booking_deposite = '';
                                                $bdate = '';
                                                $btime = '';
                                                $booking_skip = '<span class="skipText">Skip</span>';
                                            }
                                            else if($book['booking_status'] == 'cancel'){
                                                $rest_name = '';
                                                $booking_time = '';
                                                $booking_pax = '';
                                                $booking_date = '<span class="skipText">'.date('d-m-Y',strtotime($book['booking_date'])).'</span>';
                                                $booking_deposite = '';
                                                $bdate = '';
                                                $btime = '';
                                                $booking_skip = '<span class="skipText">Cancel</span>';
                                            }
                                        ?>
                                        <tr class="<?php if($j % 2 == 0){ echo 'groupOdd';} else{ echo 'groupEven';}?>">
                                            <td></td>
                                            <td><?php echo $bid;?></td>
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
                                            <td>
                                            <?php if($k==1){ ?>
                                                <?php if($book['booking_status'] != 'skip'){ ?>
                                                <a href="<?php echo site_url('admin/view_booking_detail/'.$data['id']);?>" class="view_btn">
                                                    <img src="assets/images/eye_full.svg" alt="">
                                                    View
                                                </a>
                                                <?php } ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php $k++; } $j++;}
                                        endif; ?>
                                    </tbody>
                                </table>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>