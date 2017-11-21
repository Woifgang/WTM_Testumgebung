
        <?php
           require_once 'config.php';
            $verbindung = mysqli_connect (DB_SERVER, DB_BENUTZER, DB_PASSWORT, DB_DATENBANK);
        
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