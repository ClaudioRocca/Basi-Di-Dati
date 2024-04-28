<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "studente")){

    header('Location: ../registrazione/login.php');
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
    exit();
}

$sql = 'SELECT * FROM MESSAGGIO_DOCENTE';

$stmt = $pdo->prepare($sql);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Messaggi Ricevuti</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h1>Messaggi Ricevuti</h1>
        <div class="list-group">

            <?php
            foreach ($results as $message): ?>
                <div class="list-group-item">
                    <h4 class="mb-1"><?php echo $message['TITOLO_MESSAGGIO']; ?></h4>
                    <p class="mb-1"><?php echo $message['DATA_INSERIMENTO']; ?></p>
                    <p class="mb-1"><?php echo $message['TESTO']; ?></p>
                    <p class="mb-1"><?php echo $message['TITOLO_TEST']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>

</body>
</html>