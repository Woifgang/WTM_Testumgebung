<html>
    <head>
        <title>Datensatz in Mysql speichern</title>   
        
    </head>
    <body>

        <form action="datenbank.php" method="post">
            <label> Kategorie:
                <select name="kategorie">
                    <option>Tour</option>
                    <option>Hotspots</option>
                    <option>Alle</option>
                </select>
            </label>
            <p>Längengrad: <input type="number" step="any" name="laengengrad" /></p>
            <p>Breitengrad: <input type="number" step="any" name="breitengrad" /></p>
            <p>Überschrift: <input type="text" name="ueberschrift" /></p>
            <p>Kilometer: <input type="number" name="kilometer" /></p>
            <p>Höhenmeter: <input type="number" name="hoehenmeter" /></p>
            <p>Tiefenmeter: <input type="number" name="tiefenmeter" /></p>
            <p>Beschreibung: 
                <textarea rows="4" cols="50" name="beschreibung"></textarea>
            </p>    
            <p>GPX Pfad: <input type="text" name="pfadGPX" /></p>
            <p><input type="submit" value="Los" /></p>
        </form>
        <p></p>
        <h2>Alle Daten</h2>
        <?php
            include 'auslesen.php';
        ?>
    </body>

</html>