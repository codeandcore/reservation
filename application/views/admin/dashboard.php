<?php $dates = $this->admin_model->get_dates_list_booking();?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="dash_top_wrapp">
                <div class="recent_booking">
                    <h2 class="heading_title">Recent Booking</h2>
                    <div class="wrap_table recent_booking_table action_class">
                        <div class="defaultDataTable">
                            <table class="table_class" id="recent_booking" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Id</th>
                                        <th>User name</th>
                                        <th>User email</th>
                                        <th>User contact</th>
                                <?php if(!empty($dates)){
                                    foreach($dates as $date){?>
                                        <th><?php echo date('m-d-Y',strtotime($date['date']));?></th>
                                <?php }
                                } ?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                        <?php if(!empty($recent)){
                            foreach($recent as $data){
                                $udata = $this->admin_model->get_user_detail($data['user_id']);
                                ?>
                                    <tr>
                                        <td></td>
                                        <td><?php echo $data['id'];?></td>
                                        <td><?php echo $udata['full_name'];?></td>
                                        <td><?php echo $udata['email'];?></td>
                                        <td><?php echo $udata['mobile_number'];?></td>
                                        <?php if(!empty($dates)){
                                foreach($dates as $date){
                                    $status = $this->admin_model->get_status_of_booking_date_byid($data['id'],$date['date']);
                                    ?>
                                        <td><?php echo $status;?></td>
                                <?php }
                                    } ?>
                                        <td>
                                        <a href="<?php echo site_url('admin/view_booking_detail/'.$data['id']);?>">
                                                        <img src="<?php echo base_url(); ?>/uploads/assets/images/view.svg" alt="">
                                                        View
                                        </a>
                                            <!-- <a href="javascript:void(0)" class="drop_dots">
                                                <img src="<?php //echo base_url(); ?>/uploads/assets/images/three_dots.svg" alt="">
                                            </a>
                                            <ul class="action_drop">
                                                <li>
                                                    <a href="#">
                                                        <img src="<?php //echo base_url(); ?>/uploads/assets/images/edit.svg" alt="">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php //echo site_url('admin/view_booking_detail/'.$data['id']);?>">
                                                        <img src="<?php //echo base_url(); ?>/uploads/assets/images/view.svg" alt="">
                                                        View
                                                    </a>
                                                </li>
                                            </ul> -->
                                        </td>
                                    </tr>
                        <?php }
                        } ?>            
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="activity_box_wrapper">
                    <h2 class="heading_title">Activity</h2>
                    <div class="activity_box background_light_green">
                        <div id="activity_chart"></div>
                    </div>
                </div>
            </div>
            <div class="bottom_wrapp">
                <div class="booking_list_wrapper">
                    <div class="booking_list_box">
                        <span>
                            <img src="<?php echo base_url(); ?>/uploads/assets/images/h_icon1.svg" alt="">
                        </span>
                        <h4>Add Restaurant <br />
                            For trip</h4>
                        <div class="eye_button">
                            <svg id="Component_28_1" data-name="Component 28 – 1" xmlns="http://www.w3.org/2000/svg"
                                width="32.5" height="32.5" viewBox="0 0 32.5 32.5">
                                <path id="Path_83" data-name="Path 83"
                                    d="M160.5,145.393H145.266V160.5h-2.158V145.393H128v-2.158h15.107V128h2.158v15.234H160.5Z"
                                    transform="translate(-128 -128)" fill="#fff" />
                            </svg>
                        </div>
                        <a href="<?php echo site_url('admin/add_restaurant');?>" class="stretched-link"></a>
                    </div>
                    
                    <div class="booking_list_box">
                        <span>
                            <img src="<?php echo base_url(); ?>/uploads/assets/images/h_icon2.svg" alt="">
                        </span>
                        <h4>Add New<br /> User</h4>
                        <div class="eye_button">
                            <svg id="Component_28_1" data-name="Component 28 – 1" xmlns="http://www.w3.org/2000/svg"
                                width="32.5" height="32.5" viewBox="0 0 32.5 32.5">
                                <path id="Path_83" data-name="Path 83"
                                    d="M160.5,145.393H145.266V160.5h-2.158V145.393H128v-2.158h15.107V128h2.158v15.234H160.5Z"
                                    transform="translate(-128 -128)" fill="#fff" />
                            </svg>
                        </div>
                        <a href="javascript:void(0)" class="stretched-link btn_add" data-popup="addUser"></a>
                    </div>

                    <div class="booking_list_box">
                        <span>
                            <img src="<?php echo base_url(); ?>/uploads/assets/images/h_icon3.svg" alt="">
                        </span>
                        <h4>View all <br />booking</h4>
                        <div class="eye_button">
                            <svg id="Component_17_1" data-name="Component 17 – 1" xmlns="http://www.w3.org/2000/svg"
                                width="36.544" height="23.493" viewBox="0 0 36.544 23.493">
                                <g id="Group_108" data-name="Group 108">
                                    <path id="Path_91" data-name="Path 91"
                                        d="M20.272,30.493A20.213,20.213,0,0,1,5.437,23.852a1.305,1.305,0,0,1,1.908-1.782,17.625,17.625,0,0,0,12.928,5.812c6.216,0,11.941-3.4,15.453-9.136C32.214,13.01,26.489,9.61,20.272,9.61c-6.445,0-12.362,3.656-15.831,9.779A1.305,1.305,0,1,1,2.17,18.1C6.107,11.15,12.876,7,20.272,7s14.165,4.15,18.1,11.1a1.3,1.3,0,0,1,0,1.286C34.437,26.341,27.67,30.493,20.272,30.493Z"
                                        transform="translate(-2 -7)" fill="#fff" />
                                </g>
                                <g id="Group_109" data-name="Group 109" transform="translate(11.746 5.221)">
                                    <path id="Path_92" data-name="Path 92"
                                        d="M17.526,24.052a6.526,6.526,0,1,1,6.526-6.526A6.533,6.533,0,0,1,17.526,24.052Zm0-10.441a3.915,3.915,0,1,0,3.915,3.915A3.92,3.92,0,0,0,17.526,13.61Z"
                                        transform="translate(-11 -11)" fill="#fff" />
                                </g>
                            </svg>
                        </div>
                        <a href="<?php echo site_url('admin/all_booking_list');?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Responsive.js"></script>
