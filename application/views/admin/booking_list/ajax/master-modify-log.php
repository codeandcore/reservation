<table class="table_class table-gorup" id="total_reservation1" width="100%">
                        <?php $dates = $this->admin_model->get_dates_list_booking();?>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Time Stamp </th>
                                <th>Booking ID</th>
                                <th>Action Performed</th>
                                <th>By</th>
                                <th>By Email</th>
                                <th>For User</th>
                                <th>To User</th>
                                <th>Restaurent Name</th>
                                <th>Restaurent Date</th>
                                <th>Restaurent Time</th>
                                <th>No of People</th>
                                <th>Reason Note</th>
                                <th>Admin Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list)):
                                    $j=1;
                                        foreach ($list as $key => $data) { ?>
                            <tr>
                                <td></td>
                                <?php
                                $modify_date = date('m-d-Y H:i:s A',strtotime($data['timestamp']));

                                //Convert time stamp to NY time zone
                                // Create a DateTime object from the timestamp string
                                // $date = DateTime::createFromFormat('Y-m-d H:i:s', $data['timestamp'], new DateTimeZone('UTC'));

                                // Set the target time zone (New York)
                                // $date->setTimezone(new DateTimeZone('America/New_York'));

                                // Format the date in the target time zone
                                // $new_york_time = $date->format('Y-m-d H:i:s');
                                // $modify_date = date('m-d-Y H:i:s',strtotime($new_york_time));
                                ?>
                                <!-- <td><?php //echo date('m-d-Y h:i:s',strtotime($data['timestamp']));?></td> -->
                                <td><?php echo $modify_date;?></td>
                                <td><?php echo $data['booking_id'];?></td>
                                <td><?php echo $data['action'];?></td>
                                <td><?php echo $data['added_by'];?></td>
                                <td><?php echo $data['by_email'];?></td>
                                <td><?php echo $data['for_user'];?></td>
                                <td><?php echo $data['to_user'];?></td>
                                <td><?php echo $data['restaurant_name'];?></td>
                                <td><?php echo date('m-d-Y',strtotime($data['restaurant_date']));?></td>
                                <td><?php echo $data['restaurant_time'];?></td>
                                <td><?php echo $data['no_of_people'];?></td>
                                <td><?php echo $data['reason'];?></td>
                                <td><?php echo $data['admin_note'];?></td>
                            </tr>
                            <?php
                                             $j++; }
                                        endif; ?>
                        </tbody>
                    </table>
                    <?php echo $this->ajax_pagination->create_links();?>