<html>
    <head>
        <title> Datenbank PHP </title>
    
    </head>
    <body>
        <?php 
            // Funktionierende MYSQLI verbindung!!!
             $server = "127.0.0.3";
             $Benutzer = "db289129_217";
             $Kennwort = "ps:s5meFg2mV";
             $Datenbank = "db289129_217";

             $verbindung = mysqli_connect ($server, $Benutzer, $Kennwort, $Datenbank);
        
            if(!$verbindung){
                die ("Verbindungsversuch fehlgeschlagen");
                
            }
            else{
                echo"Swag";
            }
            mysqli_close($verbindung);
        ?>
    
    </body>

</html> 

