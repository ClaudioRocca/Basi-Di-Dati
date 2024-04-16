<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header('Location: ../registrazione/login.php');
    }
    echo 'User: ';
    echo($_SESSION['username']);
    echo 'password: ';
    echo($_SESSION['password']);
?>




<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Docente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css"> <!-- Aggiungi il tuo file CSS -->
</head>

<body>

    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h1>Dashboard Docente</h1>
        <div class="list-group">
            <a href="creazione-tabelle.php" class="list-group-item list-group-item-action">Crea Tabella di Esercizio</a>
            <a href="../studente/visualizzazione-test.php" class="list-group-item list-group-item-action">Visualizza test</a>
            <a href="creazione-test.php" class="list-group-item list-group-item-action">Crea nuovo Test</a>
            <a href="creazione-quesito.php" class="list-group-item list-group-item-action">Crea nuovi quesiti</a>
            <a href="invio-messaggi-docente.php" class="list-group-item list-group-item-action">Invia messaggio</a>
            <a href="../statistiche.php" class="list-group-item list-group-item-action">Visualizzazione Statistiche</a>
            <a href="../log-eventi.php" class="list-group-item list-group-item-action">Amministrazione Log Eventi</a>
            <a href = "visualizzazione-messaggi-docente.php" class="list-group-item list-group-item-action">Messaggi ricevuti</a>
            <a href="../registrazione/pagelogin.php" class="list-group-item list-group-item-action">Logout</a>
        </div>
    </div>
    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>

</body>

</html>
