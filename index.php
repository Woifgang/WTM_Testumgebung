<!doctype html>
<html lang=de>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>WoidTrailMap</title>
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
        <script src="js/leaflet-omnivore.min.js"></script>
        <!-- Jquery -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!-- Fullscreen Map -->
        <script src="js/Control.FullScreen.js"></script>
        <!-- Bootstrap -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <!-- Fontaweson -->
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Saira+Condensed|Sigmar+One" rel="stylesheet">
        <!-- Woidtrailmap CSS -->
        <link rel="stylesheet" href="css/woidtrailmap.css" />
        
        <!-- Fancybox -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div id="titel">
                    <div id="baumMittel" class="fa fa-tree fa-lg" aria-hidden="true"></div> 
                    <div id="sitename">WoidTrailMap</div>
                    <div id="baumMittel" class="fa fa-tree fa-lg" aria-hidden="true"></div>
                </div>                
                    <nav class="navbar navbar-toggleable-md navbar-light bg-faded justify-content-end">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">                
                             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                 <span class="navbar-toggler-icon"></span>
                            </button>

                          <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item  active">
                                  <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle disabled" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      GPX
                                  </a>
                                     <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a id="alleGPX" class="dropdown-item" href="javascript:;">Alle anzeigen</a>
                                        <div class="dropdown-divider"></div>
                                        <a id="hotspotsGPX" class="dropdown-item" href="javascript:;">Hotspots</a>
                                        <a id="tourGPX" class="dropdown-item" href="javascript:;">Touren</a>
                                    </div>
                                </li>
                              <li class="nav-item">
                                  <a class="nav-link disabled" href="#">FAQ</a>
                              </li>                              
                              <li class="nav-item">
                                <a class="nav-link" href="impressum.html">Impressum</a>
                              </li>
                            </ul>
                          </div>
                        </nav>
                    </nav>
                </div>
                    <div class="clear"></div>
                <!--</div> -->
            <div id="mapid"></div>
        </div>

        <script src="js/woidtrailmap.js"></script>
        <script src="js/woidtrailfunctions.js"></script>
        <?php include 'frontend/daten.php' ?>    
    </body>    




</html>