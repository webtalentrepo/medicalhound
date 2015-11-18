<?php
/**
 * Fıxes thanks to Trevor @cotswoldphoto
 */
add_action('admin_enqueue_scripts','udefaultscreen_scripts');
add_action('admin_enqueue_scripts','udefaultscreen_styles');

function udefaultscreen_scripts(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('thickbox');
    wp_enqueue_style( 'ultimatum-notes',ULTIMATUM_ADMIN_ASSETS.'/css/notes.css' );
    wp_enqueue_script( 'ultimatum-installer',ULTIMATUM_ADMIN_ASSETS.'/js/interface-installer.js' );
    wp_enqueue_script( 'ultimatum-bootstrap',ULTIMATUM_ADMIN_ASSETS.'/js/admin.bootstrap.min.js' );
}
function udefaultscreen_styles(){
    wp_enqueue_style('thickbox');
}


function wonderNotes(){
    ?>
    <style>
        table.ult_status_table {
            font-family: monospace;
        }
        table.ult_status_table td:first-child {
            width: 20%;
            border-right:0;
        }
        table.ult_status_table td {
            padding: 6px 9px;
            font-size: 1.1em;
        }

        table.ult_status_table td mark{background:transparent none}
        table.ult_status_table td mark.yes{color:green}
        table.ult_status_table td mark.no{color:#999}
        table.ult_status_table td mark.error{color:red}
        table.ult_status_table td ul{margin:0}
    </style>
    <div class="wrap about-wrap ult-wrap">
        <h2><?php _e('ULTIMATUM SYSTEM REPORT','ultimatum')?></h2>
        <p class="submit"><?php _e( 'Please include this information when requesting support:', 'ultimatum' ); ?> <a href="#" download="ultimatum_report.txt" class="button-primary debug-report"><?php _e( 'Download System Report File', 'ultimatum' ); ?></a></p>

        <br/>
        <table class="widefat ult-tables ult_status_table">


            <thead>
            <tr>
                <th colspan="2"><?php _e( 'Environment', 'ultimatum' ); ?></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td><?php _e( 'Home URL','ultimatum' ); ?>:</td>
                <td><?php echo home_url(); ?></td>
            </tr>
            <tr>
                <td><?php _e( 'Site URL','ultimatum' ); ?>:</td>
                <td><?php echo site_url(); ?></td>
            </tr>
            <tr>
                <td><?php _e( 'Ultimatum Version','ultimatum' ); ?>:</td>
                <td><?php echo esc_html( ULTIMATUM_VERSION ); ?></td>
            </tr>
            <tr>
                <td><?php _e( 'WP Version','ultimatum' ); ?>:</td>
                <td><?php if ( is_multisite() ) echo 'WPMU'; else echo 'WP'; ?> <?php bloginfo('version'); ?></td>
            </tr>
            <tr>
                <td><?php _e( 'Web Server Info','ultimatum' ); ?>:</td>
                <td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] );  ?></td>
            </tr>
            <tr>
                <td><?php _e( 'PHP Version','ultimatum' ); ?>:</td>
                <td><?php if ( function_exists( 'phpversion' ) ) echo esc_html( phpversion() ); ?></td>
            </tr>
            <tr>
                <td><?php _e( 'MySQL Version','ultimatum' ); ?>:</td>
                <td>
                    <?php
                    global $wpdb;
                    echo $wpdb->db_version();
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php _e( 'WP Memory Limit','ultimatum' ); ?>:</td>
                <td>
                    <?php ultimatum_mem_check(true);?>
                </td>
            </tr>
            <tr>
                <td><?php _e( 'WP Debug Mode','ultimatum' ); ?>:</td>
                <td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">' . __( 'Yes', 'ultimatum' ) . '</mark>'; else echo '<mark class="no">' . __( 'No', 'ultimatum' ) . '</mark>'; ?></td>
            </tr>
            <tr>
                <td><?php _e( 'WP Max Upload Size','ultimatum' ); ?>:</td>
                <td><?php echo size_format( wp_max_upload_size() ); ?></td>
            </tr>
            <tr>
                <td><?php _e('PHP Post Max Size','ultimatum' ); ?>:</td>
                <td><?php if ( function_exists( 'ini_get' ) ) echo size_format( ultimatum_let_to_num( ini_get('post_max_size') ) ); ?></td>
            </tr>
            <tr>
                <td><?php _e('PHP Time Limit','ultimatum' ); ?>:</td>
                <td><?php if ( function_exists( 'ini_get' ) ) echo ini_get('max_execution_time'); ?></td>
            </tr>

            <tr>
                <td><?php _e( 'Default Timezone','ultimatum' ); ?>:</td>
                <td><?php
                    $default_timezone = date_default_timezone_get();
                    $phpini_timezone = ini_get('date.timezone');
                    if ( 'UTC' !== $default_timezone ) {
                        echo '<mark class="error">' . sprintf( __( 'Default timezone is %s - it should be UTC', 'ultimatum' ), $default_timezone ) . '</mark>';
                    } else {
                        echo '<mark class="yes">' . sprintf( __( 'Default timezone is %s', 'ultimatum' ), $default_timezone ) . sprintf( __( ', php.ini timezone is %s', 'ultimatum' ), $phpini_timezone ) . '</mark>';
                    } ?>
                </td>
            </tr>
            <?php
            //Do posting tests and echo results
            ultimatum_remote_post_test(true);
            ?>
            </tbody>
            <thead>
            <tr>
                <th colspan="2"><?php _e( 'Folder Permissions','ultimatum' ); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php
            ultimatum_folder_permissions_check(true);
            ?>
            </tbody>
            <thead>
            <tr>
                <th colspan="2"><?php _e( 'Activated Extras','ultimatum' ); ?></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td><?php _e( 'Ultimatum Forms','ultimatum' ); ?>:</td>
                <td>
                    <?php
                    if(get_ultimatum_option('extras', 'ultimatum_forms')){
                        _e('ON','ultimatum');
                    } else {
                        _e('OFF','ultimatum');
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php _e( 'Ultimatum Slideshows','ultimatum' ); ?>:</td>
                <td>
                    <?php
                    if(get_ultimatum_option('extras', 'ultimatum_slideshows')){
                        _e('ON','ultimatum');
                    } else {
                        _e('OFF','ultimatum');
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php _e( 'Ultimatum Shortcodes','ultimatum' ); ?>:</td>
                <td>
                    <?php
                    if(get_ultimatum_option('extras', 'ultimatum_shortcodes')){
                        _e('ON','ultimatum');
                    } else {
                        _e('OFF','ultimatum');
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php _e( 'Post Galleries','ultimatum' ); ?>:</td>
                <td>
                    <?php
                    if(get_ultimatum_option('extras', 'ultimatum_postgals')){
                        _e('ON','ultimatum');
                    } else {
                        _e('OFF','ultimatum');
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php _e( 'Post Ordering','ultimatum' ); ?>:</td>
                <td>
                    <?php
                    if(get_ultimatum_option('extras', 'ultimatum_pto')){
                        _e('ON','ultimatum');
                    } else {
                        _e('OFF','ultimatum');
                    }
                    ?>
                </td>
            </tr>
            </tbody>
            <thead>
            <tr>
                <th colspan="2"><?php _e( 'Plugins','ultimatum' ); ?></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td><?php _e( 'Installed Plugins','ultimatum' ); ?>:</td>
                <td><?php
                    $active_plugins = (array) get_option( 'active_plugins', array() );

                    if ( is_multisite() )
                        $active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

                    $wc_plugins = array();

                    foreach ( $active_plugins as $plugin ) {

                        $plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
                        $dirname        = dirname( $plugin );
                        $version_string = '';

                        if ( ! empty( $plugin_data['Name'] ) ) {

                            $wc_plugins[] = $plugin_data['Name'] . ' ' . __( 'by', 'ultimatum' ) . ' ' . $plugin_data['Author'] . ' ' . __( 'version', 'ultimatum' ) . ' ' . $plugin_data['Version'] . $version_string;

                        }
                    }

                    if ( sizeof( $wc_plugins ) == 0 )
                        echo '-';
                    else
                        echo implode( ', <br/>', $wc_plugins );

                    ?></td>
            </tr>
            </tbody>

        </table>

        <script type="text/javascript">

            jQuery.ult_strPad = function(i,l,s) {
                var o = i.toString();
                if (!s) { s = '0'; }
                while (o.length < l) {
                    o = o + s;
                }
                return o;
            };

            jQuery('a.debug-report').click(function(){

                var report = "";

                jQuery('.ult_status_table thead, .ult_status_table tbody').each(function(){

                    $this = jQuery( this );

                    if ( $this.is('thead') ) {

                        report = report + "\n### " + jQuery.trim( $this.text() ) + " ###\n\n";

                    } else {

                        jQuery('tr', $this).each(function(){

                            $this = jQuery( this );

                            name = jQuery.ult_strPad( jQuery.trim( $this.find('td:eq(0)').text() ), 25, ' ' );
                            value = jQuery.trim( $this.find('td:eq(1)').text() );

                            report = report + '' + name + value + "\n\n";
                        });

                    }
                } );

                var blob = new Blob( [report] );

                jQuery(this).attr( 'href', window.URL.createObjectURL( blob ) );

                return true;
            });

        </script>
    </div>
<?php
}




