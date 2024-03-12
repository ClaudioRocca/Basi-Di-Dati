<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header('Location: login.php');
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

    $rispostaChiusa = 'SELECT ID, DESCRIZ, LIVELLO FROM QUESITO_RISPOSTA_CHIUSA ';
    $stmt = $pdo->prepare($rispostaChiusa);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($result as $row){
        echo($row['DESCRIZ']);
        $idQuesito = $row['ID'];
        $opzioni = 'SELECT ID_OPZIONE, TESTO FROM OPZIONE WHERE ID_QUESITO = ?';
        $stmt = $pdo->prepare($opzioni);
        $stmt->execute([$idQuesito]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r($result);
    }
    $codice = 'SELECT ID, DESCRIZ, LIVELLO FROM QUESITO_CODICE';
$stmt = $pdo->prepare($rispostaChiusa);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
