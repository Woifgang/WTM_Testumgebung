<html>
    <head>
        <meta charset="utf-8">
        <title>Eingabe V2</title>   
        <!-- Leaflet / Mapbox -->
         <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css"
                   integrity="sha512-M2wvCLH6DSRazYeZRIm1JnYyh22purTM+FDB5CsyxtQJYeKq83arPe5wgbNmcFXGqiSH2XR8dT/fJISVA1r/zQ=="
                   crossorigin=""/>
         <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"
                   integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log=="
                   crossorigin=""></script>     
        <!-- Omniore GPX einbinden -->
        <script src="js/leaflet-omnivore.min.js"></script>
        <!-- Jquery -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <style>
            #mapid{
                width: 100%;
                height: 300px;
            }
        </style>
        
        
    </head>
    <body>
        <h1>Neuen Datensatz anlegen</h1>
        <form enctype="multipart/form-data" action="datenbankGpxUpload.php" method="post">
            <input type="file" name="userfile" />
            <input type="hidden" name="send" value="1" />
            <input type="submit" value="GPX Hochladen..." />
        </form>
        <br>
        <h1>Tools</h1>
        <ol>
            <li><a href="tools/markersetzen.html">Marker GPS Position Lat Lon</a></li>
        
        </ol>
        
        
        
    </body>
</html>