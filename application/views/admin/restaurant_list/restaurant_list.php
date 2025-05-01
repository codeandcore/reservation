<?php echo $message = $this->session->flashdata('message');?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="heading_title">All Restaurants</h2>
            <div class="wrap_table withLeftButtons action_class">
                <div class="leftButtonsRow">
                    <a href="<?php echo site_url('admin/add_restaurant');?>" class="btn btn_add">Add Restaurants</a>
                </div>
                <div class="defaultDataTable">
                    <table class="table_class" id="all_restaurants" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Restaurant image</th>
                                <th>Restaurant name</th>
                                <th>Website</th>
                                <th>Email</th>
                                <th>Deposit</th>
                                <th>Property type</th>
                                <th>Seating Capacity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list)){
                                foreach($list as $data){
                                    $isBook = $this->admin_model->getRestaurantIsbooked($data['id']);
                                ?>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="restaurant_img">
                                        <?php if($data['feature_image'] != ''){?>
                                            <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $data['feature_image'];?>" alt="">
                                        <?php } else{ ?>
                                            <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg"/>
                                        <?php } ?>
                                    </div>
                                    
                                </td>
                                <td><a href="<?php echo site_url('admin/edit_restaurant/'.$data['id']);?>"><?php echo $data['restaurant_name'];?></a></td>
                                <td><?php if($data['website_link']){ echo '<a href="'.$data['website_link'].'" target="_blank">'.$data['website_link'].'</a>'; }?></td>
                                <td><?php if($data['email']){?>
                                        <a href="mailto:<?php echo $data['email'];?>" class="emial_icon tooltip" data-toggle="tooltip">
                                            <span class="tooltipBtn"><img src="<?php echo base_url(); ?>/uploads/assets/images/email.svg" alt=""></span>
                                            <span class="tooltipText"><?php echo $data['email'];?></span>
                                        </a>    
                                    <?php } ?>
                                </td>
                                <td><?php if($data['deposite_amount'] > 0){ echo '$'.$data['deposite_amount']; }?></td>
                                <td><?php echo $this->admin_model->get_property_type_text($data['property_type']);?></td>
                                <td><?php echo $this->admin_model->get_total_seating_capacity_restaurant($data['id']);?></td>
                                <td>
                                    <a href="javascript:void(0)" class="drop_dots">
                                        <img src="<?php echo base_url(); ?>/uploads/assets/images/three_dots.svg" alt="">
                                    </a>
                                    <ul class="action_drop">
                                        <li>
                                            <a href="<?php echo site_url('admin/edit_restaurant/'.$data['id']);?>">
                                                <img src="<?php echo base_url(); ?>/uploads/assets/images/edit.svg" alt="">
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('admin/view_restaurant/'.$data['id']);?>">
                                                <img src="<?php echo base_url(); ?>/uploads/assets/images/view.svg" alt="">
                                                View
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="btn-dlt-rest deleteRow" data-restid="<?php echo $data['id'];?>" data-booked="<?php if($isBook){echo 'booked';} ?>">
                                                <img src="<?php echo base_url(); ?>/uploads/assets/images/trash.svg" alt="" >
                                                Delete
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