(function() {
	tinymce.PluginManager.requireLangPack('ultimatum_shortcode');
	tinymce.create('tinymce.plugins.ultimatum_shortcode', {
		init : function(ed, url) {
			ed.addCommand('mceultimatum_shortcode', function() {
				ed.windowManager.open({
					file : './index.php?page=shortcode-create',
					width : 800 + ed.getLang('ultimatum_shortcode.delta_width', 0),
					height : 400 + ed.getLang('ultimatum_shortcode.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url 
				});
			});
			ed.addButton('ultimatum_shortcode', {
				title : 'Shortcode Generator',
				cmd : 'mceultimatum_shortcode',
				image : url + '/ultimatum-icon.png'
			});
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('ultimatum_shortcode', n.nodeName == 'IMG');
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
					longname  : 'Wonder Foundry ShortCode Inserter',
					author 	  : 'WonderFoundry',
					authorurl : 'http://www.wonderfoundry.com',
					infourl   : 'http://www.wonderfoundry.com',
					version   : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('ultimatum_shortcode', tinymce.plugins.ultimatum_shortcode);
})();


