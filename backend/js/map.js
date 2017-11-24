//----------------------------------------------------------------------------------------
//---------------------------------- M A P -----------------------------------------------
//----------------------------------------------------------------------------------------
// Zentrierter Punkt Lam

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


//----------------------------------------------------------------------------------------
//------------------------------MARKER SETZTEN VIA CLICK----------------------------------
//----------------------------------------------------------------------------------------
var laengengrad;
var breitengrad;
var zaehler = 0;

mymap.on('click', function(e){
    if (zaehler == 0){
        var marker = new L.marker(e.latlng).addTo(mymap);
        var tmp = e.latlng;
        breitengrad = e.latlng.lat;
        laengengrad = e.latlng.lng;

        console.log(tmp);
        console.log(laengengrad);
        console.log(breitengrad);
        //input val
        $('#laengengrad').val(laengengrad);
        $('#breitengrad').val(breitengrad);
        
        zaehler = 1;
        
    }
    
});

//----------------------------------------------------------------------------------------
//------------------------------GPX----------------------------------
//----------------------------------------------------------------------------------------
//tmp = omnivore.gpx(gpxAdresse).addTo(mymap); 




