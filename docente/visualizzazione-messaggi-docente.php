<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {

    header('Location: ../registrazione/login.php');
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
    exit();
}

$sql = 'SELECT * FROM MESSAGGIO_STUDENTE WHERE DESTINATARIO = ?';

$username = $_SESSION["username"];

$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $username);

$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo 'Messaggi ricevuti: ';
print_r($result);

?>




