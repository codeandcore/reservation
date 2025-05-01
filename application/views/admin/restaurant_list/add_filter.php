<div class="add_fillter">
    <div class="head_top_reservation">
        <h2>Filter</h2>
        <a href="javascript:;" class="close_btn">
            <img src="<?php echo base_url(); ?>/uploads/assets/images/cross-icon.svg" alt="">
        </a>
    </div>
    <form action="<?php echo site_url('admin/insert_filter');?>" method="post" id="restro_admin_filter_form"
        enctype="multipart/form-data">
        <div class="wrap_reservation_list">
            <div class="form-group row addFilterItem addNewFilter">
                <div class="col-2">
                    <h5>Add Filter:</h5>
                </div>
                <div class="col-3">
                    <h5>Add Filter Icon: 
                        <span class="tooltip" data-toggle="tooltip">
                            <sapn class="tooltipBtn"><img src="<?php echo base_url(); ?>/uploads/assets/images/info_icon.svg" alt=""></sapn>
                            <span class="tooltipText">Icon size is 15x15</span>
                        </span>
                    </h5>
                    <div class="file_upload">
                        <div class="file_upload_wrapper fileinput-button">
                            <img src="<?php echo base_url(); ?>/uploads/assets/images/g2158.svg" alt="">
                            <h6>Drag & browse file</h6>
                            <input type="file" name="filter_main_icon" data-max_length="20"
                                class="files_in upload__inputfile">
                        </div>
                        <div class="upload__img-wrap"></div>
                    </div>
                </div>
                <div class="col-7">
                    <h5>Enter Filter Category</h5>
                    <div class="addFilterItem_buttons d-flex align-items-top">
                        <input type="text" name="filter_main_category" placeholder="Enter Filter Category"
                            class="form-item1">
                        <input type="button" value="ADD" class="add_new_fillte btn">
                    </div>
                    <div class="added_values d-flex no-listed" id="add_table_list">

                    </div>
                </div>
            </div>
            <?php if(!empty($filters)){
            foreach($filters as $main_key => $filter){?>
            <div class="form-group row addFilterItem">
                <div class="col-4">
                    <h5>
                    <?php if($filter['filter_icon'] != ''){?>
                    <i><img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $filter['filter_icon'];?>" alt=""></i> 
                    <?php } ?>
                    <?php echo str_replace('_',' ',$filter['filter_name']);?> : </h5>
                </div>
                <div class="col-8">
                    <div class="addFilterItem_inputs d-flex align-items-top">
                        <input type="text" placeholder="Enter <?php echo str_replace('_',' ',$filter['filter_name']);?>" class="form-item" data-type="<?php echo $filter['filter_name'];?>">
                        <input type="button" value="ADD" class="add_value btn"> 
                        <input type="button" value="DELETE" class="delete_value btn btn-red" data-filterid="<?php echo $filter['id'];?>"> 
                    </div>
                    <div class="added_values d-flex no-listed" id="add_table_list"></div>
                </div>
            </div>
           <?php } }?>
        </div>
        <div class="footer_reservation">
            <input type="submit" value="SAVE" class="btn">
        </div>
    </form>
</div>
<script>
    $(document).on('click', '.delete_value', function(e) {
        var filter_id = $(this).attr('data-filterid');
        var _parent = $(this).parents('.addFilterItem');
        Swal.fire({
            title: 'Do you want to delete this filter?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                        url: '<?php echo base_url();?>index.php/admin/remove_filter_permanent',
                        type: "post",
                        data: {filter_id:filter_id},
                        success: function(data) {
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