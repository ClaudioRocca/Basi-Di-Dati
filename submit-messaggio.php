<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

        header('Location: login.php');
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

    $data = date('Y/m/d', time());

    $sql = 'SELECT MAIL FROM STUDENTE';

    $res=$pdo->prepare($sql);
    $res->execute();

    $res=$pdo->query($sql);
    $row=$res->fetch();

    $invioMessaggio = 'INSERT INTO MESSAGGIO(TITOLO_MESSAGGIO, TESTO, DATA_INSERIMENTO, TITOLO_TEST, MAIL_DOCENTE, MAIL_STUDENTE)
                        VALUES(?, ?, ?, ?, ?, ?)';

    foreach($row as $mailStudente){

        $stmt = $pdo->prepare($invioMessaggio);

        $stmt->bindParam(1, $titoloMessaggio, PDO::PARAM_STR);
        $stmt->bindParam(2, $testoMessaggio, PDO::PARAM_STR);
        $stmt->bindParam(3, $data, PDO::PARAM_STR);
        $stmt->bindParam(4, $testRelativo, PDO::PARAM_STR);
        $stmt->bindParam(5, $_SESSION["username"], PDO::PARAM_STR);
        $stmt->bindParam(6, $mailStudente, PDO::PARAM_STR);

        $stmt->execute();
        echo 'Messaggio inviato agli studenti';
    }
?>