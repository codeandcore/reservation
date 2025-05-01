<table class="table_class table-gorup" id="total_reservation34" width="100%">
    <?php $dates = $this->admin_model->get_dates_list_booking();?>
    <thead>
        <tr>
        <th class="sorting"></th>
        <th class="<?php if($order == 'name'){ if($orderby=='DESC'){ echo 'sorting_asc';}else{ echo 'sorting_desc';} }else{ echo 'sorting';}?>" data-column="name">Restaurant Name</th>
        <th>Property type</th>
        <th class="<?php if($order == 'time'){ if($orderby=='DESC'){ echo 'sorting_asc';}else{ echo 'sorting_desc';} }else{ echo 'sorting';}?>" data-column="time">Reservation Time</th>
        <th class="<?php if($order == 'date'){ if($orderby=='DESC'){ echo 'sorting_asc';}else{ echo 'sorting_desc';} }else{ echo 'sorting';}?>" data-column="date">Reservation Date</th>
        <th class="<?php if($order == 'size'){ if($orderby=='DESC'){ echo 'sorting_asc';}else{ echo 'sorting_desc';} }else{ echo 'sorting';}?>" data-column="size">Table Size</th>
        <th class="<?php if($order == 'capacity'){ if($orderby=='DESC'){ echo 'sorting_asc';}else{ echo 'sorting_desc';} }else{ echo 'sorting';}?>" data-column="capacity">Capacity</th>
        <th class="<?php if($order == 'booked'){ if($orderby=='DESC'){ echo 'sorting_asc';}else{ echo 'sorting_desc';} }else{ echo 'sorting';}?>" data-column="booked">Booked</th>
        <th class="<?php if($order == 'remaining'){ if($orderby=='DESC'){ echo 'sorting_asc';}else{ echo 'sorting_desc';} }else{ echo 'sorting';}?>" data-column="remaining">Remaining</th>
        <th class="" data-column="action">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($list)){
            foreach ($list as $key => $data) {
                $booked = $this->admin_model->count_booked_tablle_byrestid_date($data['restaurant_id'],$data['date'],$data['time'],$data['size']);
                $remain = $data['capacity'] - $booked;
                        ?>
        <tr>
            <td></td>
            <td><?php echo $data['restaurant_name'];?></td>
            <td><?php echo $this->admin_model->get_property_type_text($data['property_type']);?></td>
            <td><?php echo $data['time'];?></td>
            <td><?php echo date('m-d-Y',strtotime($data['date']));?></td>
            <td><?php echo $data['size'];?></td>
            <td><?php echo $data['capacity'];?></td>
            <td><?php echo $booked;?></td>
            <td><?php echo $remain;?></td>
            <td>
                <?php if($booked > 0){?>
                <a href="javascript:void(0)" class="view_booked_slot_btn" data-popup="view_booked_slot"
                    data-restid="<?php echo $data['restaurant_id'];?>" data-date="<?php echo $data['date'];?>"
                    data-time="<?php echo $data['time'];?>" data-size="<?php echo $data['size'];?>">
                    <img src="<?php echo base_url(); ?>/uploads/assets/images/eye_full.svg" alt="">
                    View
                </a>
                <?php } ?>
            </td>
        </tr>
        <?php }
        } else{ ?>
        <tr class="not-found">
            <td colspan="9" style="text-align:center;padding:10px;">No Records Found.</td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links();?>