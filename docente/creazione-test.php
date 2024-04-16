<?php
    session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")){

        header('Location: ../registrazione/login.php');
    }

?>


<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Tabelle di Esercizio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Crea Nuovo test</h2>
        <form action="submit-test.php" method="post">
            <div class="form-group">
                <label for="nomeTest">Nome Test</label>
                <input type="text" class="form-control" id="nomeTest" name="nomeTest" required>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" checked data-toggle="toggle"
                    id="risposteVisualizzabili" name="risposteVisualizzabili">
                    Vuoi rendere visualizzabili le risposte?
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Crea Test</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>