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

add_action( 'ultimatum_after_post', 'ultimatum_get_comments_template',10,1 );

function ultimatum_get_comments_template($instance=array()) {
	global $post;
	if ( ! post_type_supports( $post->post_type, 'comments' ) )
		return;
	if ( is_singular() && $instance['show_comments_form']=='true')
		comments_template( '', true );
}

add_action( 'ultimatum_comments', 'ultimatum_do_comments' );
function ultimatum_do_comments() {
	global $post, $wp_query;
	if ( ! post_type_supports( $post->post_type, 'comments' ) )
		return;
	if ( have_comments() && ! empty( $wp_query->comments_by_type['comment'] ) ) {
		echo '<div id="comments" class="entry-comments">';
			echo apply_filters( 'ultimatum_title_comments', __( '<h3>Comments</h3>', 'ultimatum' ) );
			echo '<ol class="comment-list">';
				do_action( 'ultimatum_list_comments' );
			echo '</ol>';

			//* Comment Navigation
			$prev_link = get_previous_comments_link( apply_filters( 'ultimatum_prev_comments_link_text', '' ) );
			$next_link = get_next_comments_link( apply_filters( 'ultimatum_next_comments_link_text', '' ) );

			if ( $prev_link || $next_link )
				printf( '<div class="navigation"><div class="alignleft">%s</div><div class="alignright">%s</div></div>', $prev_link, $next_link );
		echo '</div>';
	}
	elseif ( 'open' == $post->comment_status && $no_comments_text = apply_filters( 'ultimatum_no_comments_text', '' ) ) {
		echo '<div id="comments">' . $no_comments_text . '</div>';
	}
	elseif ( $comments_closed_text = apply_filters( 'ultimatum_comments_closed_text', '' ) ) {
		echo '<div id="comments">' . $comments_closed_text . '</div>';
	}

}

add_action( 'ultimatum_pings', 'ultimatum_do_pings' );

function ultimatum_do_pings() {
	global $post, $wp_query;
	if ( ! post_type_supports( $post->post_type, 'trackbacks' ) )
		return;
	if ( have_comments() && !empty( $wp_query->comments_by_type['pings'] ) ) {
		?>
		<div id="pings">
			<?php echo apply_filters( 'ultimatum_title_pings', __( '<h3>Trackbacks</h3>', 'ultimatum' ) ); ?>
			<ol class="ping-list">
				<?php do_action( 'ultimatum_list_pings' ); ?>
			</ol>
		</div>
		<?php
	}
	else {
		echo apply_filters( 'ultimatum_no_pings_text', '' );
	}

}

add_action( 'ultimatum_list_comments', 'ultimatum_default_list_comments' );
function ultimatum_default_list_comments() {
	$defaults = array(
		'type'        => 'comment',
		'avatar_size' => 64,
		'callback'    =>  'ultimatum_comment_callback',
	);
	$args = apply_filters( 'ultimatum_comment_list_args', $defaults );
	wp_list_comments( $args );
}

add_action( 'ultimatum_list_pings', 'ultimatum_default_list_pings' );
function ultimatum_default_list_pings() {
	$args = apply_filters( 'ultimatum_ping_list_args', array(
		'type' => 'pings',
	) );
	wp_list_comments( $args );
}

