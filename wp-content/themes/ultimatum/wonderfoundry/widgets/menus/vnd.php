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
	<div class="vertical-menu">
	<?php
	$only_related = ( $instance['only_related'] == 2 || $instance['only_related'] == 3 )? new Ultimatum_Related_Sub_Items_Walker : new Walker_Nav_Menu;
	$strict_sub = $instance['only_related'] == 3 ? 1 : 0;
	$depth = $instance['depth'] ? $instance['depth'] : 0;
	wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'walker' => $only_related, 'depth' => $depth, 'strict_sub' => $strict_sub, ) );
	?>
	</div>
</div>
<?php 
