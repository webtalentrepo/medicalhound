
( function( $ ) {

	"use strict";

	$( document ).ready( function() {

		ultimatum_megamenu.menu_item_mouseup();
		ultimatum_megamenu.megamenu_status_update();
		ultimatum_megamenu.update_megamenu_fields();

		$( '.remove-ultimatum-megamenu-thumbnail' ).manage_thumbnail_display();
		$( '.ultimatum-megamenu-thumbnail-image' ).css( 'display', 'block' );
		$( ".ultimatum-megamenu-thumbnail-image[src='']" ).css( 'display', 'none' );

		ultimatum_media_frame_setup();

	});

	var ultimatum_megamenu = {

		menu_item_mouseup: function() {
			$( document ).on( 'mouseup', '.menu-item-bar', function( event, ui ) {
				if( ! $( event.target ).is( 'a' )) {
					setTimeout( ultimatum_megamenu.update_megamenu_fields, 300 );
				}
			});
		},

		megamenu_status_update: function() {

			$( document ).on( 'click', '.edit-menu-item-megamenu-status', function() {
				var parent_li_item = $( this ).parents( '.menu-item:eq( 0 )' );

				if( $( this ).is( ':checked' ) ) {
					parent_li_item.addClass( 'ultimatum-megamenu' );
				} else 	{
					parent_li_item.removeClass( 'ultimatum-megamenu' );
				}

				ultimatum_megamenu.update_megamenu_fields();
			});
		},

		update_megamenu_fields: function() {
			var menu_li_items = $( '.menu-item');

			menu_li_items.each( function( i ) 	{

				var megamenu_status = $( '.edit-menu-item-megamenu-status', this );

				if( ! $( this ).is( '.menu-item-depth-0' ) ) {
					var check_against = menu_li_items.filter( ':eq(' + (i-1) + ')' );


					if( check_against.is( '.ultimatum-megamenu' ) ) {

						megamenu_status.attr( 'checked', 'checked' );
						$( this ).addClass( 'ultimatum-megamenu' );
					} else {
						megamenu_status.attr( 'checked', '' );
						$( this ).removeClass( 'ultimatum-megamenu' );
					}
				} else {
					if( megamenu_status.attr( 'checked' ) ) {
						$( this ).addClass( 'ultimatum-megamenu' );
					}
				}
			});
		}

	};

	$.fn.manage_thumbnail_display = function( variables ) {
		var button_id;

		return this.click( function( e ){
			e.preventDefault();

			button_id = this.id.replace( 'ultimatum-media-remove-', '' );
			$( '#edit-menu-item-megamenu-thumbnail-'+button_id ).val( '' );
			$( '#ultimatum-media-img-'+button_id ).attr( 'src', '' ).css( 'display', 'none' );
		});
	}

	function ultimatum_media_frame_setup() {
		var ultimatum_media_frame;
		var item_id;

		$( document.body ).on( 'click.ultimatumOpenMediaManager', '.ultimatum-open-media', function(e){

			e.preventDefault();

			item_id = this.id.replace('ultimatum-media-upload-', '');

			if ( ultimatum_media_frame ) {
				ultimatum_media_frame.open();
				return;
			}

			ultimatum_media_frame = wp.media.frames.ultimatum_media_frame = wp.media({

				className: 'media-frame ultimatum-media-frame',
				frame: 'select',
				multiple: false,
				library: {
					type: 'image'
				}
			});

			ultimatum_media_frame.on('select', function(){

				var media_attachment = ultimatum_media_frame.state().get('selection').first().toJSON();

				$( '#edit-menu-item-megamenu-thumbnail-'+item_id ).val( media_attachment.url );
				$( '#ultimatum-media-img-'+item_id ).attr( 'src', media_attachment.url ).css( 'display', 'block' );

			});

			ultimatum_media_frame.open();
		});

	}
})( jQuery );
function widget_xtender(selector) {

   jQuery(selector).siblings('.extender-in').slideToggle();

}