function ultimatum_comment_callback( $comment, array $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	<article <?php echo 'class="well comment-container" itemtype="http://schema.org/UserComments" itemprop="comment" itemscope="itemscope"'; ?>>
		<?php do_action( 'ultimatum_before_comment' ); ?>

		<header class="comment-header">
			<p <?php echo 'class="comment-author" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="creator"'; ?>>
				<?php
				echo get_avatar( $comment, $args['avatar_size'] );

				$author = get_comment_author();
				$url    = get_comment_author_url();

				if ( ! empty( $url ) && 'http://' != $url ) {
					$author = sprintf( '<a href="%s" rel="external nofollow" itemprop="url">%s</a>', esc_url( $url ), $author );
				}

				printf( '<span itemprop="name">%s</span>', $author);
				?>
				<span class="comment-meta">
				<?php
				$pattern = '<time itemprop="commentTime" datetime="%s"><a href="%s" itemprop="url">%s %s %s</a></time>';
				printf( $pattern, esc_attr( get_comment_time( 'c' ) ), esc_url( get_comment_link( $comment->comment_ID ) ), esc_html( get_comment_date() ), __( 'at', 'ultimatum' ), esc_html( get_comment_time() ) );

				edit_comment_link( __( '(Edit)', 'ultimatum' ), ' ' );
				?>
			</span>
		 	</p>
		</header>
		<div class="comment-content" itemprop="commentText">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<p class="alert"><?php echo apply_filters( 'ultimatum_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'ultimatum' ) ); ?></p>
			<?php endif; ?>
			<?php comment_text(); ?>
		</div>
		<?php
		comment_reply_link( array_merge( $args, array(
			'depth'  => $depth,
			'before' => '<div class="comment-reply">',
			'after'  => '</div>',
		) ) );
		?>
		<?php do_action( 'ultimatum_after_comment' ); ?>
	</article>
	<?php
}

add_action( 'ultimatum_comment_form', 'ultimatum_do_comment_form' );
function ultimatum_do_comment_form() {
	global $post, $wp_query;
	if ( ! post_type_supports( $post->post_type, 'comments' ) )
	return;
	ultimatum_comment_form( array( 'format' => 'html5' ) );
}

function ultimatum_comment_form( $args = array(), $post_id = null ) {
	if ( null === $post_id )
		$post_id = get_the_ID();
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$args = wp_parse_args( $args );
	if ( ! isset( $args['format'] ) )
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5    = 'html5' === $args['format'];
	$fields   =  array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'ultimatum' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
			'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'ultimatum' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
			'<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
			'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'ultimatum' ) . '</label> ' .
			'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s', 'ultimatum'), '<span class="required">*</span>' );

	/**
	 * Filter the default comment form fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $fields The default comment fields.
	*/
	$fields = apply_filters( 'comment_form_default_fields', $fields );
	$defaults = array(
			'fields'               => $fields,
			'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'ultimatum' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
			/** This filter is documented in wp-includes/link-template.php */
			'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'ultimatum' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			/** This filter is documented in wp-includes/link-template.php */
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'ultimatum' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'ultimatum' ) . ( $req ? $required_text : '' ) . '</p>',
			'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'ultimatum' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'title_reply'          => __( 'Leave a Reply', 'ultimatum' ),
			'title_reply_to'       => __( 'Leave a Reply to %s', 'ultimatum' ),
			'cancel_reply_link'    => __( 'Cancel reply', 'ultimatum' ),
			'label_submit'         => __( 'Post Comment', 'ultimatum' ),
			'format'               => 'xhtml',
	);

	/**
	 * Filter the comment form default arguments.
	 *
	 * Use 'comment_form_default_fields' to filter the comment fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $defaults The default comment form arguments.
	*/
	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	?>
		<?php if ( comments_open( $post_id ) ) : ?>
			<?php
			/**
			 * Fires before the comment form.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_before' );
			?>
			<div id="respond" class="comment-respond">
				<h3 id="reply-title" class="comment-reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php
					/**
					 * Fires after the HTML-formatted 'must log in after' message in the comment form.
					 *
					 * @since 3.0.0
					 */
					do_action( 'comment_form_must_log_in_after' );
					?>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form"<?php echo $html5 ? ' novalidate' : ''; ?>>
						<?php
						/**
						 * Fires at the top of the comment form, inside the <form> tag.
						 *
						 * @since 3.0.0
						 */
						do_action( 'comment_form_top' );
						?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php
							/**
							 * Filter the 'logged in' message for the comment form for display.
							 *
							 * @since 3.0.0
							 *
							 * @param string $args_logged_in The logged-in-as HTML-formatted message.
							 * @param array  $commenter      An array containing the comment author's
							 *                               username, email, and URL.
							 * @param string $user_identity  If the commenter is a registered user,
							 *                               the display name, blank otherwise.
							 */
							echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
							?>
							<?php
							/**
							 * Fires after the is_user_logged_in() check in the comment form.
							 *
							 * @since 3.0.0
							 *
							 * @param array  $commenter     An array containing the comment author's
							 *                              username, email, and URL.
							 * @param string $user_identity If the commenter is a registered user,
							 *                              the display name, blank otherwise.
							 */
							do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
							?>
						<?php else : ?>
							<?php echo $args['comment_notes_before']; ?>
							<?php
							/**
							 * Fires before the comment fields in the comment form.
							 *
							 * @since 3.0.0
							 */
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								/**
								 * Filter a comment form field for display.
								 *
								 * The dynamic portion of the filter hook, $name, refers to the name
								 * of the comment form field. Such as 'author', 'email', or 'url'.
								 *
								 * @since 3.0.0
								 *
								 * @param string $field The HTML-formatted output of the comment form field.
								 */
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							/**
							 * Fires after the comment fields in the comment form.
							 *
							 * @since 3.0.0
							 */
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php
						/**
						 * Filter the content of the comment textarea field for display.
						 *
						 * @since 3.0.0
						 *
						 * @param string $args_comment_field The content of the comment textarea field.
						 */
						echo apply_filters( 'comment_form_field_comment', $args['comment_field'] );
						?>
						<?php echo $args['comment_notes_after']; ?>
						<p class="form-submit">
							<input class="btn btn-primary" name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
							<?php comment_id_fields( $post_id ); ?>
						</p>
						<?php
						/**
						 * Fires at the bottom of the comment form, inside the closing </form> tag.
						 *
						 * @since 1.5.0
						 *
						 * @param int $post_id The post ID.
						 */
						do_action( 'comment_form', $post_id );
						?>
					</form>
				<?php endif; ?>
			</div><!-- #respond -->
			<?php
			/**
			 * Fires after the comment form.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_after' );
		else :
			/**
			 * Fires after the comment form if comments are closed.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_comments_closed' );
		endif;
}

