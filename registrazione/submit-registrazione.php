<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recupera i dati dalla sessione
    $ruolo = $_SESSION["ruolo"];
    $mail = $_SESSION["mail"];
    $nome = $_SESSION["nome"];
    $cognome = $_SESSION["cognome"];
    $password = $_SESSION["password"];
    $recapito = $_SESSION["recapito"];

    // Inserimento dei dati nel database
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara e esegui la query di inserimento in base al ruolo
        if ($ruolo === "studente") {
            $codice = $_POST["codice"];
            $annoImmatricolazione = $_POST["anno_Immatricolazione"];
            $stmt = $pdo->prepare("INSERT INTO Studente (Mail, Nome, Cognome, Pazzword, Recapito, Codice, 
                      Anno_Immatricolazione) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$mail, $nome, $cognome, $password, $recapito, $codice, $annoImmatricolazione]);
        } elseif ($ruolo === "docente") {
            $dipartimento = $_POST["dipartimento"];
            $corso = $_POST["corso"];
            $stmt = $pdo->prepare("INSERT INTO Docente (Mail, Nome, Cognome, Pazzword, Recapito, Dipartimento, 
                     Corso) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$mail, $nome, $cognome, $password, $recapito, $dipartimento, $corso]);
        }

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

        // Stampa le informazioni di registrazione
        echo "<p><b>Ruolo:</b> $ruolo</p>";
        echo "<p><b>Username:</b> $mail</p>";
        echo "<p><b>Nome:</b> $nome</p>";
        echo "<p><b>Cognome:</b> $cognome</p>";
        echo "<p><b>Password:</b> $password</p>";
        if ($recapito) {
            echo "<p><b>Recapito:</b> $recapito</p>";
        }

        // Stampa info aggiuntive
        if ($ruolo === "studente") {
            echo "<p><b>Codice:</b> $codice</p>";
            echo "<p><b>Anno di Immatricolazione:</b> $annoImmatricolazione</p>";
            echo "<a href= '../studente/interfaccia-studente.php' class='btn btn-primary'>Vai alla dashboard></a>";
        } elseif ($ruolo === "docente") {
            echo "<p><b>Dipartimento:</b> $dipartimento</p>";
            echo "<p><b>Corso:</b> $corso</p>";
            echo "<a href= ' ../docente/interfaccia-docente.php' class='btn btn-primary'>Vai alla dashboard></a>";
        }
        ?>
    </div>

</body>
</html>