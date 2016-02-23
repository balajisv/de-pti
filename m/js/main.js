var SubjectInfo;

//Az oldal betöltésének befejeztével lekérjük a tárgycsoportok és tantárgyak adatait
$(document).ready(function() {
	$.getJSON("../?r=subject/getSubjectsJson", function(response) {
		SubjectInfo = response;
		ShowSubjectGroups();
		
		HideProgress();
	});
});

//Megjeleníti a tantárgycsoportokat
//(return) void
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

//Megjeleníti az adott tantárgycsoportban lévő tantárgyakat
//(param) int group_id: a tantárgycsoport azonosítója
//(return) void
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

//Megjeleníti az adott tantárgyhoz tartozó fájlokat
//(param) int subject_id: a tantárgy azonosítója
//(return) void
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

//Visszaadja a megadott azonosítójú tantárgy adatait
//(param) int subject_id: a tantárgy azonosítója
//(return) object: a tantárgy adatai; null, ha nincs ilyen azonosítójú tantárgy
function GetSubjectByID(subject_id) {
	for (var i in SubjectInfo.subjects) {
		if (SubjectInfo.subjects[i].subject_id == subject_id)
			return SubjectInfo.subjects[i];
	}
	
	return null;
}

//Megadja az adott tantárgycsoport nevét
//(param) int group_id: a tantárgycsoport azonosítója
//(return) string: a tantárgycsoport neve vagy üres string, ha nincs ilyen azonosítójú tantárgycsoport
function GetGroupNameByID(group_id) {
	for (var i in SubjectInfo.groups) {
		if (SubjectInfo.groups[i].group_id == group_id)
			return SubjectInfo.groups[i].name;
	}
	
	return "";
}

//Elrejti a tartalmat és megjeleníti a folyamatjelzőt
//(return) void
function ShowProgress() {
	$("#progress").show();
	$("#main").hide();
}

//Elrejti a folyamatjelzőt és megjeleníti a tartalmat
//(return) void
function HideProgress() {
	$("#progress").hide();
	$("#main").show();
}

//Egy tömbben megadja az egy adott feltételnek megfelelő elemek számát
//(param) object[] collection: a tömb
//(param) function predicate: egy egyparaméteres logikai eredményű függvény
//(return) int: azon elemek száma, amely a feltételnek megfeleltek
function Count(collection, predicate) {
	var Result = 0;
	for (var i in collection) {
		if (predicate(collection[i]))
			Result++;
	}
	return Result;
}