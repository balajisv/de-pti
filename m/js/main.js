var SubjectInfo;

$(document).ready(function() {
	$.getJSON("../?r=subject/getSubjectsJson", function(response) {
		SubjectInfo = response;
		ShowSubjectGroups();
		
		HideProgress();
	});
});

function ShowSubjectGroups() {
	$("#lTitle").text("Tárgycsoportok");
	
	var items = [];
	$.each(SubjectInfo.groups, function(key, val) {
		items.push('<a href="#" class="blocklink" onclick="ShowSubjects('+val.group_id+')">' + val.name + '</a>');
	});

	$("#content").html(items.join(""));
}

function ShowSubjects(group_id) {
	HideProgress();
		
	$("#lTitle").text(GetGroupNameByID(group_id));
	
	var items = [];
	items.push('<a href="#" class="blocklink_highlight" onclick="ShowSubjectGroups()">Vissza</a>');
	$.each(SubjectInfo.subjects, function(key, val) {
		if (val.group_id == group_id)
			items.push('<a href="#" class="blocklink" onclick="ShowFiles('+val.subject_id+')">' + val.name + '</a>');
	});

	$("#content").html(items.join(""));
}

function ShowFiles(subject_id) {
	ShowProgress();
	
	var Subject = GetSubjectByID(subject_id);
	
	var FileInfo;
	$.getJSON("../?r=file/getFilesJson&id="+subject_id, function(response) {
		FileInfo = response;
		
		$("#lTitle").text(Subject.name);
	
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