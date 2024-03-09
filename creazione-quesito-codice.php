
<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

    header('Location: login.php');
}

?>


<?php
// Connessione al DB
try {
    $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
    exit();
}
// Quando il form è inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $livelloDifficoltà = filter_input(INPUT_POST, 'livelloDifficoltà', FILTER_SANITIZE_STRING);
    $descrizione = filter_input(INPUT_POST, 'descrizione', FILTER_SANITIZE_STRING);
    $numRisposte = filter_input(INPUT_POST, 'numRisposte', FILTER_SANITIZE_NUMBER_INT);
    $titoloTest = filter_input(INPUT_POST, 'titoloTest', FILTER_SANITIZE_STRING);


    // Inserisci il quesito nel database
    $sqlQuesito = "INSERT INTO QUESITO_CODICE(LIVELLO, DESCRIZ, NUM_RISP, TITOLO_TEST) VALUES (?, ?, ?, ?)";
    $stmtQuesito = $pdo->prepare($sqlQuesito);
    $stmtQuesito->execute([$livelloDifficoltà, $descrizione, $numRisposte, $titoloTest]);

    echo "Quesito inserito con successo.";
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Creazione quesito codice</title>
</head>
<body>
<h2>Crea nuovo quesito con codice</h2>
<form action="creazione-quesito-codice.php" method="post">
    <select name="livelloDifficoltà" required>
        <option value="BASSO">Basso</option>
        <option value="MEDIO">Medio</option>
        <option value="ALTO">Alto</option>
    </select><br>
    <!-- riempire dinamicamente il campo titolotest e maildocente! -->
    <textarea name="descrizione" placeholder="Descrizione" required></textarea><br>
    <input type="number" name="numRisposte" placeholder="Numero di Risposte" required><br>
    <input type="text" name="titoloTest" placeholder="Titolo del Test" required><br>
    <!--        <input type="email" name="mailDocente" placeholder="Mail del Docente" required><br>-->
    <button type="submit">Invia</button>
</form>
</body>
</html>
