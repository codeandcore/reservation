<?php 
 $filter_ary = [];
 $property_type = '';
if(isset($data)){
    $property_type = $data['property_type'];
}
if(isset($selected_filters)){
    $ary = $selected_filters;
    if(!empty($ary)){
        foreach($ary as $dkt){
            $filter_ary[$dkt['filter_type']][] = $dkt['filter_value'];
        }
    }
}
?>
<div class="filterList">
    <div class="filterItem">
        <div class="filterItemTitle">Property type</div>
        <div class="filterItemList">
            <div class="custom-radio">
                <input type="radio" id="radio1" name="property_type" class="radioInput" value="" <?php if($property_type == ''){ echo 'checked';}?>>
                <label class="radioLabel" for="radio1">All Restaurants</label>
            </div>
            <div class="custom-radio">
                <input type="radio" id="radio2" name="property_type" value="on" class="radioInput" <?php if($property_type == 'on'){ echo 'checked';}?>>
                <label class="radioLabel" for="radio2">On - Property
                    Restaurant</label>
            </div>
            <div class="custom-radio">
                <input type="radio" id="radio3" name="property_type" value="off" class="radioInput" <?php if($property_type == 'off'){ echo 'checked';}?>>
                <label class="radioLabel" for="radio3">Off - Property
                    Restaurant</label>
            </div>
        </div>
    </div>
    <?php if(!empty($filters)){
        foreach($filters as $main_key => $filter){
        $filter_name = $filter['filter_name'];
        $filter_value = array_filter(explode(',',$filter['filter_value']));
        $title = str_replace('_',' ',$filter['filter_name']);
        $slug = $filter['filter_name'];
        $title = str_replace('-',' ',$title);

        if ($slug == 'establishment_type' && $this->settings['restaurant_establishment_hide'] == 'yes') {
            continue;
        }
        if ($slug == 'meals' && $this->settings['restaurant_meals_hide'] == 'yes') {
            continue;
        }
        
        ?>
<?php if(!empty($filter_value)){?>        
    <div class="filterItem">
        <div class="filterItemTitle"><?php echo ucfirst($title);?></div>
        <div class="filterItemList">
            <?php 
                foreach($filter_value as $key => $tag){?>
            <div class="custom-checkbox">
                <input type="checkbox" class="checkboxInput" name="filter_type[<?php echo $filter_name;?>][]" id="check<?php echo $main_key.$key;?>" value="<?php echo $tag;?>" <?php if (array_key_exists($filter_name,$filter_ary) && in_array($tag, $filter_ary[$filter_name])){ echo 'checked';} ?> >
                <label class="checkboxLabel" for="check<?php echo $main_key.$key;?>"><?php echo $tag;?></label>
            </div>
            <?php }  ?>
        </div>
    </div>
    <?php } } } ?>
</div>