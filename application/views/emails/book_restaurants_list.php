<?php
// echo "<pre>";
// echo "hello ";
//     echo $hide_hotel_contact;
//     echo $restaurant_address_hide;
//     echo $restaurant_fee_hide;
//     echo $restaurant_establishment_hide;
//     echo $restaurant_meals_hide;
//     echo $restaurant_website_url_hide;
//     echo $restaurant_location_hide;
//     echo $restaurant_email_hide;
    // echo "<pre>";
    // print_r($date_list);
    // die;
if (!empty($date_list)):
    $count_date = count($date_list);
    $p = 1;
  
    foreach ($date_list as $key => $list) {
        if ($list['booking_status'] == 'booked') {
            $hotel = $this->user_model->get_restaurant_detail($list['booking_restid']);
?>
            <tr style="background-color: #f7f7f7;">
                <td style="padding:35px 35px;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="25%" valign="top">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <td colspan="2">
                                            <?php if ($hotel['feature_image'] != ''): ?>
                                                <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $hotel['feature_image']; ?>"
                                                    alt="" width="100%">
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 6px;" colspan="2"></td>
                                    </tr>
                                    <?php if ($restaurant_address_hide != 'yes'): ?>
                                        <tr>
                                            <td width="30px" valign="top">
                                                <img src="<?php echo base_url(); ?>/uploads/emails/map.png" alt="">
                                            </td>
                                            <td width="500px" valign="top" style="padding-left: 5px;">
                                                <p style="color: #70016a;font-size: 10px;line-height: 16px;font-weight: 500;margin: 0px; word-wrap: break-all;"><?php echo $hotel['address']; ?></p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                        <tr>
                                            <td style="height: 10px;" colspan="2"></td>
                                        </tr>
                                        <?php if ($restaurant_location_hide != 'yes'): ?>
                                            <?php
                                            if ($hotel['location_link'] != '') {
                                            ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <a href="<?php echo $hotel['location_link']; ?>"><img src="<?php echo base_url(); ?>/uploads/emails/get.png" alt=""></a>
                                                    </td>
                                                </tr>
                                    <?php
                                            }
                                        endif;
                                    
                                    ?>

                                </table>
                            </td>
                            <td width="3%" valign="top"></td>
                            <td width="70%" valign="top">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td colspan="2">
                                                        <h2 style="color: #70016a;font-size: 20px;line-height: 24px;font-weight: 600; margin: 0; text-transform: uppercase"><?php echo $hotel['restaurant_name']; ?></h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height:10px" colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td width="51px">
                                                        <img src="<?php echo base_url(); ?>/uploads/emails/way1.png" alt="">
                                                    </td>
                                                    <td width="300px">
                                                        <p style="color:#70016a;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;"><?php echo date('D, M d, Y', strtotime($list['booking_date'])); ?></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height:5px" colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td width="51px">
                                                        <img src="<?php echo base_url(); ?>/uploads/emails/way2.png" alt="">
                                                    </td>
                                                    <td width="300px">
                                                        <p style="color:#70016a;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;">Table for <?php echo $list['booking_pax']; ?></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height:5px" colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td width="51px">
                                                        <img src="<?php echo base_url(); ?>/uploads/emails/way3.png" alt="">
                                                    </td>
                                                    <td width="300px">
                                                        <p style="color:#70016a;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;">
                                                            <?php echo $this->admin_model->get_property_type_text($hotel['property_type']); ?> </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height:5px" colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td width="51px">
                                                        <img src="<?php echo base_url(); ?>/uploads/emails/way4.png" alt="">
                                                    </td>
                                                    <td width="300px">
                                                        <p style="color:#70016a;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;"><?php echo $list['booking_time']; ?>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">

                                                <?php
                                                $user_id = $this->session->userdata('mes_user_id');
                                                $user_data = $this->user_model->get_user_detail_byuserid($user_id);
                                                ?>
                                                <?php if ($user_data['full_name'] != ''): ?>
                                                    <tr>
                                                        <td width="50%" style="padding: 5px 0;">
                                                            <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Name:</p>
                                                        </td>
                                                        <td width="50%">
                                                            <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0; text-transform: capitalize;"><?php echo $user_data['full_name']; ?></p>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if ($user_data['email'] != ''): ?>
                                                    <tr>
                                                        <td width="50%" style="padding: 5px 0;">
                                                            <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Email:</p>
                                                        </td>
                                                        <td width="50%">
                                                            <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0"><?php echo $user_data['email']; ?>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php if ($user_data['mobile_number'] != ''): ?>
                                                    <tr>
                                                        <td width="50%" style="padding: 5px 0;">
                                                            <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">User contact:
                                                            </p>
                                                        </td>
                                                        <td width="50%">
                                                            <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0"><?php echo $user_data['mobile_number']; ?></p>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if ($restaurant_email_hide != 'yes'): ?>
                                                    <?php if ($hotel['email'] != ''): ?>
                                                        <tr>
                                                            <td width="50%" style="padding: 5px 0;">
                                                                <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Restaurant
                                                                    email:</p>
                                                            </td>
                                                            <td width="50%">
                                                                <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0"><?php echo $hotel['email']; ?>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if ($hide_hotel_contact != 'yes') { ?>
                                                    <?php if ($hotel['contact'] != ''): ?>
                                                        <?php //if($hotel['contact'] == 'hideit_on_client_request'):
                                                        ?>
                                                        <tr>
                                                            <td width="50%" style="padding: 5px 0;">
                                                                <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Restaurant
                                                                    contact: </p>
                                                            </td>
                                                            <td width="50%">
                                                                <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0"><?php echo $hotel['contact']; ?>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php } ?>
                                                <?php if ($restaurant_website_url_hide != 'yes') { ?>
                                                    <?php if ($hotel['website_link'] != ''): ?>
                                                        <?php //if($hotel['contact'] == 'hideit_on_client_request'):
                                                        ?>
                                                        <tr>
                                                            <td width="50%" style="padding: 5px 0;">
                                                                <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Restaurant
                                                                    Website Url: </p>
                                                            </td>
                                                            <td width="50%">
                                                                <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0"><a href="<?php echo $hotel['website_link']; ?>">Click here</a>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php } ?>
                                                <?php
                                                if ($restaurant_fee_hide != 'yes'):
                                                    if ($hotel['deposite_amount'] != ''): ?>
                                                        <tr>
                                                            <td width="50%" style="padding: 5px 0;">
                                                                <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Late Cancel/No-Show Fee:
                                                                </p>
                                                            </td>
                                                            <td width="50%">
                                                                <?php
                                                                    if(round($hotel['deposite_amount']) > 0){
                                                                ?>
                                                                        <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0">A $<?php echo round($hotel['deposite_amount']); ?> cancellation fee may be incurred if reservations are not cancelled within two weeks of your selected reservation date. Any changes made within two weeks prior to the program start must be made when you arrive onsite.</p>
                                                                <?php
                                                                    }else{
                                                                ?>
                                                                        <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0">$<?php echo round($hotel['deposite_amount']); ?></p>
                                                                <?php
                                                                    }
                                                                ?>
                                                                
                                                            </td>
                                                        </tr>
                                                <?php
                                                    endif;
                                                endif;
                                                ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php } elseif ($list['booking_status'] == 'skip') { ?>
            <tr style="background-color: #f7f7f7;">
                <td style="padding:35px 35px;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="25%" valign="top">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <td colspan="2">
                                            <a href=""><img src="<?php echo base_url(); ?>/uploads/assets/images/left-img.png" alt=""></a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="3%" valign="top"></td>
                            <td width="70%" valign="top">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td colspan="2">
                                                        <h2 style="color: #70016a;font-size: 20px;line-height: 24px;font-weight: 600; margin: 0; text-transform: uppercase">Skipped Day</h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height:10px" colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td width="51px">
                                                        <img src="<?php echo base_url(); ?>/uploads/emails/way1.png" alt="">
                                                    </td>
                                                    <td width="300px">
                                                        <p style="color:#70016a;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;"><?php echo date('D, M d, Y', strtotime($list['booking_date'])); ?></p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td width="80px" style="padding: 5px 0;">
                                                        <p style="color:#70016a;font-size:13px;font-weight:900;margin: 0">Reason:</p>
                                                    </td>
                                                    <td width="300px">
                                                        <p style="color:#70016a;font-size:13px;font-weight:400;margin: 0"><?php echo $list['booking_reason']; ?></p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php }
        ?>
        <?php if ($p != $count_date): ?>
            <tr>
                <td style="padding:0 45px;background-color: #f7f7f7;" colspan="2">
                    <p style="border-bottom: 1px solid #D4D4D4"></p>
                </td>
            </tr>
<?php endif;
        $p++;
    }
endif; ?>