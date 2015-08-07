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