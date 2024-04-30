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
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h2>Crea Nuovo test</h2>
        <form action="submit-test.php" method="post">
            <div class="form-group">
                <label for="nomeTest">Nome Test</label>
                <input type="text" class="form-control" id="nomeTest" name="nomeTest" required>
                <label for="myfile">Aggiungi una foto (opzionale)</label>
                <input type="file" id="foto" name="foto">
            </div>

            <button type="submit" class="btn btn-primary">Crea Test</button>
        </form>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>

</body>
</html>