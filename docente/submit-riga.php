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

$nomeTabella = $_SESSION['nomeTabella'];

// Prepara l'elenco dei campi e dei valori per l'inserimento
$campi = implode(',', array_keys($_POST));
$valori = "'" . implode("','", $_POST) . "'";

try {
    $sql = "INSERT INTO $nomeTabella ($campi) VALUES ($valori)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $successMessage = 'Riga inserita correttamente nella tabella.';
    unset($_SESSION['nomeTabella']);
} catch (PDOException $e) {
    $errorMessage = "[ERRORE] Query SQL (Insert) non riuscita. Errore: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Inserimento Riga</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>
    <div class="container mt-5">
        <h1>Esito inserimento della riga:</h1>
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        <a href="interfaccia-docente.php" class="btn btn-primary">Torna alla Dashboard</a>
    </div>
    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>
</body>
</html>

