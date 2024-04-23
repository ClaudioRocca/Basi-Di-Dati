<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ruolo = $_POST["ruolo"];
    $username = $_POST["username"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $recapito = isset($_POST["recapito"]) ? $_POST["recapito"] : null;


    if ($password !== $confirm_password) {
        echo "Le password non corrispondono.";
        exit();
    }

    // Salva i dati nella sessione
    $_SESSION["ruolo"] = $ruolo;
    $_SESSION["username"] = $username;
    $_SESSION["nome"] = $nome;
    $_SESSION["cognome"] = $cognome;
    $_SESSION["password"] = $password;
    $_SESSION["recapito"] = $recapito;

    // Reindirizza a una pagina per completare le informazioni aggiuntive in base al ruolo
    if ($ruolo === "studente") {
        header("Location: informazioni-studente.php");
    } elseif ($ruolo === "docente") {
        header("Location: informazioni-docente.php");
    } else {
        echo "Ruolo non valido.";
        exit();
    }
} else {
    echo "Metodo di richiesta non valido.";
    exit();
}
?>