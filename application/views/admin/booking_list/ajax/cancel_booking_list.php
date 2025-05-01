<table class="table_class" id="total_reservation1" width="100%">
    <thead>
        <tr>
            <th></th>
            <th>Confirmation ID</th>
            <th>User name</th>
            <th>User email</th>
            <th>Restaurant name</th>
            <th>Date</th>
            <th>Time</th>
            <th>No of People</th>
            <th>Deposit $</th>
            <th>Cancelled Date</th>
            <th>Cancelled Time</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($list)){
                                foreach ($list as $key => $data) {
                                    $user_id = $data['user_id'];
                                    $udata = $this->admin_model->get_user_date_byid($user_id);
                                    $busname = $udata['full_name'];
                                    $bemail = $udata['email'];
                                    $bdate = date('d-m-Y',strtotime($data['created_date']));
                                    $btime = date('h:ma',strtotime($data['created_date']));
                                    $rest_name = $this->admin_model->get_restaurant_name_byid($data['booking_restid']);
                                ?>
        <tr>
            <td></td>
            <td>#<?php echo $data['booking_id'];?></td>
            <td><?php echo $busname;?></td>
            <td><?php echo $bemail;?></td>
            <td><?php echo $rest_name;?></td>
            <td><?php echo date('m-d-Y',strtotime($data['booking_date']));?></td>
            <td><?php echo $data['booking_time'];?></td>
            <td><?php echo $data['booking_pax'];?></td>
            <td>$<?php echo $data['booking_deposite'];?></td>
            <td><?php echo $bdate;?></td>
            <td><?php echo $btime;?></td>
            <td>

                <a href="<?php echo site_url('admin/view_booking_detail/'.$data['booking_id']);?>" class="view_btn">
                    <img src="assets/images/eye_full.svg" alt="">View
                </a>
            </td>
        </tr>
        <?php }
}
else{
?>
<tr class="not-found">
        <td colspan="12" style="text-align:center;padding:10px;">No Records Found.</td>
    </tr>
<?php } ?>
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links();?>