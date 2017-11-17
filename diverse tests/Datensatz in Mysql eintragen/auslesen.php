<html>
    <head>
        <title>Daten auslesen</title>
        
    </head>
    <body>
        <?php
            $server = "127.0.0.3";
            $benutzer = "db289129_217";
            $kennwort = "ps:s5meFg2mV";
            $datenbank = "db289129_217";
        
            $verbindung = mysqli_connect ($server, $benutzer, $kennwort, $datenbank);
        
            $databaseAbfrage = "SELECT * FROM woidtrailmap";
        
            $databaseErgebnis = mysqli_query($verbindung, $databaseAbfrage);
            
            if(!$databaseErgebnis){
                die('Ungültige Abfrage: ' . mysqli_error());
            }
            
               
        
            echo '<table border ="1">';
                while ($zeile = mysqli_fetch_array($databaseErgebnis, MYSQLI_ASSOC)){
                    echo "<tr>";
                    echo "<td>". $zeile['id'] . "</td>";
                    echo "<td>". $zeile['laengengrad'] . "</td>";
                    echo "<td>". $zeile['breitengrad'] . "</td>";
                    echo "<td>". $zeile['ueberschrift'] . "</td>";
                    echo "<td>". $zeile['beschreibung'] . "</td>";
                    echo "<td>". $zeile['pfadGPX'] . "</td>";
                    echo "</tr>";
                }
            echo "</table>";
            
            mysqli_free_result($databaseErgebnis);
        ?>
    
    </body>

</html>