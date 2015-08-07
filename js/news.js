function ShowAddNews(form_target) {
	var SelectItems = '<option value="">--- Nincs tárgyhoz rendelve ---</option>';
	
	for (var i = 0; i < Subjects.length; i++) {
		SelectItems += '<option value="'+Subjects[i]["id"]+'">'+Subjects[i]["name"]+'</option>';
	}

	$("#mbText").html(
		'<form method="post" name="frmAddNews" action="'+form_target+'">\
			Hír címe:\
			<input type="text" name="title"><br><br>\
			Tantárgy:<br/>\
			<select name="subject_id">'+SelectItems+'</select><br/><br/>\
			Leírás:<br/>\
			<textarea name="contents" style="height: 110px; width: 550px;"></textarea>\
		</form>'
	);

	$("#messageBox").dialog({
		width: 600,
		height: 350,
		resizable: false,
		modal: true,
		closeOnEscape: false,
		title: "Új hír közzététele",
		buttons: {
			'Közzététel': function() {
				$('[name="frmAddNews"]').submit();
				
				$("#mbText").html(
					'Mentés...'
				);
			}
		}
	});
}

function DeleteNews(targetUrl) {
	$("#mbText").html('Valóban törölni szeretné a hírt?');

	$("#messageBox").dialog({
		width: 400,
		height: 150,
		resizable: false,
		modal: true,
		closeOnEscape: false,
		title: "Hír törlése",
		buttons: {
			'Igen': function() {
				$("#messageBox").dialog('close');
				
				window.location = targetUrl;
			},
			
			'Nem': function() {
				$("#messageBox").dialog('close');
			}
		}
	});
}