<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {
    header('Location: ../registrazione/login.php');
    exit();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Errore di connessione al database: " . $e->getMessage();
    exit();
}

    $sqlTestDisponibili = "SELECT TITOLO FROM TEST";
    $stmtTestDisponibili = $pdo->query($sqlTestDisponibili);
    $testDisponibili = $stmtTestDisponibili->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Visualizzazione Risposte</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h1>Visualizzazione Risposte</h1>
        <form action="submit-chiusura.php" method="POST">
            <div class="form-group">
                <label for="titolo_test">Seleziona il test di cui rendere visualizzabili le risposte:</label>
                <select class="form-control" id="titolo_test" name="titolo_test" required>
                    <?php foreach($testDisponibili as $test): ?>
                        <option value="<?php echo $test['TITOLO']; ?>"><?php echo $test['TITOLO']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Chiudere Test</button>
        </form>
    </div>
    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>
</body>
</html>