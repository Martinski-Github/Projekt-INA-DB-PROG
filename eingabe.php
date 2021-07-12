<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Eingabe</title>
<link rel='stylesheet' href='style.css'>
</head>
<body>

<form name="anlegen" method="post" action="http://localhost/projekt/ausgabe.php">
<br><br>
<br><br>
<div class="select-wrapper fa fa-angle-down">
<input type="text" name="name" placeholder="Geräte Name">
</div>
<div class="select-wrapper fa fa-angle-down">
<select name="Kategorie" >
<?php
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
$strg = $strg.'">';
$strg = $strg.$row['Name'];
$strg = $strg.'</option>
';
echo $strg;
}


?>
</select>
</div>
<div class="select-wrapper fa fa-angle-down">
<select name="Bridge" >
<?php

//Datenbank Öffnen
try {

//SQL-Abfrage als String in eine Variable schreiben
$query = 'SELECT * FROM `bridge` WHERE 1;';
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
echo '<option value="">Bridge</option>';
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

$strg = '<option value="';
$strg = $strg.$row['b_id'];
$strg = $strg.'">';
$strg = $strg.$row['name'];
$strg = $strg.'</option>
';
echo $strg;
}

?>
</select>
</div>
<div class="select-wrapper fa fa-angle-down">
<select name="Raum" >
<?php

//Datenbank Öffnen
try {

//SQL-Abfrage als String in eine Variable schreiben
$query = 'SELECT * FROM `räume` WHERE 1;';
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
echo '<option value="">Raum</option>';
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

$strg = '<option value="';
$strg = $strg.$row['R_ID'];
$strg = $strg.'">';
$strg = $strg.$row['Name'];
$strg = $strg.'</option>
';
echo $strg;
}

?>
</select>
</div>
<div class="select-wrapper fa fa-angle-down">
    <input type="submit" name="action_erstellen" id="button1" value="Erstellen">
</div>
<div class="select-wrapper fa fa-angle-down">
    <input type="submit" name="action_suchen" id="button2" value="Suchen">
</div>
</form>

</body>
</html>