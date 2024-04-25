<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "studente")) {
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

try {
    $titoloMessaggio = $_POST["titoloMessaggio"];
    $testoMessaggio = $_POST["testoMessaggio"];
    $testRelativo = $_POST["testRelativo"];
    $destinatario = $_POST["destinatario"];

    // Imposta la data corrente
    $data = date('Y/m/d', time());

    $invioMessaggio = 'CALL INVIO_MESSAGGIO_STUDENTE(?,?,?,?,?,?)';
    $stmt = $pdo->prepare($invioMessaggio);
    $stmt->bindParam(1, $titoloMessaggio, PDO::PARAM_STR);
    $stmt->bindParam(2, $testoMessaggio, PDO::PARAM_STR);
    $stmt->bindParam(3, $data, PDO::PARAM_STR);
    $stmt->bindParam(4, $testRelativo, PDO::PARAM_STR);
    $stmt->bindParam(5, $_SESSION["username"], PDO::PARAM_STR);
    $stmt->bindParam(6, $destinatario, PDO::PARAM_STR);
    $stmt->execute();

    $successMessage = 'Messaggio inviato';

} catch (PDOException $e) {
    $errorMessage = "[ERRORE] Invio del messaggio non riuscito. Errore: " . $e->getMessage();
}

$linkback = '<br><br><a href="interfaccia-studente.php" class="btn btn-primary">Torna alla Dashboard</a>';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Invio Messaggio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h1>Invio Messaggio</h1>
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        <?php echo $linkback; ?>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>
</body>
</html>