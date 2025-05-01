<tr style="background-color: #f7f7f7;">
    <td style="padding:35px 35px;">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td width="25%" valign="top">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td colspan="2">
                                <?php if($hotel['feature_image'] != ''):?>
                                    <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $hotel['feature_image'];?>"
                                    alt="" width="100%">
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 6px;" colspan="2"></td>
                        </tr>
                        <?php 
                        if($restaurant_address_hide != 'yes'): 
                            if($hotel['address']!= ''){
                                ?>
                                <tr>
                                    <td width="30px" valign="top">
                                        <img src="<?php echo base_url(); ?>/uploads/emails/map.png" alt="">
                                    </td>
                                    <td width="500px" valign="top" style="padding-left: 5px;">
                                        <p style="color: #70016a;font-size: 10px;line-height: 16px;font-weight: 500;margin: 0px; word-wrap: break-all;"><?php echo $hotel['address'];?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 10px;" colspan="2"></td>
                                </tr>
                                <?php
                            }
                        endif;
                            ?>
                            <?php if($restaurant_location_hide != 'yes'): ?>
                                <?php 
                                if($hotel['location_link']!=''){
                                        ?>
                                <tr>
                                    <td colspan="2">
                                        <a href="<?php echo $hotel['location_link'];?>"><img src="<?php echo base_url(); ?>/uploads/emails/get.png" alt=""></a>
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
                                            <h2 style="color: #70016a;font-size: 20px;line-height: 24px;font-weight: 600; margin: 0; text-transform: uppercase"><?php echo $hotel['restaurant_name'];?></h2>
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
                                            <p style="color:#70016a;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;"><?php echo date('D, M d, Y',strtotime($booking['booking_date']));?></p>
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
                                            <p style="color:#70016a;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;">Table for <?php echo $booking['booking_pax'];?></p>
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
                                            <?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?> </p>
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
                                            <p style="color:#70016a;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;"><?php echo $booking['booking_time'];?>
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
                                    <?php if($user_data['full_name'] != ''):?>
                                    <tr>
                                        <td width="50%" style="padding: 5px 0;">
                                            <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Name:</p>
                                        </td>
                                        <td width="50%">
                                            <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0; text-transform: capitalize;"><?php echo $user_data['full_name'];?></p>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($user_data['email'] != ''):?>
                                    <tr>
                                        <td width="50%" style="padding: 5px 0;">
                                            <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Email:</p>
                                        </td>
                                        <td width="50%">
                                            <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0"><?php echo $user_data['email'];?>
                                            </p>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    
                                    <?php if($user_data['mobile_number'] != ''):?>
                                    <tr>
                                        <td width="50%" style="padding: 5px 0;">
                                            <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">User contact:
                                            </p>
                                        </td>
                                        <td width="50%">
                                            <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0"><?php echo $user_data['mobile_number'];?></p>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($restaurant_email_hide != 'yes'): ?>
                                        <?php if($hotel['email'] != ''):?>
                                        <tr>
                                            <td width="50%" style="padding: 5px 0;">
                                                <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Restaurant
                                                    email:</p>
                                            </td>
                                            <td width="50%">
                                                <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0"><?php echo $hotel['email'];?>
                                                </p>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php 
                                    if($hide_hotel_contact != 'yes'){
                                        ?>
                                            <?php if($hotel['contact'] != ''):?>
                                            <tr>
                                                <td width="50%" style="padding: 5px 0;">
                                                    <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Restaurant
                                                        contact: </p>
                                                </td>
                                                <td width="50%">
                                                    <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0"><?php echo $hotel['contact'];?>
                                                    </p>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        <?php
                                    }

                                    ?>
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
                                    if($restaurant_fee_hide != 'yes'){
                                        if($hotel['deposite_amount'] != ''):?>
                                        <tr>
                                            <td width="50%" style="padding: 5px 0;">
                                                <p style="color:#70016a;font-size:12px;font-weight:900;margin: 0">Late Cancel/No-Show Fee:
                                                </p>
                                            </td>
                                            <td width="50%">
                                                <p style="color:#70016a;font-size:12px;font-weight:400;margin: 0">$<?php echo round($hotel['deposite_amount']);?></p>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>