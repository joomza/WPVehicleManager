// responsive tables
jQuery('table#jsvm_js-table').each(function(i){
	var headertext = [];
	
	headers = jQuery(this).find('th');
	tablerows = jQuery(this).find('th');
	tablebody = jQuery(this).find('tbody tr');

	for (var i = 0; i < headers.length; i++) {
	    var current = headers[i];
	    headertext.push(current.textContent.replace(/\r?\n|\r/, ""));
	}

	for (var i = 0; row = tablebody[i]; i++) {
		var cols = jQuery(row).find('td');
	    for (var j = 0; col = cols[j]; j++) {
	        col.setAttribute("data-th", headertext[j]);
	    }
	}
});
