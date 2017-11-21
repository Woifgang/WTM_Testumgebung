$(function(){
	var editTemplate = '<tr><form id="t"><td>&nbsp;</td><td>&nbsp;</td><td><input name="kategorie" style="width:100%" type="text" /></td><td><input name="laengengrad" style="width:100%" type="text" /></td><td><input name="breitengrad" style="width:100%" type="text" /></td><td><input name="ueberschrift" style="width:100%" type="text" /></td><td><input name="kilometer" style="width:100%" type="text" /></td><td><input name="hoehenmeter" style="width:100%" type="text" /></td><td><input name="tiefenmeter" style="width:100%" type="text" /></td><td><textarea name="beschreibung" style="height:22px;width:100%"></textarea></td><td><input name="pfadGPX" style="width:100%" type="text" /></td><td><a class="save" href="#"><img src="images/save.png" alt="save" /></a><a class="delete_new" href="#"><img src="images/icon_del_light.png" alt="delete" /></a></td></form></tr>';

	// Neue Zeile an erste Stelle der Tabelle hinzufügen zum Hinzufügen von Daten
	$(".add_row").click(function() {
		$("table tr").first().after(editTemplate);
		addEvents();
	});
	
	function addEvents() {
		// Sorgt dafür, dass beim mehrfachen hinzufügen von zeilen, der Eventhandler nicht mehrfach ausgeführt wird.
		$(".save").unbind();
	
		// Speichern eines neuen Eintrags
		$(".save").click(function() {
			$('#loader').show(); // Zeige Ajax Loader
			var kategorie = $(this).parent().parent().find('input[name="kategorie"]').val(); // Holt den Namen aus dem Input Feld der Aktuellen Zeile
            var laengengrad = $(this).parent().parent().find('input[name="laengengrad"]').val();
            var breitengrad = $(this).parent().parent().find('input[name="breitengrad"]').val();
            var ueberschrift = $(this).parent().parent().find('input[name="ueberschrift"]').val();
            var kilometer = $(this).parent().parent().find('input[name="kilometer"]').val();
            var hoehenmeter = $(this).parent().parent().find('input[name="hoehenmeter"]').val();
            var tiefenmeter = $(this).parent().parent().find('input[name="tiefenmeter"]').val();       
			var beschreibung = $(this).parent().parent().find('textarea[name="beschreibung"]').val(); // Holt Kommentar
            var pfadGPX = $(this).parent().parent().find('input[name="pfadGPX"]').val();
			var currentItem = this;
			
			if(laengengrad!='' && breitengrad!='') {
				// Schicke speicher Anfrage an PHP
				$.post("index.php", {"kategorie": kategorie,"laengengrad": laengengrad,"breitengrad": breitengrad,"ueberschrift": ueberschrift,"kilometer": kilometer,"hoehenmeter": hoehenmeter,"tiefenmeter": tiefenmeter, "beschreibung": beschreibung, "pfadGPX": pfadGPX, "action": "add_new" },
				function(data){
					$(currentItem).parent().parent().replaceWith(data.row); // Ersetzt die Aktuelle Zeile mit der gespeicherten
					addEvents();
					$('#loader').hide(); // Verstecke Ajax Loader
				}, "json");
			} else {
				$('#loader').hide(); // Verstecke Ajax Loader
				alert('Bitte trage Namen und Kommentar ein');
			}
		});
		
		// Entfernt die neue Row, da sie noch nicht gespeichert wurde wird nur der HTML Code entfernt
		$(".delete_new").click(function() {
			$(this).parent().parent().remove(); // Mit parent wird 2 Objekte höher gegangen um die komplette Zeile zu löschen nicht nur den löschen Button
		});
		
		// Entfernt eine Zeile
		$(".delete_row").click(function() {
			$('#loader').show();
			var id = $(this).parent().parent().find("td:first").html();
			$(this).parent().parent().remove(); // Mit parent wird 2 Objekte höher gegangen um die komplette Zeile zu löschen nicht nur den löschen Button
			$.post("index.php", { "action": "delete_row", "id": id }, function(){
				$('#loader').hide();
			});
		});
	}
	
	addEvents();
});