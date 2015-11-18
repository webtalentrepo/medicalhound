<?php 
/*
 * Ultimatum Sidr Menu
 */
if($instance['menustyle'] !='sidr') {?>
<div class="ultimatum-responsive-menu">
<?php } ?>
<a id="<?php echo $this->id.'-responsive';?>" href="#<?php echo $this->id.'-resonsive-sidr';?>"  <?php if ($instance['sidr_position']=='right'){echo ' style="float:right"'; }?> class="sidr-toggler"><i class="fa fa-bars"></i></a>

<div id="<?php echo $this->id.'-responsive-sidr';?>" <?php if($instance['sidr_type']=='dark') echo ' class="dark-sidr"';?>>
<?php
if( is_active_sidebar($instance['sidr_top_widget'] ) ) {
    $item_output .= '<div class="ultimatum-sidr-top-widget">';
    ob_start();
    dynamic_sidebar( $instance['sidr_top_widget'] );

    $item_output .= ob_get_clean() . '</div>';
}
echo $item_output;
wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false ,'menu_id'=> $this->id.'-resonsive') );
if( is_active_sidebar($instance['sidr_bottom_widget'] ) ) {
    $item_output2 .= '<div class="ultimatum-sidr-bottom-widget">';
    ob_start();
    dynamic_sidebar( $instance['sidr_bottom_widget'] );

    $item_output2 .= ob_get_clean() . '</div>';
}
echo $item_output2;
?>
</div>
<?php if($instance['menustyle'] !='sidr') {?>
</div>
<?php } ?>
<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function() {
		jQuery('#<?php echo $this->id.'-responsive';?>').sidr({
		    name: "<?php echo $this->id.'-responsive-sidr';?>",
		    <?php if ($instance['sidr_position']=='left'): ?>
		    side: "left" 
		    <?php else: ?>
		    side: "right"
		    <?php endif;?>
		  });

		});
	//]]>
</script>
