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
        <script src="js/leaflet-omnivore.min.js"></script>
        <!-- Jquery -->
        <script src="js/jquery-3.2.1.min.js"></script>
        
        
        <script src="js/tinymce/tinymce.min.js"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
        <style>
            #mapid{
                width: 100%;
                height: 300px;
            }
        </style>
        
    </head>
    <body>
        <?php 
            // Hole MYSQL Config
            require_once("../config.php");
            
            /*********************************************************
            ******************* U P L O A D  G P X *******************
            **********************************************************/
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
                    //print_r($_FILES);
                    }
                else{
                    echo "Fehler beim Hochladen der Datei. Fehlermeldung:\n<br />";
                    print_r($_FILES);
                    }
            }
        
        
            // Verbinde mit Datenbank
            $verbindung = mysqli_connect (DB_SERVER, DB_BENUTZER, DB_PASSWORT, DB_DATENBANK);
        
            // Formulareinträge in Variablen speichern
           /* $kategorie = $_POST["kategorie"];
            $laengengrad = $_POST["laengengrad"];
            $breitengrad = $_POST["breitengrad"];
            $ueberschrift = $_POST["ueberschrift"];
            $kilometer = $_POST["kilometer"];
            $hoehenmeter = $_POST["hoehenmeter"];
            $tiefenmeter = $_POST["tiefenmeter"];
            $beschreibung = $_POST["beschreibung"]; */
            $pfadGPX = $_FILES['userfile']['name'];
            // echo " hier soll der pfad stehn $pfadGPX";
            
            // Prüfe ob GPX-Pfad vorhanden ist
            if($pfadGPX == ""){
                echo "Es wurde kein Pfad angegeben!";
            }
            else{           
                // Erzeuge neuen Eintrag in Datenbank
                $sendeDaten = "INSERT INTO woidtrailmap (pfadGPX) VALUES('$pfadGPX')";
                // Abfrage durchführen
                $sendenAnDatabase = mysqli_query($verbindung, $sendeDaten);
                // Letzte ID von Datenbank holen
                $lastID = mysqli_insert_id($verbindung);
                //echo " die letzte id war $lastID !!!!!!!!!";
                
                // Prüfen ob senden erfolgreich war
                if($sendenAnDatabase == true){
                    echo "Daten wurden gespeichert";
                    //Letzten eintrag holen
                    $letztenEintragHolen = "SELECT * FROM woidtrailmap ORDER BY ID DESC LIMIT 1";
                    // Abfrage durchführen
                    $letzterEintrag = mysqli_query($verbindung, $letztenEintragHolen);
                    // Letzten Eintrag in Variable speichern
                    $daten = mysqli_fetch_array( $letzterEintrag ); 
                    //echo $daten['id'];  
                    //$id = $daten['id']; 
                    //echo $daten['pfadGPX'];  
                }
                else{
                    // MYSQL Fehler ausgeben
                    echo"fehler";   
                    echo mysqli_errno($verbindung) . ": " . mysqli_error($verbindung). "\n";
                }
            }
        //MYSQL Verbindung schließen
        mysqli_close($verbindung);                  
        ?>
        
        <!-- Formular für weitere Datensätze eintragen -->
        <form enctype="multipart/form-data" action="datenbankUpdate.php" method="post">
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
        <!-- JAVASCRIPT KARTE EINBINDEN -->
        <script src="js/map.js"></script>
        <!-- GPX ANZEIGEN-->
        <script>
            var gpxPfad = '<?php echo $daten['pfadGPX']; ?>';;
            var tmpGPX = '../gpx/'+gpxPfad;
            omnivore.gpx(tmpGPX).addTo(mymap);
        </script>
    
    </body>

</html>