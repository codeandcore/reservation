<table class="table_class" id="total_reservation1" width="100%">
    <thead>
        <tr>
            <th></th>
            <th>User email</th>
            <th>IP</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <?php if(!empty($list)){?>
    <tbody>
        <?php foreach($list as $data):?>
        <tr>
            <td></td>
            <td><?php echo $data['email'];?></td>
            <td><?php echo $data['ip'];?></td>
            <td></td>
            <td></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    <?php }
    else{ ?>
    <tr class="not-found">
        <td colspan="5" style="text-align:center;padding:10px;">No Records Found.</td>
    </tr>
    <?php } ?>
</table>
<?php echo $this->ajax_pagination->create_links();?>