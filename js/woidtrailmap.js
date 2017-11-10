//----------------------------------------------------------------------------------------
//---------------------------------- M A P -----------------------------------------------
//----------------------------------------------------------------------------------------
// Zentrierter Punkt Lam
//var mymap = L.map('mapid').setView([49.197, 13.050], 8);
// Karte einbinden
/*
// Mapbox    
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1Ijoid29pZmdhbmciLCJhIjoiY2lqdmhxZXBkMDc2Znc4bTNncWxkMGM0YiJ9.p8Kxga4m-9kvzFuNNF7Gww'

// Opentopomap
L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            maxZoom: 17,
            attribution: 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
            
}).addTo(mymap);
*/
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

//----------------------------------------------------------------------------------------
//------------------------------ C L U S T E R -------------------------------------------
//----------------------------------------------------------------------------------------
// Cluster Variable erstellen
var markers = L.markerClusterGroup();
            
           
//----------------------------------------------------------------------------------------
//---------------------- P O P U P / M A R K E R / C S V ---------------------------------
//----------------------------------------------------------------------------------------
// Mit Papa parse wird die CSV datei geladen, Marker, Popup und GPX angezeigt
/*
Papa.parse("./csv/gpx.csv",{
    download: true,
    delimiter: ";",
    quoteChar:'',
    complete: function(results){
        var ergebnis = results.data;
        //console.log(ergebnis); // Debug informationen
        for(var i = 0; i < ergebnis.length; i++){ // For-Schleife CSV auswerten
            var lon = ergebnis[i][0]; // Längengrad
            var lat = ergebnis[i][1]; // Breitengrad
            var popupText = ergebnis[i][2]; // Popup HTML
            var gpxPfad = ergebnis[i][3]; // GPX Pfad

            // Cluster-Marker erzeugen erzeugen
            var marker = L.marker([lat,lon]); // Breiten-und Längengrad in Variable schreiben
            markers.addLayer(marker); // Marker zum Layer hinzufügen

            // Popup generieren mit HTML 
            marker.bindPopup(popupText);
            // Button GPX verwendbar machen               
            //gpxInMapAnzeigenSeperatesArray(gpxPfad,i); // -> seperates Array
            gpxInMapAnzeigen(gpxPfad); // -> aus marker Arrray
            
        };
        // Alle Marker hinzufügen -> Cluster
        mymap.addLayer(markers);    
        var gpxA;
        // FUNKTION GPX in Karte via Button Anzeigen
        function gpxInMapAnzeigen(gpxAdresse){
            $('#mapid').on('click', '#'+i, function(){
                if(gpxA == undefined){
                    gpxA = omnivore.gpx(gpxAdresse).addTo(mymap); // GPX in Map anzeigen
                    //mymap.setZoom(12);
                }
                else{
                    mymap.removeLayer(gpxA); //GPX aus MAP entfernen
                    gpxA = omnivore.gpx(gpxAdresse).addTo(mymap); // GPX in Map anzeigen
                    //mymap.setZoom(12);
                }
                mymap.setZoom(12);
            })

        }; 
    }
});
*/

//----------------------------------------------------------------------------------------
//---------------------- A L L E  G P X  A N Z E I G E N ---------------------------------
//----------------------------------------------------------------------------------------
var gpxA; // Globale variable für GPXpfade
var leichteGPX = "./csv/gpx.csv";
var mittelGPX = "./csv/test.csv";

//alle marker anzeigen
var seiteNeuGeladen = false;
if(seiteNeuGeladen == false){
    csvDateiAuswerten(mittelGPX);
    seiteNeuGeladen = true;
}


// Menüpunkt Leicht
$("#leichteGPX").click(function(){
    mymap.removeLayer(gpxA);
    csvDateiAuswerten(leichteGPX);
});

// Menüpunkt Mittel
$("#mittelGPX").click(function(){
    mymap.removeLayer(gpxA);
    csvDateiAuswerten(mittelGPX);
});

function csvDateiAuswerten(csvDatei){
    Papa.parse("./csv/gpx.csv",{
    download: true,
    delimiter: ";",
    quoteChar:'',
    complete: function(results){
        var ergebnis = results.data;
        //console.log(ergebnis); // Debug informationen
        for(var i = 0; i < ergebnis.length; i++){ // For-Schleife CSV auswerten
            var lon = ergebnis[i][0]; // Längengrad
            var lat = ergebnis[i][1]; // Breitengrad
            var popupText = ergebnis[i][2]; // Popup HTML
            var gpxPfad = ergebnis[i][3]; // GPX Pfad

            // Cluster-Marker erzeugen erzeugen
            var marker = L.marker([lat,lon]); // Breiten-und Längengrad in Variable schreiben
            markers.addLayer(marker); // Marker zum Layer hinzufügen

            // Popup generieren mit HTML 
            marker.bindPopup(popupText);
            // Button GPX verwendbar machen               
            //gpxInMapAnzeigenSeperatesArray(gpxPfad,i); // -> seperates Array
            gpxInMapAnzeigen(gpxPfad); // -> aus marker Arrray
            
        };
        // Alle Marker hinzufügen -> Cluster
        mymap.addLayer(markers);    

        // FUNKTION GPX in Karte via Button Anzeigen
        function gpxInMapAnzeigen(gpxAdresse){
            $('#mapid').on('click', '#'+i, function(){
                if(gpxA == undefined){
                    gpxA = omnivore.gpx(gpxAdresse).addTo(mymap); // GPX in Map anzeigen
                    //mymap.setZoom(12);
                }
                else{
                    mymap.removeLayer(gpxA); //GPX aus MAP entfernen
                    gpxA = omnivore.gpx(gpxAdresse).addTo(mymap); // GPX in Map anzeigen
                    //mymap.setZoom(12);
                }
                mymap.setZoom(12);
            })

        }; 
    }
});
}




            
//----------------------------------------------------------------------------------------
//---------------------------------- H T M L ---------------------------------------------
//----------------------------------------------------------------------------------------
            
// Buttons ausserhalb der Map
document.getElementById("reload").onclick = function(){mapReload()};
            
//----------------------------------------------------------------------------------------
//--------------------------- F U N K T I O N E N ----------------------------------------
//----------------------------------------------------------------------------------------
// Karte neu laden
function mapReload(){
    location.reload();
};
