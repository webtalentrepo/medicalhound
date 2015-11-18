<?php
add_action('widgets_init', create_function('', 'return register_widget("Ultimate_Recent_Comments");'));
class Ultimate_Recent_Comments extends WP_Widget {

    function Ultimate_Recent_Comments() {
        parent::WP_Widget(false, $name = 'Ultimatum Recent Comments');
		add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
	}

	function widget_style() {
        ?>
        <style type="text/css">#erc{padding:0;margin:0;list-style:none !important;} #erc img{padding:0;margin:3px;float:<?php echo is_rtl() ? 'right' : 'left'; ?>;}</style>
        <?php
    }

	function flush_widget_cache() {
		wp_cache_delete('widget_erc', 'widget');
	}

	function widget( $args, $instance ) {

        global $comments, $comment;

		$cache = wp_cache_get('widget_erc', 'widget');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

 		extract($args, EXTR_SKIP);
 		$output = '';
 		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Comments', 'ultimatum') : $instance['title']);

		if ( ! $number = (int) $instance['number'] )
 			$number = 5;
 		else if ( $number < 1 )
 			$number = 1;

		$size = $instance['size'];

		$comments = get_comments( array( 'number' => $number, 'status' => 'approve' ) );
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul class="recent-comments">';
		if ( $comments ) {
			foreach ( (array) $comments as $comment) {
				$output .=  '<li class="recent-comment">';
				$output .=  get_avatar(get_comment_author_email($comment->comment_ID), $size) . ' ';
				$output .=  /* translators: extended comments widget: 1: comment author, 2: post link */ sprintf(__('%1$s on %2$s', 'ultimatum'), get_comment_author_link(), '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>');
				$comment = get_comment($comment->comment_ID,ARRAY_A);
				$output .= '<br />'.substr($comment["comment_content"],0,$instance['length']).'...';
				$output .=  '</li>';
			}
 		}
		$output .= '</ul>';
		$output .= $after_widget;
		$output = str_replace('avatar avatar', 'avatar alignleft avatar', $output);
		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_erc', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['length'] = (int) $new_instance['length'];
		$instance['size'] = ( $new_instance['size'] < 20 ) ? 20 : (int) $new_instance['size'];
		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_erc']) )
			delete_option('widget_erc');

		return $instance;
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$size = isset($instance['size']) ? absint($instance['size']) : 40;
		$length = isset($instance['length']) ? absint($instance['length']) : 40;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ultimatum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show', 'ultimatum'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Length of Comment', 'ultimatum'); ?></label>
            <input id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" value="<?php echo $length; ?>" size="3" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Avatar size', 'ultimatum'); ?></label>
            <input id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $size; ?>" size="3" />
        </p>
        <?php
    }
}