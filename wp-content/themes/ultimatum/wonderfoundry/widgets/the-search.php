<?php
class UltimatumSearch extends WP_Widget {

	function UltimatumSearch() {
        parent::WP_Widget(false, $name = 'Ultimatum Search');
    }

    function widget($args, $instance) {
     extract($args);
    $html ='<form role="search" class="form-search" method="get" id="searchform" action="' . home_url( '/' ) . '" >';
    if(strlen($instance['label'])!=0){
    $html .= '<label class="assistive-text" for="s">' .$instance['label'] . '</label>';
    }
    if(strlen($instance['placeholder'])!=0){
        $html .= '<input type="search" placeholder="'.$instance['placeholder'].'" value="' . get_search_query() . '" name="s" id="s" />';
    } else {
    	$html .= '<input type="search"  value="' . get_search_query() . '" name="s" id="s" />';
    }
    if(strlen($instance['button'])!=0){
    $html .= '<button class="btn">'.$instance['button'].'</button>';
    }
    $html .= '</form>';
	  echo $before_widget;
			if ( $instance["title"])
				echo $before_title . $instance["title"] . $after_title;
	  echo $html;
	  echo $after_widget;
    }

function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['label'] = strip_tags( stripslashes($new_instance['label']) );
		$instance['button'] = ( stripslashes($new_instance['button']) );
		$instance['placeholder'] = strip_tags( stripslashes($new_instance['placeholder']) );
        return $instance;
    }
function form($instance) {
        $title = isset( $instance['title'] ) ? esc_attr($instance['title']):'';
        $label = isset( $instance['label'] ) ? esc_attr($instance['label']):'';
        $placeholder = isset( $instance['placeholder'] ) ? esc_attr($instance['placeholder']):'';
        $appended = isset( $instance['appended'] ) ? esc_attr($instance['appended']):'';
        $button = isset( $instance['button'] ) ? esc_attr($instance['button']):'';

        ?>
        <i><?php _e('Leave fields empty to disable them','ultimatum');?></i>
        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ultimatum'); ?></label>
		<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" class="widefat" />
		</p>
       <p>
        <label for="<?php echo $this->get_field_id('label'); ?>"><?php _e('Label', 'ultimatum'); ?></label>
		<input id="<?php echo $this->get_field_id('label'); ?>" name="<?php echo $this->get_field_name('label'); ?>" type="text" value="<?php echo $label; ?>" class="widefat" />
		</p>
		<p>
        <label for="<?php echo $this->get_field_id('placeholder'); ?>"><?php _e('Placeholder text', 'ultimatum'); ?></label>
		<input id="<?php echo $this->get_field_id('placeholder'); ?>" name="<?php echo $this->get_field_name('placeholder'); ?>" type="text" value="<?php echo $placeholder; ?>" class="widefat" />
		</p>
		<p>
        <label for="<?php echo $this->get_field_id('button'); ?>"><?php _e('Button text', 'ultimatum'); ?></label>
		<input id="<?php echo $this->get_field_id('button'); ?>" name="<?php echo $this->get_field_name('button'); ?>" type="text" value="<?php echo $button; ?>" class="widefat" />
		</p>
		<?php 
    }

}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumSearch");'));
?>