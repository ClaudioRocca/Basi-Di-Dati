<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "studente")){

    header('Location: ../registrazione/login.php');
}

$idQuesito = $_POST['idQuesito'];
$opzione = $_POST['opzione'];

echo("ID: " . $idQuesito);
echo("OPZIONE: " . $opzione);





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
