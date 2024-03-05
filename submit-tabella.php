<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

        header('Location: login.php');
    }

?>

<?php
   $nomeTabella=$_POST["nomeTabella"];
   $numeroRighe=$_POST["numeroRighe"];
   $attributi=$_POST["attributi"];
   $vincoli=$_POST["vincoli"];

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
      $date = date('Y/m/d', time());


      /*$sqlCreateTable = "CREATE TABLE ? (ID INT, PRIMARY KEY(ID))";

      $stmt = $pdo->prepare($sqlCreateTable);

      $stmt->bindParam(1, $nomeTabella, PDO::PARAM_STR);

      $stmt->execute();

      echo 'Tabella creata';


      $sqlInsertOnTable = "INSERT INTO  ? (ID) VALUES (?)";

      $stmt = $pdo->prepare($sqlInsertOnTable);

      $stmt->bindParam(1, $nomeTabella, PDO::PARAM_STR);
      $stmt->bindParam(2, 1, PDO::PARAM_STR);

      $stmt->execute();
      echo 'Dato inserito';*/


      // Query SQL per l'inserimento dati
      $sql = "INSERT INTO TABELLA(NOME, DATA_CREAZIONE, NUMRIGHE, MAIL_DOCENTE) VALUES (?,?,?, 'Mario.rossi@uni.it')";

      $stmt = $pdo->prepare($sql);

      $stmt->bindParam(1, $nomeTabella, PDO::PARAM_STR);
      $stmt->bindParam(2, $date, PDO::PARAM_STR);
      $stmt->bindParam(3, $numeroRighe, PDO::PARAM_STR);


      $stmt->execute();

      $attributi_splittati = explode(',', $attributi);

      $sqlInsertAttributi = 'INSERT INTO ATTRIBUTO(NOME, TIPO, NOME_TABELLA) VALUES (?, ?, ?)';
      foreach ($attributi_splittati as $attributo) {
         $nome_tipo = explode(':', $attributo);

         $stmt = $pdo->prepare($sqlInsertAttributi);

         $stmt->bindParam(1, $nome_tipo[0], PDO::PARAM_STR);
         $stmt->bindParam(2, $nome_tipo[1], PDO::PARAM_STR);
         $stmt->bindParam(3, $nomeTabella, PDO::PARAM_STR);

         $stmt->execute();
        
      }


   /*echo 'Query: ' . $sql;
   echo 'Nome tabella: ' .$nomeTabella;
   echo 'Data: ' .$date;
   echo 'Numero righe: ' .$numeroRighe;*/
   echo 'Tabella creata con successo';

} catch (PDOException $e) {
    echo "[ERRORE] Query SQL (Insert) non riuscita. Errore: " . $e->getMessage();
    exit();
}
  
  $linkback='<br><br><a href="crea-tabelle.html"> Torna Indietro </a>';
  echo($linkback);
      
 ?>