<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ruolo = $_POST["ruolo"];
    $mail = $_POST["mail"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $pazzword = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $recapito = isset($_POST["recapito"]) ? $_POST["recapito"] : null;

    // Verifica se le password coincidono
    if ($pazzword !== $confirm_password) {
        echo "Le password non corrispondono.";
        exit();
    }

    // Inserimento dei dati nel database
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara e esegui la query di inserimento in base al ruolo
        if ($ruolo === "studente") {
            $codice = $_POST["codice"];
            $annoImmatricolazione = $_POST["anno_Immatricolazione"];
            $stmt = $pdo->prepare("INSERT INTO Studente (Mail, Nome, Cognome, Password, Recapito, Codice, AnnoImmatricolazione) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$mail, $nome, $cognome, $pazzword, $recapito, $codice, $annoImmatricolazione]);
        } elseif ($ruolo === "docente") {
            $dipartimento = $_POST["dipartimento"];
            $corso = $_POST["corso"];
            $stmt = $pdo->prepare("INSERT INTO Docente (Mail, Nome, Cognome, Password, Recapito, Dipartimento, Corso) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$mail, $nome, $cognome, $pazzword, $recapito, $dipartimento, $corso]);
        }

        // Se l'inserimento è avvenuto con successo, reindirizza alla pagina di registrazione completata
        /*header("Location: final-registration.php");
        exit();*/
    } catch (PDOException $e) {
        echo "Errore durante l'inserimento dei dati nel database: " . $e->getMessage();
        exit();
    }
} else {
    echo "Metodo di richiesta non valido.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Final Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Registrazione Utente</h2>
    <p>Grazie per esserti registrato!</p>
    <?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recupera i dati dalla sessione
        $ruolo = $_SESSION["ruolo"];
        $mail = $_SESSION["mail"];
        $nome = $_SESSION["nome"];
        $cognome = $_SESSION["cognome"];
        $pazzword = $_SESSION["pazzword"];
        $recapito = $_SESSION["recapito"];

        // Stampa le informazioni di registrazione
        echo "<p><b>Ruolo:</b> $ruolo</p>";
        echo "<p><b>Username:</b> $mail</p>";
        echo "<p><b>Nome:</b> $nome</p>";
        echo "<p><b>Cognome:</b> $cognome</p>";
        echo "<p><b>Password:</b> $pazzword</p>";
        if ($recapito) {
            echo "<p><b>Recapito:</b> $recapito</p>";
        }

        // Aggiungi ulteriori informazioni in base al ruolo
        if ($ruolo === "studente") {
            $codice = $_POST["codice"];
            $annoImmatricolazione = $_POST["anno_Immatricolazione"];
            echo "<p><b>Codice:</b> $codice</p>";
            echo "<p><b>Anno di Immatricolazione:</b> $annoImmatricolazione</p>";
        } elseif ($ruolo === "docente") {
            $dipartimento = $_POST["dipartimento"];
            $corso = $_POST["corso"];
            echo "<p><b>Dipartimento:</b> $dipartimento</p>";
            echo "<p><b>Corso:</b> $corso</p>";
        }
    } else {
        echo "<p>Metodo di richiesta non valido.</p>";
    }
    ?>
</div>
</body>
</html>




<!--/*// Recupera i dati dal modulo di registrazione-->
<!--if(isset($_POST['username'], $_POST['password'], $_POST['confirm_password'], $_POST['ruolo'], $_POST['nome'], $_POST['cognome']-->
<!--    , $_POST['codice'])) {-->
<!--    $username = $_POST['username'];-->
<!--    $password = $_POST['password'];-->
<!--    $confirm_password = $_POST['confirm_password'];-->
<!--    $ruolo = $_POST['ruolo'];-->
<!--    $nome = $_POST['nome'];-->
<!--    $cognome = $_POST['cognome'];-->
<!--    $codice = $_POST['codice'];-->
<!--    $anno_Immatricolazione = $_POST['anno_Immatricolazione'];-->
<!--    $recapito = isset($_POST['recapito']) ? $_POST['recapito'] : null;-->
<!---->
<!---->
<!--    // Controllo se le password coincidono-->
<!--    if($password !== $confirm_password) {-->
<!--        echo "Le password non corrispondono.";-->
<!--        exit();-->
<!--    }-->
<!---->
<!---->
<!--    // Inserimento dei dati nella tabella appropriata in base al ruolo-->
<!--    try {-->
<!--        if($ruolo === 'docente') {-->
<!--            $stmt = $pdo->prepare("INSERT INTO Docente (mail, pazzword, nome, cognome, recapito) VALUES (?, ?, ?, ?, ?)");-->
<!--            $stmt->execute([$username, $password, $nome, $cognome, $recapito]);-->
<!--        } elseif($ruolo === 'studente') {-->
<!--            $stmt = $pdo->prepare("INSERT INTO Studente (mail, pazzword, nome, cognome, recapito,anno_Immatricolazione,-->
<!--                      codice) VALUES (?, ?, ?, ?, ?, ?, ?)");-->
<!--            $stmt->execute([$username, $password, $nome, $cognome, $recapito,$anno_Immatricolazione,$codice]);-->
<!--        } else {-->
<!--            echo "Ruolo non valido.";-->
<!--            exit();-->
<!--        }-->
<!---->
<!--        echo "Registrazione avvenuta con successo!";-->
<!--    } catch(PDOException $e) {-->
<!--        echo "Errore durante l'inserimento dei dati nel database: " . $e->getMessage();-->
<!--    }-->
<!--} else {-->
<!--    echo "Tutti i campi del modulo di registrazione sono obbligatori.";-->
<!--}-->
<!---->
<!---->
<!--*/?>-->

