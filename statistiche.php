<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header('Location: registrazione/login.php');
    exit();
}

// Connessione al database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connessione al DB non riuscita: " . $e->getMessage());
}

// Query per statistiche studenti
$sqlTestCompletati = 'SELECT * FROM CLASSIFICA_STUDENTI_TEST_COMPLETATI';
$sqlQuesitiCorretti = 'SELECT * FROM CLASSIFICA_STUDENTI_QUESITI_CORRETTI';
$sqlQuesitiPopolari = 'SELECT * FROM QUESITI_COMPLETATI_MAGGIORMENTE';

// Esecuzione delle query e recupero dei dati
try {
    $statisticheTestCompletati = $pdo->query($sqlTestCompletati)->fetchAll(PDO::FETCH_ASSOC);
    $statisticheQuesitiCorretti = $pdo->query($sqlQuesitiCorretti)->fetchAll(PDO::FETCH_ASSOC);
    $statisticheQuesitiPopolari = $pdo->query($sqlQuesitiPopolari)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Errore nell'esecuzione delle query: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Statistiche Studenti</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include 'fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h2>Statistiche Studenti</h2>

        <!-- Stampa delle statistiche Test Completati -->
        <h3 class="mt-5">Classifica Studenti per Test Completati</h3>
        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th>Codice Studente</th>
                <th>Test Completati</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($statisticheTestCompletati as $statistica): ?>
                <tr>
                    <td><?= htmlspecialchars($statistica['CODICE']) ?></td>
                    <td><?= htmlspecialchars($statistica['NUMERO_TEST_COMPLETATI']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Stampa delle statistiche Quesiti Corretti -->
        <h3>Classifica Studenti per Quesiti Corretti</h3>
        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th>Codice Studente</th>
                <th>Quesiti Corretti</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($statisticheQuesitiCorretti as $statistica): ?>
                <tr>
                    <td><?= htmlspecialchars($statistica['CODICE']) ?></td>
                    <td><?= htmlspecialchars($statistica['NUMERO_QUESITI_CORRETTI']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Stampa delle statistiche Quesiti Popolari -->
        <h3>Classifica Quesiti con Più Risposte</h3>
        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th>Titolo test</th>
                <th>ID Quesito</th>
                <th>Numero Risposte</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($statisticheQuesitiPopolari as $statistica): ?>
                <tr>
                    <td><?= htmlspecialchars($statistica['TITOLO_TEST']) ?></td>
                    <td><?= htmlspecialchars($statistica['ID_QUESITO']) ?></td>
                    <td><?= htmlspecialchars($statistica['NUMERO_RISPOSTE']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <?php include 'fragments/footer.html'; ?>
    </footer>
</body>
</html>