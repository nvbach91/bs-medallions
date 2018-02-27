/*this JS translates (vedoucí) to (Chief/Leader/Head)*/

jQuery(document).ready(function(){
	var url = window.location.href;
	if(url.indexOf("/en/aboutus") >= 0){
		jQuery(".membercap").each(function(){
			var t = jQuery(this);
			var text = t.html();
			var index = text.indexOf("vedoucí");
			if(index >= 0){
				t.html(text.substring(0, index-1) + "(Leader)");
			}
		});
	}

});