<?php
   /*if (isset($_POST["username"]) and isset($_POST["password"])) {
 
      $username=$_POST["username"];
      $password=$_POST["password"];
   
       // Connessione al DB
      try {
          $pdo=new PDO('mysql:host=localhost;dbname=Accessi','root', 'root');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch(PDOException $e) {
          echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
         exit();
      }
   
   
      try {
         $sql='SELECT COUNT(*) AS counter FROM Login  WHERE (Utente=:lab1) AND (Password=:lab2)';
         $res=$pdo->prepare($sql);
         $res->bindValue(":lab1",$username);
         $res->bindValue(":lab2",$password);
         $res->execute(); 
      }
      catch(PDOException $e) {
         echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: ".$e->getMessage());
         exit();
      }   
  
 
      $row=$res->fetch();
       if ($row['counter']>0) {
         session_start();
         $_SESSION['authorized']=1;
         $_SESSION['name']=$username;
         header("Location: pagewelcome.php");
        } else {
         header("Location: pagelogin.php");
      }
   } */
  
      
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>
<body>
<form action='login.php' method="post"
 
<br>
 <br>
  <hr> LOGIN UTENTI </hr>
<table>
<tr>
 <td> <b> </b> Username:  </b></td>
 <td><input type='text' name="username" id="username"><td>
</tr>
<tr>
 <td> <b> </b> Password:  </b></td>
 <td><input type='text' name="password" id="password"><td>
</tr>

</table>
<div> <input type='submit' value='Login' href="login.php"></div>

</form>
</body>
</html>
