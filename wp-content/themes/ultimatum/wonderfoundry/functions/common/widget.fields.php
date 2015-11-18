<?php
 /*
  * Once upon a time... @xenous get bored of writing widget fields...
  * So he decided to create this function set where widget writing was fun :)
  */

/*
 * Single field wrapper open
 */
function ult_widget_single_field_wrap_begin($wrapper,$display,$class){
    ?><<?php echo $wrapper; echo $display; if($class){ echo ' class="'.$class.'"';}?>><?php
}

/*
 * Single field wrapper close
 */
function ult_widget_single_field_wrap_end($wrapper){
    ?></<?php echo $wrapper;?>>  <?php 
}

/*
 * Shows a text field
 */
function ult_widget_field_txt($fieldid,&$curval,$title,&$that,$parent=null,$parentval=array(),$class=null,$wrapper='p'){
    $display ='';
    if($parent){
        if(!in_array ($parent , $parentval )){
            $display = ' style="display:none"';
        }
    }
    ult_widget_single_field_wrap_begin($wrapper,$display,$class); 
    ?>
        <label for="<?php echo $that->get_field_id($fieldid); ?>"><?php echo $title;  ?></label>
        <input class="widefat" type="text" name="<?php echo $that->get_field_name($fieldid); ?>" id="<?php echo $that->get_field_id($fieldid); ?>"  value="<?php echo $curval; ?>" />
    <?php
    ult_widget_single_field_wrap_end($wrapper);
    
}

/*
 * Shows a select field
 */
function ult_widget_field_select($fieldid,$options,&$curval,$title,&$that,$onchange=null,$parent=null,$parentval=array(),$class=null,$wrapper='p'){
    $display ='';
    if($parent){
        if(!in_array ($parent , $parentval )){
            $display = ' style="display:none"';
        }
    }
    ult_widget_single_field_wrap_begin($wrapper,$display,$class);
    ?>
        <label for="<?php echo $that->get_field_id($fieldid); ?>"><?php echo $title;  ?></label>
        <select class="widefat" name="<?php echo $that->get_field_name($fieldid); ?>" id="<?php echo $that->get_field_id($fieldid); ?>" <?php if($onchange){ echo ' onchange="ultgenericChange(this,\''.$onchange.'\')"';} ?>>
        <?php 
        foreach ($options as $name=>$value){
            echo '<option value="'.$value.'" '.selected($curval,$value,false).'>'.$name.'</option>';
        }
        ?>
        </select>
    <?php
    ult_widget_single_field_wrap_end($wrapper);
    
}

/*
 * function ultimatum_custcontent_inptext( $fieldid, &$currval, $title, &$that, $size = ''){

   $format ='';

   if ($size !== '' ){  $format = ' size="' .$size. '" ';  }

?>

      
      


<?php

}
 */