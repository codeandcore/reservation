<div class="page has-sidebar-right height-full">

    <header class="blue accent-3 relative nav-sticky">

        <div class="container-fluid text-white">

            <div class="row p-t-b-10">

                <div class="col">

                    <h4> <i class="icon-table"></i> צור תשלום</h4>

                </div>

            </div>


        </div>

    </header>



    <div class="containers">

        <section class="paper-card">

            <div class="tab-content" id="v-pills-tabContent">

                <div class="content-wrapper animatedParent animateOnce pt-0">

                    <div class="box" id="dataList">

                        <table id="table_id1" class="displays table table-striped">

                            <thead>

                                <tr>

                                    <th>מס'</th>

                                    <th>שם החברה</th>

                                    <th>שם הבניין</th>

                                    <th>שם הדירה</th>

                                    <th>שם משפחה</th>

                                    <th>מספר טלפון</th>

                                    <th>כתובת דוא"ל</th>

                                    <th>סה"כ</th>

                                    <th>מצב הזמנה</th>

                                    <th>תאריך יצירה</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php $i = 1;

                                    if(!empty($booking_list)):

                                    foreach($booking_list as $user){ ?>

                                <tr>

                                    <td><?php echo $i; ?></td>

                                    <td><?php echo $user['cmp_name']; ?></td>

                                    <td><?php echo $user['building_name'];?></td>

                                    <td><?php echo $user['appartment_name'];?></td>

                                    <td><?php echo $user['family_name'];?></td>

                                    <td><?php echo $user['phone_number'];?></td>

                                    <td><?php echo $user['email_address'];?></td>

                                    <td><?php echo $user['sum'];?></td>

                                    <td><?php if($user['status']=='0'){ echo 'ממתין ל';}else if($user['status']=='1'){ echo 'הושלם';}else{ echo 'לבטל';}?>
                                    </td>

                                    <td><?php echo date('d-m-Y',strtotime($user['created_date']));?></td>

                                </tr>

                                <?php $i++; } endif;?>

                            </tbody>

                        </table>

                        <?php echo $this->ajax_pagination->create_links(); ?>

                    </div>

                    <div class="sort_div">

                        <label>הופעה <select name="entry_limit" id="entry_limit" aria-controls="example"
                                class="entry_limit">

                                <option value="10">10</option>

                                <option value="25">25</option>

                                <option value="50">50</option>

                                <option value="100">100</option>

                            </select> ערכים</label>

                    </div>

                </div>

            </div>

        </section>

    </div>

</div>

<div class="modal fade" id="modal_payment_iframe" tabindex="-1" role="dialog" aria-labelledby="modalCreateMessage">

    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:412px;">

        <div class="modal-content b-0">

            <div class="modal-body no-p no-b">

                <div id="meshulam_iframe_response"><iframe src="" id="iframe_meshualm" height="467px"
                        width="100%"></iframe>

                    <div id="meshulam_error"></div>

                </div>

                <script>
                jQuery(document).ready(function() {

                    window.addEventListener('message', function(e) {

                        console.log(e.data);

                        if (e.data.hasOwnProperty("MeshulamActiveLoader_nauK1M54J") && e.data

                            .MeshulamActiveLoader_nauK1M54J == 1) {

                            jQuery('.payment_loader').css('display', 'flex');

                        }

                        if (e.data.hasOwnProperty("MeshulamCancelBitPayment_nauK1M54J") || e.data ==

                            'MeshulamCancelBitPayment_nauK1M54J') {

                            window.top.location.href = "";

                        }

                        if (e.data.hasOwnProperty("iframeError")) {

                            jQuery('.payment_loader').css('display', 'none');

                            <?php

								$p_title="הפעולה נכשלה";

								$p_short_d="נא לבדוק שפרטי הכרטיס נכונים";

								$p_home="בית";

								$p_card="עגלה";

							?>

                            const popup = `<div class="meshulam_order_page"><div class="popup_content">

								<h1><?php echo $p_title; ?></h1>

								<div class="text">

									<!-- <p><?php echo $p_short_d; ?></p> -->

									<p>${e.data.iframeError.message}</p>

								</div>

								<a href="<?php echo site_url(); ?>

								"><?php echo $p_home; ?></a>

							</div></div>`;

                            jQuery(popup).insertAfter("#meshulam_iframe_response");

                        }

                    });

                });
                </script>

            </div>



        </div>

    </div>

