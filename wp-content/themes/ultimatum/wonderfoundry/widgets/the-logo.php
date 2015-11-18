<?php
class UltimatumLogo extends WP_Widget {

	function UltimatumLogo() {
        parent::WP_Widget(false, $name = 'Ultimatum Logo');
    }

 function widget($args, $instance) {
    if(is_single()){
       		$ltag = (get_ultimatum_option('tags', 'single_logo') ? get_ultimatum_option('tags', 'single_logo') : 'h1');
       		$stag = (get_ultimatum_option('tags', 'single_slogan') ? get_ultimatum_option('tags', 'single_slogan') : 'span');
     } else {
      		$ltag = (get_ultimatum_option('tags', 'multi_logo') ? get_ultimatum_option('tags', 'multi_logo') : 'h1');
       		$stag = (get_ultimatum_option('tags', 'multi_slogan') ? get_ultimatum_option('tags', 'multi_slogan') : 'span');
     }
       
      
       echo '<div id="logo-container">';
       if(get_ultimatum_option('general', 'text_logo')!=0 && !$instance["logoimage"]){
       if($instance["logotext"]){
       		echo '<'.$ltag.' id="logo"><a id="logo" class="logo" href="'.get_bloginfo('url').'">'.$instance["logotext"].'</a></'.$ltag.'>';
       } else {
       		echo '<'.$ltag.' id="logo"><a class="logo" href="'.get_bloginfo('url').'">'.get_bloginfo().'</a></'.$ltag.'>';
       }
       if(get_ultimatum_option('general', 'display_site_desc')){
       		if($instance["logotag"]){ 
       			echo '<'.$stag.' id="tagline">'.$instance["logotag"].'</'.$stag.'>';
       		} else {
       			echo '<'.$stag.' id="tagline">'.get_bloginfo ( 'description' ).'</'.$stag.'>';
       		} 
       }
       	
       //
       } else {
       		if($instance["logoimage"]){
       			$logo_src=$instance["logoimage"];
       		} else {
       			$logo_src=get_ultimatum_option('general', 'logo');
       		}
       		 echo '<'.$ltag.'><a href="'.get_bloginfo('url').'" class="logo"><img src="'.$logo_src.'" alt="'.get_bloginfo().'" class="img-responsive"/></a></'.$ltag.'>'; 
       }
       echo '</div>';
    }

function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['logotext'] = $new_instance['logotext'];
	$instance['logotag'] = $new_instance['logotag'];
	$instance['logoimage'] = $new_instance['logoimage'];
        return $instance;
    }
function form($instance) {
        $title 		= isset( $instance['title'] ) ?  esc_attr($instance['title']) :'';
        $logotext 	= isset( $instance['logotext'] ) ? $instance['logotext'] : '';
        $logotag 	= isset( $instance['logotag'] ) ? $instance['logotag'] : '';
        $logoimage 	= isset( $instance['logoimage'] ) ? $instance['logoimage'] : '';
        ?>
        <p><i>Leave Below Empty to use default Settings</i></p>
        <p>
        	<label for="<?php echo $this->get_field_id('logotext'); ?>"><?php _e('Logo Text', 'ultimatum'); ?></label>
			<input id="<?php echo $this->get_field_id('logotext'); ?>" name="<?php echo $this->get_field_name('logotext'); ?>" type="text" value="<?php echo $logotext; ?>" class="widefat" />
		</p>
		<p>
       		<label for="<?php echo $this->get_field_id('logotag'); ?>"><?php _e('Logo Tag', 'ultimatum'); ?></label>
			<input id="<?php echo $this->get_field_id('logotag'); ?>" name="<?php echo $this->get_field_name('logotag'); ?>" type="text" value="<?php echo $logotag; ?>" class="widefat" />
		</p>
		<p>
       		<label for="<?php echo $this->get_field_id('logoimage'); ?>"><?php _e('Logo Image', 'ultimatum'); ?></label><i> Full URL to image</i>
			<input id="<?php echo $this->get_field_id('logoimage'); ?>" name="<?php echo $this->get_field_name('logoimage'); ?>" type="text" value="<?php echo $logoimage; ?>" class="widefat" />
		</p>
		<?php 
    }

}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumLogo");'));
?>