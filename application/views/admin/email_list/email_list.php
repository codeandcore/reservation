<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-between">
                <h2 class="heading_title">email list</h2>
                
            </div>
            <div class="wrap_table withLeftButtons action_class">
                <div class="defaultDataTable">
                    <table class="table_class" id="all_email_list" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Email Name</th>
                                <th>Email Subject</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; 
                            if(!empty($list)){
                                foreach($list as $data){
                                ?>
                            <tr>
                                <td></td>
                                <td><?php echo $i;?></td>
                                <td><?php echo $data['email_name'];?></td>
                                <td><?php echo $data['email_subject'];?> </td>
                                <td>
                                    <a href="javascript:void(0)" class="drop_dots">
                                        <img src="<?php echo base_url(); ?>/uploads/assets/images/three_dots.svg" alt="">
                                    </a>
                                    <ul class="action_drop">
                                        <li>
                                            <a href="<?php echo site_url('admin/edit_email/'.$data['id']);?>">
                                                <img src="<?php echo base_url(); ?>/uploads/assets/images/edit.svg" alt="">
                                                Edit
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </td>
                            </tr>
                            <?php $i++; } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>