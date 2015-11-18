/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
this file under any circumstances.
*/

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @category Ultimatum
 * @package  Templates
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.50
 */
// Layout Generator 
var LayoutGetRow;
(function($){
	LayoutSetRowIds = function(){
		var ids = jQuery('#header_cont').sortable('toArray').toString();
		jQuery('#before_main').val(ids);
		var ids = jQuery('#body_cont').sortable('toArray').toString();
		jQuery('#layout_row_ids').val(ids);
		var ids = jQuery('#footer_cont').sortable('toArray').toString();
		jQuery('#after_main').val(ids);
		SaveLayout(0);
		
		}
	LayoutSetRowIds2 = function(){
		var ids = jQuery('#body_cont').sortable('toArray').toString();
		jQuery('#layout_row_ids').val(ids);
		SaveLayout(1);
		//location.reload();
		}
	LayoutDeleteRow = function(attachment_id){
		jQuery("#"+ attachment_id).remove();
		LayoutSetRowIds();
		}
	LayoutGetRow = function(layoutid,rowstyle){
		jQuery.post(ajaxurl, {
			action:'ultimatum-get-row',
			id: layoutid,
			style:rowstyle,
			cookie: encodeURIComponent(document.cookie)
			}, 
			function(str){
				if ( str == '0' ) {
					alert( 'ERROR' );
					} else {
						jQuery("#body_cont").append(str);
						LayoutSetRowIds2();
						}
				});
		}
	SaveLayout = function(reload){
		var layout_data = {
				action: 'ultimatum_save_layout_rows',
				layoutid:jQuery('#layoutid').val(),
				layoutname: jQuery('#layoutname').val(),
				rows:jQuery('#layout_row_ids').val(),
				before:jQuery('#before_main').val(),
				after:jQuery('#after_main').val(),
				theme:jQuery('#theme').val(),
				isdefault:jQuery('#isdefault').val(),
				type :jQuery('#layout_type').val()
		}
		jQuery.post(ajaxurl,layout_data, function(response) {
			if(reload==1) {
				location.reload();
			}
		});
	}
	SaveLayoutCSS=function(){
		window.tb_remove();
		LayoutSetRowIds();
		
	}
	Block = function(){
		jQuery('#blocker').css('display', 'block')
	}
	
	UnBlock = function(){
		jQuery('#blocker').css('display', 'none')
	}
	
	SetLayoutAssignments = function(){
		window.tb_remove();
		location.reload();
	}
	CreateLayout = function(layout_id,template_id,admin_url){
		window.tb_remove();
		window.location.href = admin_url+"admin.php?page=wonder-layout&task=edit&theme="+template_id+"&layoutid="+layout_id;
	}
	CloneLayout = function(layout_id){
		//ultimatum-clone-layout
		jQuery.post(ajaxurl, {
			action:'ultimatum-clone-layout',
			layoutid: layout_id,
			cookie: encodeURIComponent(document.cookie)
			}, function(str){
				location.reload();
			});
		
	}
	DefaultLayout = function(layout_id,template_id){
		jQuery.post(ajaxurl, {
			action:'ultimatum-default-layout',
			layout_id: layout_id,
			template_id : template_id,
			cookie: encodeURIComponent(document.cookie)
			}, function(str){
				location.reload();
			});
	}
	DeleteLayout = function(layout_id){
		jQuery.post(ajaxurl, {
			action:'ultimatum-delete-layout',
			layout_id: layout_id,
			cookie: encodeURIComponent(document.cookie)
			}, function(str){
				location.reload();
			});
	}
	
})(jQuery);

jQuery(document).ready(function() {
	/* Layout Functions */
	// Make Partials Droppable
	jQuery(function() {
		jQuery( ".partial_layo" ).draggable({
			connectToSortable: '.connectedSortable',
			distance: 2,
			helper: 'clone',
			zIndex: 100,
			containment: 'document',
		});
	});
	// Make Rows and Parts Draggable
	jQuery("#header_cont, #body_cont, #footer_cont").sortable({
		opacity: 0.6,
		handle: '.drag',
		cursor: 'move',
		distance: 2,
		containment: 'document',
		connectWith:".connectedSortable",
		placeholder: 'layout-row-placeholder',
		start: function(e,ui) {
			ui.item.css({margin:'', 'width':'','height':''});
		},
		stop: function(event, ui) {
			LayoutSetRowIds();
		},
		receive: function(event,ui) {
			dataID =jQuery(newItem).attr("data-id");
			jQuery(newItem).attr("id",dataID);
		  },
	  beforeStop: function (event, ui) { 
		  newItem = ui.item;
		  }
	});
	// Delete a Layout
	jQuery('.deletelayout',".layoutactions").live('click', function(){
		var where_to= confirm("Do you really want to delete this layout? This action is irreversible");
		if (where_to== true){
			var layout_id = jQuery(this).attr('data-layout');
			DeleteLayout(layout_id);
		
		}
	});
	// Clone a Layout
	jQuery('.clonelayout',".layoutactions").live('click', function(){
			var layout_id = jQuery(this).attr('data-layout');
			CloneLayout(layout_id);
	});
	// Set Layout as Default
	jQuery('.setdefault',".layoutactions").live('click', function(){
		var layout_id = jQuery(this).attr('data-layout');
		var template_id = jQuery(this).attr('data-template');
		DefaultLayout(layout_id,template_id);
	});
	 // Delete a ROW
	jQuery('.delete-item',".connectedSortable").live('click', function(){
		var where_to= confirm("Do you really want to delete this row?");
		if (where_to== true){
			var id = jQuery(this).attr('data-row');
			LayoutDeleteRow(id);
			} else {
				
			}
	});
	// DELETE PART
	jQuery('.delete-part',".connectedSortable").live('click', function(){
		var where_to= confirm("Do you really want to delete this part from layout?");
		if (where_to== true){
			jQuery(this).parent().parent().parent().parent().remove();
			LayoutSetRowIds();
			} else {
				
			}
	});
	// Popover controls for the editors.
	jQuery(".poppover").each(function () {
		var content = jQuery('.popover-content',this).html();
		var popper = jQuery('.poplink',this);
		popper.popover({
			html : true,
			content: function() {
				return content;
				},
			trigger: 'manual',
		}).click(function(e) {
			jQuery('.poplink').popover('hide');
			popper.popover('show');
			jQuery('.close-popover').click(function(e){
				popper.popover('hide');
			});
			e.preventDefault();
		});
	});
	// Save Button
	jQuery('#layosavebutton').click(function(e) {
		e.preventDefault();
		LayoutSetRowIds();
	});
});