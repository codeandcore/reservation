<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="heading_title">admin list(<?php echo $total_count;?>)</h2>
            <?php echo $message = $this->session->flashdata('message');?>
            <?php
             if ($this->session->flashdata('alert-danger')) { ?>
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('alert-danger')[0]; ?>
    </div>
<?php } ?>
            <div class="wrap_table withLeftButtons action_class">
                <div class="leftButtonsRow">
                    <a href="<?php echo site_url('admin/add_admin'); ?>" class="btn btn_add">Add Admin</a>
                </div>
                <div class="defaultDataTable">
                    <table class="table_class" id="all_admin_list" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Admin email</th>
                                <th>Admin name</th>
                                <th>Admin contact</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list)){
                                foreach($list as $data){
                                    $explode = explode(' ',$data['full_name']);
                                    if(!empty($explode)){
                                        $first_name = $explode[0];
                                        if(array_key_exists('1',$explode)){
                                        $last_name = $explode[1];
                                        }
                                        else{
                                            $last_name = '';
                                        }
                                    }
                                ?>
                            <tr>
                                <td></td>
                                <td><?php echo $data['email'];?></td>
                                <td><?php echo $data['full_name'];?> </td>
                                <td><?php echo $data['mobile_number'];?></td>
                                <td>
                                    <a href="javascript:void(0)" class="drop_dots">
                                        <img src="<?php echo base_url(); ?>/uploads/assets/images/three_dots.svg" alt="">
                                    </a>
                                    <ul class="action_drop">
                                    <li>
                                        <a href="javascript:void(0);" class="edit_admin_btn"  data-popup="editAdmin" data-firstname="<?php echo $first_name;?>" data-lastname="<?php echo $last_name;?>" data-email="<?php echo $data['email'];?>" data-altemail="<?php echo $data['alternate_email'];?>" data-phone="<?php echo $data['mobile_number'];?>" data-href="<?php echo site_url('admin/update_admin/'.$data['id']);?>">
                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/edit.svg" alt="">
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" data-userid="<?php echo $data['id'];?>" class="deleteRow deleteuseradmin">
                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/trash.svg" alt="">
                                            Delete
                                        </a>
                                    </li>
                                    <li>
                                            <a href="javascript:void(0);" data-popup="resetpasswordAdmin" data-userid="<?php echo $data['id'];?>" data-useremail="<?php echo $data['email'];?>" data-href="<?php echo site_url('admin/reset_password_admin/'.$data['id']);?>" class="reset_user_password">
                                                <img src="<?php echo base_url(); ?>/uploads/assets/images/setting_active.svg" alt="">
                                                Send Temporary Password
                                            </a>
                                    </li>
                                </ul>
                                </td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var adminList = $("#all_admin_list").DataTable({
    language: {
        sLengthMenu: "Show Entries: _MENU_",
        searchPlaceholder: "Please search here..."
    },
    dom: '<"#top_filter"lf>rt<"#bottom_page"ip><"clear">',
    "responsive": true,
  });
    $(document).on('click', '.deleteuseradmin', function(e) {
        var user_id = $(this).attr('data-userid');
        var _parent = $(this).parents('tr');
        Swal.fire({
            title: 'Do you want to delete this admin?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                        url: '<?php echo base_url();?>index.php/admin/delete_user_admin',
                        type: "post",
                        data: {user_id:user_id},
                        success: function(data) {
                            adminList.row(_parent).remove();
                            $(_parent).remove();
                            Swal.fire('Deleted!', '', 'success')
                        }
                    });
            } else if (result.isDenied) {
                // Swal.fire('Changes are not saved', '', 'info')
            }
        })
    });



    
</script>