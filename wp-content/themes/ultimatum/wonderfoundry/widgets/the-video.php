<?php
class UltimatumVideo extends WP_Widget {

	function UltimatumVideo() {
        parent::WP_Widget(false, $name = 'Ultimatum Video');
    }

	function widget($args, $instance) {
		extract( $args );
		echo $before_widget;
		if ( $instance['title'])
				echo $before_title . $instance['title'] . $after_title;
		$instance[width]=$grid_width;
 		$sc ='[ult_video width="100%" height="'.$instance['height'].'"]'.$instance['video'].'[/ult_video]';
		echo do_shortcode($sc);
		echo $after_widget;
    }

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['video'] = strip_tags( stripslashes($new_instance['video']) );
		$instance['height'] = strip_tags( stripslashes($new_instance['height']) );
        return $instance;
    }
	function form($instance) {
        $title = $title = isset( $instance['title'] ) ? esc_attr($instance['title']) : '';
        $video = isset( $instance['video'] ) ? esc_attr($instance['video']):'';
        $height	= isset( $instance['height'] ) ? $instance['height'] : '400';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ultimatum'); ?></label>
		<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" class="widefat" />
		</p>
        <p>
		<label for="<?php echo $this->get_field_id('video'); ?>"><?php _e('Video URL', 'ultimatum') ?></label>
		<input name="<?php echo $this->get_field_name('video'); ?>" id="<?php echo $this->get_field_id('video'); ?>" class="widefat" value="<?php echo $video; ?>"/>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Video Height', 'ultimatum') ?></label>
		<input name="<?php echo $this->get_field_name('height'); ?>" id="<?php echo $this->get_field_id('height'); ?>" class="widefat" value="<?php echo $height;?>"/>
		</p>
        
		<?php 
    }

}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumVideo");'));
?>