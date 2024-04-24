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
    echo "Errore di connessione al database: " . $e->getMessage();
    exit();
}

// Verifica se è stato inviato il modulo
if(isset($_POST['titolo_test'])) {

    $titoloTest = $_POST['titolo_test'];

    $sql = "UPDATE TEST SET VISUALIZZA_RISPOSTE = 1 WHERE TITOLO = ?";

    $stmt = $pdo->prepare($sql);
    $stmt -> bindParam(1, $titoloTest);
    $stmt->execute([$titoloTest]);

    header('Location: interfaccia-docente.php');
    exit();
} else { //TODO: gestire meglio il caso in cui non sia inviato il modulo. Es stampa messaggio di errore.
    // Se il modulo non è stato inviato, reindirizza alla pagina visualizzazione-risposte.php
    header('Location: visualizzazione-risposte.php');
    exit();
}
?>

