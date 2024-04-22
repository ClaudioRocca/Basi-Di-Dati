<?php
    session_start();

    if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "studente")){

        header('Location: ../registrazione/login.php');
    }

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo("[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage());
        exit();
    }

    $sql = "SELECT ID_QUESITO, TITOLO_TEST, ESITO FROM RISPOSTA_QUESITO_CHIUSO WHERE TITOLO_TEST IN(SELECT TITOLO FROM TEST WHERE VISUALIZZA_RISPOSTE = 1) 
                UNION SELECT ID_QUESITO, TITOLO_TEST, ESITO FROM RISPOSTA_QUESITO_CODICE WHERE TITOLO_TEST IN(SELECT TITOLO FROM TEST WHERE VISUALIZZA_RISPOSTE = 1)";

    $res=$pdo->prepare($sql);
    $res->execute();
    $result = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        echo("Id quesito: " . $row['ID_QUESITO']);
        echo("Titolo test: " . $row["TITOLO_TEST"]);
        echo("Esito: " . $row["ESITO"]);
        echo "<br>";
    }
?>