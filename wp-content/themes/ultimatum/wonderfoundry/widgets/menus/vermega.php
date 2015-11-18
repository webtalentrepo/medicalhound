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
wp_enqueue_script('menu-vmega');
$effect = $instance['veffect'];
if($effect == ''){$effect = 'fade';}
$direction = $instance['vdirection'];
if($direction == ''){$direction = 'right';}
?>
<script type="text/javascript">
	//<![CDATA[
		jQuery(document).ready(function($) {
			jQuery('#<?php echo $this->id.'-item'; ?> .menu').dcVerticalMegaMenu({
				rowItems: <?php echo $instance['vrowItems']; ?>,
				speed: '<?php echo $instance['vspeed']; ?>',
				direction: '<?php echo $direction; ?>',
				effect: '<?php echo $effect; ?>'
			});
		});
	//]]>
</script>
<div class="ultimatum-nav">
	<div class="wfm-vertical-mega-menu" id="<?php echo $this->id.'-item'; ?>">
		<?php wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false ) ); ?>
	</div>
</div>
