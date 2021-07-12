<?php 







if(isset($_POST['action_suchen'])){
    suchen();
}
elseif(isset($_POST['action_erstellen'])){
    erstellen();
}
elseif(isset($_POST['action_bearbeiten'])){
    bearbeiten();
}



function suchen() {
    $werte = array();
    $name = $_POST['name'];
    $anzwerte = 0;

    if(!empty($name)) {
        //echo $anzwerte;
        $werte[$anzwerte]["type"] = "name";
        $werte[$anzwerte]["value"] = preg_replace('/[^\da-z]/i', '', $name);
        $anzwerte = $anzwerte + 1;
    }
    if(!empty($_POST['Kategorie'])) {
        //echo "kat";
        $werte[$anzwerte]["type"] = "K_ID";
        $werte[$anzwerte]["value"] = preg_replace('/[^\da-z]/i', '', $_POST['Kategorie']);
        $anzwerte = $anzwerte + 1;
        //echo $anzwerte;
    }
    if(!empty($_POST['Bridge'])) {
       // echo $anzwerte;
        $werte[$anzwerte]["type"] = "B_ID";
        $werte[$anzwerte]["value"] = preg_replace('/[^\da-z]/i', '', $_POST['Bridge']);
        $anzwerte = $anzwerte + 1;
    }
    if(!empty($_POST['Raum'])) {
       // echo $anzwerte;
        $werte[$anzwerte]["type"] = "R_ID";
        $werte[$anzwerte]["value"] = preg_replace('/[^\da-z]/i', '', $_POST['Raum']);
        $anzwerte = $anzwerte + 1;
    }

    
    $query = 'SELECT * FROM devices where ';
    if($anzwerte<1) {
        $query = $query."1";
    }
    else {
        for($i = 0; $i < $anzwerte; $i++) {
            
            if($i>0) {
                $query = $query." and ";
            }
            else {

            }
            
            
            $query = $query.$werte[$i]["type"];
                $query = $query." like ";
                $query = $query."'%";
                $query = $query.$werte[$i]["value"];
                $query = $query."%'"; 
        // echo $werte[$i];

        }   
    }
    echo $query;
        
        //Zugangsdaten für Datenbank
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $name = 'herzing_martin_smarthome';
    $charset = 'utf8';

    //String zusammenbauen
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $host, $name, $charset);

    //Datenbank Öffnen
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


    //Kategorie Fremdschlüsselauflösung mit Array
    try {
        //$query = 'SELECT * FROM devices where 1';
        $queryKat = 'SELECT * FROM Kategorie where 1';
        $statement = $pdo->prepare($queryKat);
        $statement->execute();
        } catch (PDOException $e) {
        // beim Herstellen der Datenbankverbindung oder der Vorbereitung der Abfrage ist ein Fehler 
        //aufgetreten!
        //echo "shit";
        $e->getMessage(); //stellt eine Fehlerbeschreibung bereit
        }
        $arrKat = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['K_ID'];
            $name = $row['Name'];
            $arrKat[$id] = $name;
            // echo '<br>'.$id.'<br>'.$name;
        }
        //Bridge Fremdschlüsselauflösung mit Array
    try {
        //$query = 'SELECT * FROM devices where 1';
        $queryBridge = 'SELECT * FROM bridge where 1';
        $statement = $pdo->prepare($queryBridge);
        $statement->execute();
        } catch (PDOException $e) {
        // beim Herstellen der Datenbankverbindung oder der Vorbereitung der Abfrage ist ein Fehler 
        //aufgetreten!
        //echo "shit";
        $e->getMessage(); //stellt eine Fehlerbeschreibung bereit
        }
        $arrBridge = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['b_id'];
            $name = $row['name'];
            $arrBridge[$id] = $name;
            //echo '<br>'.$id.'<br>'.$name;
        }
                //Raum Fremdschlüsselauflösung mit Array
    try {
        //$query = 'SELECT * FROM devices where 1';
        $queryRaum = 'SELECT * FROM räume where 1';
        $statement = $pdo->prepare($queryRaum);
        $statement->execute();
        } catch (PDOException $e) {
        // beim Herstellen der Datenbankverbindung oder der Vorbereitung der Abfrage ist ein Fehler 
        //aufgetreten!
        //echo "shit";
        $e->getMessage(); //stellt eine Fehlerbeschreibung bereit
        }
        $arrRaum = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['R_ID'];
            $name = $row['Name'];
            $arrRaum[$id] = $name;
            //echo '<br>'.$id.'<br>'.$name;
        }






    //Devices Auslesen und in Tabelle anzeigen
    try {
        //$query = 'SELECT * FROM devices where 1';
        //echo '<br>'.$query;
        $statement = $pdo->prepare($query);
        $statement->execute();
        } catch (PDOException $e) {
        // beim Herstellen der Datenbankverbindung oder der Vorbereitung der Abfrage ist ein Fehler 
        //aufgetreten!
        //echo "shit";
        $e->getMessage(); //stellt eine Fehlerbeschreibung bereit
        }
        
        echo "<html><head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<link rel='stylesheet' href='style.css'>
		<title>Anzeigen</title>
	    </head><body>";
        echo '';
        echo '<table id="wertetabelle" style="border: 1px solid black class="fixed_header"">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Device_ID</th>';
        echo '<th>Gerätename</th>';
        echo '<th>Kategorie</th>';
        echo '<th>Bridge</th>';
        echo '<th>Raum</th>';
        echo '<th>Bearbeiten</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $anzdaten = 0;
        //echo $anzdaten;
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $anzdaten = $anzdaten + 1;
            //echo $anzdaten;
            $IDtemp   = $row['D_ID'];
            $nametemp = $row['name'];
            $KIDtemp  = $row['K_ID'];
            $BIDtemp  = $row['B_ID'];
            $RIDtemp  = $row['R_ID'];

        echo '<tr>';
            echo '<td>'.$IDtemp.'</td>';
            echo '<td>'.$nametemp.'</td>';
            echo '<td>'.$arrKat[$KIDtemp].'</td>';
            echo '<td>'.$arrBridge[$BIDtemp].'</td>';
            echo '<td>'.$arrRaum[$RIDtemp].'</td>';
            echo '<td>';
            //$_POST['text'] = 'Test';
            echo '<form name="formular" method="post" action="http://localhost/projekt/bearbeiten.php">
            <input type="hidden" name="name" value="'.$row['D_ID'].'" readonly >
            <input type="submit" name="submit" value="bearbeiten">
            </form>';
            
            echo '</tr>';
            }
        echo '</tbody>';
        echo '</table>';
        echo "<form action=\"http://localhost/projekt/eingabe.php\">
            <input class=\"button\" type=\"submit\" value=\"Zurück\" />
        </form>";
       // echo"Ende der Abfrage(: <br>";
        echo "</body> </html>";


}
function erstellen() {
    echo "<!DOCTYPE html>
    <html>
    <head>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <link rel='stylesheet' href='style.css'>
    </head>
    <body>";
    $err = 0;
     if(empty($_POST['name']) || empty(preg_replace('/[^\da-z]/i', '', $_POST['name'])) ) {
        echo "<div class=\"alert\">
        <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> 
        <strong>Achtung!</strong> Das Feld Name muss gefüllt sein.
      </div><br>";
      $err = 1;
    }
    if(empty($_POST['Kategorie'])) {
    }
    if(empty($_POST['Bridge'])) {
        echo "<div class=\"alert\">
        <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> 
        <strong>Achtung!</strong> Wählen Sie eine Bridge aus.
      </div><br>";
      $err = 1;

    }
    if(empty($_POST['Raum']) && $_POST['Raum'] !== '0') {
        echo "<div class=\"alert\">
        <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> 
        <strong>Achtung!</strong> Wählen Sie einen Raum für Ihr Gerät.
      </div><br>";
      $err = 1;
    }
    if ($err==0) {
        
    $query = "INSERT INTO `devices` (`name`, `K_ID`, `B_ID`, `R_ID`) VALUES ('";
    $query = $query.preg_replace('/[^\da-z]/i', '', $_POST['name'])."', '";
    $query = $query.preg_replace('/[^\da-z]/i', '', $_POST['Kategorie'])."', '";
    $query = $query.preg_replace('/[^\da-z]/i', '', $_POST['Bridge'])."', '";
    $query = $query.preg_replace('/[^\da-z]/i', '', $_POST['Raum'])."')";
    echo $query;

    

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

        echo $row;
    }
    if($pdo->errorCode() == 0000) {
        
        echo "<div class=\"alertgood\">
        <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> 
        Neues Gerät erfolgreich angelegt!
      </div>";
    }
    } else {
            
    }
    echo "<form action=\"http://localhost/projekt/eingabe.php\">
        <input class=\"button\" type=\"submit\" value=\"Zurück\" />
    </form>";
    echo "</body>
    </html>";

}


function bearbeiten() {
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
            $query = "UPDATE devices SET name = \"";
            $query = $query.preg_replace('/[^\da-z]/i', '', $_POST['name']);
            $query = $query."\", K_ID = \"";
            $query = $query.preg_replace('/[^\da-z]/i', '', $_POST['Kategorie']);
            $query = $query."\", B_ID = \"";
            $query = $query.preg_replace('/[^\da-z]/i', '', $_POST['Bridge']);
            $query = $query."\", R_ID = \"";
            $query = $query.preg_replace('/[^\da-z]/i', '', $_POST['Raum']);
            $query = $query."\" WHERE D_ID = \"";
            $query = $query.preg_replace('/[^\da-z]/i', '', $_POST['D_ID']);
            $query = $query."\";";
            echo $query;



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



        }

        suchen();
}
?>