/* Beispieldaten von textcsv:
Dracula;51.23424;8.14242;20;10
Einhorn;51.52424;7.94242;20;10
*/

/*
    Parameters:
        fileName - Name der Datei die eingelesen werden soll
        separator - Trennzeichen, dass zwischen den einzelnen Feldern verwendet wird
        callback - Methode die mit dem Ergebniss aufgerufen werden soll (Achtung: der Aufruf ist asynchron)
*/
function asyncCsv2Array(fileName, separator, callback) {
    // Datei einlesen (benötigt JQuery oder Zepto (bei AppFurnace automatisch enthalten))
   $.get(fileName, function(fileContent){
        // Array für Ergebnis
        var result = [];
        // Eingelesenen Text in ein Array splitten (\r\n, \n und\r sind die Trennzeichen für verschiedene Betriebssysteme wie Windows, Linux, OS X)
        var textArray = fileContent.split(/(\r\n|\n|\r)/gm);
        // Über alle Zeilen iterieren
        for (var i = 0; i < textArray.length; i++) {
            // Nur wenn die Größe einer Zeile > 1 ist (sonst ist in der Zeile nur das Zeilenumbruch Zeichen drin)
            if (textArray[i].length > 1) {
                // Zeile am Trennzeichen trennen
                var elementArray = textArray[i].split(separator);
                // überflüssiges Element am Ende entfernen - nur notwendig wenn die Zeile mit dem Separator endet
                elementArray.splice(elementArray.length - 1, 1);
                // Array der Zeile dem Ergebnis hinzufügen
                result.push(elementArray);
            } // Ende if
        } // Ende for
        callback(result);
    }); // Ende von $.get Aufruf
} // Ende function asyncCsv2Array
    
// Beispielaufruf    
asyncCsv2Array("./csv/gpx.csv", ";", function(result) {
    var tmp = result;
    console.log(tmp);
    // Ausgabe von "Dracula"
    console.log(result[0][2]);
    // Ausgabe von "51.23424"
    console.log(result[0][3]);
    console.log(result[2][2]);
    // Ausgabe von "51.23424"
    console.log(result[2][3]);    
});