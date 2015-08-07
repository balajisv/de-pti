$('#contents').html('Kérés végrehajtása a következő helyen: http://www.inf.unideb.hu');

$.get('querydeik.php', function(data) {
	if (data != '') {
		var jq = $(data);
		$('#contents').html(null);
		jq.find('li').each(function() {
			var Contents = $(this).text();
			
			$('#contents').append('<div class="news"><div class="metadata">www.inf.unideb.hu</div>'+Contents+'</div>');
		});
		
		$(".news").each(function(){
			var text = $(this).html();
			$(this).html(replaceURLWithHTMLLinks(text));
		});
	}
	else {
		$('#contents').html('Hiba történt az adatok letöltése során a következő helyen: http://www.inf.unideb.hu');
	}
});