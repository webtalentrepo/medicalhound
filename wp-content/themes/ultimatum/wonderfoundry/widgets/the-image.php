<?php
class UltimatumImage extends WP_Widget {

	function UltimatumImage() {
        parent::WP_Widget(false, $name = 'Ultimatum Image');
    }

	function widget($args, $instance) {
		extract( $args );
		echo $before_widget;
        $class = "img-responsive";
        $alt = $instance['image'];
        if ( !empty( $instance['title'] ) ) { echo $before_title . $instance['title']  . $after_title; }
        if ( !empty( $instance['img_class'] ) ) { $class .= ' '.$instance['img_class']; }
        if ( !empty( $instance['alt'] ) ) { $alt = $instance['alt']; }
        if ( !empty( $instance['link'] ) ) {
            if($instance['linktarget']!="prettyphoto"){
                $target = 'target="'.$instance['linktarget'].'"';
            } else {
                $target = 'class="prettyPhoto"';
            }
            echo '<a href="'.$instance['link'].'" '.$target.'>';
        }
		echo '<img src="'.$instance['image'].'" class="'.$class.'" alt="'.$alt.'"/>';
        if ( !empty( $instance['link'] ) ) {
            echo '</a>';
        }
		echo $after_widget;
    }

	function update( $new_instance, $old_instance ) {
		$instance['image'] = strip_tags( stripslashes($new_instance['image']) );
        $instance['img_class'] = strip_tags( stripslashes($new_instance['img_class']) );
        $instance['alt'] = strip_tags( stripslashes($new_instance['alt']) );
        $instance['link'] = strip_tags( stripslashes($new_instance['link']) );
        $instance['linktarget'] = strip_tags( stripslashes($new_instance['linktarget']) );
        return $instance;
    }
	function form($instance) {

        ?>
        <a href="#" id="ultimatum-media-upload-<?php echo $this->get_field_id('image'); ?>" class="ultimatum-open-media button button-primary"><?php _e( 'Set Image', 'ultimatum' ); ?></a>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ultimatum'); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['title'])); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>">
                <input type="hidden" id="edit-menu-item-megamenu-thumbnail-<?php echo $this->get_field_id('image'); ?>" class="ultimatum-new-media-image widefat code " name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo $instance['image']; ?>" />
                <img src="<?php echo $instance['image']; ?>" id="ultimatum-media-img-<?php echo $this->get_field_id('image'); ?>" class="ultimatum-megamenu-thumbnail-image" style="<?php echo ( trim( $instance['image']) ) ? 'display: inline;' : '';?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('img_class'); ?>"><?php _e('Image Class','ultimatum'); ?></label>
            <input class="widefat" type ="text" name="<?php echo $this->get_field_name('img_class'); ?>" value="<?php echo $instance['img_class']; ?>" id="<?php echo $this->get_field_id('img_class'); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Alternate Text', 'ultimatum'); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" name="<?php echo $this->get_field_name('alt'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['alt'])); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link', 'ultimatum'); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['link'])); ?>" /><br />
            <select name="<?php echo $this->get_field_name('linktarget'); ?>" id="<?php echo $this->get_field_id('linktarget'); ?>">
                <option value="_self"<?php selected( $instance['linktarget'], '_self' ); ?>><?php _e('Stay in Window', 'ultimatum'); ?></option>
                <option value="_blank"<?php selected( $instance['linktarget'], '_blank' ); ?>><?php _e('Open New Window', 'ultimatum'); ?></option>
                <option value="prettyphoto"<?php selected( $instance['linktarget'], 'prettyphoto' ); ?>><?php _e('Lightbox', 'ultimatum'); ?></option>
            </select>
        </p>
        
		<?php 
    }

}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumImage");'));
?>