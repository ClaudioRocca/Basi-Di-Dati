
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h2>Crea Nuovo Quesito a Risposta Chiusaaa</h2>
        <form action="creazione-quesito-risposta-chiusa.php" method="post">
            <div class="form-group">
                <label for="livelloDifficoltà">Livello di Difficoltà:</label>
                <select id="livelloDifficoltà" name="livelloDifficoltà" class="form-control" required>
                    <option value="BASSO">Basso</option>
                    <option value="MEDIO">Medio</option>
                    <option value="ALTO">Alto</option>
                </select>
            </div>
            <div class="form-group">
                <label for="descrizione">Descrizione:</label>
                <textarea id="descrizione" name="descrizione" class="form-control" placeholder="Descrizione" required></textarea>
            </div>
            <div class="form-group">
                <label for="numRisposte">Numero di Risposte:</label>
                <input type="number" id="numRisposte" name="numRisposte" class="form-control" placeholder="Numero di Risposte" required oninput="aggiungiOpzioni()">
            </div>
            <div class="form-group">
                <label for="titoloTest">Test relativo:</label>
                <input type="text" id="titoloTest" name="titoloTest" class="form-control" placeholder="Test relativo" required>
            </div>
            <div class="form-group">
                <label for="nomiTabelle">Tabelle relative:</label>
                <input type="text" id="nomiTabelle" name="nomiTabelle" class="form-control" placeholder="Tabelle relative" required>
            </div>
            <div id="opzioniContainer">
                <!--  campi delle opzioni aggiunti dinamicamnte -->
            </div>
            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
        <a href="interfaccia-docente.php" class="btn btn-secondary mt-3">Torna alla dashboard</a>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>

    <script>
            function aggiungiOpzioni() {
                const numRisposte = document.getElementById('numRisposte').value;
                const containerOpzioni = document.getElementById('opzioniContainer');

                for (let i = 0; i < numRisposte; i++) {
                    const label = document.createElement('label');
                    label.innerText = 'Opzione ' + (i + 1) + ':';
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = 'opzione' + (i + 1);
                    input.required = true;
                    input.className = 'form-control';
                    input.placeholder = 'Testo dell opzione';

                    const checkboxLabel = document.createElement('label');
                    checkboxLabel.innerText = ' Corretta';
                    const checkbox = document.createElement('input');
                    checkbox.type = 'radio';
                    checkbox.name = 'opzioneCorretta';
                    checkbox.value = i + 1;
                    // La prima opzione è quella corretta
                    if (i === 0) checkbox.checked = true;

                    containerOpzioni.appendChild(label);
                    containerOpzioni.appendChild(input);
                    containerOpzioni.appendChild(checkboxLabel);
                    containerOpzioni.appendChild(checkbox);
                    containerOpzioni.appendChild(document.createElement('br'));
                }
            }
        </script>
</body>
</html>

