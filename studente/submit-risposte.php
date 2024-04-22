<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "studente")){

    header('Location: ../registrazione/login.php');
}

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo("[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage());
        exit();
    }

    $idQuesito = $_POST['idQuesito'];
    $titoloTest = $_SESSION['titoloTest'];
    $tipoQuesito = $_POST['tipoQuesito'];
    $username = $_SESSION['username'];

echo("TIPO: " . $tipoQuesito);



    // In base al tipo di quesito, elabora i dati
    if ($tipoQuesito === 'chiuso') {

        $opzione = $_POST['opzione'];

         echo "ID Quesito:" . $idQuesito;
        echo("OPZIONE: " . $opzione);
        // Chiamata alla procedura per risposta a quesito chiuso
        $stmt = $pdo->prepare("CALL inserisci_risposta_quesito_chiuso(?, ?, ?, ?)");
        $stmt->execute([$username, $idQuesito, $titoloTest, $opzione]);

    } elseif ($tipoQuesito === 'codice') {
        $risposta = $_POST['risposta'];

            echo "ID Quesito: $idQuesito, Titolo Test: $titoloTest, Tipo Quesito: $tipoQuesito, Risposta: $risposta";
        $stmt = $pdo->prepare("CALL inserisci_risposta_quesito_codice(?, ?, ?, ?)");
        $stmt->execute([$username, $idQuesito, $titoloTest, $risposta]);
        }
     else {
    echo "Errore: dati mancanti";
}


$linkback = '<br><br><a href="interfaccia-studente.php"> Torna alla dashboard </a>';
echo($linkback);
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Submit risposte</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../styles.css">
    </head>
    <body>
        <header>
            <?php include '../fragments/header.html'; ?>
        </header>
        <div>
<!--TODO COMPLETARE LA PAGINA-->
        </div>
        <footer>
            <?php include '../fragments/footer.html'; ?>
        </footer>
    </body>
</html>
