<?
// Verbindung aufbauen und Datenbank auswählen
$link = mysql_connect("127.0.0.3", "db289129_217", "ps:s5meFg2mV") 
    or die("Keine Verbindung möglich: " .mysql_error());

// Datenbank auswählen
mysql_select_db("db289129_217") or die("Auswahl der Datenbank fehlgeschlagen\n");