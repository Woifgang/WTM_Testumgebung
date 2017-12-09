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

    /************************************************************************
    ***************** B U T T O N S  V E R A R B E I T E N ******************
    ************************************************************************/
    
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
        if (tmpGPXAdresse != undefined){
            mymap.removeLayer(tmpGPXAdresse); //GPX aus MAP entfernen
        }
       
        
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
        if (tmpGPXAdresse != undefined){
            mymap.removeLayer(tmpGPXAdresse); //GPX aus MAP entfernen
        }
        
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
        if (tmpGPXAdresse != undefined){
            mymap.removeLayer(tmpGPXAdresse); //GPX aus MAP entfernen
        }

        <?php 
            $markersTouren = 'markersTouren';
            datensaetzeAusgeben($verbindung, $databaseAbfrageTour, $markersTouren );
        ?>
        
        mymap.addLayer(markersTouren); 
    })
 
    /************************************************************************
    ************* A L L G E M E I N E  F U N K T I O N E N ******************
    ************************************************************************/
    
    // FUNKTION GPX in Karte via Button Anzeigen
    function gpxInMapAnzeigen(gpxAdresse, identNr,popUpTextOhneButton){
        
     /******* T E S T S ****************************************************
    */
    
    function highlightFeature(e) {
        var layer = e.target;

        layer.setStyle({
            weight: 5,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.7
        });

        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }
    }
    
    function resetHighlight(e) {
        customLayer.resetStyle(e.target);
    }
    /******* T E S T S ****************************************************
    */
        
        // Custom layer
        var customLayer = L.geoJson(null, {
            // http://leafletjs.com/reference.html#geojson-style
            
            
            
            style: function(feature) {
                return {
                    color: '#f00'
                };
            }
        });
        
        $('#mapid').on('click', '#'+identNr, function(){                                     
            if(tmpGPXAdresse == undefined){
                // GPX in MAP anzeigen mit Funktionen wenn Track geladen wurde
                tmpGPXAdresse = omnivore.gpx(gpxAdresse, null, customLayer)
                    .on('ready', function(){
                    
                        /*TETS*/
                        tmpGPXAdresse.on({
                            mouseover: highlightFeature,
                            mouseout: resetHighlight
                        });

                        /*TETS*/
                    
                        mymap.fitBounds(tmpGPXAdresse.getBounds());
                        tmpGPXAdresse.eachLayer(function(layer){
                            
                            // Hier die FANCYBOX anstatt bindPopup
                            //layer.bindPopup(layer.feature.properties.name);
                            layer.bindPopup(popUpTextOhneButton);                            
                        });
                }).addTo(mymap); // GPX in Map anzeigen
                //console.log("if zweig");
                //mymap.setZoom(12);
            }
            else{
                //GPX aus MAP entfernen
                mymap.removeLayer(tmpGPXAdresse); 
                // GPX in MAP anzeigen mit Funktionen wenn Track geladen wurde
                tmpGPXAdresse = omnivore.gpx(gpxAdresse, null, customLayer)
                    .on('ready', function(){
                    
                    /*TETS*/
                        tmpGPXAdresse.on({
                            mouseover: highlightFeature,
                            mouseout: resetHighlight
                        });

                        /*TETS*/
                    
                        mymap.fitBounds(tmpGPXAdresse.getBounds());
                        tmpGPXAdresse.eachLayer(function(layer){
                            // Popup ohne Track Button
                            layer.bindPopup(popUpTextOhneButton)
                            
                        });
                }).addTo(mymap); // GPX in Map anzeigen
                //console.log("else zweig");    
                //mymap.setZoom(12);
            }
            mymap.setZoom(12);
                    
        })
    }
    // Fancy Box Öffnen 
    function fancyBoxOeffnen(inhalt, ident){
        $('#mapid').on('click', '#fancyBox'+ident, function(){   
            $.fancybox.open('<div class="fancyBoxMessage">' + inhalt + '</div>');
        });
    }
    

    // Karte auf Marker Zentrieren
    function karteAufMarkerZentrieren(e) {
        mymap.setView(e.target.getLatLng(),15);
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
                $tmpBeschreibungKurz =  implode(' ', array_slice(explode(' ', $tmpBeschreibung, 50), 0, -1));  
                echo "
                    var id = \"".$zeile['id']."\";
                    var lon = \"".$zeile['laengengrad']."\";
                    var lat = \"".$zeile['breitengrad']."\";
                    var ueberschrift = \"".$zeile['ueberschrift']."\";
                    var kilometer = \"".$zeile['kilometer']."\";
                    var hoehenmeter = \"".$zeile['hoehenmeter']."\";
                    var tiefenmeter = \"".$zeile['tiefenmeter']."\";
                    var beschreibung = \"".$tmpBeschreibung."\";
                    var beschreibungKurz = \"".$tmpBeschreibungKurz."\";
                    var gpxPfad = \"".$zeile['pfadGPX']."\";
                    //alert(id);
                    // Cluster-Marker erzeugen erzeugen
                    var marker = L.marker([lat,lon]); // Breiten-und Längengrad in Variable schreiben

                    // GPX Pfad erzeugen
                    var tmpGPX = './gpx/'+gpxPfad;

                    //Popuptext erzeugen
                    var tmpUeberschrift = '<h4>' + ueberschrift + '</h4>';
                    var tmpKilometer = '<li>Kilometer : ' + kilometer + '</li>';
                    var tmpHoehenmeter = '<li>Höhenmeter : ' + hoehenmeter + '</li>';
                    var tmpTiefenmeter = '<li>Tiefenmeter : ' + tiefenmeter + '</li>';
                    var tmpBeschreibungKurz = '<p>' + beschreibungKurz ;
                    var tmpBeschreibungLang = '<p>' + beschreibung + '</p>' ;
                    var tmpWeiterlesenPunkte ='... '; 
                    var tmpWeiterlesen ='<a href=\"#\" id=\"fancyBox' + id + '\">weiterlesen</a></p>'; 
                    var tmpButton = '<button type=\"button\" class=\"btn btn-success\" id=\"' + id + '\">Track  anzeigen</button>';
                    
                    // Popup erzeugen
                    var popupText = tmpUeberschrift + tmpKilometer + tmpHoehenmeter + tmpTiefenmeter + tmpBeschreibungKurz + tmpWeiterlesenPunkte + tmpWeiterlesen + tmpButton; 
                    
                    // Popup erzeugen wenn auf Track geclickt wird
                    var popupTextOhneButton = tmpUeberschrift + tmpKilometer + tmpHoehenmeter + tmpTiefenmeter + tmpBeschreibungKurz + tmpWeiterlesenPunkte + tmpWeiterlesen;
                    
                    // Lightbox erzeugen
                    var lightBoxInhalt = tmpUeberschrift + tmpKilometer + tmpHoehenmeter + tmpTiefenmeter + tmpBeschreibungLang;
                    

                    // Marker zum Layer hinzufügen                                
                    //markers.addLayer(marker); 
                    $punkte.addLayer(marker); 

                    // Popup generieren mit HTML 
                    marker.bindPopup(popupText);      

                    // GPX via Button
                    gpxInMapAnzeigen(tmpGPX, id, popupTextOhneButton);
                    
                    
                    // Fancybox öffnen -> Komplette beschreibung / Bilder können angezeigt werden
                    fancyBoxOeffnen(lightBoxInhalt, id);
                
                ";
               
            }
            // Datensätze ausgeben
            mysqli_free_result($tmpQuery);
        }
?>