</div>

<script>
jQuery(document).ready(function() {

    jQuery(document).on('change', '#company_dropdown', function() {

        var cmp_id = $(this).val();

        if (cmp_id != '') {

            var ajax_url = "<?=site_url('admin/');?>";

            $.ajax({

                url: ajax_url + 'get_json_building_list_by_companyid',

                type: 'post',

                data: {

                    cmp_id: cmp_id

                },

                success: function(response) {

                    $("#building_dropdown").html(response);

                }

            });

        }

    });

    jQuery(document).on('change', '#building_dropdown', function() {

        var build_id = $(this).val();

        if (build_id != '') {

            var ajax_url = "<?=site_url('admin/');?>";

            $.ajax({

                url: ajax_url + 'get_json_appartment_list_by_companyid',

                type: 'post',

                data: {

                    build_id: build_id

                },

                success: function(response) {

                    $("#appartment_id").html(response);

                }

            });

        }

    });

    jQuery(document).on('change', '#appartment_id', function() {

        var apar_id = $(this).val();

        if (apar_id != '') {

            var ajax_url = "<?=site_url('admin/');?>";

            $.ajax({

                url: ajax_url + 'get_appartment_detail_by_appartment_id',

                type: 'post',

                data: {

                    apar_id: apar_id

                },

                success: function(response) {

                    if (response) {

                        var json = JSON.parse(response);

                        $('#family_name').val(json.family_name);

                        $('#cmp_name').val(json.cmp_name);

                        $('#building_name').val(json.building_name);

                        $('#appartment_name').val(json.apartment_name);

                        $('#phone_number').val(json.phone);

                        $('#email_address').val(json.email_address);

                        $('#monthly_price').val(json.price);

                        $('#sum').val(json.price);

                    }

                }

            });

        }

    });

});
</script>

<script>
jQuery(document).ready(function() {

    $('input[type=radio][name=billing_type]').on('change', function() {

        var value = $(this).val();

        if (value == 'monthly') {

            $("input:radio[value='credit']").prop('checked', true);

            $("#payment_number_div").show();

            $(".credit_label").show();

            $(".bit_label").hide();

            $(".apple_label").hide();

        } else {

            $("#payment_number_div").hide();

            $(".credit_label").show();

            $(".bit_label").show();

            $(".apple_label").show();

        }

    });

    $("#payment_form").submit(function(e) {

        e.preventDefault();

        $('#meshulam_error').html('');

        $('#iframe_meshualm').attr('src', '');

        var form = $(this);

        var url = "<?=site_url('admin/ajax_insert_payment_details')?>";

        $.ajax({

            type: "POST",

            url: url,

            data: form.serialize(),

            success: function(data) {

                var json = JSON.parse(data);

                if (json.response == 'failure') {

                    $('#modal_payment_iframe').modal({

                        backdrop: 'static',

                        keyboard: false

                    });

                    $('#iframe_meshualm').remove();

                    $('#meshulam_error').html(json.message);

                } else if (json.status == 1) {

                    $('#modal_payment_iframe').modal({

                        backdrop: 'static',

                        keyboard: false

                    });

                    $('#iframe_meshualm').attr('src', json.data.url);

                } else if (json.status == 0) {

                    $('#modal_payment_iframe').modal({

                        backdrop: 'static',

                        keyboard: false

                    });

                    $('#iframe_meshualm').remove();

                    $('#meshulam_error').html(json.err.message);

                }

            }

        });

    });

});
</script>

<script>
jQuery(document).ready(function() {

    jQuery(document).on('change', '#entry_limit', function() {

        booking_list_filter(0);

    });

});



function booking_list_filter(page_num) {

    page_num = page_num ? page_num : 0;

    var url = "<?=site_url('admin/')?>";

    var entry_limit = $('#entry_limit').val();

    $.ajax({

        type: 'POST',

        url: url + 'ajax_booking_list/' + page_num,

        data: 'page=' + page_num + '&entry_limit=' + entry_limit,

        beforeSend: function() {

            $('.loading').show();

        },

        success: function(html) {

            $('#dataList').html(html);

            $('.loading').fadeOut("slow");

        }

    });

}
</script>