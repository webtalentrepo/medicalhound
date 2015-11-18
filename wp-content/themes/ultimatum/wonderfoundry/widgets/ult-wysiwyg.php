<?php
/**
* Adds WP_Editor_Widget widget.
*/
class UltimatumWySIWYG extends WP_Widget
{

    function UltimatumWySIWYG() {
        parent::WP_Widget(false, $name = 'Ultimatum WYSIWYG');
    }


    public function widget($args, $instance)
    {

        extract($args);

        $title = apply_filters('ult_wysiwyg_widget_title', $instance['title']);
        $output_title = apply_filters('ult_wysiwyg_widget_output_title', $instance['output_title']);
        $content = apply_filters('ult_wysiwyg_widget_content', $instance['content']);

        echo $before_widget;

        if ($output_title == "1" && !empty($title)) {
            echo $before_title . $title . $after_title;
        }

        echo $content;

        echo $after_widget;

    } // END widget()


    public function form($instance)
    {

        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'ultimatum');
        }

        if (isset($instance['content'])) {
            $content = $instance['content'];
        } else {
            $content = "";
        }

        $output_title = (isset($instance['output_title']) && $instance['output_title'] == "1" ? true : false);
        ?>
        <input type="hidden" id="<?php echo $this->get_field_id('content'); ?>"
               name="<?php echo $this->get_field_name('content'); ?>" value="<?php echo esc_attr($content); ?>">
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ultimatum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <a href="javascript:UltWYSIWYGWidget.showEditor('<?php echo $this->get_field_id('content'); ?>');"
               class="button"><?php _e('Edit content', 'ultimatum') ?></a>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('output_title'); ?>">
                <input type="checkbox" id="<?php echo $this->get_field_id('output_title'); ?>"
                       name="<?php echo $this->get_field_name('output_title'); ?>"
                       value="1" <?php checked($output_title, true) ?>> <?php _e('Output title', 'ultimatum'); ?>
            </label>
        </p>
        <?php
        $url = home_url('/');
        $url .= '?ult-front-frame=ult-wysiwyg-widget&data=' . urlencode(base64_encode(($content)));
        ?>
        <iframe src="<?php echo $url; ?>" style="border:0;width:100%;"></iframe>
    <?php

    }

    public function update($new_instance, $old_instance)
    {

        $instance = array();

        $instance['title'] = (!empty($new_instance['title']) ? strip_tags($new_instance['title']) : '');
        $instance['content'] = (!empty($new_instance['content']) ? $new_instance['content'] : '');
        $instance['output_title'] = (isset($new_instance['output_title']) && $new_instance['output_title'] == "1" ? 1 : 0);

        do_action('ult_wysiwyg_widget_update', $new_instance, $instance);

        return apply_filters('ult_wysiwyg_widget_update_instance', $instance, $new_instance);

    }

}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumWySIWYG");'));