<?php
/*
 * Ultimatum Widget-Extender functions the magical world of Widgets will be here
 */

if(!class_exists('Ultimatum_Widget_Extender')) {
    class Ultimatum_Widget_Extender
    {

        function __construct()
        {

            if (!is_admin()) {
                add_filter('dynamic_sidebar_params', array($this, 'add_widget_extras'));
            } else {
                add_action('in_widget_form', array($this, 'extra_fields'), 10, 3);
                add_filter('widget_update_callback', array($this, 'update_widget'), 10, 2);

            }
        }

        public static function update_widget($instance, $new_instance)
        {
            $instance['ult_classes'] = $new_instance['ult_classes'];
            $instance['ult_template'] = $new_instance['ult_template'];
            $instance['ult_hidden_desktop'] = $new_instance['ult_hidden_desktop'];
            $instance['ult_hidden_tablet'] = $new_instance['ult_hidden_tablet'];
            $instance['ult_hidden_mobile'] = $new_instance['ult_hidden_mobile'];
            return $instance;
        }

        function extra_fields($widget, $return, $instance)
        {
            $no_field = array('ultimatumcontent','ultimatummenu','ultimatumbcumb','ultimatumsidebars');
            $fields = '<div  class="widget-extender"><h3 onclick="widget_xtender(this);">Widget Extras</h3><div class="extender-in">'."\n";
            $fields .= "<p>\n";
            if (!isset($instance['ult_classes'])) $instance['ult_classes'] = null;
            $fields .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-ult_classes'>" . esc_html__('CSS Class', 'ultimatum') . ":</label>";
            $fields .= "<input type='text' name='widget-{$widget->id_base}[{$widget->number}][ult_classes]' id='widget-{$widget->id_base}-{$widget->number}-ult_classes' value='{$instance['ult_classes']}'/>\n";
            $fields .= "</p>\n";
            if(!in_array($widget->id_base,$no_field)) {
                $templates = $this->widget_templates();
                if (!isset($instance['ult_template'])) $instance['ult_template'] = 'default';
                $fields .= "<p>\n";
                $fields .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-ult_template'>" . esc_html__('Widget Template', 'ultimatum') . ":</label>";
                $fields .= "<select name='widget-{$widget->id_base}[{$widget->number}][ult_template]' id='widget-{$widget->id_base}-{$widget->number}-ult_template'>";
                $fields .= '<option value="default" ' . selected($instance['ult_template'], 'default', false) . '>' . esc_html__('Default', 'ultimatum') . '</option>';
                foreach ($templates as $template) {
                    if ($template) $fields .= '<option value="' . $template['id'] . '" ' . selected($instance['ult_template'], $template['id'], false) . '>' . $template['name'] . '</option>';
                }
                $fields .= '</select>';
                $fields .= "</p>\n";
            }
            $fields .= "<p>\n";
            $fields .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-ult_hidden_desktop'>" . esc_html__('Hide for Desktop', 'ultimatum') . ":</label>";
            $fields .= "<input type='checkbox' name='widget-{$widget->id_base}[{$widget->number}][ult_hidden_desktop]' id='widget-{$widget->id_base}-{$widget->number}-ult_hidden_desktop' value='hidden-desktop' ". checked($instance['ult_hidden_desktop'], 'hidden-desktop', false) .">";
            $fields .= "</p>\n";
            $fields .= "<p>\n";
            $fields .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-ult_hidden_tablet'>" . esc_html__('Hide for Tablets', 'ultimatum') . ":</label>";
            $fields .= "<input type='checkbox' name='widget-{$widget->id_base}[{$widget->number}][ult_hidden_tablet]' id='widget-{$widget->id_base}-{$widget->number}-ult_hidden_tablet' value='hidden-tablet' ". checked($instance['ult_hidden_tablet'], 'hidden-tablet', false) .">";
            $fields .= "</p>\n";
            $fields .= "<p>\n";
            $fields .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-ult_hidden_mobile'>" . esc_html__('Hide for Mobile', 'ultimatum') . ":</label>";
            $fields .= "<input type='checkbox' name='widget-{$widget->id_base}[{$widget->number}][ult_hidden_mobile]' id='widget-{$widget->id_base}-{$widget->number}-ult_hidden_mobile' value='hidden-phone' ". checked($instance['ult_hidden_mobile'], 'hidden-phone', false) .">";
            $fields .= "</p>\n";
            $fields .="</div></div>";


                //do_action( 'widget_css_classes_form', $fields, $instance );

                echo $fields;

            return $instance;
        }

        function apply_widget_template($temp, $params)
        {
            $template = $temp;
            if ($template['before_widget']) $params[0]['before_widget'] = $this->apply_change($params[0]['before_widget'], $template['before_widget']);
            if ($template['before_title']) $params[0]['before_title'] = $this->apply_change($params[0]['before_title'], $template['before_title']);
            if ($template['after_title']) $params[0]['after_title'] = $this->apply_change($params[0]['after_title'], $template['after_title']);
            if ($template['after_widget']) $params[0]['after_widget'] = $this->apply_change($params[0]['after_widget'], $template['after_widget']);

            return $params;

        }

        function apply_change($old, $newa)
        {
            $new = $newa['value'];
            $action = $newa['action'];
            if ($action == 'append') {
                $value = $old . $new;
            } elseif ($action == "prepend") {
                $value = $new . $old;
            } else {
                $value = $new;
            }

            return $value;

        }

        function widget_templates()
        {
            $widget_templates = array(
                'panel-default' => array(
                    'id' => 'panel-default',
                    'name' => 'Panel Default',
                    'before_widget' => null,
                    'before_title' => array('action' => 'replace', 'value' => '<div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'),
                    'after_title' => array('action' => 'replace', 'value' => '</div><div class="panel-body">'),
                    'after_widget' => array('action' => 'append', 'value' => '</div></div>'),
                    'requires' => 'title',
                    'gridwork' => 'tbs3',
                    'fall-back' => array(
                        'before_widget' => array('action' => 'append', 'value' => '<div class="panel panel-default"><div class="panel-body">'),
                        'before_title' => null,
                        'after_title' => null,
                        'after_widget' => array('action' => 'prepend', 'value' => '</div></div>'),
                    )
                ),
                'panel-primary' => array(
                    'id' => 'panel-primary',
                    'name' => 'Panel Primary',
                    'before_widget' => null,
                    'before_title' => array('action' => 'replace', 'value' => '<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">'),
                    'after_title' => array('action' => 'replace', 'value' => '</div><div class="panel-body">'),
                    'after_widget' => array('action' => 'append', 'value' => '</div></div>'),
                    'requires' => 'title',
                    'gridwork' => 'tbs3',
                    'fall-back' => array(
                        'before_widget' => array('action' => 'append', 'value' => '<div class="panel panel-primary"><div class="panel-body">'),
                        'before_title' => null,
                        'after_title' => null,
                        'after_widget' => array('action' => 'prepend', 'value' => '</div></div>'),
                    )
                ),
                'panel-success' => array(
                    'id' => 'panel-success',
                    'name' => 'Panel Success',
                    'before_widget' => null,
                    'before_title' => array('action' => 'replace', 'value' => '<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title">'),
                    'after_title' => array('action' => 'replace', 'value' => '</div><div class="panel-body">'),
                    'after_widget' => array('action' => 'append', 'value' => '</div></div>'),
                    'requires' => 'title',
                    'gridwork' => 'tbs3',
                    'fall-back' => array(
                        'before_widget' => array('action' => 'append', 'value' => '<div class="panel panel-success"><div class="panel-body">'),
                        'before_title' => null,
                        'after_title' => null,
                        'after_widget' => array('action' => 'prepend', 'value' => '</div></div>'),
                    )
                ),
                'panel-warning' => array(
                    'id' => 'panel-warning',
                    'name' => 'Panel Warning',
                    'before_widget' => null,
                    'before_title' => array('action' => 'replace', 'value' => '<div class="panel panel-warning"><div class="panel-heading"><h3 class="panel-title">'),
                    'after_title' => array('action' => 'replace', 'value' => '</div><div class="panel-body">'),
                    'after_widget' => array('action' => 'append', 'value' => '</div></div>'),
                    'requires' => 'title',
                    'gridwork' => 'tbs3',
                    'fall-back' => array(
                        'before_widget' => array('action' => 'append', 'value' => '<div class="panel panel-warning"><div class="panel-body">'),
                        'before_title' => null,
                        'after_title' => null,
                        'after_widget' => array('action' => 'prepend', 'value' => '</div></div>'),
                    )
                ),
                'panel-danger' => array(
                    'id' => 'panel-danger',
                    'name' => 'Panel Danger',
                    'before_widget' => null,
                    'before_title' => array('action' => 'replace', 'value' => '<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">'),
                    'after_title' => array('action' => 'replace', 'value' => '</div><div class="panel-body">'),
                    'after_widget' => array('action' => 'append', 'value' => '</div></div>'),
                    'requires' => 'title',
                    'gridwork' => 'tbs3',
                    'fall-back' => array(
                        'before_widget' => array('action' => 'append', 'value' => '<div class="panel panel-danger"><div class="panel-body">'),
                        'before_title' => null,
                        'after_title' => null,
                        'after_widget' => array('action' => 'prepend', 'value' => '</div></div>'),
                    )
                ),
                'panel-info' => array(
                    'id' => 'panel-info',
                    'name' => 'Panel Info',
                    'before_widget' => null,
                    'before_title' => array('action' => 'replace', 'value' => '<div class="panel panel-info"><div class="panel-heading"><h3 class="panel-title">'),
                    'after_title' => array('action' => 'replace', 'value' => '</div><div class="panel-body">'),
                    'after_widget' => array('action' => 'append', 'value' => '</div></div>'),
                    'requires' => 'title',
                    'gridwork' => 'tbs3',
                    'fall-back' => array(
                        'before_widget' => array('action' => 'append', 'value' => '<div class="panel panel-info"><div class="panel-body">'),
                        'before_title' => null,
                        'after_title' => null,
                        'after_widget' => array('action' => 'prepend', 'value' => '</div></div>'),
                    )
                ),
                'alert-warning' => array(
                    'id' => 'alert-warning',
                    'name' => 'Alert Warning',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="alert alert-warning">'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),
                'alert-success' => array(
                    'id' => 'alert-success',
                    'name' => 'Alert Success',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="alert alert-success">'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),
                'alert-danger' => array(
                    'id' => 'alert-danger',
                    'name' => 'Alert Danger',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="alert alert-danger">'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),
                'alert-info' => array(
                    'id' => 'alert-info',
                    'name' => 'Alert Info',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="alert alert-info">'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),
                'alert-warning-dismissible' => array(
                    'id' => 'alert-warning-dismissible',
                    'name' => 'Alert Warning Dismissible',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert">×</button>'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),
                'alert-success-dismissible' => array(
                    'id' => 'alert-success-dismissible',
                    'name' => 'Alert Success Dismissible',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">×</button>'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),
                'alert-danger-dismissible' => array(
                    'id' => 'alert-danger-dismissible',
                    'name' => 'Alert Danger Dismissible',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">×</button>'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),
                'alert-info-dismissible' => array(
                    'id' => 'alert-info-dismissible',
                    'name' => 'Alert Info Dismissible',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert">×</button>'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),
                'well' => array(
                    'id' => 'well',
                    'name' => 'Well',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="well">'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),
                'well-sm' => array(
                    'id' => 'well-sm',
                    'name' => 'Well Small',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="well well-sm">'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),
                'well-lg' => array(
                    'id' => 'well-lg',
                    'name' => 'Well Large',
                    'before_widget' => array('action' => 'append', 'value' => '<div class="well well-lg">'),
                    'before_title' => null,
                    'after_title' => null,
                    'after_widget' => array('action' => 'append', 'value' => '</div>'),
                    'requires' => null,
                    'gridwork' => 'tbs3'
                ),

            );
            return apply_filters('ult_widget_templates', $widget_templates);
        }

        function add_widget_extras($params)
        {
            global $wp_registered_widgets, $widget_number, $ultimatumlayout;

            $arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets
            $this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
            $widget_id = $params[0]['widget_id'];
            $widget_obj = $wp_registered_widgets[$widget_id];
            $widget_num = $widget_obj['params'][0]['number'];
            $widget_opt = null;

            // if Widget Logic plugin is enabled, use it's callback
            if (in_array('widget-logic/widget_logic.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                $widget_logic_options = get_option('widget_logic');
                if (isset($widget_logic_options['widget_logic-options-filter']) && 'checked' == $widget_logic_options['widget_logic-options-filter']) {
                    $widget_opt = get_option($widget_obj['callback_wl_redirect'][0]->option_name);
                } else {
                    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
                }

                // if Widget Context plugin is enabled, use it's callback
            } elseif (in_array('widget-context/widget-context.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                $callback = isset($widget_obj['callback_original_wc']) ? $widget_obj['callback_original_wc'] : null;
                $callback = !$callback && isset($widget_obj['callback']) ? $widget_obj['callback'] : null;

                if ($callback && is_array($widget_obj['callback'])) {
                    $widget_opt = get_option($callback[0]->option_name);
                }
            } // Default callback
            else {
                // Check if WP Page Widget is in use
                global $post;
                $id = (isset($post->ID) ? get_the_ID() : NULL);
                if (isset($id) && get_post_meta($id, '_customize_sidebars')) {
                    $custom_sidebarcheck = get_post_meta($id, '_customize_sidebars');
                }
                if (isset($custom_sidebarcheck[0]) && ($custom_sidebarcheck[0] == 'yes')) {
                    $widget_opt = get_option('widget_' . $id . '_' . substr($widget_obj['callback'][0]->option_name, 7));
                } else {
                    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
                }
            }

            // add classes
            $class = array();
            if (isset($widget_opt[$widget_num]['ult_classes']) && !empty($widget_opt[$widget_num]['ult_classes'])){
                $class[] = $widget_opt[$widget_num]['ult_classes'];
            }
            if (isset($widget_opt[$widget_num]['ult_hidden_desktop']) && !empty($widget_opt[$widget_num]['ult_hidden_desktop'])){
                $class[] = $widget_opt[$widget_num]['ult_hidden_desktop'];
            }
            if (isset($widget_opt[$widget_num]['ult_hidden_tablet']) && !empty($widget_opt[$widget_num]['ult_hidden_tablet'])){
                $class[] = $widget_opt[$widget_num]['ult_hidden_tablet'];
            }
            if (isset($widget_opt[$widget_num]['ult_hidden_mobile']) && !empty($widget_opt[$widget_num]['ult_hidden_mobile'])){
                $class[] = $widget_opt[$widget_num]['ult_hidden_mobile'];
            }
            if(count($class)!=0){
                $classes = implode(" ",$class);
                $params[0]['before_widget'] = preg_replace('/class="/', "class=\"{$classes} ", $params[0]['before_widget'], 1);
            }

            if (isset($widget_opt[$widget_num]['ult_template']) && !empty($widget_opt[$widget_num]['ult_template']) && $widget_opt[$widget_num]['ult_template'] != 'default') {
                $templates = $this->widget_templates();
                $template = $templates[$widget_opt[$widget_num]['ult_template']];
                if(isset($template) && is_array($template)) {
                    if ($template['requires'] && !$widget_opt[$widget_num][$template['requires']]) {
                        $temp = $template['fall-back'];
                    } else {
                        $temp = $template;
                    }
                    $params = $this->apply_widget_template($temp, $params);
                }

            }
            return $params;
        }
    }

    new Ultimatum_Widget_Extender();
}