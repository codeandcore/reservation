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
                            <?php if($restaurant_address_hide != 'yes'): ?>
                                <tr>
                                    <td width="30px" valign="top">
                                        <img src="<?php echo base_url(); ?>/uploads/emails/map.png" alt="">
                                    </td>
                                    <td width="500px" valign="top" style="padding-left: 5px;">
                                        <p style="color: <?php echo $color1; ?>;font-size: 10px;line-height: 16px;font-weight: 500;margin: 0px; word-wrap: break-all;"><?php echo $hotel['address'];?></p>
                                    </td>
                                </tr>
                            <?php  endif; ?>
                                <tr>
                                    <td style="height: 10px;" colspan="2"></td>
                                </tr>
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
                                    ?>
                                <?php  endif; ?>
                           
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
                                                <h2 style="color: <?php echo $color1; ?>;font-size: 20px;line-height: 24px;font-weight: 600;margin: 0; text-transform: uppercase"><?php echo $hotel['restaurant_name'];?></h2>
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
                                                <p style="color:<?php echo $color1; ?>;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;"><?php echo date('D, M d, Y',strtotime($booking['booking_date']));?></p>
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
                                                <p style="color:<?php echo $color1; ?>;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;">Table for <?php echo $booking['booking_pax'];?></p>
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
                                                <p style="color:<?php echo $color1; ?>;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;">
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
                                                <p style="color:<?php echo $color1; ?>;font-size: 14px;line-height: 16px;font-weight: 600;margin: 0px;"><?php echo $booking['booking_time'];?>
                                                </p>
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