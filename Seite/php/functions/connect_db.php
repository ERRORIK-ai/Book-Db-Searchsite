<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
</head>

<body>

  <?php

  //Die Festlegung der allgemeinen variablen
  $host     = 'localhost';       // host PORT MUSS folgender sein: 3306
  $username = 'root';
  $password = '';
  $database = 'buecher';   // database

  $ausgabe = "";
  $tabelle_db = "";


  //Session wird gestartet
  session_start();
  session_regenerate_id();

  //Start der Funktion welche sich mit der DB verbindet
  $ausgabe .= connect($host, $username, $password, $database, $ausgabe);



  //------------------------------------------------------PHP FUNKTIONEN------------------------------------------------------
  function connect($host, $username, $password, $database, $ausgabe)
  {

    // mit Datenbank verbinden
    $conn = new mysqli($host, $username, $password, $database);

    // fehlermeldung, falls die Verbindung fehlschlägt.
    if ($conn->connect_error) {
      die('ACHTUNG: Verbindungsfehler ' . $conn->connect_error);
    }
    $ausgabe .= "Verbindung erfolgreich";
    return $ausgabe;
  }


  ?>

</body>

</html>