<table class="table_class" id="total_reservation2" width="100%">
    <thead>
        <tr>
            <th></th>
            <th>User email</th>
            <th>User name</th>
            <th>User contact</th>
            <th>Reservervation status</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($list)){
                                foreach ($list as $key => $data) {
                                ?>
        <tr>
            <td></td>
            <td><?php echo $data['email'];?></td>
            <td><?php echo $data['full_name'];?></td>
            <td><?php echo $data['mobile_number'];?></td>
            <td>No Response</td>
        </tr>
        <?php } 
        } 
        else{
        ?>
        <tr class="not-found">
            <td colspan="5" style="text-align:center;padding:10px;">No Records Found.</td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links();?>