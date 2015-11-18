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
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<?php do_action('ultimatum_after_head_open'); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php do_action( 'ultimatum_meta' ); ?>
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php do_action('ultimatum_before_wp_head');?>
	<?php wp_head(); ?>
	<?php if(get_ultimatum_option('scripts', 'head_scripts')){
        $text = stripslashes(get_ultimatum_option('scripts', 'head_scripts'));
        ob_start();
        eval('?>'.$text);
        $text = ob_get_contents();
        ob_end_clean();
        echo $text;
    }
    echo "\n";
    ?>
	<?php do_action('ultimatum_before_head_close');?>	 
</head>
<body <?php body_class(); ?>>
<?php do_action('ultimatum_after_body_open');?>
<div class="clear"></div>
<?php do_action('ultimatum_print_header'); ?>
