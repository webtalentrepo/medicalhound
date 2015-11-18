<?php


if( ! class_exists( 'UltimatumMegaMenu' ) )
{
    class UltimatumMegaMenu 
    {
        function __construct() 
        {
            add_action( 'wp_update_nav_menu_item', array( $this, 'save_custom_fields' ), 10, 3 );
            add_filter( 'wp_edit_nav_menu_walker', array( $this, 'add_custom_fields' ) );;
            add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_data_to_menu' ) );
			add_action( 'admin_enqueue_scripts', 	array( $this, 'scripts_and_styles' ) );
		}

		function scripts_and_styles() {
		    // scripts
		    wp_enqueue_media();
		    wp_enqueue_script( 'ultimatum-megamenu', ULTIMATUM_ADMIN_ASSETS . '/js/ultimatum-menu.js', array( 'jquery' ), '1.0.0', true );
		    wp_enqueue_style( 'ultimatum-megamenu', ULTIMATUM_ADMIN_ASSETS . '/css/ultimatum-menu.css', false, '1.0' );
		}
		
		
        function add_custom_fields() 
        {
			return 'UltimatumMenuAdminWalker';
		}

        function save_custom_fields( $menu_id, $menu_item_db_id, $args ) 
        {
            $field_name_suffix = array( 'status', 'width', 'columns', 'title', 'widgetarea', 'icon', 'thumbnail' );
            foreach ( $field_name_suffix as $key ) 
            {
                if( !isset( $_REQUEST['menu-item-ultimatum-megamenu-'.$key][$menu_item_db_id] ) ) 
                {
                    $_REQUEST['menu-item-ultimatum-megamenu-'.$key][$menu_item_db_id] = '';
                }
                $value = $_REQUEST['menu-item-ultimatum-megamenu-'.$key][$menu_item_db_id];
                update_post_meta( $menu_item_db_id, '_menu_item_ultimatum_megamenu_'.$key, $value );
            }
        }

        function add_data_to_menu( $menu_item ) 
        {
            $menu_item->ultimatum_megamenu_status = get_post_meta( $menu_item->ID, '_menu_item_ultimatum_megamenu_status', true );
            $menu_item->ultimatum_megamenu_width = get_post_meta( $menu_item->ID, '_menu_item_ultimatum_megamenu_width', true );
            $menu_item->ultimatum_megamenu_columns = get_post_meta( $menu_item->ID, '_menu_item_ultimatum_megamenu_columns', true );
            $menu_item->ultimatum_megamenu_title = get_post_meta( $menu_item->ID, '_menu_item_ultimatum_megamenu_title', true );
            $menu_item->ultimatum_megamenu_widgetarea = get_post_meta( $menu_item->ID, '_menu_item_ultimatum_megamenu_widgetarea', true );
            $menu_item->ultimatum_megamenu_icon = get_post_meta( $menu_item->ID, '_menu_item_ultimatum_megamenu_icon', true );
            $menu_item->ultimatum_megamenu_thumbnail = get_post_meta( $menu_item->ID, '_menu_item_ultimatum_megamenu_thumbnail', true );
            return $menu_item;
        }
    } 
}


/*
 * The Customized admin walker for adding fields
 * copy-paste-edit form wp-admin/includes/nav-menu.php
 */
