<html>
    <head>
        <title>Daten Update</title>
    </head>
    <body>
        <?php
            require_once("../config.php");
        
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
        
            if($laengengrad == "" or $breitengrad == "" or $ueberschrift == "" or $kilometer == "" or $hoehenmeter == "" or $tiefenmeter == "" or $beschreibung == ""){
                echo "Es wurden nicht alle Felder ausgefüllt";
            }
            else{
                
                //Letzten eintrag holen
                $letztenEintragHolen = "SELECT * FROM woidtrailmap ORDER BY ID DESC LIMIT 1";
                $letzterEintrag = mysqli_query($verbindung, $letztenEintragHolen);
                
                
                if($letzterEintrag->num_rows > 0){
                    echo "Der letzte Eintrag ist";
                    $daten = mysqli_fetch_array( $letzterEintrag ); 
                    echo $daten['id'];  
                    $id = $daten['id']; 
                    //echo $daten['pfadGPX'];  
                    
                    $aendern = "UPDATE woidtrailmap Set kategorie = '$kategorie', laengengrad = '$laengengrad', breitengrad = '$breitengrad', ueberschrift = '$ueberschrift', kilometer = '$kilometer', hoehenmeter = '$hoehenmeter', tiefenmeter = '$tiefenmeter', beschreibung = '$beschreibung' WHERE id = '$id'";
                    
                    $updateDaten = mysqli_query($verbindung, $aendern);
                    
                    if ($updateDaten == true){
                        echo "Daten update durchgeführt";
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
                
            mysqli_close($verbindung);
        ?>
    
    </body>

</html>