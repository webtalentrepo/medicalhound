<?php
if( comments_open() ){
    
    if( is_user_logged_in() ){
        echo '<div id="comments" class="comments-list user-logged-in">';
    }
    else{
        echo '<div id="comments" class="comments-list">';
    }

    if ( post_password_required() ){
        echo '<p class="nopassword">';
        _e( 'This post is password protected. Enter the password to view any comments.' , 'mythemes' );
        echo '</p>';
        echo '</div>';
        return;
    }

    /* IF EXISTS WORDPRESS COMMENTS */
    if ( have_comments() ) {
        $nr = get_comments_number();
        
        if( $nr == 1 )
            $title = __( 'Comment' , 'mythemes' );
        else
            $title = __( 'Comments' , 'mythemes' );

        echo '<h3 class="comments-title">';
        echo $title . ' ( <strong>' . number_format_i18n( $nr ) . '</strong> )'; 
        echo '</h3>';
		
        echo '<ol>';
        wp_list_comments( array( 'callback' =>  array( 'myThemes' , 'comment' ) , 'style' => 'ul' ) );
        echo '</ol>';
        
        /* WORDPRESS PAGINATION FOR COMMENTS */
        echo '<div class="pagination comments">';
        echo '<nav class="inline aligncenter">';
        echo paginate_comments_links();
        echo '</nav>';
        echo '</div>';
    }
	
    /* FORM SUBMIT COMMENTS */
    $commenter = wp_get_current_commenter();

    /* CHECK VALUES */
    if( esc_attr( $commenter[ 'comment_author' ] ) )
        $name = esc_attr( $commenter[ 'comment_author' ] );
    else
        $name = __( 'Nickname ( required )' , 'mythemes' );

    if( esc_attr( $commenter[ 'comment_author_email' ] ) )
        $email = esc_attr( $commenter[ 'comment_author_email' ] );
    else
        $email = __( 'E-mail ( required )' , 'mythemes' );

    if( esc_attr( $commenter[ 'comment_author_url' ] ) )
        $web = esc_attr( $commenter[ 'comment_author_url' ] );
    else
        $web = __( 'Website' , 'mythemes' );

    /* FIELDS */
    $fields =  array(
        'author' => '<div class="field">'.
                '<p class="comment-form-author input">'.
                '<input class="required" value="' . $name . '" onfocus="if (this.value == \'' . __( 'Nickname ( required )' , 'mythemes' ). '\') {this.value = \'\';}" onblur="if (this.value == \'\' ) { this.value = \'' . __( 'Nickname ( required )' , 'mythemes' ) . '\';}" id="author" name="author" type="text" size="30"  />' .
            '</p>',
        'email'  => '<p class="comment-form-email input">'.
                '<input class="required" value="' . $email . '" onfocus="if (this.value == \'' . __( 'E-mail ( required )' , 'mythemes' ). '\') {this.value = \'\';}" onblur="if (this.value == \'\' ) { this.value = \'' . __( 'E-mail ( required )' , 'mythemes' ) . '\';}" id="email" name="email" type="text" size="30" />' .
            '</p>',
        'url'    => '<p class="comment-form-url input">'.
                '<input value="' . $web . '" onfocus="if (this.value == \'' . __( 'Website' , 'mythemes' ). '\') {this.value = \'\';}" onblur="if (this.value == \'\' ) { this.value = \'' . __( 'Website' , 'mythemes' ). '\';}" id="url" name="url" type="text" size="30" />' .
            '</p></div>',
    );
    

    $rett  = '<div class="textarea"><p class="comment-form-comment textarea user-not-logged-in">';
    $rett .= '<textarea id="comment" name="comment" cols="45" rows="10" aria-required="true"></textarea>';
    $rett .= '</p></div>';
    
    $rett .= '<p>' . __( 'You may use these HTML tags and attributes' , 'mythemes' ) . ':</p>';
    $rett .= '<pre>';
    $rett .= htmlspecialchars( '<a href="" title=""> <abbr title=""> <acronym title=""> <b> <blockquote cite=""> <cite> <code> <del datetime=""> <em> <i> <q cite=""> <strike> <strong>' );
    $rett .= '</pre>';

    $args = array(	
        'title_reply' => __( "Leave a reply" , 'mythemes' ),
        'comment_notes_after'   => '',
        'comment_notes_before'  => '<p class="comment-notes">' . __( 'Your email address will not be published.' , 'mythemes' ) . '</p>',
        'logged_in_as'          => '<p class="logged-in-as">' . __( 'Logged in as' , 'mythemes' ) . ' <a href="' . home_url('/wp-admin/profile.php') . '">' . get_the_author_meta( 'nickname' , get_current_user_id() ) . '</a>. <a href="' . wp_logout_url( get_permalink( $post -> ID ) ) .'" title="' . __( 'Log out of this account' , 'mythemes' ) . '">' . __( 'Log out?' , 'mythemes' ) . ' </a></p>',		
        'fields'                => apply_filters( 'comment_form_default_fields', $fields ),
        'comment_field'         => $rett,
        'label_submit'          => __( 'Submit Comment' , 'mythemes' )
    );

    comment_form( $args );
    echo '<div class="clear"></div>';
    echo '</div>';
}
?>