<table class="table_class" id="total_reservation1" width="100%">
    <thead>
        <tr>
            <th></th>
            <th>From Name</th>
            <th>To Name</th>
            <th>Restaurant Name</th>
            <th>Booking Date</th>
            <th>Booking Time</th>
            <th>Booking Pax</th>
            <th>Status</th>
        </tr>
    </thead>
    <?php if(!empty($list)):?>
    <tbody>
    <?php foreach($list as $data):
            $from = $this->admin_model->get_user_detail($data['from_id']);
            $to = $this->admin_model->get_user_detail($data['to_id']);
            $rest_name = $this->admin_model->get_restaurant_name_byid($data['booking_restid']);
            ?>
        <tr>
            <td></td>
            <td><?php echo $from['full_name'].' ('.$from['email'].')';?></td>
            <td><?php echo $to['full_name'].' ('.$to['email'].')';?></td>
            <td><?php echo $rest_name;?></td>
            <td><?php echo date('m-d-Y',strtotime($data['booking_date']));?></td>
            <td><?php echo $data['booking_time'];?></td>
            <td><?php echo $data['booking_pax'];?></td>
            <td><?php echo ucfirst($data['status']);?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    <?php endif; ?>
</table>
<?php echo $this->ajax_pagination->create_links();?>