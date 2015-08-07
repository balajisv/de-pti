function replaceURLWithHTMLLinks(text) {
	var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
	return text.replace(exp,"<a onclick='showWarningDialog(\"$1\")'>$1</a>");
}

function showWarningDialog(url) {
	$('#url').html(url);
	
	$('#url_warning').dialog({
		resizable: false,
		height: 250,
		width: 400,
		modal: true,
		buttons: {
			'Igen': function() {
				window.location = url;
				$('#url_warning').dialog('close');
			},
			'Nem': function() {
				$('#url_warning').dialog('close');
			}
		}
	});
}