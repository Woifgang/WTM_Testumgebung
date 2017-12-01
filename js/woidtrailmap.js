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
    maxZoom: 15,
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






