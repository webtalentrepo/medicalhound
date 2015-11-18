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

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
	die ( 'Please do not load this page directly. Thanks!' );

if ( post_password_required() ) {
	printf( '<p class="alert">%s</p>', __( 'This post is password protected. Enter the password to view comments.', 'ultimatum' ) );
	return;
}

do_action( 'ultimatum_before_comments' );
do_action( 'ultimatum_comments' );
do_action( 'ultimatum_after_comments' );

do_action( 'ultimatum_before_pings' );
do_action( 'ultimatum_pings' );
do_action( 'ultimatum_after_pings' );

do_action( 'ultimatum_before_comment_form' );
do_action( 'ultimatum_comment_form' );
do_action( 'ultimatum_after_comment_form' );
