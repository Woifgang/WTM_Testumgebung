<html>
    <head>
        <title>Daten Update</title>
        <!-- <meta http-equiv="refresh" content="0; URL=index.php"> --> 
    </head>
    <body>
        <?php
            // Hole MYSQL Config
            require_once("../config.php");
        
            // Verbinde mit Datenbank
            $verbindung = mysqli_connect (DB_SERVER, DB_BENUTZER, DB_PASSWORT, DB_DATENBANK);
        
            // Formulareinträge in Variablen speichern
            $kategorie = $_POST["kategorie"];
            $laengengrad = $_POST["laengengrad"];
            $breitengrad = $_POST["breitengrad"];
            $ueberschrift = $_POST["ueberschrift"];
            $kilometer = $_POST["kilometer"];
            $hoehenmeter = $_POST["hoehenmeter"];
            $tiefenmeter = $_POST["tiefenmeter"];
            $beschreibung = $_POST["beschreibung"];
        
            // Prüfe ob alle Felder ausgefüllt worden sind
            if($laengengrad == "" or $breitengrad == "" or $ueberschrift == "" or $kilometer == "" or $hoehenmeter == "" or $tiefenmeter == "" or $beschreibung == ""){
                echo "Es wurden nicht alle Felder ausgefüllt";
            }
            else{                
                //Letzten Eintrag aus Datenbank holen
                $letztenEintragHolen = "SELECT * FROM woidtrailmap ORDER BY ID DESC LIMIT 1";
                $letzterEintrag = mysqli_query($verbindung, $letztenEintragHolen);
                
                
                if($letzterEintrag->num_rows > 0){
                    //echo "Der letzte Eintrag ist";
                    $daten = mysqli_fetch_array( $letzterEintrag ); 
                    //echo $daten['id'];  
                    // Letzte ID in Variable Speichern
                    $id = $daten['id']; 
                    //echo $daten['pfadGPX'];  
                    
                    // Datensatz bearbeiten
                    $aendern = "UPDATE woidtrailmap Set kategorie = '$kategorie', laengengrad = '$laengengrad', breitengrad = '$breitengrad', ueberschrift = '$ueberschrift', kilometer = '$kilometer', hoehenmeter = '$hoehenmeter', tiefenmeter = '$tiefenmeter', beschreibung = '$beschreibung' WHERE id = '$id'";
                    
                    // Datensatz Update durchführen
                    $updateDaten = mysqli_query($verbindung, $aendern);
                    
                    
                    // Prüfe ob Update erfolgreich war
                    if ($updateDaten == true){
                        echo "Daten update durchgeführt";
                        /*
                        // Beschreibung Update Zeilenumbrüche entfernen
                        $beschreibungAendern = "UPDATE woidtrailmap SET beschreibung = REPLACE(beschreibung, '  ','')";
                        $beschreibungUpdate = mysqli_query($verbindung, $beschreibungAendern);
                        if($beschreibungUpdate == true){
                            echo "beschreiung zeilenumbrüche entfernt";
                        }
                        else{
                            echo "Update Fehler";
                            echo mysqli_errno($verbindung) . ": " . mysqli_error($verbindung). "\n";
                        }
                        */
                    }
                    else{
                        echo "Update Fehler";
                        echo mysqli_errno($verbindung) . ": " . mysqli_error($verbindung). "\n";
                    }
                }
                else{
                    echo"fehler";   
                    echo mysqli_errno($verbindung) . ": " . mysqli_error($verbindung). "\n";
                }
             }
            // MYSQL Verbindung schlißen    
            mysqli_close($verbindung);
        ?>
    
    </body>
    
    <a href="index.php">Neuer Eintrag</a>

</html>