<?php
    session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {

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
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h2>Crea Nuova Tabella di Esercizio</h2>
        <form action="submit-tabella.php" method="post">
            <div class="form-group">
                <label for="nomeTabella">Nome Tabella</label>
                <input type="text" class="form-control" id="nomeTabella" name="nomeTabella" required>
            </div>
            <div class="form-group">
                <label for="attributi">Attributi</label>
                <textarea class="form-control" id="attributi" name="attributi" rows="3" required></textarea>
                <small class="form-text text-muted">Inserisci gli attributi separati da virgola (es. id int, nome varchar(255), ...)</small>
            </div>
            <div class="form-group">
                <label for="vincoli">Vincoli di Integrità</label>
                <textarea class="form-control" id="vincoli" name="vincoli" rows="3"></textarea>
                <small class="form-text text-muted">Inserisci eventuali vincoli di integrità.</small>
            </div>
            <button type="submit" class="btn btn-primary">Crea Tabella</button>
        </form>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>

</body>
</html>