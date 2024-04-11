
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

    //TODO utilizzare la procedura per inserire i dati
    $sqlQuesito = "INSERT INTO QUESITO_RISPOSTA_CHIUSA(LIVELLO, DESCRIZ, TITOLO_TEST, NUM_RISPOSTE) VALUES (?,?,?,?)";
    $stmtQuesito = $pdo->prepare($sqlQuesito);
    $stmtQuesito->execute([$livelloDifficoltà, $descrizione, $titoloTest, $numRisposte]);


    echo "Quesito inserito con successo.";
}
/* -------------------- DA PROVARE ------------------------------------------------------
// Se ci sono dati nella sessione, li preleviamo
if (isset($_SESSION['livelloDifficoltà']) && isset($_SESSION['descrizione']) && isset($_SESSION['numRisposte']) && isset($_SESSION['titoloTest']) && isset($_SESSION['mailDocente'])) {
    $livelloDifficoltà = $_SESSION['livelloDifficoltà'];
    $descrizione = $_SESSION['descrizione'];
    $numRisposte = $_SESSION['numRisposte'];
    $titoloTest = $_SESSION['titoloTest'];
    $mailDocente = $_SESSION['mailDocente'];

    // Utilizziamo la procedura SQL per inserire il quesito nel database
    $stmt = $pdo->prepare("CALL INSERIMENTO_QUESITO_RISPOSTACHIUSA(?, ?, ?, ?, ?)");
    $stmt->execute([$livelloDifficoltà, $descrizione, $numRisposte, $titoloTest, $mailDocente]);

    echo "Quesito inserito con successo.";
}*/

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Creazione quesito a risposta chiusa</title>
</head>
<body>
    <h2>Crea Nuovo Quesito a Risposta Chiusa</h2>
    <form action="creazione-quesito-risposta-chiusa.php" method="post">
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
