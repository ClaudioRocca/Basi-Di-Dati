<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

        header('Location: registrazione/login.php');
    }


use MongoDB\Client;

// Connessione al server MongoDB
$mongoClient = new Client("mongodb://localhost:27017");

?>