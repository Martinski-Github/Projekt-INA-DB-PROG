<html>
<head>
<link rel='stylesheet' href='style.css'>
</head>
<body>

<?php 
$device = $_POST['name'];


//Zugangsdaten für Datenbank
$host = 'localhost';
$user = 'root';
$pass = '';
$name = 'herzing_martin_smarthome';
$charset = 'utf8';

//String zusammenbauen
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $host, $name, $charset);

//Datenbank Öffnen
try {
$pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
//SQL-Abfrage als String in eine Variable schreiben
$query = "SELECT * FROM `devices` WHERE D_ID = ".$device;
//echo '<br>'.$query;

$statement = $pdo->prepare($query);
$statement->execute();
} catch (PDOException $e) {
// beim Herstellen der Datenbankverbindung oder der Vorbereitung der Abfrage ist ein Fehler 
//aufgetreten!
echo "shit";
$e->getMessage(); //stellt eine Fehlerbeschreibung bereit
}


//Daten von der Datenbank entgegennehmen und Als html ausgeben. 

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

    $IDtemp   = $row['D_ID'];
    $nametemp = $row['name'];
    $KIDtemp  = $row['K_ID'];
    $BIDtemp  = $row['B_ID'];
    $RIDtemp  = $row['R_ID'];





    echo "<form name=\"anlegen\" method=\"post\" action=\"http://localhost/projekt/ausgabe.php\">";
    echo "<input type=\"hidden\" name=\"D_ID\" value=\"".$IDtemp."\" readonly >";
    echo "<div class=\"select-wrapper fa fa-angle-down\">";
    echo "<input type=\"text\" name=\"name\" value=\"";
    echo $nametemp;
    echo "\">";
    echo "</div>";
    echo "<div class=\"select-wrapper fa fa-angle-down\">";
    echo "<select name=\"Kategorie\" >";
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $name = 'herzing_martin_smarthome';
    $charset = 'utf8';
    
    //String zusammenbauen
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $host, $name, $charset);
    
    //Datenbank Öffnen
    try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    //SQL-Abfrage als String in eine Variable schreiben
    $query = 'SELECT * FROM `kategorie` WHERE 1;';
    //echo '<br>'.$query;
    $statement = $pdo->prepare($query);
    $statement->execute();
    } catch (PDOException $e) {
    // beim Herstellen der Datenbankverbindung oder der Vorbereitung der Abfrage ist ein Fehler 
    //aufgetreten!
    echo "shit";
    $e->getMessage(); //stellt eine Fehlerbeschreibung bereit
    }
    
    //Daten von der Datenbank entgegennehmen und Als html ausgeben. 
    echo '<option value="">Kategorie</option>';
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    
    $strg = '<option value="';
    $strg = $strg.$row['K_ID'];
    if ($row["K_ID"] == $KIDtemp) {
        $strg = $strg.'" selected=\"selected\">';
    } else {
        $strg = $strg.'">';
    }
 
    $strg = $strg.$row['Name'];
    $strg = $strg.'</option>';
    echo $strg;
    }
    
    
    echo "</select>";
    echo "</div>";
    echo "<div class=\"select-wrapper fa fa-angle-down\">";
    echo "<select name=\"Bridge\" >";
    
    $query = 'SELECT * FROM `bridge` WHERE 1;';
    //echo '<br>'.$query;
    $statement = $pdo->prepare($query);
    $statement->execute();
    
    //Daten von der Datenbank entgegennehmen und Als html ausgeben. 
    echo '<option value="">Kategorie</option>';
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    
    $strg = '<option value="';
    $strg = $strg.$row['b_id'];
    if ($row["b_id"] == $BIDtemp) {
        $strg = $strg.'" selected=\"selected\">';
    } else {
        $strg = $strg.'">';
    }
 
    $strg = $strg.$row['name'];
    $strg = $strg.'</option>';
    echo $strg;
    }
    
    
    echo "</select>";
    echo "</div>";
    echo "<div class=\"select-wrapper fa fa-angle-down\">";
    echo "<select name=\"Raum\" >";
    
    $query = 'SELECT * FROM `räume` WHERE 1;';
    //echo '<br>'.$query;
    $statement = $pdo->prepare($query);
    $statement->execute();
    
    //Daten von der Datenbank entgegennehmen und Als html ausgeben. 
    echo '<option value="">Raum</option>';
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    
    $strg = '<option value="';
    $strg = $strg.$row['R_ID'];
    if ($row["R_ID"] == $RIDtemp) {
        $strg = $strg.'" selected=\"selected\">';
    } else {
        $strg = $strg.'">';
    }
 
    $strg = $strg.$row['Name'];
    $strg = $strg.'</option>';
    echo $strg;
    }
    
    
    echo "</select>";
    echo "</div>";
    echo "<div class=\"select-wrapper fa fa-angle-down\">";
    echo "<input type=\"submit\" class=\"button2\" name=\"action_bearbeiten\" id=\"button1\" value=\"Bearbeiten\">";
    echo "</div>";
    echo "</form>";
    

}
?>


</body>
</html>