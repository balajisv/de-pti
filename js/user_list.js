function ShowSetLevelDialog(targetUrl) {
	$("#mbText").html(
		'<form method="post" name="frmSetLevel" action="'+targetUrl+'">\
			Új szint:\
			<select name="level">\
				<option value="0">Átlagfelhasználó</option>\
				<option value="1">Szerkesztő</option>\
				<option value="2">Tulajdonos</option>\
			</select>\
		\</form>'
	);

	$("#messageBox").dialog({
		width: 400,
		height: 150,
		resizable: false,
		modal: true,
		closeOnEscape: false,
		title: "Szint módosítása",
		buttons: {
			'Mentés': function() {
				$('[name="frmSetLevel"]').submit();
			},
		}
	});
}