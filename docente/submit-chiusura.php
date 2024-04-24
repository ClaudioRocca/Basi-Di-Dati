<?php
session_start();

// Verifica se l'utente è loggato come docente
if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {
    header('Location: ../registrazione/login.php');
    exit();
}

// Connessione al database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Errore di connessione al database: " . $e->getMessage();
    exit();
}

// Verifica se è stato inviato il modulo
if(isset($_POST['titolo_test'])) {
    // Recupera il titolo del test selezionato dal menu a tendina
    $titoloTest = $_POST['titolo_test'];

    // Esegui l'aggiornamento sulla tabella TEST per impostare VISUALIZZA_RISPOSTE a TRUE per il test selezionato
    $sql = "UPDATE TEST SET VISUALIZZA_RISPOSTE = 1 WHERE TITOLO = ?";

    // Esegui la query
    $stmt = $pdo->prepare($sql);
    $stmt -> bindParam(1, $titoloTest);
    $stmt->execute([$titoloTest]);

    // Redirect alla pagina visualizzazione-risposte.php con un messaggio di successo
    header('Location: interfaccia-docente.php');
    exit();
} else {
    // Se il modulo non è stato inviato, reindirizza alla pagina visualizzazione-risposte.php
    header('Location: visualizzazione-risposte.php');
    exit();
}
?>

