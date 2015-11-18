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
?>
<div class="ultimatum-nav">
	<div class="horizontal-menu" style="float:<?php echo $instance["hndfloat"]; ?>">
	 	<?php wp_nav_menu( array( 'depth'=>1,'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false ) ); ?>
	</div>
</div>