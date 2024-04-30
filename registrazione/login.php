<?php
require_once 'C:/xampp/htdocs/Basi-Di-Dati/vendor/autoload.php';
require_once 'C:/xampp/htdocs/Basi-Di-Dati/mongodb/logger/Log_login.php';

////controlla lo stato della sessione e avvia una nuova sessione solo se non è già attiva
//if (session_status() == PHP_SESSION_NONE) {
//
//}

session_start();
$username=$_POST["username"]; // aggiorna la variab  con l'istanza nuova
$password=$_POST["password"];

   try {
      $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
   catch(PDOException $e) {
      echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
      exit();
   }


   try {
     // Query SQL per l'inserimento dati
    $sql='SELECT COUNT(*) AS counter FROM Docente WHERE (Mail="'.$username.'") AND (Pazzword="'.$password.'")';

    $res=$pdo->prepare($sql);
    $res->execute();

    $res=$pdo->query($sql);
    $row=$res->fetch();

    if ($row['counter']>0) {
        $_SESSION["username"] = $username; // Session cosi forziamo il passaggio da Login
        $_SESSION["password"] = $password;
        $_SESSION["ruolo"]= "docente";

        // Registra il log dell'accesso del docente
        logLoginEvent("Docente", $username);

        header('Location: ../docente/interfaccia-docente.php');
    }

    $sql='SELECT COUNT(*) AS counter FROM Studente WHERE (Mail="'.$username.'") AND (Pazzword="'.$password.'")';

    $res=$pdo->prepare($sql);
    $res->execute();

    $res=$pdo->query($sql);
    $row=$res->fetch();

    if ($row['counter']>0) {
        $_SESSION["username"] = $username; // Session cosi forziamo il passaggio da Login
        $_SESSION["password"] = $password;
        $_SESSION["ruolo"]= "studente";

        // Registra il log dell'accesso dello studente
        logLoginEvent("Studente", $username);
        
        header('Location: ../studente/interfaccia-studente.php');
    }
    else{
      echo 'Accesso non autorizzato';}
    }
  catch(PDOException $e) {
    echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: ".$e->getMessage());
    exit();
  }
  $linkback= '<br><br><a href="pagelogin.php"> Torna alla pagina di login </a>'; // pop per tornare a menu
  echo($linkback);

 ?>