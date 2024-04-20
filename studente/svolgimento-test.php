<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['ruolo'] !== 'studente') {
    header('Location: ../registrazione/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titoloTest = $_POST['Titolo'];
    header("Location: svolgimento-test.php?Titolo=" . urlencode($titoloTest));
    exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prendi il titolo del test dalla query string se viene da un redirect GET
$titoloTest = isset($_GET['Titolo']) ? $_GET['Titolo'] : null;
$quesiti = [];

$sql = "CALL CAMBIO_STATO_TEST(?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $_SESSION['username']);
$stmt->bindParam(2, $titoloTest);
$stmt->execute();

if ($titoloTest) {
    $stmt = $pdo->prepare("SELECT ID, DESCRIZ FROM QUESITO_RISPOSTA_CHIUSA WHERE TITOLO_TEST = :idTest");
    $stmt->execute(['idTest' => $titoloTest]);
    $quesiti = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Invio Risposta Quesito</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

    <header>
        <?php include '../fragments/header.html'; ?>
    </header>
    <div class="container mt-5">
        <h2>Quesiti del Test: <?= htmlspecialchars($titoloTest) ?></h2>
        <form action="inserimento-risposte.php" method="post">
            <?php foreach ($quesiti as $quesito): ?>
                <div class="form-group">
                    <fieldset>
                        <legend><?= htmlspecialchars($quesito['DESCRIZ']) ?></legend>
                        <?php
                        // Query per recuperare le opzioni relative al quesito
                        $stmtOpzioni = $pdo->prepare("SELECT ID_OPZIONE, TESTO FROM OPZIONE WHERE ID_QUESITO = :idQuesito");
                        $stmtOpzioni->execute(['idQuesito' => $quesito['ID']]);
                        $opzioni = $stmtOpzioni->fetchAll(PDO::FETCH_ASSOC);

                        if (!$opzioni) {
                            echo "<p>Nessuna opzione disponibile per questo quesito.</p>";
                        } else {
                            foreach ($opzioni as $opzione):
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" name="risposta[' . $quesito['ID'] . ']" id="opzione' . $opzione['ID_OPZIONE'] . '" value="' . $opzione['ID_OPZIONE'] . '">';
                                echo '<label class="form-check-label" for="opzione' . $opzione['ID_OPZIONE'] . '">' . htmlspecialchars($opzione['TESTO']) . '</label>';
                                echo '</div>';
                            endforeach;
                        }
                        ?>
                    </fieldset>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Invia Risposte</button>
        </form>
        <a href="interfaccia-studente.php" class="btn btn-secondary mt-3">Torna alla dashboard</a>
    </div>
    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>
</body>
</html>
