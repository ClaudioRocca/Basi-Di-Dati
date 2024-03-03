<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>
<body>
<p> 
<?php
   $username=$_POST["username"];
   $password=$_POST["password"];
   
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
    $sql='SELECT COUNT(*) AS counter, RUOLO FROM Credenziali WHERE (Utente="'.$username.'") AND (Pazzword="'.$password.'") GROUP BY (RUOLO)';
    
    $res=$pdo->prepare($sql);
    $res->execute();
    
    $res=$pdo->query($sql);
   }
  catch(PDOException $e) {
    echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: ".$e->getMessage());
    exit();
  }
  
 
   $row=$res->fetch();
   if ($row['counter']>0 && $row['RUOLO'] === 1 ) {
    header('Location: interfaccia_Docente.html');
   
    } else if ($row['counter']>0 && $row['RUOLO'] === 0 ) {
        header('Location: interfaccia-studente.html'); 
    }
    else{
        echo 'Accesso non autorizzato';
    }
  
  $linkback='<br><br><a href="pagelogin.php"> Torna Indietro </a>';
  echo($linkback);
      
 ?>

</p>
</body>

</html>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operazioni disponibili</title>
</head>
<body>

    <h2>Operazioni disponibili</h2>

    <form action="visualizza-test-disponibili.php" method="post">
        <button type="submit">Visualizza test disponibili</button>
    </form>

</body>
</html>