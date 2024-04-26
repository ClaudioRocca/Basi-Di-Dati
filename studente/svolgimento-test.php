<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['ruolo'] !== 'studente') {
    header('Location: ../registrazione/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titoloTest = $_POST['Titolo'];

    $_SESSION['titoloTest'] = $titoloTest;
    header("Location: svolgimento-test.php?Titolo=" . urlencode($titoloTest));
    exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prendi il titolo del test dalla query string se viene da un redirect GET
$titoloTest = isset($_GET['Titolo']) ? $_GET['Titolo'] : null;
$quesitiChiusi = [];

//$sqlFoto = "SELECT FOTO FROM TEST WHERE TITOLO = ?";
//$stmtFoto = $pdo->prepare($sqlFoto);
//$stmtFoto->bindParam(1, $titoloTest);
//$stmtFoto->execute();
//$row = $stmtFoto->fetch(PDO::FETCH_ASSOC);
//$foto = $row['FOTO'];
//$encodedImage = base64_encode($foto);

$sql = "CALL CAMBIO_STATO_TEST(?, ?)";
$stmt1 = $pdo->prepare($sql);
$stmt1->bindParam(1, $_SESSION['username']);
$stmt1->bindParam(2, $titoloTest);
$stmt1->execute();

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
        <h2>Quesiti del Test: <?=  ($titoloTest) ?></h2>

        <img src="../foto/sql.png" alt="Foto">


        <?php
            if ($titoloTest) {
                $stmt1 = $pdo->prepare("SELECT ID, DESCRIZIONE, LIVELLO FROM QUESITO_RISPOSTA_CHIUSA WHERE TITOLO_TEST = ?");
                $stmt1->bindParam(1, $titoloTest, PDO::PARAM_STR);
                $stmt1->execute();
                $quesitiChiusi = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                $stmt2 = $pdo ->prepare("SELECT ID, LIVELLO, DESCRIZIONE FROM QUESITO_CODICE WHERE TITOLO_TEST = ?");
                $stmt2->bindParam(1, $titoloTest);
                $stmt2->execute();
                $quesitiCodice = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            }

            foreach ($quesitiChiusi as $quesito):?>
                <div class="form-group">


                    <label>ID:</label>
                    <span><?php echo htmlspecialchars($quesito['ID']); ?></span><br>
                    <label>Descrizione:</label>
                    <span><?php echo htmlspecialchars($quesito['DESCRIZIONE']); ?></span><br>
                    <label>Livello:</label>
                    <span><?php echo htmlspecialchars($quesito['LIVELLO']); ?></span><br>

                    <form class="form-quesito" action="submit-risposte.php" method="post">

                        <input type="hidden" name="tipoQuesito" value="chiuso">
                        <input type="hidden" name="titoloTest" value= <?php $titoloTest ?> >
                        <?php
                        // Query per recuperare le opzioni relative al quesito
                        $idQuesito = $quesito['ID'];
                        $stmtOpzioni = $pdo->prepare("SELECT ID_OPZIONE, TESTO FROM OPZIONE WHERE ID_QUESITO = ? AND TITOLO_TEST = ?");
                        $stmtOpzioni->bindParam(1, $idQuesito);
                        $stmtOpzioni->bindParam(2, $titoloTest);
                        $stmtOpzioni->execute();
                        $opzioni = $stmtOpzioni->fetchAll(PDO::FETCH_ASSOC);

                        if (!$opzioni) {
                            echo "<p>Nessuna opzione disponibile per questo quesito.</p>";
                        } else {
                            echo '<div class="opzioni">';
                            foreach ($opzioni as $opzione):
                                echo '<div class="form-check">';
                                echo '<input type="hidden" name="idQuesito" value = '. $idQuesito . '>';
                                echo '<input class="form-check-input" type="radio" name="opzione' . '" value="' .$opzione['ID_OPZIONE'].'">';
                                echo '<label class="form-check-label" for="opzione' . $opzione['ID_OPZIONE'] . '">' . htmlspecialchars($opzione['TESTO']) . '</label>';
                                echo '</div>';
                            endforeach;
                            echo "</div>";
                        }
                        ?>

                        <button class ="btn btn-primary" type ="submit">Inserisci risposta</button>
                    </form>
                    <fieldset>

                </div>
            <?php endforeach; ?>

            <?php

            foreach ($quesitiCodice as $quesitoCodice): ?>
                <form class="form-quesito" action="submit-risposte.php" method="post">
                    <input type="hidden" name="idQuesito" value="<?= htmlspecialchars($quesitoCodice['ID']) ?>">
                    <input type="hidden" name="titoloTest" value="<?= htmlspecialchars($titoloTest) ?>">
                    <input type="hidden" name="tipoQuesito" value="codice">
                    <div class="formgroup">
                        <fieldset>
                            <legend><?= htmlspecialchars("Descrizione: " . $quesitoCodice['DESCRIZIONE']) ?></legend>
                            <legend><?= htmlspecialchars("Livello: " . $quesitoCodice['LIVELLO']) ?></legend>

                            <input type="text" name="risposta" placeholder="Inserisci la tua risposta">
                        </fieldset>
                        <button style="margin-top: 1rem" type="submit" class="btn btn-primary">Invia risposta</button>
                    </div>
                </form>
            <?php endforeach; ?>

        <a style="margin-top: 1rem" href="interfaccia-studente.php" class="btn btn-secondary">Torna alla dashboard</a>
    </div>
    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>
</body>

<?php

?>
</html>