<html>
    <head>
        <title> Datenbank PHP </title>
        <!-- <meta http-equiv="refresh" content="0; URL=index.php"> -->
        <!-- Leaflet / Mapbox -->
         <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css"
                   integrity="sha512-M2wvCLH6DSRazYeZRIm1JnYyh22purTM+FDB5CsyxtQJYeKq83arPe5wgbNmcFXGqiSH2XR8dT/fJISVA1r/zQ=="
                   crossorigin=""/>
         <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"
                   integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log=="
                   crossorigin=""></script>     
        <!-- Omniore GPX einbinden -->
        <script src="http://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js"></script>
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
        <?php 
            require_once("../config.php");
            
            // UPLOAD
            if(isset($_POST['send']) && $_POST['send'] == "1"){
                //Pfad zum Ordner, in dem die Datei gespeichert werden soll
                //Dieser Ordner muss Schreibrechte besitzen (Chmod 777)
                $uploaddir = '../gpx/';
                // An dieser Stelle sollten im Produktivbetrieb weitere Überprüfungen der hochgeladenen Datei erfolgen
                // Dazu gehören die Überprüfung auf zulässige Dateiendungen, max. Dateigröße etc.
                // Diese Zeile sorgt dafür, dass die hochgeladene Datei im richtigen Verzeichnis landet.
                // $_FILES['userfile']['name'] ist der Dateiname, mit dem die Datei gespeichert wird.
                if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $_FILES['userfile']['name'])){
                    echo "Datei erfolgreich hochgeladen.\n";
                    print_r($_FILES);
                    }
                else{
                    echo "Fehler beim Hochladen der Datei. Fehlermeldung:\n<br />";
                    print_r($_FILES);
                    }
            }
        
        
            // Formular
            $verbindung = mysqli_connect (DB_SERVER, DB_BENUTZER, DB_PASSWORT, DB_DATENBANK);
        
            $kategorie = $_POST["kategorie"];
            $laengengrad = $_POST["laengengrad"];
            $breitengrad = $_POST["breitengrad"];
            $ueberschrift = $_POST["ueberschrift"];
            $kilometer = $_POST["kilometer"];
            $hoehenmeter = $_POST["hoehenmeter"];
            $tiefenmeter = $_POST["tiefenmeter"];
            $beschreibung = $_POST["beschreibung"];
           // $pfadGPX = $_POST["userfile"];
            $pfadGPX = $_FILES['userfile']['name'];
            echo " hier soll der pfad stehn $pfadGPX";
            
        
            if($pfadGPX == ""){
                echo "Es wurde kein Pfad angegeben!";
            }
            else{
                
                $sendeDaten = "INSERT INTO woidtrailmap (
                                            pfadGPX
                                            ) 
                                            VALUES(
                                            '$pfadGPX'
                                            )";
                $sendenAnDatabase = mysqli_query($verbindung, $sendeDaten);
                $lastID = mysqli_insert_id($verbindung);
                echo " die letzte id war $lastID !!!!!!!!!";
                if($sendenAnDatabase == true){
                    echo "Daten wurden gespeichert";
                }
                else{
                    echo"fehler";   
                    echo mysqli_errno($verbindung) . ": " . mysqli_error($verbindung). "\n";
                }
            }
        
        /*  
        // Update Datenbank
            $updateDaten = "UPDATE woidtrailmap Set hoehenmeter ='$hoehenmeter', tiefenmeter = '$tiefenmeter' WEHRE id = '$lastID'";
            
            $updateDatabase = mysqli_query($verbindung, $updateDatabase);
        */    
                
            mysqli_close($verbindung);                  
        ?>
        
        <form enctype="multipart/form-data" action="datenbank3.php" method="post">
            <label> Kategorie:
                <select name="kategorie">
                    <option>Tour</option>
                    <option>Hotspots</option>
                    <option>Alle</option>
                </select>
            </label>
            <p>Längengrad: <input type="text" name="laengengrad" id="laengengrad" /></p>
            <p>Breitengrad: <input type="text"  name="breitengrad" id="breitengrad" /></p>
            <div id="mapid"></div>
            <p>Überschrift: <input type="text" name="ueberschrift" /></p>
            <p>Kilometer: <input type="number" name="kilometer" /></p>
            <p>Höhenmeter: <input type="number" name="hoehenmeter" /></p>
            <p>Tiefenmeter: <input type="number" name="tiefenmeter" /></p>
            <p>Beschreibung: 
                <textarea rows="4" cols="50" name="beschreibung"></textarea>
            </p> 
            <p><input type="submit" value="Los" /></p>
        </form>
        
        <script src="js/map.js"></script>
    
    </body>

</html>