<?php
    // Hole Config Datei
    require_once './config.php';
    // Verbinde mit MYSQL-Datenbank
    $verbindung = mysqli_connect (DB_SERVER, DB_BENUTZER, DB_PASSWORT, DB_DATENBANK);
    
    // Datenbankabfragen 
    $databaseAbfrageAlle = "SELECT * FROM woidtrailmap";
    $databaseAbfrageHotspots = "SELECT * FROM woidtrailmap WHERE kategorie = 'Hotspots'";
    $databaseAbfrageTour = "SELECT * FROM woidtrailmap WHERE kategorie = 'Tour'";        
?>
<script>
    // Cluster Variablen erstellen
    var markers = L.markerClusterGroup();
    var markersHotspots = L.markerClusterGroup();
    var markersTouren = L.markerClusterGroup();
    
    // GPX Variable
    var tmpGPXAdresse; 

    // Wenn Seite geladen lade alle Datenbankeinträge von MYSQL
    $( document ).ready(function() {
        markers.clearLayers();
        markersHotspots.clearLayers();
        markersTouren.clearLayers();
        
        <?php 
            $markersAlle = 'markers';
            datensaetzeAusgeben($verbindung, $databaseAbfrageAlle, $markersAlle );
        ?>      
        
        mymap.addLayer(markers); 
    });
    
    // Wenn Button 'Alle anzeigen' gedrückt wurde lade alle Datenbankeinträge von MYSQL
    $('#alleGPX').click(function(){
        markers.clearLayers();
        markersHotspots.clearLayers();
        markersTouren.clearLayers();
        mymap.removeLayer(tmpGPXAdresse); //GPX aus MAP entfernen
        
        <?php 
            $markersAlle = 'markers';
            datensaetzeAusgeben($verbindung, $databaseAbfrageAlle, $markersAlle );
        ?>      
        
        mymap.addLayer(markers); 
    })
    
     // Wenn Button 'Hotspots' gedrückt wurde lade alle Datenbankeinträge aus der Kategorie "Hotspots" von MYSQL
    $('#hotspotsGPX').click(function(){
        markers.clearLayers();
        markersHotspots.clearLayers();
        markersTouren.clearLayers();
        mymap.removeLayer(tmpGPXAdresse); //GPX aus MAP entfernen
        
        <?php 
            $markersHotspots = 'markersHotspots';
            datensaetzeAusgeben($verbindung, $databaseAbfrageHotspots, $markersHotspots );
        ?>
        
        mymap.addLayer(markersHotspots); 
    })
    // Wenn Button 'Touren' gedrückt wurde lade alle Datenbankeinträge aus der Kategorie "Touren" von MYSQL
    $('#tourGPX').click(function(){
        markers.clearLayers();
        markersHotspots.clearLayers();
        markersTouren.clearLayers();
        mymap.removeLayer(tmpGPXAdresse); //GPX aus MAP entfernen

        <?php 
            $markersTouren = 'markersTouren';
            datensaetzeAusgeben($verbindung, $databaseAbfrageTour, $markersTouren );
        ?>
        
        mymap.addLayer(markersTouren); 
    })
 

    // FUNKTION GPX in Karte via Button Anzeigen
    function gpxInMapAnzeigen(gpxAdresse, identNr){
        $('#mapid').on('click', '#'+identNr, function(){                                     
            if(tmpGPXAdresse == undefined){
                tmpGPXAdresse = omnivore.gpx(gpxAdresse).addTo(mymap); // GPX in Map anzeigen
                //console.log("if zweig");
                //mymap.setZoom(12);
            }
            else{
                mymap.removeLayer(tmpGPXAdresse); //GPX aus MAP entfernen
                tmpGPXAdresse = omnivore.gpx(gpxAdresse).addTo(mymap); // GPX in Map anzeigen
                //console.log("else zweig");    
                //mymap.setZoom(12);
            }
            mymap.setZoom(12);
                    
        })
    }
            
</script>
<?php   
    // FUNKTION Datensätze ausgeben je nach Button Klick
    function datensaetzeAusgeben($tmpVerbindung, $tmpDatensatz, $punkte){
            
            // Datenbankabfrage ausführen
            $tmpQuery = mysqli_query($tmpVerbindung, $tmpDatensatz);
            // Prüfen ob Datenbankabfrage gültig war
            if(!$tmpQuery){
                die('Ungültige Abfrage: ' . mysqli_error());
            }
        
            // Datensätze zusammenfügen als Marker -> Popup -> GPX-Button 
            while ($zeile = mysqli_fetch_array($tmpQuery, MYSQLI_ASSOC)){
                $tmpBeschreibung = str_replace(array("\r\n","\n","\r"),"",$zeile['beschreibung']); 
                echo "
                    var id = \"".$zeile['id']."\";
                    var lon = \"".$zeile['laengengrad']."\";
                    var lat = \"".$zeile['breitengrad']."\";
                    var ueberschrift = \"".$zeile['ueberschrift']."\";
                    var kilometer = \"".$zeile['kilometer']."\";
                    var hoehenmeter = \"".$zeile['hoehenmeter']."\";
                    var tiefenmeter = \"".$zeile['tiefenmeter']."\";
                    var beschreibung = \"".$tmpBeschreibung."\";
                    var gpxPfad = \"".$zeile['pfadGPX']."\";
                    //alert(id);
                    // Cluster-Marker erzeugen erzeugen
                    var marker = L.marker([lat,lon]); // Breiten-und Längengrad in Variable schreiben

                    // GPX Pfad erzeugen
                    var tmpGPX = './gpx/'+gpxPfad;

                    //Popuptext erzeugen
                    var tmpUeberschrift = '<h1>' + ueberschrift + '</h1>';
                    var tmpBeschreibung = '<p>' + beschreibung + '</p>';
                    var tmpKilometer = '<li>Kilometer : ' + kilometer + '</li>';
                    var tmpHoehenmeter = '<li>Höhenmeter : ' + hoehenmeter + '</li>';
                    var tmpTiefenmeter = '<li>Tiefenmeter : ' + tiefenmeter + '</li>';
                    var tmpButton = '<button type=\"button\" class=\"btn btn-success\" id=\"' + id + '\">Track  anzeigen</button>';

                    var popupText = tmpUeberschrift + tmpKilometer + tmpHoehenmeter + tmpTiefenmeter + tmpBeschreibung + tmpButton;


                    // Marker zum Layer hinzufügen                                
                    //markers.addLayer(marker); 
                    $punkte.addLayer(marker); 

                    // Popup generieren mit HTML 
                    marker.bindPopup(popupText);      

                    // GPX via Button
                    gpxInMapAnzeigen(tmpGPX, id);
                ";
            }
            // Datensätze ausgeben
            mysqli_free_result($tmpQuery);
        }
?>