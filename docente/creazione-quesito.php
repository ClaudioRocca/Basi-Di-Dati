<?php
    session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {

        header('Location: ../registrazione/login.php'); // rimanda a pag iniziale di login
    }

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea nuovo quesito</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Crea Nuovo Quesito</h1>

        <form>
            <p>Che tipo di quesito vuoi creare?</p>

            <a href = "creazione-quesito-risposta-chiusa.php" class ="btn btn-primary"> Crea quesito risposta chiusa</a>
            <a href = "creazione-quesito-codice.php" class ="btn btn-primary"> Crea quesito con codice</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>