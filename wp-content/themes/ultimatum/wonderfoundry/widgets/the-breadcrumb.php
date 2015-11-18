<?php
class UltimatumBcumb extends WP_Widget {

	function UltimatumBcumb() {
        parent::WP_Widget(false, $name = 'Ultimatum BreadCrumbs');
    }

    function widget($args, $instance) {
        extract( $args );
        echo $before_widget;
		if (function_exists( 'bcn_display')) {
			echo '<div class="breadcrumb" itemprop="breadcrumb">';
			bcn_display();
			echo '</div>';
		} elseif (function_exists('yoast_breadcrumb' )) {
			yoast_breadcrumb( '<div class="breadcrumb">', '</div>' );
		} elseif ( function_exists( 'breadcrumbs' ) ) {
			breadcrumbs();
		} elseif ( function_exists( 'crumbs' ) ) {
			crumbs();
		} else {
			$this->ultimatum_breadcrumb();
		}
        echo $after_widget;
    }

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
	        return $instance;
	    }
	function form($instance) {
	       // $title = esc_attr($instance['title']);
	}
	function ultimatum_breadcrumb( $args = array() ) {
		global $_ultimatum_breadcrumb;
		if ( ! $_ultimatum_breadcrumb )
			$_ultimatum_breadcrumb = new UltimatumBreadcrumb;
			$_ultimatum_breadcrumb->output( $args );
	}

}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumBcumb");'));

?>