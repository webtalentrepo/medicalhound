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
wp_enqueue_script('menu-ddsmooth');
?>
<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function($) {
		ddsmoothmenu.init({
			mainmenuid: "<?php echo $this->id.'-item'; ?>",
			orientation: '<?php echo $instance['menustyle']; ?>',
			classname: 'ddsmoothmenu<?php echo $instance['menustyle']; ?>',
			contentsource: "markup"
		})
	});
	//]]>
</script>
<div class="ultimatum-nav">
<div class="ddsmoothmenu<?php echo $instance['menustyle']; ?>" id="<?php echo $this->id.'-item'; ?>">
	<?php wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false ) ); ?>
</div>
</div>