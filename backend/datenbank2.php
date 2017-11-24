<html>
    <head>
        <title> Datenbank PHP </title>
        <!-- <meta http-equiv="refresh" content="0; URL=index.php"> -->
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
            
        
            if($laengengrad == "" or $breitengrad == "" or $ueberschrift == "" or $beschreibung == "" or $pfadGPX == ""){
                echo "Es wurden nicht alle Felder ausgefüllt";
            }
            else{
                
                $sendeDaten = "INSERT INTO woidtrailmap (
                                            kategorie,
                                            laengengrad, 
                                            breitengrad, 
                                            ueberschrift, 
                                            kilometer,
                                            hoehenmeter,
                                            tiefenmeter,
                                            beschreibung,
                                            pfadGPX
                                            ) 
                                            VALUES(
                                            '$kategorie',
                                            '$laengengrad', 
                                            '$breitengrad', 
                                            '$ueberschrift',
                                            '$kilometer',
                                            '$hoehenmeter',
                                            '$tiefenmeter',
                                            '$beschreibung', 
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
    
    </body>

</html>