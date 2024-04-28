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

// Variabile per memorizzare il messaggio di successo o errore
$message = '';

// Verifica se è stato inviato il modulo
if(isset($_POST['titolo_test'])) {

    $titoloTest = $_POST['titolo_test'];

    $sql = "UPDATE TEST SET VISUALIZZA_RISPOSTE = 1 WHERE TITOLO = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $titoloTest);
    if ($stmt->execute([$titoloTest])) {
        $message = 'Risposte rese visualizzabili con successo';
    } else {
        $message = 'Errore durante il processo';
    }
} else {
    header('Location: visualizzazione-risposte.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Chiusura Test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h1>Esito attivazione di visualizza risposte:</h1>
        <?php if (!empty($message)): ?>
            <div class="alert <?php echo ($message == 'Risposte rese visualizzabili con successo') ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <a href="interfaccia-docente.php" class="btn btn-primary">Torna alla Dashboard</a>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>
</body>
</html>