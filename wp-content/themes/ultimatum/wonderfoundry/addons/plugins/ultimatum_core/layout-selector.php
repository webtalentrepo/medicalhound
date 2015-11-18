<?php
function ultimatum_select_layout() {
	$args=array('public'   => true,'publicly_queryable' => true);
	$post_types=get_post_types($args,'names');
	foreach ($post_types as $post_type ) {
		if($post_type!='attachment'){
			add_meta_box('ultimate_layoutselector',__( 'Layout Selection', 'ultimatum'),'ultimatum_select_layout_form',$post_type,'side','high');
		}
	}
	add_meta_box('ultimate_layoutselector',__( 'Layout Selection', 'ultimatum'),'ultimatum_select_layout_form','page','side','high');
}

function ultimatum_select_layout_form($post) {
	// Set the nonce for security
	wp_nonce_field( 'ultimatum_post_layout', 'ultimatum_post_layout_nonce' );
	// Set the meta key
	$meta_key= THEME_SLUG.'_layout';
	// get the Post ID
	$post_id = $post->ID;
	
	global $wpdb;
	
	$ttable=$wpdb->prefix.ULTIMATUM_PREFIX.'_templates';
	$table=$wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
	
	
	echo '<label for="ultimatum_layout">';
	_e("Select a Layout", 'ultimatum');
	echo '</label><br /> ';
	$curr= get_post_meta($post_id,$meta_key,true);
	echo '<select name="ultimatum_layout">';
	echo '<option value="">The Default</option>';
	$query1 = "SELECT * FROM $ttable WHERE `theme`='".THEME_SLUG."'";
	$result1 = $wpdb->get_results($query1,ARRAY_A);
	foreach ($result1 as $theme){
	$query = "SELECT * FROM $table WHERE type='full' AND `theme`='$theme[id]'";
	$result = $wpdb->get_results($query,ARRAY_A);
	if($result){
		echo '<optgroup label="'.$theme['name'].'">';
	foreach ($result as $fetch){
		echo '<option value="'.$fetch["id"].'" ';
		if($fetch["id"]==$curr){ echo ' selected="selected" ';}
   		echo '>'.$fetch["title"].'</option>';
   }
   echo '</optgroup>';
	}
	}
   echo '</select>';
}

function ultimatum_select_layout_save_postdata( $post_id,$post) {
 	//echo '<pre>';print_r($_POST);die();
 	//* Verify the nonce
	if ( ! isset( $_POST[ 'ultimatum_post_layout_nonce' ] ) ){
        return;
    }

    if( ! wp_verify_nonce( $_POST[ 'ultimatum_post_layout_nonce' ], 'ultimatum_post_layout' ) ) {
        return;
    }
	
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
	if( ! isset( $_POST['ultimatum_layout'] ) ){
        return;
    }
	$mydata = $_POST['ultimatum_layout'];
  	$meta_key= THEME_SLUG.'_layout';
  	update_post_meta($post->ID, $meta_key, $mydata);
}

add_action( 'admin_menu', 'ultimatum_select_layout', 1 );
add_action( 'save_post', 'ultimatum_select_layout_save_postdata',1,2);