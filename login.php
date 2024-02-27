<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>
<body>
<p> 
<?php
   $username=$_POST["username"];
   $pazzword=$_POST["password"];
   
   // Connessione al DB
   try {
      $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'root');
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
   catch(PDOException $e) {
      echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
      exit();
   }
   
   
   try {
     // Query SQL per l'inserimento dati
    //$sql='SELECT COUNT(*) AS counter FROM Credenziali  WHERE (Utente="'.$username.'") AND (Password="'.$password.'")';
        
    
    $sql='SELECT COUNT(*) AS counter FROM Credenziali  WHERE (Utente=:lab1) AND (Pazzword=:lab2)';
    echo("Query ".$sql);
    $res=$pdo->prepare($sql);
    $res->bindValue(":lab1",$username);
    $res->bindValue(":lab2",$pazzword);
    $res->execute();

    $res=$pdo->query($sql);
   }
  catch(PDOException $e) {
    echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: ".$e->getMessage());
    exit();
  }
  
 
   $row=$res->fetch();
   if ($row['counter']>0) {
       echo("<b> Benvenuto nel sistema, ".$username."</b>"); 
      } else {
       echo("<b>Accesso non autorizzato! </b>");  
   }
  
  $linkback='<br><br><a href="formlogin.html"> Torna Indietro </a>';
  echo($linkback);
      
 ?>

</p>
</body>

</html>

<?php
/*$sql='SELECT COUNT(*) AS counter FROM Login  WHERE (Utente=:lab1) AND (Password=:lab2)';
     $res=$pdo->prepare($sql);
     $res->bindValue(":lab1",$username);
     $res->bindValue(":lab2",$password);
     $res->execute();
     
     session_start();
       $_SESSION_['user']=$username;
     */
?>