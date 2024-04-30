<?php
require_once 'C:/xampp/htdocs/Basi-Di-Dati/vendor/autoload.php';
require_once 'C:/xampp/htdocs/Basi-Di-Dati/mongodb/logger/log_inserimentoRisposta.php';

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
    $messaggio = "";



    // In base al tipo di quesito, elabora i dati
    if ($tipoQuesito === 'chiuso') {

        $opzione = $_POST['opzione'];

        logInserimentoRisposta($idQuesito, $titoloTest, $tipoQuesito, $opzione, $username);
        $messaggio = '<div class="alert alert-success" role="alert">Risposta inserita con successo</div>';

        $stmt = $pdo->prepare("CALL inserisci_risposta_quesito_chiuso(?, ?, ?, ?)");
        $stmt->execute([$username, $idQuesito, $titoloTest, $opzione]);

    } elseif ($tipoQuesito === 'codice') {
        $risposta = $_POST['risposta'];

        logInserimentoRisposta($idQuesito, $titoloTest, $tipoQuesito, $risposta, $username);
        $messaggio = '<div class="alert alert-success" role="alert">Risposta inserita con successo</div>';

        $stmt = $pdo->prepare("CALL inserisci_risposta_quesito_codice(?, ?, ?, ?)");
        $stmt->execute([$username, $idQuesito, $titoloTest, $risposta]);
        }
     else {
         $messaggio = '<div class="alert alert-danger" role="alert">L\'inserimento non è andato a buon fine</div>';
     }


$linkback = '<br><br><a style="margin-top:1rem" class="btn btn-primary" href="interfaccia-studente.php"> Torna alla dashboard </a>';

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
        <div class="container mt-5">
            <h1>Esito inserimento quesito</h1>
            <?php echo($messaggio);
            echo($linkback);?>
        </div>
        <footer>
            <?php include '../fragments/footer.html'; ?>
        </footer>
    </body>
</html>
