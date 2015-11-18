<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
 */

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @package  Ultimatum
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.50
 */
add_action('admin_enqueue_scripts','layouteditor_scripts');
function layouteditor_scripts(){
	global $wp_version;
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-widget');
	wp_enqueue_script('jquery-ui-mouse');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-droppable');
	wp_enqueue_script('jquery-ui-selectable');
	wp_enqueue_style( 'ultimatum-row-selector',ULTIMATUM_ADMIN_ASSETS.'/css/ultimatum.row.selector.css' );
}
add_action( 'load-dashboard_page_ultimatum-layout-options', 'ultimatum_layout_options_thickbox' );

function ultimatum_layout_options_thickbox()
{
	iframe_header();
	ultimatum_layout_opts();
	iframe_footer();
	exit;
}
function ultimatum_layout_opts(){
    /*
     * var win = window.dialogArguments || opener || parent || top;
     * win.LayoutGetRow(id,style);
     * win.tb_remove();
     */
    if(!$_POST){
        $defaults = array(
            'type'  =>  'basic',
            'stickwidth'  =>  '300',
            'breakpoint'  =>  '992',
            'header' => '',
            'footer' => '',
            'class' => '',
        );
        $options = get_option(THEME_SLUG.'_'.$_GET['layout_id'].'_options');
        $vals = wp_parse_args( $options, $defaults );
//        echo '<pre>';
//        print_r($options);
//        echo '</pre>';
        ?>
    <form method="post" action ="">
        <table class="widefat">
            <tr>
                <th>
                    <label>Layout Type:</label>
                </th>
                <td>
                    <select name="type">
                        <option value="basic" <?php selected($vals['type'],'');?>>Basic</option>
                        <option value="fluid" <?php selected($vals['type'],'fluid');?>>Fluid</option>
                        <option value="fluidsl" <?php selected($vals['type'],'fluidsl');?>>Fluid with Sticky Left</option>
                        <option value="fluidsr" <?php selected($vals['type'],'fluidsr');?>>Fluid with Sticky Right</option>
                    </select>
                    <p>Fluid layouts will only work for Bootstrap 3 (other ones will not function well).Sticky Left/Right will stick the header section and will make the below setting for header obsolete.</p>
                </td>
            </tr>
            <tr>
                <th>
                    <label>Left or Right Sticked Width:</label>
                </th>
                <td>
                    <input type="text" name="stickwidth" value="<?php echo $vals['stickwidth'];?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label>Left or Right Sticky break point:</label>
                </th>
                <td>
                    <input type="text" name="breakpoint" value="<?php echo $vals['breakpoint'];?>"/>
                    <p>Below this pixel value the default layout will beshown without any thing stikcy</p>
                </td>
            </tr>
            <tr>
                <th>
                    <label>Header:</label>
                </th>
                <td>
                    <select name="header">
                        <option value="" <?php selected($vals['header'],'');?>>Basic</option>
                        <option value="sticky" <?php selected($vals['header'],'sticky');?>>Sticky</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    <label>Footer:</label>
                </th>
                <td>
                    <select name="footer">
                        <option value="" <?php selected($vals['footer'],'');?>>Basic</option>
                        <option value="sticky" <?php selected($vals['footer'],'sticky');?>>Sticky - Always shown</option>
                        <option value="push"  <?php selected($vals['footer'],'push');?>>Pushed Down in viewport</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    <label>Extra Classes:</label>
                </th>
                <td>
                    <input type="text" name="class" value="<?php echo $vals['class'];?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" class="button button-primary" />
                </td>
            </tr>
        </table>

    </form>
    <?php
    } else {
        update_option(THEME_SLUG.'_'.$_GET['layout_id'].'_options',$_POST);
        ?>
        <script type="text/javascript">
            var win = window.dialogArguments || opener || parent || top;
            win.tb_remove();
        </script>
        <?php
    }


}

function ultimatum_layout_options_screen(){
	
}
?>
