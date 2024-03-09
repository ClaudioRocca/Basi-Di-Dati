<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Informazioni Studente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Informazioni Aggiuntive Studente</h2>
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
        <button type="submit" class="btn btn-primary">Registrati</button>
    </form>
</div>
</body>
</html>