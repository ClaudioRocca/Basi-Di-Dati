<?php
    session_start();


    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

        header('Location: ../registrazione/login.php');
    }

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: ".$e->getMessage());
        exit();
    }


    $titoloMessaggio=$_POST["titoloMessaggio"];
    $testoMessaggio=$_POST["testoMessaggio"];
    $testRelativo=$_POST["testRelativo"];
    $destinatario = $_POST["destinatario"];

    $data = date('Y/m/d', time());

    try{
        $invioMessaggio = 'CALL INVIO_MESSAGGIO_STUDENTE(?,?,?,?,?,?)';

        $stmt = $pdo->prepare($invioMessaggio);

        $stmt->bindParam(1, $titoloMessaggio, PDO::PARAM_STR);
        $stmt->bindParam(2, $testoMessaggio, PDO::PARAM_STR);
        $stmt->bindParam(3, $data, PDO::PARAM_STR);
        $stmt->bindParam(4, $testRelativo, PDO::PARAM_STR);
        $stmt->bindParam(5, $_SESSION["username"], PDO::PARAM_STR);
        $stmt->bindParam(6, $destinatario, PDO::PARAM_STR);

        $stmt->execute();
        echo 'Messaggio inviato';
    }
    catch(PDOException $e) {
        echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: ".$e->getMessage());
        exit();
    }

