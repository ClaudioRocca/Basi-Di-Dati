
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
    $nomiTabelle = filter_input(INPUT_POST, 'nomiTabelle', FILTER_SANITIZE_STRING);

    $sqlQuesito = "CALL INSERIMENTO_QUESITO_RISPOSTA_CHIUSA(?, ?, ?, ?)";
    $stmtQuesito = $pdo->prepare($sqlQuesito);
    $stmtQuesito->execute([$titoloTest, $livelloDifficoltà, $descrizione, $numRisposte]);

    $sqlMaxIdQuesito = 'SELECT MAX(ID) AS ID FROM QUESITO_RISPOSTA_CHIUSA';

    $res=$pdo->query($sqlMaxIdQuesito);
    $row=$res->fetch();

    echo 'Arriva qui';

    $nomiTabelleSplittati = explode(", ", $nomiTabelle);
    $sqlAppartenenza = 'INSERT INTO APPARTENENZA_QUESITO_CHIUSO(NOME_TABELLA, TITOLO_TEST, ID_QUESITO) VALUES(?, ?, ?)';
    $stmt = $pdo->prepare($sqlAppartenenza);
    foreach ($nomiTabelleSplittati as $nomeTabella){
        $stmt->bindParam(1, $nomeTabella, PDO::PARAM_STR);
        $stmt->bindParam(2, $titoloTest, PDO::PARAM_STR);
        $stmt->bindParam(3, $row['ID'], PDO::PARAM_STR);

        $stmt->execute();
    }


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
        <input type="text" name="titoloTest" placeholder="Test relativo" required><br>
        <input type="text" name="nomiTabelle" placeholder="Tabelle relative" required><br>
<!--        <input type="email" name="mailDocente" placeholder="Mail del Docente" required><br>-->
        <button type="submit">Invia</button>
    </form>

    <a href="interfaccia-docente.php" class="btn btn-primary">Torna alla dashboard</a>
</body>
</html>
