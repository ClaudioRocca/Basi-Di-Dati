<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header('Location: login.php');
    exit;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connessione al database fallita: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invia Messaggio agli Studenti</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Invia Messaggio agli Studenti</h1>
        <form action="submit-messaggio-docente.php" method="post">
            <div class="form-group">
                <label for="titoloMessaggio">Titolo messaggio</label>
                <input type="text" class="form-control" name="titoloMessaggio" id="titoloMessaggio" required>
            </div>
            <div class="form-group">
                <label for="testoMessaggio">Testo messaggio</label>
                <textarea class="form-control" name="testoMessaggio" id="testoMessaggio" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="testRelativo">Test relativo al messaggio</label>
                <input type="text" class="form-control" name="testRelativo" id="testRelativo" required>
            </div>
            <button type="submit" class="btn btn-primary">Invia Messaggio</button>
        </form>
    </div>

</html>
