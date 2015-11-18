<?php
class UltimatumSidebars extends WP_Widget {
	function UltimatumSidebars() {
        parent::WP_Widget(false, $name = 'Ultimatum Sidebars');
    }
    function widget($args, $instance) {
    	extract($args);
    	echo $before_widget;
		$sidebar ='ultimatum-'.strtolower(str_replace(' ','',$instance['sidebar']));
		dynamic_sidebar( $sidebar );
	  	echo $after_widget;
    }
	function update( $new_instance, $old_instance ) {
		$instance['sidebar'] = $new_instance['sidebar'];
        return $instance;
    }
	function form($instance) {
        $sidebar = isset( $instance['sidebar'] ) ? $instance['sidebar']:''; 
        $sidebars = get_theme_option('sidebars', 'sidebars');
        $sidebars = explode(';',$sidebars);
        if(count($sidebars)!=0){
        
        ?>
        <p>
        	<label for="<?php echo $this->get_field_id('sidebar'); ?>"><?php _e('Sidebar', 'ultimatum'); ?></label>
        	<select name="<?php echo $this->get_field_name('sidebar'); ?>" id="<?php echo $this->get_field_id('sidebar'); ?>">
        	<?php 
        	foreach($sidebars as $sider){
        		$siderr =strtolower(str_replace(' ','',$sider));
        		echo '<option value="'.$siderr.'" '.selected($sidebar,$siderr,false).'>'.$sider.'</option>';
        		
        	}
        	?>
        	</select>
        </p>
        <?php 
        } else {
         echo '<p>'.__('you do not have any sidebars defined please define some in developer options page', 'ultimatum').'</p>';
        }
    }
}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumSidebars");'));
?>