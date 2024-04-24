<?php
//require_once __DIR__ . '/../vendor/autoload.php';
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