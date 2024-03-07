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
}
// Connessione al database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Errore di connessione al database: " . $e->getMessage();
    exit();
}
// Inserimento dei dati nel database
try {
    // Prepara e esegui la query di inserimento in base al ruolo
    if ($ruolo === "studente") {
        $codice = $_POST["codice"];
        $anno_Immatricolazione = $_POST["anno_Immatricolazione"];
        $stmt = $pdo->prepare("INSERT INTO Studente (mail, nome, cognome, pazzword, recapito, codice, anno_Immatricolazione) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$mail, $nome, $cognome, $pazzword, $recapito, $codice, $anno_Immatricolazione]);
    } elseif ($ruolo === "docente") {
        $dipartimento = $_POST["dipartimento"];
        $corso = $_POST["corso"];
        $stmt = $pdo->prepare("INSERT INTO Docente (mail, nome, cognome, pazzword, recapito, dipartimento, corso) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$mail, $nome, $cognome, $pazzword, $recapito, $dipartimento, $corso]);
    }

    // Se l'inserimento è avvenuto con successo, reindirizza alla pagina di registrazione completata
    header("Location: final-registration.php");
    exit();
} catch (PDOException $e) {
    echo "Errore durante l'inserimento dei dati nel database: " . $e->getMessage();
    exit();
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Conferma Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Conferma Registrazione</h2>
    <p>Grazie per esserti registrato!</p>

    <?php
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

    } else {
        echo "<p>Metodo di richiesta non valido.</p>";
    }
    ?>
</div>
</body>
</html>
