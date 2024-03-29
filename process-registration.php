<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ruolo = $_POST["ruolo"];
    $mail = $_POST["mail"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $pazzword = $_POST["pazzword"];
    $confirm_password = $_POST["confirm_pazzword"];
    $recapito = isset($_POST["recapito"]) ? $_POST["recapito"] : null;

    // Verifica se le password coincidono
    if ($pazzword !== $confirm_password) {
        echo "Le password non corrispondono.";
        exit();
    }

    // Salva i dati nella sessione
    $_SESSION["ruolo"] = $ruolo;
    $_SESSION["mail"] = $mail;
    $_SESSION["nome"] = $nome;
    $_SESSION["cognome"] = $cognome;
    $_SESSION["pazzword"] = $pazzword;
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