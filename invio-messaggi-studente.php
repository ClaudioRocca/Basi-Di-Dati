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
        echo("[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage());
        exit();
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invio Messaggio a un Docente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Invia messaggio ad un docente</h1>
        <form action="submit-messaggio-studente.php" method="post">
            <div class="form-group">
                <label for="destinatario">Docente destinatario</label>
                <input type="text" class="form-control" name="destinatario" id="destinatario" required>
            </div>
            <div class="form-group">
                <label for="titoloMessaggio">Titolo messaggio</label>
                <input type="text" class="form-control" name="titoloMessaggio" id="titoloMessaggio" required>
            </div>
            <div class="form-group">
                <label for="testoMessaggio">Testo messaggio</label>
                <textarea class="form-control" name="testoMessaggio" id="testoMessaggio" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="testRelativo">Test relativo al messaggio (opzionale)</label>
                <input type="text" class="form-control" name="testRelativo" id="testRelativo">
            </div>
            <button type="submit" class="btn btn-primary">Invia Messaggio</button>
        </form>
    </div>
</body>
</html>
