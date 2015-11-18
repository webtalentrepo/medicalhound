<?php

class ULT_Templetera_Widget extends WP_Widget {

    function ULT_Templetera_Widget() {
        parent::WP_Widget(false, $name = 'Ultimatum Templatera');
    }

    function form($instance) {

		$select = $instance ? esc_attr($instance['select']) : '';
        ?>
		<p>
            <label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('Select template', 'ultimatum'); ?></label>
            <select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
                <?php
                $options = $this->get_templatera_list();
                foreach ($options as $k=>$v) {
                    echo '<option value="' . $v . '" id="' . $v . '"', $select == $v ? ' selected="selected"' : '', '>', $k, '</option>';
                }
                ?>
            </select>
        </p>
    <?php
    }

	function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['select'] = strip_tags($new_instance['select']);
        return $instance;
    }

	function widget($args, $instance) {
        extract( $args );
        $select = $instance['select'];
        echo $before_widget;
        echo do_shortcode('[templatera id='.$select.']');
        echo $after_widget;
    }

    function get_templatera_list()
    {
        global $current_user;
        get_currentuserinfo();
        $current_user_role = isset($current_user->roles[0]) ? $current_user->roles[0] : false;
        $list = array();
        $templates = get_posts(array(
            'post_type' => 'templatera',
            'numberposts' => -1
        ));
        $post = !empty($_POST['post_id']) ? get_post($_POST['post_id']) : false;
        foreach ($templates as $template) {
            $id = $template->ID;
            $meta_data = get_post_meta($id, 'templatera', true);
            $post_types = isset($meta_data['post_type']) ? $meta_data['post_type'] : false;
            $user_roles = isset($meta_data['user_role']) ? $meta_data['user_role'] : false;
            if (
                (!$post || !$post_types || in_array($post->post_type, $post_types))
                && (!$current_user_role || !$user_roles || in_array($current_user_role, $user_roles))
            ) {
                $list[$template->post_title] = $id;
            }
        }
        return $list;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("ULT_Templetera_Widget");'));


?>