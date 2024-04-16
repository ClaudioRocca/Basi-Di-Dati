
<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {

    header('Location: ../registrazione/login.php');
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

    $sqlQuesito = "CALL INSERIMENTO_QUESITO_CODICE(?, ?, ?, ?)";
    $stmtQuesito = $pdo->prepare($sqlQuesito);
    $stmtQuesito->execute([ $titoloTest, $livelloDifficoltà, $descrizione, $numRisposte]);

    $sqlMaxIdQuesito = 'SELECT MAX(ID) AS ID FROM QUESITO_CODICE';

    $res=$pdo->query($sqlMaxIdQuesito);
    $row=$res->fetch();

    $nomiTabelleSplittati = explode(", ", $nomiTabelle);
    $sqlAppartenenza = 'INSERT INTO APPARTENENZA_QUESITO_CODICE(NOME_TABELLA, TITOLO_TEST, ID_QUESITO) VALUES(?, ?, ?)';
    $stmt = $pdo->prepare($sqlAppartenenza);
    foreach ($nomiTabelleSplittati as $nomeTabella){
        $stmt->bindParam(1, $nomeTabella, PDO::PARAM_STR);
        $stmt->bindParam(2, $titoloTest, PDO::PARAM_STR);
        $stmt->bindParam(3, $row['ID'], PDO::PARAM_STR);

        $stmt->execute();
    }

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
        <!-- riempire dinamicamente il campo titolotest -->
        <textarea name="descrizione" placeholder="Descrizione" required></textarea><br>
        <input type="number" name="numRisposte" placeholder="Numero di Risposte" required><br>
        <input type="text" name="titoloTest" placeholder="Test relativo" required><br>
        <input type="text" name="nomiTabelle" placeholder="Tabelle relative" required><br>

        <button type="submit">Invia</button>
    </form>
    <a href="interfaccia-docente.php" class="btn btn-primary">Torna alla dashboard</a>
</body>
</html>
