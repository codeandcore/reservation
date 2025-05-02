<?php
if(array_key_exists('trip_title',$this->settings) && $this->settings['trip_title'] != ''){ 
    $trip_title = $this->settings['trip_title'];
} else {
    $trip_title = 'Bahamas trip';
}
?>
<main>
    <section class="banner banner-lg" style="background-image: url(<?php echo base_url(); ?>/uploads/front/images/banner-bg.jpg);">
        <div class="container">
            <h1 class="d-none"><?php echo $this->settings['site_title'];?></h1>
        </div>
    </section>

    <section class="booking-section">
        <div class="container">
            <div class="innerSearchForm">
                <h3>Welcome to the <?php echo $trip_title;?> restaurant reservation request portal.<br>Please request your restaurant reservations below.</h3>
                <form action="<?php echo site_url('reservation');?>" class="bookingForm">
                    <div class="row">
                        <div class="col">
                            <div class="findInput dateInput">
                                <label class="inputlabel" for="book_date">Select Date</label>
                                <select name="book_date" id="book_date" class="form-control cmnSelect">
                                    <?php foreach($dates_list as $list){?>
                                    <option value="<?php echo date('d-m-Y',strtotime($list['date']));?>"><?php echo date('m-d-Y',strtotime($list['date']));?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="findInput timeInput">
                                <label class="inputlabel" for="book_time">Select Time</label>
                                <select name="book_time" id="book_time" class="form-control cmnSelect">
                                <option value="">Any Time</option>
                                <?php foreach($time_list as $list){?>
                                    <option value="<?php echo $list['time'];?>"><?php echo $list['time'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="findInput personInput">
                            <label class="inputlabel" for="book_persons">Select People</label>
                                <select name="book_persons" id="book_persons" class="form-control cmnSelect">
                                <?php foreach($pax_list as $list){?>
                                    <option value="<?php echo $list['size'];?>"><?php echo $list['size'];?> People</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="findInput">
                                <button type="submit" class="btn" data-target="findRestro">Reserve</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="relevantRestaurant" style="display:none;">
        <div class="container">
            <div class="sliderTitle">
                <h2>Relevant Restaurant</h2>

                <div class="swiper-buttons">
                    <div class="swiper-button-next"><img
                            src="<?php echo base_url(); ?>/uploads/front/images/right-line-arrow.svg" alt=""></div>
                    <div class="swiper-button-prev"><img
                            src="<?php echo base_url(); ?>/uploads/front/images/left-line-arrow.svg" alt=""></div>
                </div>
            </div>

            <div class="swiper restaurantSlider">
                <div class="swiper-wrapper">
                    <?php foreach($hotels_list as $hotel){?>
                    <div class="swiper-slide">
                        <div class="slideItem">
                            <a href="javascript:void(0)" class="itemView restaurant-modal-button" data-rest_id="<?php echo $hotel['id'];?>" data-target="viewDetails">
                                <img src="<?php echo base_url(); ?>/uploads/front/images/eye-icon.svg" alt="">
                            </a>
                            <div class="itemImg">
                                <?php if($hotel['feature_image'] != ''){?>
                                <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $hotel['feature_image'];?>"
                                    alt="">
                                <?php } else{ ?>
                                    <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg"
                                    alt="">
                                <?php } ?>
                            </div>
                            <div class="itemDetails">
                                <h5><?php echo $hotel['restaurant_name'];?></h5>
                                <div class="itemArea"><?php echo $this->admin_model->get_property_type_text($hotel['property_type']);?></div>
                            </div>
                            <a href="javascript:void(0)" class="fullHyperlink restaurant-modal-button" data-rest_id="<?php echo $hotel['id'];?>" data-target="viewDetails"></a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

</main>