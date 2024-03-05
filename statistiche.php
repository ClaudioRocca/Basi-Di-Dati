<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header('Location: login.php');
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
</head>
<body>
<h1>Statistiche Studenti</h1>

<!-- Stampa delle statistiche Test Completati -->
<h2>Classifica Studenti per Test Completati</h2>
<table>
    <tr>
        <th>Codice Studente</th>
        <th>Test Completati</th>
    </tr>
    <?php foreach ($statisticheTestCompletati as $statistica): ?>
        <tr>
            <td><?= htmlspecialchars($statistica['CODICE']) ?></td>
            <td><?= htmlspecialchars($statistica['NUMERO_TEST_COMPLETATI']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Stampa delle statistiche Quesiti Corretti -->
<h2>Classifica Studenti per Quesiti Corretti</h2>
<table>
    <tr>
        <th>Codice Studente</th>
        <th>Quesiti Corretti</th>
    </tr>
    <?php foreach ($statisticheQuesitiCorretti as $statistica): ?>
        <tr>
            <td><?= htmlspecialchars($statistica['CODICE']) ?></td>
            <td><?= htmlspecialchars($statistica['NUMERO_QUESITI_CORRETTI']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Stampa delle statistiche Quesiti Popolari -->
<h2>Classifica Quesiti con Più Risposte</h2>
<table>
    <tr>
        <th>ID Quesito</th>
        <th>Numero Risposte</th>
    </tr>
    <?php foreach ($statisticheQuesitiPopolari as $statistica): ?>
        <tr>
            <td><?= htmlspecialchars($statistica['ID']) ?></td>
            <td><?= htmlspecialchars($statistica['NUMERO_RISPOSTE']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>


</body>
</html>