<?
    define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'); // TRUE bei Ajax Request
 
 
    // Erstellt eine H T M L Tabellen Zeile
    function MakeRow($line) {
        $return = "\t<tr>\n";
        foreach ($line as $col_value) {
            $return .= "\t\t<td>$col_value</td>\n";
        }
        $return .= "\t</tr>\n";

        return $return;
    }

    // Führt MySQL Queries aus und zeigt ggf. Fehler an
    function sql_query($query)
    {
        $result = mysqli_query($query);
        if(!$result) {
            die("Anfrage fehlgeschlagen: " . mysqli_error());
        }   
        return $result;
    }

    function saveColumn($value) {
        $value = mysqli_real_escape_string($value);
        $value = htmlspecialchars($value);
        return $value;
    }
