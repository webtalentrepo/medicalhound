<?php
add_action('admin_enqueue_scripts','layouteditor_scripts');
add_action('admin_enqueue_scripts','layouteditor_styles');
function layouteditor_styles(){
    wp_enqueue_style('thickbox');
    wp_enqueue_style( 'wp-color-picker' );
//	wp_enqueue_style('ultimatum-sc-editor',ULTIMATUM_ADMIN_ASSETS.'/css/ultimatum-sc-editor.css');
}

function layouteditor_scripts(){
    global $wp_version;
    wp_enqueue_media();
    wp_enqueue_script('media-upload');
    wp_enqueue_script('jquery');
    wp_enqueue_script('thickbox');
    wp_enqueue_script( 'wp-color-picker' );

}

add_action( 'load-dashboard_page_ultimatum-custom-css', 'ultimatum_custom_css_thickbox' );

function ultimatum_custom_css_thickbox()
{
    iframe_header();
    ultimatum_custom_css_generator();
    iframe_footer();
    exit;
}
function ultimatum_custom_css_screen(){

}

function ultimatum_custom_css_generator(){
    ?>
    <script type='text/javascript' src='<?php echo ULTIMATUM_ADMIN_ASSETS;?>/js/codemirror/lib/codemirror.js'></script>
    <script type='text/javascript' src='<?php echo ULTIMATUM_ADMIN_ASSETS;?>/js/codemirror/mode/css/css.js'></script>
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo ULTIMATUM_ADMIN_ASSETS;?>/js/codemirror/lib/codemirror.css" />
    <?php
    if(isset($_REQUEST['layout_id'])){
        $layout_id = $_REQUEST['layout_id'];
        $option = THEME_SLUG.'_custom_css_'.$layout_id;
        $cssfile = 'layout_custom_'.$layout_id;
    } elseif($_REQUEST['template_id']){
        $layout_id = $_REQUEST['template_id'];
        $option = THEME_SLUG.'_custom_template_css_'.$layout_id;
        $cssfile = 'template_custom_'.$layout_id;
    }
    if($_POST) {
        $file = THEME_CACHE_DIR . DS . $cssfile . '.css';
        if (file_exists($file)) {
            unlink($file);
        }
        delete_option($option);
        if (strlen($_POST['custom_css']) != 0) {
            update_option($option, $_POST['custom_css']);
            $fhandle = @fopen($file, 'w+');
            if ($fhandle) fwrite($fhandle, stripslashes($_POST['custom_css']), strlen(stripslashes($_POST['custom_css'])));
        }
    }
    $css=stripslashes(get_option($option));
    ?>
    <form method="post" action="" id="css-editor-form">
        <div class="fixed-top">
            <div class="tb-closer"><i class="fa fa-off"></i> Close</div>
            <div class="save-form" data-form="css-editor-form"><i class="fa fa-save"></i> <?php _e('Save', 'ultimatum');?></div>
        </div>
        <textarea id="custom_css" name="custom_css"><?php echo $css; ?></textarea>
    </form>
    <script type="text/javascript">
        var editor = CodeMirror.fromTextArea(document.getElementById("custom_css"), {
                mode: "text/css",
                styleActiveLine: true,
                lineNumbers: true,
                lineWrapping: true}
        );
        jQuery('.tb-closer') .click(
            function() {
                self.parent.tb_remove();
            });
        jQuery('.save-form').each(function(){
            var form = jQuery(this).attr('data-form');
            jQuery(this).click(function(){
                jQuery('#'+form).submit();
            });
        });
    </script>
<?php
}

