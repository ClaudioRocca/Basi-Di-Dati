<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'studente') {
    header('Location: login.php');
    exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', '');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // risposta comd array delle risposte inviate
    foreach ($_POST['risposta'] as $idQuesito => $risposta) {
        // Prepara l'inserimento nel database
        $query = "INSERT INTO risposte (id_quesito, risposta) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$idQuesito, $risposta]);
    }

    // to do ridirezione a una pagina di conferma
    header('Location: scelta-test.php');
    exit();
} else {
    echo "Errore";
}
?>
