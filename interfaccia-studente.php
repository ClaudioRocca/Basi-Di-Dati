<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

        header('Location: login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Studente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Dashboard Studente</h1>

        <div class="list-group">
            <a href="visualizzazione-test.php" class="list-group-item list-group-item-action">Visualizza test</a>
            <a href="scelta-test.php" class="list-group-item list-group-item-action">Completa un test</a>
            <a href="visualizzazione-esiti-risposte.php" class="list-group-item list-group-item-action">Visualizza esito delle
                risposte</a>
            <a href="invio-messaggi-studente.php" class="list-group-item list-group-item-action">Invia messaggio</a>
            <a href="statistiche.php" class="list-group-item list-group-item-action">Visualizzazione Statistiche</a>
            <a href = "visualizzazione-messaggi-studente.php" class="list-group-item list-group-item-action">Messaggi ricevuti</a>
        </div>


    </div>
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    -->
</body>

</html>