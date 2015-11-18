function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function insertUltimateContent(theCode) {
	var ed;

	if (typeof tinyMCE != 'undefined' && (ed = tinyMCE.activeEditor) && !ed.isHidden()) {
		// restore caret position on IE
		if (tinymce.isIE && ed.windowManager.insertimagebookmark) ed.selection.moveToBookmark(ed.windowManager.insertimagebookmark);

		ed.execCommand('mceInsertContent', false, theCode);
		tinyMCEPopup.close();
	}
	return;
}