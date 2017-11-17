<html>
    <head>        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>WoidTrailMap mit PHP/MYSQL/JS Abfrage</title>
        <!-- Leaflet / Mapbox -->
         <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css"
                   integrity="sha512-M2wvCLH6DSRazYeZRIm1JnYyh22purTM+FDB5CsyxtQJYeKq83arPe5wgbNmcFXGqiSH2XR8dT/fJISVA1r/zQ=="
                   crossorigin=""/>
         <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"
                   integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log=="
                   crossorigin=""></script>
        <!-- Marker Cluster -->
        <script src="js/leaflet.markercluster-src.js"></script>
        <!-- Omnivore GPX einbinden 
        <script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script> -->
        <script src="http://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js"></script>
        <!-- Jquery -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!-- Fullscreen Map -->
        <script src="js/Control.FullScreen.js"></script>     
        
        <style>
            #mapid{
                width: 100%;
                height: 300px;
            }
        
        </style>
    </head>
    <body>
        
        <div id="mapid"></div>
        
        <!-- Karte anzeigen -->
        <script>
            var base = new L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            maxZoom: 17,
            attribution: 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'            
            });

            var mymap = new L.Map('mapid', {
                        layers: [base],
                        center: new L.LatLng(49.197, 13.050),
                        zoom: 10,
                        fullscreenControl: true,
                        fullscreenControlOptions: { // optional
                            title:"Fullscreen",
                            titleCancel:"Exit fullscreen"
                        }
                    });

            // detect fullscreen toggling
            mymap.on('enterFullscreen', function(){
                if(window.console) window.console.log('enterFullscreen');
                });
            mymap.on('exitFullscreen', function(){
                if(window.console) window.console.log('exitFullscreen');
                });
        
        </script>
        
        <?php
            $server = "127.0.0.3";
            $benutzer = "db289129_217";
            $kennwort = "ps:s5meFg2mV";
            $datenbank = "db289129_217";
        
            $verbindung = mysqli_connect ($server, $benutzer, $kennwort, $datenbank);
        
            $databaseAbfrage = "SELECT * FROM woidtrailmap";
        
            $databaseErgebnis = mysqli_query($verbindung, $databaseAbfrage);
            
            if(!$databaseErgebnis){
                die('Ungültige Abfrage: ' . mysqli_error());
            }
        ?>
        <script type=\"text/javascript\">
            // Cluster Variable erstellen
            var markers = L.markerClusterGroup();
            
        <?php
            while ($zeile = mysqli_fetch_array($databaseErgebnis, MYSQLI_ASSOC)){
                echo "
                        var id = \"".$zeile['id']."\";
                        var lon = \"".$zeile['laengengrad']."\";
                        var lat = \"".$zeile['breitengrad']."\";
                        var ueberschrift = \"".$zeile['ueberschrift']."\";
                        var gpxPfad = \"".$zeile['pfadGPX']."\";
                        //alert(id);
                        // Cluster-Marker erzeugen erzeugen
                        var marker = L.marker([lat,lon]); // Breiten-und Längengrad in Variable schreiben
                        markers.addLayer(marker); // Marker zum Layer hinzufügen

                        // Popup generieren mit HTML 
                        marker.bindPopup(ueberschrift);                        
                    ";
            }
        ?>
            // Alle Marker hinzufügen -> Cluster
            mymap.addLayer(markers); 
        </script>
        <?php
               
            /*
            echo '<table border ="1">';
                while ($zeile = mysqli_fetch_array($databaseErgebnis, MYSQLI_ASSOC)){
                    echo "<tr>";
                    echo "<td>". $zeile['id'] . "</td>";
                    echo "<td>". $zeile['laengengrad'] . "</td>";
                    echo "<td>". $zeile['breitengrad'] . "</td>";
                    echo "<td>". $zeile['ueberschrift'] . "</td>";
                    echo "<td>". $zeile['beschreibung'] . "</td>";
                    echo "<td>". $zeile['pfadGPX'] . "</td>";
                    echo "</tr>";
                }
            echo "</table>";
            */
            
            mysqli_free_result($databaseErgebnis);
        ?>
        
        
    
    </body>

</html>