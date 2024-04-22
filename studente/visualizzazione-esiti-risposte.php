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
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Visualizzazione Risposte</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header>
    <!-- Includi l'header dalla pagina header.html -->
    <?php include '../fragments/header.html'; ?>
</header>

<div class="container mt-5">
    <?php foreach($result as $row): ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> Test: <?php echo $row["TITOLO_TEST"];?> - Quesito: <?php echo $row['ID_QUESITO']; ?></h5>
                <?php if($row["ESITO"] == 1): ?>
                    <p class="card-text">Esito: Risposta corretta</p>
                <?php else: ?>
                    <p class="card-text">Esito: Risposta sbagliata</p>
                <?php endif; ?>
            </div>
        </div>
        <br>
    <?php endforeach; ?>
</div>

<footer>
    <!-- Includi il footer dalla pagina footer.html -->
    <?php include '../fragments/footer.html'; ?>
</footer>

</body>
</html>
