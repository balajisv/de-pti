function EditDescription(form_target) {
	$("#mbText").html(
		'<form method="post" name="frmEditDetails" action="'+form_target+'">\
			Leírás:<br/>\
			<textarea name="description" style="height: 140px; width: 350px;"></textarea>\
		</form>'
	);

	$("#messageBox").dialog({
		width: 400,
		height: 300,
		resizable: false,
		modal: true,
		closeOnEscape: false,
		title: "Leírás módosítása",
		buttons: {
			'Mentés': function() {
				$('[name="frmEditDetails"]').submit();
				
				$("#mbText").html(
					'Mentés...'
				);
			}
		}
	});
}