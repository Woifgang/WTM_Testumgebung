            //----------------------------------------------------------------------------------------
            //---------------------------------- M A P -----------------------------------------------
            //----------------------------------------------------------------------------------------
            // Zentrierter Punkt Lam
            var mymap = L.map('mapid').setView([49.197, 13.050], 8);
            // Karte einbinden
            /*
            // Mapbox    
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox.streets',
                accessToken: 'pk.eyJ1Ijoid29pZmdhbmciLCJhIjoiY2lqdmhxZXBkMDc2Znc4bTNncWxkMGM0YiJ9.p8Kxga4m-9kvzFuNNF7Gww'
                */
                // Opentopomap
            L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                maxZoom: 17,
                attribution: 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
            
            }).addTo(mymap);


            //----------------------------------------------------------------------------------------
            //---------------------------------- G P X -----------------------------------------------
            //----------------------------------------------------------------------------------------
            
            var gpxArray= [
                './gpx/Lam-Heugstatt-KleinerArbersee-Lam.gpx',
                './gpx/Lam-Kollmstein-Ottenzell-Lam.gpx',
                './gpx/Lam-Osser-KleinerAber-KleinerArbersee-Lam.gpx',
            ];
            
            //----------------------------------------------------------------------------------------
            //-------------------------------- M A R K E R -------------------------------------------
            //----------------------------------------------------------------------------------------
            var markerArray = [
                [13.04552393965423107147216796875, 49.19880174100399017333984375, "<h1>Lam - Heugstatt - Kleiner Arbersee - Lam</h1><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p><button id='0'>Track anzeigen</button>"],
                [13.04581, 49.19845, "<h1>Lam - Kolmstein - Ottenzell - Lam</h1> <br><button id='1'>Track anzeigen</button>"],
                [13.05144980, 49.19648030, "<h1>Lam - Osser - Kleiner Arber - Kleiner Arbersee - Lam</h1> <br><button id='2'>Track anzeigen</button>"],
                
            ];      

            //----------------------------------------------------------------------------------------
            //------------------------------ C L U S T E R -------------------------------------------
            //----------------------------------------------------------------------------------------
            // Cluster Variable erstellen
            var markers = L.markerClusterGroup();
            
           
            //----------------------------------------------------------------------------------------
            //-------------------------- P O P U P / M A R K E R -------------------------------------
            //----------------------------------------------------------------------------------------
            // Die For-Schleife liest das Marker-Array aus,
            // Marker-Array und GPX-Array müssen vom Index her identisch sein
            // Die Funktion "gpxInMapAnzeigen wird aufgerufen zusammenspiel mit Marker-Array + GPX-Array
            for(var i=0; i<markerArray.length; i++){
                
                var lon = markerArray[i][0]; // Längengrad
                var lat = markerArray[i][1]; // Breitengrad
                var popupText = markerArray[i][2]; // Popup HTML
                
                // Cluster-Marker erzeugen erzeugen
                var marker = L.marker([lat,lon]); // Breiten-und Längengrad in Variable schreiben
                markers.addLayer(marker); // Marker zum Layer hinzufügen
                
                // Popup generieren mit HTML 
                marker.bindPopup(popupText);
                // Button GPX verwendbar machen                
                gpxInMapAnzeigen(gpxArray,i);
                 
            }
            // Alle Marker hinzufügen -> Cluster
            mymap.addLayer(markers);
            
            //----------------------------------------------------------------------------------------
            //---------------------------------- H T M L ---------------------------------------------
            //----------------------------------------------------------------------------------------
            
            // Buttons ausserhalb der Map
            document.getElementById("reload").onclick = function(){mapReload()};

            $(function() {
                $(".rslides").responsiveSlides();
            });

            
            //----------------------------------------------------------------------------------------
            //--------------------------- F U N K T I O N E N ----------------------------------------
            //----------------------------------------------------------------------------------------
            
            // GPX-Array in Karte anzeigen via Klick             
            function gpxInMapAnzeigen(gpxAdresse, arrayNummer){
                $('#mapid').on('click', '#'+i, function(){
                    //var tmp = aa[ii];
                    
                    omnivore.gpx(gpxAdresse[arrayNummer]).addTo(mymap);
                   // alert(tmp);
                })
            }
            
            // Einzelne GPX Datei anzeigen
            function gpxShow(gpxDatei){
                omnivore.gpx(gpxDatei).addTo(mymap);
            };
            
            // Karte neu laden
            function mapReload(){
                location.reload();
            };
        