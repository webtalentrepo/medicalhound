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

jQuery(document).ready(function() {
	// Delete Template 
	jQuery('.deletetemplate',".templateactions").live('click', function(){
		var template_id = jQuery(this).attr('data-id');
		var where_to= confirm("Do you really want to delete this Template? This action is irreversible");
		if (where_to== true){
			jQuery.post(ajaxurl, {
				action:'ultimatum-delete-template',
				template_id: template_id,
				cookie: encodeURIComponent(document.cookie)
				}, function(str){
					location.reload();
				});		
		}
	});
	//defaulttemplate
	jQuery('.defaulttemplate',".templateactions").live('click', function(){
		var template_id = jQuery(this).attr('data-id');
		jQuery.post(ajaxurl, {
			action:'ultimatum-default-template',
			template_id: template_id,
			cookie: encodeURIComponent(document.cookie)
			}, function(str){
				location.reload();
			});
	});
});