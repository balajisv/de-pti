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

function CookieWarning() {
	if (getCookie('cookiewarningdisplayed') == '') {
		$('#mbText').html('\
			<p>A DE-PTI cookie-kat használ. Ha nem tudod, mik azok, akkor\
			járj be "Az internet eszközei és szolgáltatásai" előadásra.</p>\
			<p>Mi csak azért használjuk, hogy tudjuk, hogy be vagy-e\
			jelentkezve vagy sem.</p>\
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
				},
				
				'Ez tetszik :)': function() {
					$('#messageBox').dialog('close');
					alert('Ennek örülünk, legközelebb is megjelenítjük neked!');
				}
			}
		});
	}
}

$(document).ready(function() {
	CookieWarning();
});