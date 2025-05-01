<?php use Jlorente\CreditCards\CreditCardValidator;?>   
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="heading_title">View Total Complete Reservation (300)</h2>
            <div class="wrap_table withLeftButtons action_class">
                <form action=""  id="complete_booking" method="post">
                    <div class="leftButtonsRow">
                        <a href="assets/images/download.xlsx" class="btn btn_add" download=""><img
                                src="<?php echo base_url(); ?>/uploads/assets/images/download_sheet.svg" alt="">
                            Download Report</a>
                        <div class="startToendSearch">

                            <div class="innerSearchDate">
                                <div class="searchDate">
                                    <span class="searchDateTitle">Start Date:</span>
                                    <div class="searchDateInput">
                                        <input type="text" id="from_date_select" name="min" placeholder="--/--/----">
                                    </div>
                                </div>
                                <div class="searchDate">
                                    <span class="searchDateTitle">End Date:</span>
                                    <div class="searchDateInput">
                                        <input type="text" id="to_date_select" name="max" placeholder="--/--/----">
                                    </div>
                                </div>
                                <div class="searchDateButton">
                                    <input type="submit" value="search" class="btn">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="top_filter">
                        <div class="dataTables_length" id="all_restaurants_length">
                            <label>Show Entries:
                                <select name="all_restaurants_length" aria-controls="all_restaurants" class="">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </label>
                        </div>
                        <div id="all_restaurants_filter" class="dataTables_filter">
                            <label>Search:<input type="search" name="search_keyword" placeholder="Please search here..."
                                    aria-controls="all_restaurants"></label>
                        </div>
                    </div>
                </form>
                    <div class="defaultDataTable" id="complete_reports">
                        <table class="commonTable table-gorup" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>User email</th>
                                    <th>User name</th>
                                    <th>User contact</th>
                                    <th>Confirmation ID</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Restaurant name</th>
                                    <th>No of People</th>
                                    <th>Deposit $</th>
                                    <th>Credit card</th>
                                    <th>Booked Date</th>
                                    <th>Booked Time</th>
                                    <th>Invited Info</th>
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
                                            $bnumber = $udata['mobile_number'];
                                            $bdate = date('d-m-Y',strtotime($book['created_date']));
                                            $btime = date('h:ia',strtotime($book['created_date']));
                                        }
                                        else{
                                            $bid = '';
                                            $busname = '';
                                            $bemail = '';
                                            $bdate = '';
                                            $bnumber = '';
                                            $btime = '';
                                        }
                                    $rest_name = $this->admin_model->get_restaurant_name_byid($book['booking_restid']);
                                ?>
                                <tr class="<?php if($j % 2 == 0){ echo 'groupOdd';} else{ echo 'groupEven';}?>">
                                    <td></td>
                                    <td><span><?php echo $bemail;?></span></td>
                                    <td><?php echo $busname;?></td>
                                    <td><?php echo $bnumber;?></td>
                                    <td><?php echo $bid;?></td>
                                    <td><?php echo date('d-m-Y',strtotime($book['booking_date']));?></td>
                                    <td><?php echo $book['booking_time'];?></td>
                                    <td><?php echo $rest_name;?></td>
                                    <td><?php echo $book['booking_pax'];?></td>
                                    <td><?php echo $book['booking_deposite'];?>$</td>
                                    <td>
                                        <?php if($data['card_number'] != '' && $k == 1){
                                            $card_number = $this->encrypt->decode($data['card_number']);
                                            $validator = CreditCardValidator::make([
                                                CreditCardValidator::TYPE_VISA,
                                                CreditCardValidator::TYPE_MASTERCARD,
                                    ]);
                                            $typeConfig = $validator->getType($card_number);
                                           $type = $typeConfig->getniceType();
                                            if($type == 'Mastercard'){
                                                $card_icon = base_url()."/uploads/assets/images/mastercard-logo.svg";
                                            }
                                            else{
                                                $card_icon = base_url()."/uploads/assets/images/visa-icon.svg";
                                            }
                                            $newstring = substr($card_number, -4);
                                            ?>
                                        <a href="javascript:void(0)" class="view_btn drop_dots"> <img
                                                src="<?php echo base_url(); ?>/uploads/assets/images/eye_full.svg"
                                                alt="">View card</a>
                                        <div class="action_drop card_drop">
                                            <div class="cardDetails">
                                                <h6>Card Number</h6>
                                                <span class="cardNumber">**** **** **** <?php echo $newstring;?></span>
                                                <div class="cardType">
                                                    <i><img src="<?php echo $card_icon;?>" alt=""></i>
                                                    <?php echo $type;?>
                                                </div>
                                                <a href="javascript:void(0);" class="btn">Send details</a>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $bdate;?></td>
                                    <td><?php echo $btime;?></td>
                                    <td>
                                    <?php if($book['guests'] != ''){?>
                                        <a href="javascript:void(0)" class="view_btn drop_dots"> <img
                                                src="<?php echo base_url(); ?>/uploads/assets/images/eye_full.svg"
                                                alt="">View Details</a>
                                        <div class="action_drop card_drop">
                                            <?php $exp = $this->admin_model->get_notification_list_bookid($book['id']);
                                            foreach($exp as $user){
                                                $udt = $this->admin_model->get_user_detail($user['to_id']);
                                                ?>
                                            <div class="invitedUnfo">
                                                <ul class="list-unstyled">
                                                    <li><span>Email :</span> <?php echo $udt['email'];?></li>
                                                    <li><span>Name :</span> <?php echo $udt['full_name'];?></li>
                                                    <li><span>Contact :</span> <?php echo $udt['mobile_number'];?></li>
                                                    <li><span>Status :</span> <?php echo $user['status'];?></li>
                                                </ul>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php $k++; } $j++; }
                                endif;?>
                            </tbody>
                        </table>
                        <?php echo $this->ajax_pagination->create_links();?>
                    </div>
            </div>
        </div>
    </div>
</div>
<script>
$("#from_date_select").datepicker({
    dateFormat: "dd-mm-yy",
    duration: "fast",
    onSelect: function(selected) {
          $("#to_date_select").datepicker("option","minDate", selected)
    }
});
$("#to_date_select").datepicker({
    dateFormat: "dd-mm-yy",
    duration: "fast"
});
</script>