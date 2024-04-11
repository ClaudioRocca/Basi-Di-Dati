<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informazioni Studente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css"> <!-- Aggiungi il tuo file CSS -->
</head>
<body>

<header>
    <!-- Includi l'header dalla pagina header.html -->
    <?php include '../fragments/header.html'; ?>
</header>

<div class="container mt-5">
    <h2 class="text-center">Informazioni Aggiuntive Studente</h2>
    <form action="submit-registrazione.php" method="post">
        <!-- Campi per le informazioni aggiuntive dello studente -->
        <div class="form-group">
            <label for="codice">Codice:</label>
            <input type="text" class="form-control" id="codice" name="codice" required>
        </div>
        <div class="form-group">
            <label for="anno_Immatricolazione">Anno di Immatricolazione:</label>
            <input type="text" class="form-control" id="anno_Immatricolazione" name="anno_Immatricolazione" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Registrati</button>
    </form>
</div>

<footer>
    <!-- Includi il footer dalla pagina footer.html -->
    <?php include '../fragments/footer.html'; ?>
</footer>

</body>
</html>