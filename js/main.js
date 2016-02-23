//Az oldal betöltésének befejeztével megjeleníti a sütis fugyelmeztetést
$(document).ready(function() {
	CookieWarning();
});

//A "table tbody.list" CSS selector-nak megfelelő táblázat sorait úgy módosítja,
//hogy automatikusan kijelölődjön az a sor, amely felett az egér áll.
//(return) void
function ApplyHover() {
	$("tbody.list tr").hover(
		function () {
			$(this).addClass("gray");
		}, 
		function () {
			$(this).removeClass("gray");
		}
	);
	
	$("tbody.list tr.completed").hover(
		function () {
			$(this).addClass("completed_hover");
		}, 
		function () {
			$(this).removeClass("completed_hover");
		}
	);
	
	$("tbody.list tr.completable").hover(
		function () {
			$(this).addClass("completable_hover");
		}, 
		function () {
			$(this).removeClass("completable_hover");
		}
	);
}

//Felvesz vagy eltávolít egy tantárgyat a teljesített tárgyak közül
//TODO: nem igazán jó ötlet a jelölőnégyzet állapota alapján eldönteni, hogy mit is kéne csinálni... ezen változtatni kell
//(param) int subject_id: a tantárgy azonosítója
//(param) object checkbox: a tantárgyhoz tartozó jelölőnégyzet
//(return) void
function ToggleSubjectCompletion(subject_id, checkbox) {
	$('#td_subject_' + subject_id).html('<span class="fa fa-spin fa-refresh"></span>');
	
	if ($(checkbox).is(':checked')) {
		$.get('index.php?r=user/addSubject&id=' + subject_id, function(response) {
			if (response != "ok")
				alert(response);
			
			else {
				$('#subject_' + subject_id).addClass('completed');
				location.reload();
			}
		});
	}
	else {
		$.get('index.php?r=user/removeSubject&id=' + subject_id, function(response) {
			if (response != "ok")
				alert(response);
			
			else {
				$('#subject_' + subject_id).removeClass('completed');
				location.reload();
			}
		});
	}
}

//Feljegyez egy új hiányzást a megadott azonosítójú tantárgyhoz
//(param) int subject_id: a tantárgy azonosítója
//(return) void
function IncrementAbsenteeism(subject_id) {
	$('#absenteeism').html('<span class="fa fa-spin fa-refresh"></span> Mentés...');
	$.get('index.php?r=user/incrementAbsenteeism&subject_id=' + subject_id, function(response) {
		if (response == 'fail')
			$('#absenteeism').html('Hiba történt a változások mentése során');
		else {
			$('#absenteeism').html('Ebből a tárgyból eddig ' + response + ' alkalommal hiányoztál.');
		}
	});
}

//Lenullázza a hiányzásokat a megadott tantárgyból
//(param) int subject_id: a tantárgy azonosítója
//(return) void
function ResetAbsenteeism(subject_id) {
	$('#absenteeism').html('<span class="fa fa-spin fa-refresh"></span> Mentés...');
	$.get('index.php?r=user/resetAbsenteeism&subject_id=' + subject_id, function(response) {
		if (response == 'fail')
			$('#absenteeism').html('Hiba történt a változások mentése során');
		else {
			$('#absenteeism').html('Ebből a tárgyból eddig még nincs hiányzásod - jól csinálod.');
		}
	});
}

//Megjeleníti a sütis figyelmeztetést ha még nem látta a felhasználó vagy nagyon tetszett neki
//és újra látni szeretné.
//(return) void
function CookieWarning() {
	if (getCookie('cookiewarningdisplayed') == '') {
		$('#mbText').html('\
			<p>A DE-PTI cookie-kat használ. Ha nem tudod, mik azok, akkor\
			járj be "Az internet eszközei és szolgáltatásai" előadásra.</p>\
			\
			<p>Mi azért használjuk a cookie-kat, hogy:\
				<ol>\
					<li>tudjuk, be vagy-e jelentkezve vagy sem</li>\
					<li>tároljuk, hogy ezt az ablakot nem akarod látni egy jó ideig</li>\
				</ol>\
			</p>\
			\
			<p>Ha részletesen érdekelnek a cookie-k, olvasd el az RFC 2109-es\
			dokumentumot <a href="https://www.ietf.org/rfc/rfc2109.txt" target="_blank">[itt]</a>.</p>\
		');
		
		$("#messageBox").dialog({
			width: 400,
			height: 300,
			resizable: false,
			modal: true,
			closeOnEscape: false,
			title: "Vigyázz! Sütik!",
			buttons: {
				'Megértettem': function() {
					setCookie('cookiewarningdisplayed', 'true', 1000);
					$('#messageBox').dialog('close');
					alert('A 2. pontban említett sütit épp most hoztuk létre a gépeden. Ha érvényteleníteni akarod, akkor ezt a JavaScript utasítást hívd meg:\nsetCookie("cookiewarningdisplayed", "", -5);');
				},
				
				'Ez tetszik :)': function() {
					$('#messageBox').dialog('close');
					alert('Ennek örülünk, legközelebb is megjelenítjük neked!');
				}
			}
		});
	}
}

//Az adott tantárgyhoz kiír egy új eseményt
//TODO: nem az URI-t kellene átpasszolni paraméterként, hanem a tantárgy azonosítóját
//(param) string targetUrl: az uri, ahová az űrlap el lesz küldve
//(return) void
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

//Megjeleníti az űrlapot, amellyel egy adott tantárgyhoz fájlt lehet feltölteni
//TODO: nem az URI-t kellene átpasszolni, hanem a tantárgy azonosítóját
//TODO: a megengedett maximális méretet sem igazán string-ként kellene átadni, hanem bájtokban, és JS-ben átváltva
//TODO: a megengedett maximális méretet hidden-ként a form-ban is meg kellene adni
//(param) string form_target: az uri, ahová az űrlap el lesz küldve
//(param) string max_file_size: a megengedett maximális méret felhasználóbarát formában
//(return) void
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

//Megjeleníti a hír kiírása űrlapot.
//TODO: nem az URI-t kellene átpasszolni
//TODO: a tantárgyak listáját paraméterként kellene átadni
//(param) string form_target: az uri, ahová az űrlap el lesz küldve
//(return) void
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

//Megkérdezi, hogy biztosan törölni akarjuk-e a hírt.
//TODO: az URI helyett a hír azonosítóját jobb ötlet lenne átadni
//(param) string targetUrl: az uri, ami törli a hírt
//(return) void
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

//Módosítja egy tantárgy leírását
//TODO: az URI helyett a tantárgy azonosítóját kellene átadni
//(param) string form_target: az URI, ahová az űrlap el lesz küldve
//(return) void
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

//Módosítja egy adott felhasználó hozzáférési szintjét
//TODO: az URI helyett a felhasználó azonosítóját kellene átadni
//(param) string form_target: az URI, ahová az űrlap el lesz küldve
//(return) void
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