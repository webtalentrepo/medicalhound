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
	jQuery('#api_submitter').live('click', function(){
		var api_key = jQuery('.api_key').val();
		var prefix = jQuery('.prefix').val();
			jQuery.post(ajaxurl, {
				action:'lisans_kontrol',
				api_key: api_key,
				prefix : prefix,
				cookie: encodeURIComponent(document.cookie)
				}, function(str){
					jQuery("#installer").append(str);
				});		
	});
	
});