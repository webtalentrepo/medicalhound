<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
 */
/*
 * 27/09/2014 Edit by Powder centered
 */
/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @package  Ultimatum
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.50
 */
wp_enqueue_script('menu-ddsmooth');
$classname='ddsmoothmenu'.$instance['menustyle'];
?>
<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function($) {
		<?php if($instance["float"]=="center") {
			$classname.=" center";
		?>
		var ddmenuwidth=jQuery("#<?php echo $this->id.'-item'; ?> > ul").width();
		jQuery("#<?php echo $this->id.'-item'; ?> > ul").css("width",(2+ddmenuwidth)+"px");
		<?php } ?>
		ddsmoothmenu.init({
			mainmenuid: "<?php echo $this->id.'-item'; ?>",
			orientation: '<?php echo $instance['menustyle']; ?>',
			classname: '<?php echo $classname; ?>',
			contentsource: "markup"
		})
	});
	//]]>
</script>
<?php 
if($instance["float"]!="center") {
	?>
<style>.ddsmoothmenuh ul {float: <?php echo $instance["float"]; ?>;}</style>
<?php 
}
?>
<div class="ultimatum-nav">
<div class=" ddsmoothmenu<?php echo $instance['menustyle']; ?>" id="<?php echo $this->id.'-item'; ?>">
	<?php wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false ) ); ?>
</div>
</div>
