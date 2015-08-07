function CreateEvent(targetUrl) {
	$("#mbText").html(
		'<form method="post" name="frmEvent" action="'+targetUrl+'">\
			Időpont:<br/>\
			<input type="text" name="time"><br><br>\
			Típus:<br/>\
			<select name="type">\
				<option value="1">Vizsga</option>\
				<option value="2">Zárthelyi</option>\
				<option value="3">Konzultáció</option>\
				<option value="9">Egyéb</option>\
			</select><br/><br/>\
			Leírás:<br/>\
			<textarea name="notes" style="height: 110px; width: 350px;"></textarea><br>\
		</form>'
	);

	$("#messageBox").dialog({
		width: 400,
		height: 350,
		resizable: false,
		modal: true,
		closeOnEscape: false,
		title: "Új esemény létrehozása",
		buttons: {
			'Mentés': function() {
				$('[name="frmEvent"]').submit();
				
				$("#mbText").html(
					'Mentés...'
				);
			}
		}
	});
	
	$('[name="time"]').datetimepicker({
		firstDay: 1,
		dateFormat: "yy-mm-dd",
	});
}