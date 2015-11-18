<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
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
wp_enqueue_script('jquery-hoverIntent');
wp_enqueue_script('menu-hmega');

$effect = $instance['effect'];
if($effect == ''){$effect = 'fade';}
if(isset($instance['event'])) $event = $instance['event'];
if(!isset($event)){$event = 'hover';}
if(isset($instance['fullWidth']))$fullWidth = $instance['fullWidth'];
if(!isset($fullWidth)){$fullWidth = ',fullWidth: true';}
?>
<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function() {
		for (i=0;i<1;i++) {
			setTimeout('addDot()',1000);
			}
		});
		function addDot() {
			jQuery(document).ready(function($) {
				jQuery('#<?php echo $this->id.'-item'; ?> .menu').wfMegaMenu({
					rowItems: <?php echo $instance['rowItems']; ?>,
					speed: <?php echo $instance['speed'] == '0' ? 0 : "'".$instance['speed']."'"; ?>,
					effect: '<?php echo $effect; ?>',
					subMenuWidth:200
				});
			});
	}
	//]]>
</script>
<div class="ultimatum-nav">
<?php if ($instance["subMenuWidth"]){?>
<div class="wfm-mega-menu" id="<?php echo $this->id.'-item'; ?>" style="width:<?php echo $instance["subMenuWidth"];?>px;float:right">
<?php } else { ?>
<div class="wfm-mega-menu" id="<?php echo $this->id.'-item'; ?>" style="width:<?php echo $grid_width;?>px;">
<?php } 
wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false ) );
?>
</div>
</div>