if( ! class_exists( 'UltimatumMenuAdminWalker' ) ) {

    class UltimatumMenuAdminWalker extends Walker_Nav_Menu {

        function start_lvl( &$output, $depth = 0, $args = array() ) {}

        function end_lvl( &$output, $depth = 0, $args = array() ) {}

        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            global $_wp_nav_menu_max_depth, $wp_registered_sidebars;
            $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

            ob_start();
            $item_id = esc_attr( $item->ID );
            $removed_args = array(
                'action',
                'customlink-tab',
                'edit-menu-item',
                'menu-item',
                'page-tab',
                '_wpnonce',
            );

            $original_title = '';
            if ( 'taxonomy' == $item->type ) {
                $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
                if ( is_wp_error( $original_title ) )
                    $original_title = false;
            } elseif ( 'post_type' == $item->type ) {
                $original_object = get_post( $item->object_id );
                $original_title = get_the_title( $original_object->ID );
            }

            $classes = array(
                'menu-item menu-item-depth-' . $depth,
                'menu-item-' . esc_attr( $item->object ),
                'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
            );

            $title = $item->title;

            if ( ! empty( $item->_invalid ) ) {
                $classes[] = 'menu-item-invalid';
                $title = sprintf( __( '%s (Invalid)', 'ultimatum'), $item->title );
            } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
                $classes[] = 'pending';
                $title = sprintf( __('%s (Pending)', 'ultimatum'), $item->title );
            }

            $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

            $submenu_text = '';
            if ( 0 == $depth )
                $submenu_text = 'style="display: none;"';

            ?>
			<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php _e( 'sub item' , 'ultimatum'); ?></span></span>
						<span class="item-controls">
							<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
							<span class="item-order hide-if-js">
								<a href="<?php
									echo wp_nonce_url(
										add_query_arg(
											array(
												'action' => 'move-up-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									);
								?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'ultimatum'); ?>">&#8593;</abbr></a>
								|
								<a href="<?php
									echo wp_nonce_url(
										add_query_arg(
											array(
												'action' => 'move-down-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									);
								?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'ultimatum'); ?>">&#8595;</abbr></a>
							</span>
							<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item', 'ultimatum'); ?>" href="<?php
								echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
							?>"><?php _e( 'Edit Menu Item', 'ultimatum' ); ?></a>
						</span>
					</dt>
				</dl>

				<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
					<?php if( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo $item_id; ?>">
								<?php _e( 'URL', 'ultimatum' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-thin">
						<label for="edit-menu-item-title-<?php echo $item_id; ?>">
							<?php _e( 'Navigation Label', 'ultimatum' ); ?><br />
							<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="description description-thin">
						<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
							<?php _e( 'Title Attribute', 'ultimatum' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="field-link-target description">
						<label for="edit-menu-item-target-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
							<?php _e( 'Open link in a new window/tab', 'ultimatum' ); ?>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
							<?php _e( 'CSS Classes (optional)', 'ultimatum' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
							<?php _e( 'Link Relationship (XFN)', 'ultimatum' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo $item_id; ?>">
							<?php _e( 'Description', 'ultimatum' ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
							<span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', 'ultimatum' ); ?></span>
						</label>
					</p>

					<?php
					// Add the custom field options
					do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args );
					?>

					<p class="field-move hide-if-no-js description description-wide">
						<label>
							<span><?php _e( 'Move', 'ultimatum' ); ?></span>
							<a href="#" class="menus-move-up"><?php _e( 'Up one', 'ultimatum' ); ?></a>
							<a href="#" class="menus-move-down"><?php _e( 'Down one', 'ultimatum' ); ?></a>
							<a href="#" class="menus-move-left"></a>
							<a href="#" class="menus-move-right"></a>
							<a href="#" class="menus-move-top"><?php _e( 'To the top', 'ultimatum' ); ?></a>
						</label>
					</p>

					<div class="menu-item-actions description-wide submitbox">
						<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
							<p class="link-to-original">
								<?php printf( __('Original: %s', 'ultimatum' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
						echo wp_nonce_url(
							add_query_arg(
								array(
									'action' => 'delete-menu-item',
									'menu-item' => $item_id,
								),
								admin_url( 'nav-menus.php' )
							),
							'delete-menu_item_' . $item_id
						); ?>"><?php _e( 'Remove', 'ultimatum' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
							?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel', 'ultimatum' ); ?></a>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}

	}
}

/*
 * Define and add the custom fields
 */
add_action( 'wp_nav_menu_item_custom_fields', 'ultimatum_add_megamenu_fields', 10, 4 );
function ultimatum_add_megamenu_fields( $item_id, $item, $depth, $args ) { ?>
	<div class="clear"></div>
	<div class="ultimatum-mega-menu-options">
		<p class="field-megamenu-status description description-wide">
			<label for="edit-menu-item-megamenu-status-<?php echo $item_id; ?>">
				<input type="checkbox" id="edit-menu-item-megamenu-status-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-status" name="menu-item-ultimatum-megamenu-status[<?php echo $item_id; ?>]" value="enabled" <?php checked( $item->ultimatum_megamenu_status, 'enabled' ); ?> />
				<strong><?php _e( 'Enable Ultimatum Mega Menu', 'ultimatum' ); ?></strong>
			</label>
		</p>
		<p class="field-megamenu-width description description-wide">
			<label for="edit-menu-item-megamenu-width-<?php echo $item_id; ?>">
				<input type="checkbox" id="edit-menu-item-megamenu-width-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-width" name="menu-item-ultimatum-megamenu-width[<?php echo $item_id; ?>]" value="fullwidth" <?php checked( $item->ultimatum_megamenu_width, 'fullwidth' ); ?> />
				<?php _e( 'Full Width Mega Menu', 'ultimatum' ); ?>
			</label>
		</p>
		<p class="field-megamenu-columns description description-wide">
			<label for="edit-menu-item-megamenu-columns-<?php echo $item_id; ?>">
				<?php _e( 'Mega Menu Number of Columns', 'ultimatum' ); ?>
				<select id="edit-menu-item-megamenu-columns-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-columns" name="menu-item-ultimatum-megamenu-columns[<?php echo $item_id; ?>]">
					<option value="auto" <?php selected( $item->ultimatum_megamenu_columns, 'auto' ); ?>><?php _e( 'Auto', 'ultimatum' ); ?></option>
					<option value="1" <?php selected( $item->ultimatum_megamenu_columns, '1' ); ?>>1</option>
					<option value="2" <?php selected( $item->ultimatum_megamenu_columns, '2' ); ?>>2</option>
					<option value="3" <?php selected( $item->ultimatum_megamenu_columns, '3' ); ?>>3</option>
					<option value="4" <?php selected( $item->ultimatum_megamenu_columns, '4' ); ?>>4</option>
					<option value="5" <?php selected( $item->ultimatum_megamenu_columns, '5' ); ?>>5</option>
					<option value="6" <?php selected( $item->ultimatum_megamenu_columns, '6' ); ?>>6</option>
				</select>
			</label>
		</p>
		<p class="field-megamenu-title description description-wide">
			<label for="edit-menu-item-megamenu-title-<?php echo $item_id; ?>">
				<input type="checkbox" id="edit-menu-item-megamenu-title-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-title" name="menu-item-ultimatum-megamenu-title[<?php echo $item_id; ?>]" value="disabled" <?php checked( $item->ultimatum_megamenu_title, 'disabled' ); ?> />
				<?php _e( 'Disable Mega Menu Column Title', 'ultimatum' ); ?>
			</label>
		</p>
		<p class="field-megamenu-widgetarea description description-wide">
			<label for="edit-menu-item-megamenu-widgetarea-<?php echo $item_id; ?>">
				<?php _e( 'Mega Menu Widget Area', 'ultimatum' ); ?>
				<select id="edit-menu-item-megamenu-widgetarea-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-widgetarea" name="menu-item-ultimatum-megamenu-widgetarea[<?php echo $item_id; ?>]">
					<option value="0"><?php _e( 'Select Widget Area', 'ultimatum' ); ?></option>
					<?php
					global $wp_registered_sidebars;
					if( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ):
					foreach( $wp_registered_sidebars as $sidebar ):
					?>
					<option value="<?php echo $sidebar['id']; ?>" <?php selected( $item->ultimatum_megamenu_widgetarea, $sidebar['id'] ); ?>><?php echo $sidebar['name']; ?></option>
					<?php endforeach; endif; ?>
				</select>
			</label>
		</p>
		<p class="field-megamenu-icon description description-wide">
			<label for="edit-menu-item-megamenu-icon-<?php echo $item_id; ?>">
				<?php _e( 'Mega Menu Icon (use full font awesome name)', 'ultimatum' ); ?>
				<input type="text" id="edit-menu-item-megamenu-icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-icon" name="menu-item-ultimatum-megamenu-icon[<?php echo $item_id; ?>]" value="<?php echo $item->ultimatum_megamenu_icon; ?>" />
			</label>
		</p>
		<a href="#" id="ultimatum-media-upload-<?php echo $item_id; ?>" class="ultimatum-open-media button button-primary ultimatum-megamenu-upload-thumbnail"><?php _e( 'Set Thumbnail', 'ultimatum' ); ?></a>
		<p class="field-megamenu-thumbnail description description-wide">
			<label for="edit-menu-item-megamenu-thumbnail-<?php echo $item_id; ?>">
				<input type="hidden" id="edit-menu-item-megamenu-thumbnail-<?php echo $item_id; ?>" class="ultimatum-new-media-image widefat code edit-menu-item-megamenu-thumbnail" name="menu-item-ultimatum-megamenu-thumbnail[<?php echo $item_id; ?>]" value="<?php echo $item->ultimatum_megamenu_thumbnail; ?>" />
				<img src="<?php echo $item->ultimatum_megamenu_thumbnail; ?>" id="ultimatum-media-img-<?php echo $item_id; ?>" class="ultimatum-megamenu-thumbnail-image" style="<?php echo ( trim( $item->ultimatum_megamenu_thumbnail ) ) ? 'display: inline;' : '';?>" />
				<a href="#" id="ultimatum-media-remove-<?php echo $item_id; ?>" class="remove-ultimatum-megamenu-thumbnail" style="<?php echo ( trim( $item->ultimatum_megamenu_thumbnail ) ) ? 'display: inline;' : '';?>">Remove Image</a>
			</label>
		</p>
	</div>
<?php }  

new UltimatumMegaMenu();



