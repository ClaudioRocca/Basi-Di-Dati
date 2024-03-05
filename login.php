<?php
session_start();

    $username=$_POST["username"];
    $password=$_POST["password"];

    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
    
   // Connessione al DB
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
      header('Location: interfaccia-docente.php');
    } 

    $sql='SELECT COUNT(*) AS counter FROM Studente WHERE (Mail="'.$username.'") AND (Pazzword="'.$password.'")';
    
    $res=$pdo->prepare($sql);
    $res->execute();
    
    $res=$pdo->query($sql);

    $row=$res->fetch();
    if ($row['counter']>0) {
      header('Location: interfaccia-studente.php');
    }
    else{
      echo 'Accesso non autorizzato';
  }

   }
  catch(PDOException $e) {
    echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: ".$e->getMessage());
    exit();
  }
    
  
  $linkback='<br><br><a href="pagelogin.php"> Torna alla pagina di login </a>';
  echo($linkback);
      
 ?>