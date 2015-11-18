jQuery(document).ready(function() {
	var editor = CodeMirror.fromTextArea(document.getElementById("custom_css"), {
    mode: "text/css",
	  styleActiveLine: true,
	  lineNumbers: true,
	  lineWrapping: true
	  });
  var editor2 = CodeMirror.fromTextArea(document.getElementById("custom_css_theme"), {
    mode: "text/css",
	  styleActiveLine: true,
	  lineNumbers: true,
	  lineWrapping: true
	  });
  editor2.on("change", function(editor2, change) {
	  var theme_css = editor2.getValue();
	  jQuery('#custom_css_theme_style').html(theme_css);
	  });
  editor.on("change", function(editor, change) {
	  var layout_css = editor.getValue();
	  jQuery('#custom_css_layout_style').html(layout_css);
	  });
 	jQuery('#css-gen-close').click(function(){
		jQuery(".ultimatum-css-customizer").hide();
	});
	jQuery('#css-gen-save').click(function(){
		jQuery("#ultimatum-custom-css-form").submit();
	});
	jQuery("#lspec-click").live('click', function(){
		jQuery('#lspecific .CodeMirror').each(function(i, el){
		    el.CodeMirror.refresh();
		 });
	});
  });
function UltCssGenerator(){
	jQuery("body").addClass("ult-css-gen");
	jQuery(".ultimatum-css-customizer").show();	
	jQuery('.CodeMirror').each(function(i, el){
	    el.CodeMirror.refresh();
	 });
};
