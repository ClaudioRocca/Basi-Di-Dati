
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

    $sketch = [];
    $sqlSketch = 'CALL INSERIMENTO_SKETCH(?,?,?)';
    for ($i = 1; $i <= $numRisposte; $i++) {
        $valore_sketch = $_POST['sketch' . $i];

        $stmt = $pdo->prepare($sqlSketch);
        $stmt->bindParam(1, $valore_sketch, PDO::PARAM_STR);
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h2>Crea nuovo quesito con codice</h2>
        <div class="row">
            <div class="col-md-6">
                <form action="creazione-quesito-codice.php" method="post">
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
                <input type="number" id="numRisposte" name="numRisposte" class="form-control" placeholder="Numero di Risposte" required oninput="aggiungiSketch()">
            </div>
            <div class="form-group">
                <label for="titoloTest">Test relativo:</label>
                <input type="text" id="titoloTest" name="titoloTest" class="form-control" placeholder="Test relativo" required>
            </div>
            <div class="form-group">
                <label for="nomiTabelle">Tabelle relative:</label>
                <input type="text" id="nomiTabelle" name="nomiTabelle" class="form-control" placeholder="Tabelle relative" required>
            </div>
            <div id="sketchContainer">
                <!--  campi delle opzioni aggiunti dinamicamnte -->
            </div>

            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
        <a href="interfaccia-docente.php" class="btn btn-secondary mt-3">Torna alla dashboard</a>

        </div>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>

    <script>
        function aggiungiSketch() {
            const numRisposte = document.getElementById('numRisposte').value;
            const containerOpzioni = document.getElementById('sketchContainer');

            for (let i = 0; i < numRisposte; i++) {
                const label = document.createElement('label');
                label.innerText = 'sketch ' + (i + 1) + ':';
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'sketch' + (i + 1);
                input.required = true;
                input.className = 'form-control';
                input.placeholder = 'Codice che risolve il quesito';

                containerOpzioni.appendChild(label);
                containerOpzioni.appendChild(input);
                containerOpzioni.appendChild(document.createElement('br'));
            }
        }
    </script>

</body>
</html>