<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "studente")){
    header('Location: ../registrazione/login.php');
}
?>

<?php
    $titolo=$_GET["Titolo"];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: ".$e->getMessage());
        exit();
    }

    $sql = 'CALL VISUALIZZAZIONE_QUESITI_TEST(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $titolo, PDO::PARAM_STR);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    print_r($result);

//    foreach($result as $row){
//        echo($row['DESCRIZ']);
//        $idQuesito = $row['ID'];
//        $opzioni = 'SELECT ID_OPZIONE, TESTO FROM OPZIONE WHERE ID_QUESITO = ?';
//        $stmt = $pdo->prepare($opzioni);
//        $stmt->execute([$idQuesito]);
//        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        foreach($result as $option){
//            echo'<br>';
//            echo($option['TESTO']);
//        }
//        echo('<br>------------------------------<br>');
//    }
//    $codice = 'SELECT DESCRIZ FROM QUESITO_CODICE WHERE TITOLO_TEST = ?';
//    $stmt = $pdo->prepare($codice);
//    $stmt->bindParam(1, $titolo, PDO::PARAM_STR);
//    $stmt->execute();
//    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    foreach($result as $row){
//        echo ($row['DESCRIZ']);
//        echo '<br><input type="text" id="risposta" name="risposta" placeholder = "Inserisci la tua risposta">';
//
//        echo('<br>------------------------------<br>');
//    }
?>
