<?php
    require_once './config.php';
    //require_once("../config.php");
    $verbindung = mysqli_connect (DB_SERVER, DB_BENUTZER, DB_PASSWORT, DB_DATENBANK);
        
    $databaseAbfrage = "SELECT * FROM woidtrailmap";
    
    $databaseErgebnis = mysqli_query($verbindung, $databaseAbfrage);
            
    if(!$databaseErgebnis){
        die('Ungültige Abfrage: ' . mysqli_error());
    }
        
        
?>
<script>
    // Cluster Variable erstellen
    var markers = L.markerClusterGroup();
            
    <?php
        while ($zeile = mysqli_fetch_array($databaseErgebnis, MYSQLI_ASSOC)){
            echo "
                var id = \"".$zeile['id']."\";
                var lon = \"".$zeile['laengengrad']."\";
                var lat = \"".$zeile['breitengrad']."\";
                var ueberschrift = \"".$zeile['ueberschrift']."\";
                var kilometer = \"".$zeile['kilometer']."\";
                var hoehenmeter = \"".$zeile['hoehenmeter']."\";
                var tiefenmeter = \"".$zeile['tiefenmeter']."\";
                var beschreibung = \"".$zeile['beschreibung']."\";
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
                markers.addLayer(marker); 

                // Popup generieren mit HTML 
                marker.bindPopup(popupText);      

                // GPX via Putton
                gpxInMapAnzeigen(tmpGPX, id);
            ";
        }
    ?>
                
    // Alle Marker hinzufügen -> Cluster
    mymap.addLayer(markers); 
    var tmp; 
    // FUNKTION GPX in Karte via Button Anzeigen
    function gpxInMapAnzeigen(gpxAdresse, identNr){
        $('#mapid').on('click', '#'+identNr, function(){                                     
            if(tmp == undefined){
                tmp = omnivore.gpx(gpxAdresse).addTo(mymap); // GPX in Map anzeigen
                //console.log("if zweig");
                //mymap.setZoom(12);
            }
            else{
                mymap.removeLayer(tmp); //GPX aus MAP entfernen
                tmp = omnivore.gpx(gpxAdresse).addTo(mymap); // GPX in Map anzeigen
                //console.log("else zweig");    
                //mymap.setZoom(12);
            }
            mymap.setZoom(12);
                    
        })
    }
            
</script>
<?php   
    mysqli_free_result($databaseErgebnis);
?>