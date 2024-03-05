<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

        header('Location: login.php');
    }

    // Creazione della connessione
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e){
        echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
        exit();
    }

    echo 'Scegliere il docente a cui si vuole inviare il messaggio';
?>