<?
    require_once "config.php"   ;
    $verbindung = mysqli_connect (DB_SERVER, DB_BENUTZER, DB_PASSWORT, DB_DATENBANK)
        or die("Keine Verbindung möglich: " . mysql_error());;
