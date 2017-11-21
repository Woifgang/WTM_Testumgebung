<?php
require('mysql.php');
require('functions.php');


// Wenn kein AJAX, dann HTML Page ausgeben, sonst ajax actions ausführen
if(!IS_AJAX) {
	// KEIN AJAX Request
	// Erstellt die "normale" HTML Page

	// Daten aus Datenbank besorgen
	$query = "SELECT `woidtrailmap`, 
                        id, 
                        kategorie, 
                        laengengrad, 
                        breitengrad, 
                        ueberschrift, 
                        kilometer,
                        hoehenmeter,
                        tiefenmeter,
                        beschreibung,
                        pfadGPX 
                        FROM `woidtrailmap` ORDER BY id DESC"; // Ausführen einer SQL-Anfrage
	$result = sql_query($query);

	$i = 0;
	while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$i++;
		
		// Alle Spalten
		foreach ($line as $key=>$col_value) {
			if($key=='id') {
				$col_value = date('d.m.Y H:i', $col_value);
			}
			$data[$i][] = $col_value;
		}
		
		$data[$i][] = '<a class="delete_row" href="#"><img src="images/icon_del_light.png" alt="delete" /></a>'; // Aktions Links
	}
	$return = "<table border=\"1\">\n";
	
	//Tabellen Kopf
	$return .= "\t<tr>\n";
	$return .= "\t\t<th>ID</th>\n";
	$return .= "\t\t<th>Kategorie</th>\n";
	$return .= "\t\t<th>Längengrad</th>\n";
	$return .= "\t\t<th>Breitengrad</th>\n";
	$return .= "\t\t<th>Überschrift</th>\n";
	$return .= "\t\t<th>Kilometer</th>\n";
	$return .= "\t\t<th>Höhenmeter</th>\n";
	$return .= "\t\t<th>Tiefenmeter</th>\n";
	$return .= "\t\t<th>Beschreibung</th>\n";
	$return .= "\t\t<th>GPX-Pfad</th>\n";
	$return .= "\t\t".'<th style="width:90px">Aktionen <a class="add_row" href="#"><img src="images/icon_add_light.png" alt="add" /></a></th>'."\n";
	$return .= "\t</tr>\n";
	///////
	
	//Tabellen Daten
	if(count($data)>0) {
		foreach($data as $line) 
		{
			$return .= MakeRow($line);
		}
	}
	$return .= "</table>\n";
	///////


	//HTML Template
$template = 
'<html>
	<head>
		<style>
			table {
				width:800px;
			}
			
			input, textarea {
				background-color: #66FF99;
			}
			#loader { position: fixed; left:50%; top:30px; display:none }
		</style>	
		
		<!-- JQuery -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="./functions.js"></script>
	</head>

	<body>
		<div id="loader"><img src="images/ajax-loader.gif"></div> <!-- Ajax Loader -->
		'.$return.'
		<a href="http://d4nza.de/blog/tutorials/jquery-ajax-mysql-tabellen-editieren-tutorial">Zurück zum Tutorial</a>
	</body>
</html>';

	echo $template; // Alles ausgeben
	///////	

} else {
	switch ($_POST['action']) {
		case "add_new":
			// Speicher neuen Eintrag und Tabelle Zeile zurückgeben
			
			// Daten Speichen
			$query = "INSERT INTO woidtrailmap (
                                            kategorie,
                                            laengengrad, 
                                            breitengrad, 
                                            ueberschrift, 
                                            kilometer,
                                            hoehenmeter,
                                            tiefenmeter,
                                            beschreibung,
                                            pfadGPX
                                            ) 
                                            VALUES('".saveColumn($_POST['kategorie'])."',
                                            '".saveColumn($_POST['laengengrad'])."',
                                            '".saveColumn($_POST['breitengrad'])."',
                                            '".saveColumn($_POST['ueberschrift'])."',
                                            '".saveColumn($_POST['kilometer'])."',
                                            '".saveColumn($_POST['hoehenmeter'])."',
                                            '".saveColumn($_POST['tiefenmeter'])."',
                                            '".saveColumn($_POST['beschreibung'])."',
                                            '".saveColumn($_POST['pfadGPX'])."',);"; 
			$result = sql_query($query);
			$id = mysqli_insert_id();
				
			// Die neue Zeile erstellen
			$query = "SELECT `woidtrailmap`,kategorie,
                                            laengengrad, 
                                            breitengrad, 
                                            ueberschrift, 
                                            kilometer,
                                            hoehenmeter,
                                            tiefenmeter,
                                            beschreibung,
                                            pfadGPX FROM `woidtrailmap` WHERE `id`=".$id;
			$result = sql_query($query);

			$i = 0;
			while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
				$i++;
				
				// Alle Spalten
				foreach ($line as $key=>$col_value) {
					if($key=='timestamp') {
						$col_value = date('d.m.Y H:i', $col_value);
					}
					$data[$i][] = $col_value;
				}
				
				$data[$i][] = '<a class="delete_row" href="#"><img src="images/icon_del_light.png" alt="delete" /></a>'; // Aktions Links
			}
		
			foreach($data as $line) 
			{
				$json['row'] = MakeRow($line);
			}
			
			$json['success'] = true;
			echo json_encode($json);
			break;    
		
		case "delete_row":
			$query = "DELETE FROM `woidtrailmap` WHERE`id`=".saveColumn($_POST['id']); 
			echo $query;
			sql_query($query);
			break; 
	}
}

// Schließen der Verbinung
mysqli_close($link);