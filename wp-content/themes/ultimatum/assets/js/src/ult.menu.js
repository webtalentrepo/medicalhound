/**
 * Ultimatum Mega Menu
 */
jQuery.fn.ultimatum_position_megamenu = function () {
    var reference_elem = "";
    reference_elem = jQuery(this).parent("nav").parent();
    if (jQuery(this).parent("nav").length) {
        var main_nav_container = reference_elem,
            main_nav_container_position = main_nav_container.offset(),
            main_nav_container_width = main_nav_container.width(),
            main_nav_container_left_edge = main_nav_container_position.left,
            main_nav_container_right_edge = main_nav_container_left_edge + main_nav_container_width;
        if (!jQuery('body.rtl').length) {
            return this.each(function () {
                jQuery(this).children('li').each(function () {
                    var li_item = jQuery(this),
                        li_item_position = li_item.offset(),
                        megamenu_wrapper = li_item.find(".ultimatum-megamenu-wrapper"),
                        megamenu_wrapper_width = megamenu_wrapper.outerWidth(),
                        megamenu_wrapper_position = 0;
                    if (megamenu_wrapper.length) {
                        if (li_item_position.left + megamenu_wrapper_width > main_nav_container_right_edge) {
                            megamenu_wrapper_position = -1 * ( li_item_position.left - ( main_nav_container_right_edge - megamenu_wrapper_width ) );
                            if (li_item_position.left + megamenu_wrapper_position < main_nav_container_left_edge) {
                                megamenu_wrapper_position = -1 * ( li_item_position.left - main_nav_container_left_edge );
                            }
                        }
                        megamenu_wrapper.css('left', megamenu_wrapper_position);
                    }
                });
            });
        } else {
            return this.each(function () {
                jQuery(this).children("li").each(function () {
                    var li_item = jQuery(this),
                        li_item_position = li_item.offset(),
                        li_item_right_edge = li_item_position.left + li_item.outerWidth(),
                        megamenu_wrapper = li_item.find(".ultimatum-megamenu-wrapper"),
                        megamenu_wrapper_width = megamenu_wrapper.outerWidth(),
                        megamenu_wrapper_position = 0;
                    if (megamenu_wrapper.length) {
                        megamenu_wrapper.removeAttr('style');
                        if (li_item_right_edge - megamenu_wrapper_width < main_nav_container_left_edge) {
                            megamenu_wrapper_position = -1 * ( megamenu_wrapper_width - ( li_item_right_edge - main_nav_container_left_edge ) );
                            if (li_item_right_edge - megamenu_wrapper_position > main_nav_container_right_edge) {
                                megamenu_wrapper_position = -1 * ( main_nav_container_right_edge - li_item_right_edge );
                            }
                            megamenu_wrapper.css('right', megamenu_wrapper_position);
                        }
                    }
                });
            });
        }
    }
};

jQuery.fn.position_last_top_menu_item = function( variables ) {
    if( jQuery( this ).children( 'ul' ).length || jQuery( this).children( 'div' ).length ) {
        var last_item = jQuery( this ),
            last_item_left_pos = last_item.position().left,
            last_item_width = last_item.outerWidth(),
            last_item_child,
            parent_container = jQuery( '.ultimatum-menu' ),
            parent_container_left_pos = parent_container.position().left,
            parent_container_width = parent_container.outerWidth();

        if( last_item.children( 'ul' ).length ) {
            last_item_child =  last_item.children( 'ul' );
        } else if( last_item.children('div').length ) {
            last_item_child =  last_item.children( 'div' );
        }

        if( ! jQuery( 'body.rtl' ).length ) {
            if( last_item_left_pos + last_item_child.outerWidth() > parent_container_left_pos + parent_container_width ) {
                last_item_child.css( 'right', '-1px' ).css( 'left', 'auto' );

                last_item_child.find( '.sub-menu' ).each( function() {
                    jQuery( this ).css( 'right', '100px' ).css( 'left', 'auto' );
                });
            }
        } else {
            if( last_item_child.position().left < last_item_left_pos ) {
                last_item_child.css( 'left', '-1px' ).css( 'right', 'auto' );

                last_item_child.find( '.sub-menu' ).each( function() {
                    jQuery( this ).css( 'left', '100px' ).css( 'right', 'auto' );
                });
            }
        }
    }
};

if(jQuery.fn.ultimatum_position_megamenu){
    jQuery(".ultimatum-menu-nav").ultimatum_position_megamenu();
    jQuery(".ultimatum-menu-nav .ultimatum-megamenu-menu").mouseenter(function () {
        jQuery(this).parent().ultimatum_position_megamenu();
    });
}

jQuery(window).resize(function () {
    jQuery(".ultimatum-menu-nav").ultimatum_position_megamenu()
});

jQuery(document).click(function () {
    jQuery(".nav-search-form").hide()
});

jQuery(".nav-search-form").click(function (e) {
    e.stopPropagation()
});

jQuery(".nav-search .search-link").click(function (e) {
    e.stopPropagation();
    if("block" == jQuery(this).parent().find(".nav-search-form").css("display")) {
        jQuery(this).parent().find(".nav-search-form").hide();
    } else {
        jQuery(this).parent().find(".nav-search-form").show();
    }
});
