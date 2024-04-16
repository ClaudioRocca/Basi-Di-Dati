<?php
    session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "studente")){

        header('Location: ../registrazione/login.php');
    }

    echo 'User: ';
    echo($_SESSION['username']);
    echo 'password: ';
    echo($_SESSION['password']);
    echo 'Ruolo: ';
    echo($_SESSION['ruolo']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Studente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h1 class="text-center">Dashboard Studente</h1>

        <div class="list-group">
            <a href="visualizzazione-test.php" class="list-group-item list-group-item-action">Visualizza test</a>
            <a href="scelta-test.php" class="list-group-item list-group-item-action">Completa un test</a>
            <a href="visualizzazione-esiti-risposte.php" class="list-group-item list-group-item-action">Visualizza esito delle risposte</a>
            <a href="invio-messaggi-studente.php" class="list-group-item list-group-item-action">Invia messaggio</a>
            <a href="../statistiche.php" class="list-group-item list-group-item-action">Visualizzazione Statistiche</a>
            <a href="visualizzazione-messaggi-studente.php" class="list-group-item list-group-item-action">Messaggi ricevuti</a>
            <a href="../registrazione/pagelogin.php" onclick="logout()" class="list-group-item list-group-item-action">Logout</a>
        </div>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>

    <script>
        function logout() {
            // Cancella le informazioni di sessione
            sessionStorage.clear();
            // Reindirizza l'utente alla pagina di login
            //window.location.href = 'login.php';
        }
    </script>

</body>
</html>