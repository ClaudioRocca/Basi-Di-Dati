<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header('Location: login.php');
    }
?>



<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Docente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Dashboard Docente</h1>
        <div class="list-group">
            <a href="creazione-tabelle.php" class="list-group-item list-group-item-action">Crea Tabella di Esercizio</a>
            <a href="visualizzazione-test.php" class="list-group-item list-group-item-action">Visualizza test</a>
            <a href="creazione-test.php" class="list-group-item list-group-item-action">Crea nuovo Test</a>
<!--            <a href="creazione-quesito.php" class="list-group-item list-group-item-action">Crea nuovo quesito</a>-->
            <a href="invio-messaggi-docente.php" class="list-group-item list-group-item-action">Invia messaggio</a>
            <a href="statistiche.php" class="list-group-item list-group-item-action">Visualizzazione Statistiche</a>
            <a href="log-eventi.php" class="list-group-item list-group-item-action">Amministrazione Log Eventi</a>
            <a href = "visualizzazione-messaggi-docente.php" class="list-group-item list-group-item-action">Messaggi ricevuti</a>
            <a href="pagelogin.php" class="list-group-item list-group-item-action">Logout</a>
        </div>
    </div>
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    -->
</body>

</html>
<!--
h da 1 a 6 x dimens testo
a -> link ipertest
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    -->