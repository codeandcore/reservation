<div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <h2 class="heading_title">View Total Complete Reservation (<?php echo count($list);?>)</h2>
                        <div class="table_filter_wrap">
                            
                        </div>
                        <div class="wrap_table">
                            <div class="defaultDataTable">
                                <table class="table_class table-gorup" id="total_reservation" width="100%">
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
                                            <th>No of People</th>
                                            <th>Deposit $</th>
                                            <th>Booked Date</th>
                                            <th>Booked Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($list)):
                                    $j = 1;
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
                                                if($book['ref_id'] == 0){
                                                    $type = 'Primary';
                                                }
                                                else{
                                                    $type = 'Guest';
                                                }
                                            $rest_name = $this->admin_model->get_restaurant_name_byid($book['booking_restid']);

                                        ?>
                                        <tr class="<?php if($j % 2 == 0){ echo 'groupOdd';} else{ echo 'groupEven';}?>">
                                            <td></td>
                                            <td><?php echo $bid;?></td>
                                            <td><?php echo $type;?></td>
                                            <td><?php echo $busname;?></td>
                                            <td><?php echo $bemail;?></td>
                                            <td><?php echo $rest_name;?></td>
                                            <td><?php echo date('d-m-Y',strtotime($book['booking_date']));?></td>
                                            <td><?php echo $book['booking_time'];?></td>
                                            <td><?php echo $book['booking_pax'];?></td>
                                            <td><?php echo $book['booking_deposite'];?>$</td>
                                            <td><?php echo $bdate;?></td>
                                            <td><?php echo $btime;?></td>
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
                                        endif; ?>
                                    </tbody>
                                </table>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>