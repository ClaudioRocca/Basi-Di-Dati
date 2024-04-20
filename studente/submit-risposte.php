<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "studente")){

    header('Location: ../registrazione/login.php');
}


    $idQuesito = $_POST['idQuesito'];
    $titoloTest = $_SESSION['titoloTest'];
    $tipoQuesito = $_POST['tipoQuesito'];

    // In base al tipo di quesito, elabora i dati
    if ($tipoQuesito === 'chiuso') {

            $opzione = $_POST['opzione'];

            echo "Quesito chiuso - ID Quesito: $idQuesito, Titolo Test: $titoloTest, Tipo Quesito: $tipoQuesito, ID Opzione: $opzione";

    } elseif ($tipoQuesito === 'codice') {
        $risposta = $_POST['risposta'];

            echo "Quesito codice - ID Quesito: $idQuesito, Titolo Test: $titoloTest, Tipo Quesito: $tipoQuesito, Risposta: $risposta";
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
