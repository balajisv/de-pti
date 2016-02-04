var SubjectInfo;

$(document).ready(function() {
	$.getJSON("../?r=subject/getSubjectsJson", function(response) {
		SubjectInfo = response;
		ShowSubjectGroups();
		
		HideProgress();
	});
});

function ShowSubjectGroups() {
	$("#title").text("Tárgycsoportok");
	
	var items = [];
	
	$.each(SubjectInfo.groups, function(key, val) {
		var NumOfSubjects = Count(SubjectInfo.subjects, function(x) { return x.group_id == val.group_id; });
		
		items.push(
			'<a href="#" class="blocklink_nocenter" onclick="ShowSubjects('+val.group_id+')">' +
				val.name + 
				'<div class="hint">' + NumOfSubjects + ' tantárgy</div>' +
			'</a>'
		);
	});
	
	if (items.length > 0)
		$("#content").html(items.join(""));
	else
		$("#content").html('<div class="error">Nincsenek tárgycsoportok.</div>');
}

function ShowSubjects(group_id) {
	HideProgress();
		
	$("#title").text(GetGroupNameByID(group_id));
	
	var items = [];
	items.push('<a href="#" class="blocklink_highlight" onclick="ShowSubjectGroups()">Vissza</a>');
	$.each(SubjectInfo.subjects, function(key, val) {
		if (val.group_id == group_id) {
			items.push(
				'<a href="#" class="blocklink_nocenter" onclick="ShowFiles('+val.subject_id+')">' +
					val.name + 
					'<div class="hint">' + val.credit + ' kredit | ' + val.files + ' fájl</div>' +
				'</a>'
			);
		}
	});
	
	$("#content").html(items.join(""));
	
	if (items.length == 1)
		$("#content").append('<div class="error">Ehhez a tárgycsoporthoz nem tartoznak tantárgyak.</div>');
}

function ShowFiles(subject_id) {
	ShowProgress();
	
	var Subject = GetSubjectByID(subject_id);
	
	var FileInfo;
	$.getJSON("../?r=file/getFilesJson&id="+subject_id, function(response) {
		FileInfo = response;
		
		$("#title").text(Subject.name);
	
		var items = [];
		items.push('<a href="#" class="blocklink_highlight" onclick="ShowSubjects('+Subject.group_id+')">Vissza</a>');
		
		$.each(FileInfo, function(key, val) {
			items.push(
				'<a href="../index.php?r=file/download&id='+val.file_id+'" class="blocklink_nocenter">'
					+ val.filename
					+ '<br><div class="hint">' + val.description + '</div>' +
				'</a>'
			);
		});
		
		$("#content").html(items.join(""));
		
		if (items.length == 1)
			$("#content").append('<div class="error">Ehhez a tárgyhoz még nem töltöttek fel fájlokat.</div>');
		
		HideProgress();
	});
}

function GetSubjectByID(subject_id) {
	for (var i in SubjectInfo.subjects) {
		if (SubjectInfo.subjects[i].subject_id == subject_id)
			return SubjectInfo.subjects[i];
	}
	
	return "";
}

function GetGroupNameByID(group_id) {
	for (var i in SubjectInfo.groups) {
		if (SubjectInfo.groups[i].group_id == group_id)
			return SubjectInfo.groups[i].name;
	}
	
	return "";
}

function ShowProgress() {
	$("#progress").show();
	$("#main").hide();
}

function HideProgress() {
	$("#progress").hide();
	$("#main").show();
}

function Count(collection, predicate) {
	var Result = 0;
	for (var i in collection) {
		if (predicate(collection[i]))
			Result++;
	}
	return Result;
}