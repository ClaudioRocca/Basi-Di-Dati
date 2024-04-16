<?php
    session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {

        header('Location: ../registrazione/login.php');
    }

?>

<?php
   $nomeTabella=$_POST["nomeTabella"];

   $attributi=$_POST["attributi"];
   $vincoli=$_POST["vincoli"];
   $username = $_SESSION["username"];

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
      $data = date('Y/m/d', time());

      $attributi_splittati = explode(', ', $attributi);

      //TODO aggiungere i vincoli d'integrità nella relativa tabella
       if($vincoli == null || empty($vincoli)){
           $sqlCreateTable = "CREATE TABLE $nomeTabella ($attributi)";
       }
       else
          $sqlCreateTable = "CREATE TABLE $nomeTabella ($attributi, $vincoli)";

       echo("query: " .$sqlCreateTable);
      $stmt = $pdo->prepare($sqlCreateTable);

      $stmt->execute();

      // Query SQL per l'inserimento dati
      $sql = "INSERT INTO TABELLA(NOME, DATA_CREAZIONE, NUMRIGHE, MAIL_DOCENTE) VALUES (?,?,0,?)";
      $stmt = $pdo->prepare($sql);

      $stmt->bindParam(1, $nomeTabella, PDO::PARAM_STR);
      $stmt->bindParam(2, $data, PDO::PARAM_STR);
      $stmt->bindParam(3, $username, PDO::PARAM_STR);

      $stmt->execute();

       $sqlInsertAttributi = 'INSERT INTO ATTRIBUTO(NOME, TIPO, NOME_TABELLA) VALUES (?, ?, ?)';
       foreach ($attributi_splittati as $attributo) {
           $nome_tipo = explode(' ', $attributo);

           $stmt = $pdo->prepare($sqlInsertAttributi);

           $stmt->bindParam(1, $nome_tipo[0], PDO::PARAM_STR);
           $stmt->bindParam(2, $nome_tipo[1], PDO::PARAM_STR);
           $stmt->bindParam(3, $nomeTabella, PDO::PARAM_STR);

           $stmt->execute();
       }
       echo 'Tabella creata con successo';

    } catch (PDOException $e) {
    echo "[ERRORE] Query SQL (Insert) non riuscita. Errore: " . $e->getMessage();
    exit();
}
  
  $linkback= '<br><br><a href="interfaccia-docente.php"> Torna Indietro </a>';
  echo($linkback);
      
 ?>