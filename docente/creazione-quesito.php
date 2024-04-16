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
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h1>Crea Nuovo Quesito</h1>
        <form>
            <p>Che tipo di quesito vuoi creare?</p>
            <a href="creazione-quesito-risposta-chiusa.php" class="btn btn-primary">Crea quesito risposta chiusa</a>
            <a href="creazione-quesito-codice.php" class="btn btn-primary">Crea quesito con codice</a>
        </form>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>
</body>

</html>