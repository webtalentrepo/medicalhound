(function($){
	themeGalleryImagesSetIds = function(){
		var ids = jQuery('#imagesSortable').sortable('toArray').toString();
		jQuery('#gallery_image_ids').val(ids);
	}
	themeGalleryDeleteImage = function(attachment_id){
		jQuery("#image-"+ attachment_id).remove();
		themeGalleryImagesSetIds();
	}
	themeGalleryCompleteEditImage = function(attachment_id){
		jQuery.post(ajaxurl, {
			action:'theme-gallery-get-image',
			id: attachment_id, 
			cookie: encodeURIComponent(document.cookie)
		}, function(str){
			if ( str == '0' ) {
				alert( 'Could not insert into gallery. Try a different attachment.' );
			} else {
				jQuery("#image-"+ attachment_id).replaceWith(str);
				themeGalleryImagesSetIds();
			}
		});
	};
})(jQuery);

jQuery(document).ready( function() {
	jQuery('.edit-item',"#imagesSortable").live('click', function(){
		var id = jQuery(this).parents('.imageItemWrap').attr('id').slice(6);//remove "image-"
		tb_show('Edit Image',"media.php?action=edit&attachment_id="+id+"&gallery_edit_image=true&TB_iframe=true");
	})

	jQuery('.delete-item',"#imagesSortable").live('click', function(){
		var id = jQuery(this).parents('.imageItemWrap').attr('id').slice(6);//remove "image-"
		
		themeGalleryDeleteImage(id);
	})
	jQuery("#imagesSortable").sortable({
		handle: '.handle',
		opacity: 0.6,
		placeholder: 'sort-item-placeholder',
		stop: function(event, ui) {
			themeGalleryImagesSetIds();
		}
	});
	var file_frame;
	jQuery('.upload_image_button').live('click', function( event ){
		event.preventDefault();
		if ( file_frame ) {
			file_frame.open();
			return;
		} 

		file_frame = wp.media.frames.file_frame = wp.media({
	    	title: jQuery( this ).data( 'uploader_title' ),
	    	button: {
	    		text: jQuery(this).data( 'uploader_button_text' ),
	    		},
	    	multiple: true
	    	});
	    file_frame.on('select', function() {
	    	var selection = file_frame.state().get('selection');
	    	selection.map( function( attachment ) {
	    		attachment = attachment.toJSON();
	    		jQuery.post(ajaxurl, {
	    			action:'theme-gallery-get-image',
	    			id: attachment.id,
	    			cookie: encodeURIComponent(document.cookie)
	    			},
	    			function(str){
	    				if ( str == '0' ) {
	    					alert( 'ERROR' );
	    					} else {
	    						jQuery("#imagesSortable").append(str);
	    						themeGalleryImagesSetIds();
	    						}
	    				});
	    		});
	    	});
	    file_frame.open();
	    });
	
	});
