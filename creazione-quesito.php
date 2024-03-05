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
    <title>Crea nuovo quesito</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Crea Nuovo Quesito</h2>
        <form action="submit-quesito.php" method="post">
            <div class="form-group">
                <label for="nomeQuesito">Nome Tabella</label>
                <input type="text" class="form-control" id="nomeQuesito" name="nomeQuesito" required>
            </div>
            <div class="form-group">
                <label for="numeroRisposte">Numero di Risposte</label>
                <input type="number" class="form-control" id="numeroRisposte" name="numeroRisposte" required>
            </div>
            <!-- <div class="form-group">
                <label for="attributi">Attributi</label>
                <textarea class="form-control" id="attributi" name="attributi" rows="3" required></textarea>
                <small class="form-text text-muted">Inserisci gli attributi separati da virgola (es. id:int,
                    nome:varchar(255), ...)</small>
            </div> -->
            <button type="submit" class="btn btn-primary">Crea Quesito</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>