<script>
        var root = am5.Root.new("activity_chart");
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        var chart = root.container.children.push(am5percent.PieChart.new(root, {
            layout: root.verticalLayout,
            width: am5.percent(100),
            height: am5.percent(100),
            innerRadius: am5.percent(60)
        }));

        var series = chart.series.push(am5percent.PieSeries.new(root, {
            valueField: "value",
            categoryField: "category",
            alignLabels: true
        }));

        var tooltip = am5.Tooltip.new(root, {
            getFillFromSprite: false,
            getStrokeFromSprite: true,
            autoTextColor: false,
            getLabelFillFromSprite: true,
            labelText: "[bold #70016a]{category}[/]\n[#152850]{value}"
        });
            tooltip.get("background").setAll({
            fill: am5.color(0xffffff),
            fillOpacity: 1
        });

        series.get("colors").set("colors", [
            am5.color("#F7B84B"),
            am5.color("#0AB39C"),
            am5.color("#F06548")
        ]);

        series.set("tooltip", tooltip);

        <?php 
            $pending = $this->admin_model->get_pending_booking_list();
            $pending_count = count($pending);
            $partial = $this->admin_model->get_partial_booking_list();
            $partial_count = count($partial);
            $complete = $this->admin_model->get_complete_booking_list();
            $complete_count = count($complete);
        ?>
        // Set data
        series.data.setAll([
            {value: <?php echo $partial_count;?>,category: "Total \n partial \n Reservation"},
            {value: <?php echo $complete_count;?>,category: "Total \n Complete \n Reservervation"},
            {value: <?php echo $pending_count;?>,category: "Pending \n Reservation" }
        ]);

        

        series.labels.template.setAll({
            fontSize: 14,
            fill: am5.color("#70016a"),
            text: "{category}"
        });
        series.labels.template.set("text", "[900 16 #70016a]{valuePercentTotal.formatNumber('0.00')}% \n  [400 13 #70016a]{category} ");

        series.labels.template.setAll({
            maxWidth: 100,
            oversizedBehavior: "truncate" 
        });
        // Play initial series animation
        series.appear(1000, 100);
    </script>