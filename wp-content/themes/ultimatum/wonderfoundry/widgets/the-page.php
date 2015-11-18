<?php
class UltimatumPcontent extends WP_Widget {

	function UltimatumPcontent() {
        parent::WP_Widget(false, $name = 'Ultimatum Include Page');
    }

	function widget($args, $instance) {
   	extract( $args );
		$instance["width"]=$grid_width;

		if($instance["paje"]){
            $post_id = $instance["paje"];
            $post_self = get_post($post_id);

		echo $before_widget;
			if ( $instance['title'])
				echo $before_title . $instance['title'] . $after_title;
		

			$img = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large') ;
			if ($img){
				$imgsrc = UltimatumImageResizer( get_post_thumbnail_id($post_id), null,$instance["width"], $instance["height"], true );
			   	}
			if($img && $instance['image']=='btitle'){
				echo '<img src="'.$imgsrc.'" />';
			}
			if($instance["titl"]=='true'){
			echo '<h3 class="element-title">';
                echo $post_self->post_title;
			echo '</h3>';
			}
			if($img && $instance['image']=='atitle'){
				echo '<img src="'.$imgsrc.'" />';
			}
            $content = apply_filters( 'ult_widget_content', $post_self->post_content, $post_id );
            echo $content;
		echo $after_widget;

		}

 		
    }

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['paje'] = strip_tags( stripslashes($new_instance['paje']) );
		$instance['image'] = strip_tags( stripslashes($new_instance['image']) );
		$instance['height'] = strip_tags( stripslashes($new_instance['height']) );
		$instance['titl'] = strip_tags( stripslashes($new_instance['titl']) );
        return $instance;
    }
	function form($instance) {
        $title =isset( $instance['title'] ) ? esc_attr($instance['title']):'';
        $paje = isset( $instance['paje'] ) ? esc_attr($instance['paje']) : '';
        $image = isset( $instance['image'] ) ?  $instance['image'] : 'false';
        $height= isset( $instance['height'] ) ?  $instance['height'] : '100';
        $titl = isset( $instance['titl'] ) ?  $instance['titl'] : 'true';
        ?>
        <p><i><?php _e('This will show the content of the page selected in a Position', 'ultimatum')?></i></p>
        <p>
		<label for="<?php echo $this->get_field_id('paje'); ?>"><?php _e('Select a Page', 'ultimatum') ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name('paje'); ?>" id="<?php echo $this->get_field_id('paje'); ?>">
	 			<option value=""><?php echo esc_attr( __( 'Select page', 'ultimatum' ) ); ?></option> 
				 <?php 
				  $pages = get_pages(); 
				  foreach ( $pages as $pagg ) {
				  	$option = '<option value="'. ( $pagg->ID ).'" '.selected($paje,$pagg->ID,false).'>';
					$option .= $pagg->post_title;
					$option .= '</option>';
					echo $option;
				  }
				 ?>
			</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('titl'); ?>"><?php _e('Page Title', 'ultimatum') ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name('titl'); ?>" id="<?php echo $this->get_field_id('titl'); ?>">
	 			<option value="false" <?php selected($titl,'false')?>>OFF</option> 
				<option value="true" <?php selected($titl,'true')?>>ON</option>
			</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Featured Image', 'ultimatum') ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name('image'); ?>" id="<?php echo $this->get_field_id('image'); ?>">
	 			<option value="false" <?php selected($image,'false')?>><?php echo esc_attr( __( 'OFF', 'ultimatum') ); ?></option> 
				<option value="atitle" <?php selected($image,'atitle')?>><?php echo esc_attr( __( 'After Title', 'ultimatum') ); ?></option>
				<option value="btitle" <?php selected($image,'btitle')?>><?php echo esc_attr( __( 'Before Title', 'ultimatum') ); ?></option>
			</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Image Height:', 'ultimatum') ?></label>
		<input name="<?php echo $this->get_field_name('height'); ?>" id="<?php echo $this->get_field_id('height'); ?>" value="<?php echo $height;?>"/>
		</p>
		<?php 
    }

}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumPcontent");'));
add_filter( 'ult_widget_content', 'wptexturize') ;
add_filter( 'ult_widget_content', 'convert_smilies' );
add_filter( 'ult_widget_content', 'convert_chars' );
add_filter( 'ult_widget_content', 'wpautop' );
add_filter( 'ult_widget_content', 'shortcode_unautop' );
add_filter( 'ult_widget_content', 'do_shortcode', 11);
add_filter( 'ult_widget_content', array( $GLOBALS['wp_embed'], 'run_shortcode' ), 8 );
add_filter( 'ult_widget_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
?>