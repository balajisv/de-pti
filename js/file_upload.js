function ShowUploadDialog(form_target, max_file_size) {
	$("#mbText").html(
		'<form method="post" name="frmUpload" action="'+form_target+'" enctype="multipart/form-data">\
			<input type="file" name="to_upload"><br><br>\
			Kérjük, mondj egy pár szót erről a fájlról!<br/>\
			<textarea name="description" style="height: 110px; width: 350px;"></textarea><br>\
			Feltölthető méret: '+max_file_size+'\
		</form>'
	);

	$("#messageBox").dialog({
		width: 400,
		height: 300,
		resizable: false,
		modal: true,
		closeOnEscape: false,
		title: "Fájl feltöltése",
		buttons: {
			'Feltöltés': function() {
				$('[name="frmUpload"]').submit();
				
				$("#mbText").html(
					'Feltöltés folyamatban, kérem várjon...'
				);
			}
		}
	});
}