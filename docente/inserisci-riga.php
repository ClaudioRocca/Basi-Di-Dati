<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {
    header('Location: ../registrazione/login.php');
}

    // Connessione al DB
    try {
        $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
        exit();
    }

// Query SQL per recuperare l'elenco delle tabelle nel database
$sql = 'SELECT * FROM TABELLA'; //' WHERE MAIL_DOCENTE = ?';

$stmt = $pdo->prepare($sql);
$stmt->execute();

// Recupero delle tabelle
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserisci Riga</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header>
    <?php include '../fragments/header.html'; ?>
</header>

<div class="container mt-5">
    <h1>Inserisci Riga</h1>
<!--    <form action="inserisci-riga.php" method="post">-->
    <form action="recupera-attributi.php" method="post">
        <div class="form-group">
            <label for="nomeTabella">Seleziona Tabella:</label>
            <select class="form-control" id="nomeTabella" name="nomeTabella" required>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Continua</button>
    </form>
</div>

<footer>
    <?php include '../fragments/footer.html'; ?>
</footer>

</body>
</html>