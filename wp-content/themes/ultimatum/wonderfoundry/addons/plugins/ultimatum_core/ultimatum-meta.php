<?php
function ultimatum_meta_box() {
	$args=array('public'   => true,'publicly_queryable' => true);
	$post_types=get_post_types($args,'names');
	foreach ($post_types as $post_type ) {
		if($post_type!='attachment'){
			add_meta_box('ultimate_meta',__( 'Post Properties', 'ultimatum'),'ultimatum_meta',$post_type);
		}
	}
	
}

function ultimatum_meta() {
	global $wpdb;
	$table=$wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	wp_nonce_field( 'ultimatum_additional_meta', 'ultimatum_additional_meta_nonce' );
	echo '<p><label for="ultimatum_author">';
	_e("Show Author Info", 'ultimatum');
	echo '</label>';
	echo '<select name="ultimatum_author">';
	$cura= get_post_meta($post_id,'ultimatum_author',true);
	echo '<option value="false"';
	if($cura=='false') { echo ' selected="selected" '; }
	echo '>OFF</option>';
	echo '<option value="true"';
	if($cura=='true') { echo ' selected="selected" '; }
	echo '>ON</option>';
	echo '</select></p>';
	echo '<p><label for="ultimatum_video">';
	_e("Video URL", 'ultimatum');
	echo '</label>';
	$curv= get_post_meta($post_id,'ultimatum_video',true);
	echo '<input type="text" name="ultimatum_video" value="'.$curv.'" size="50" />';
	_e("Used in slideshows as post info ", 'ultimatum');
	echo '</p>';
	
}

function ultimatum_meta_save_postdata( $post_id, $post ) {
	//echo '<pre>';print_r($_POST);die();
	//* Verify the nonce
	if ( ! isset( $_POST[ 'ultimatum_additional_meta_nonce' ] ) || ! wp_verify_nonce( $_POST[ 'ultimatum_additional_meta_nonce' ], 'ultimatum_additional_meta' ) )
		return;
	
	//* Don't try to save the data under autosave, ajax, or future post.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return;
	if ( defined( 'DOING_CRON' ) && DOING_CRON )
		return;
	//* Grab the post object
	$post = get_post( $post );
	
	//* Don't save if WP is creating a revision (same as DOING_AUTOSAVE?)
	if ( 'revision' === $post->post_type )
		return;
	//* Check that the user is allowed to edit the post
	if ( ! current_user_can( 'edit_post', $post->ID ) )
		return;
	
	$mydata = $_POST['ultimatum_video'];
    update_post_meta($post->ID, 'ultimatum_video', $mydata);
	$mydata = $_POST['ultimatum_author'];
	update_post_meta($post->ID, 'ultimatum_author', $mydata);
}

add_action( 'admin_menu', 'ultimatum_meta_box', 1 );
add_action( 'save_post', 'ultimatum_meta_save_postdata',1,2 );