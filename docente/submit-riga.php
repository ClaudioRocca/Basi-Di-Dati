<?php
    session_start();

    if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {
        header('Location: ../registrazione/login.php');
        exit();
    }

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo("[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage());
        exit();
    }

    $nomeTabella = $_SESSION['nomeTabella'];

    // Prepara l'elenco dei campi e dei valori per l'inserimento
    $campi = implode(',', array_keys($_POST));
    $valori = "'" . implode("','", $_POST) . "'";

    try {
        // Query per inserire la riga nella tabella selezionata
        $sql = "INSERT INTO $nomeTabella ($campi) VALUES ($valori)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        echo 'Riga inserita correttamente nella tabella.';
        unset($_SESSION['nomeTabella']);
    } catch (PDOException $e) {
        echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: " . $e->getMessage());
        exit();
    }
    $linkback = '<br><br><a href="interfaccia-docente.php"> Torna Indietro </a>';
    echo($linkback);

?>