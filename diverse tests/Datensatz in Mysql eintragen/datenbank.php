<html>
    <head>
        <title> Datenbank PHP </title>
    
    </head>
    <body>
        <?php 
            /* 
             $server = "127.0.0.3";
             $Benutzer = "db289129_217";
             $Kennwort = "ps:s5meFg2mV";
             $Datenbank = "db289129_217";
             */
            require_once 'config.php';
            $verbindung = mysqli_connect (DB_SERVER, DB_BENUTZER, DB_PASSWORT, DB_DATENBANK);
        
            $kategorie = $_POST["kategorie"];
            $laengengrad = $_POST["laengengrad"];
            $breitengrad = $_POST["breitengrad"];
            $ueberschrift = $_POST["ueberschrift"];
            $kilometer = $_POST["kilometer"];
            $hoehenmeter = $_POST["hoehenmeter"];
            $tiefenmeter = $_POST["tiefenmeter"];
            $beschreibung = $_POST["beschreibung"];
            $pfadGPX = $_POST["pfadGPX"];
            
        
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
                
                if($sendenAnDatabase == true){
                    echo "Daten wurden gespeichert";
                    ?>
                    <a href="datensatz.html">
                        <button>zurück</button>
                    </a>
                <?php
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