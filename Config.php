<?php
include 'database.php';
$host = 'localhost';
$port = 8889; // Porta specifica utilizzata da MAMP per MySQL
$dbname = 'ESQLDB';
$user = 'root';
$pass = 'root!'; // Assumi che 'root' sia la tua password di sviluppo

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass, [
       // PDO::MYSQL_ATTR_SSL_CA => null, // Disabilita SSL
        //PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "Connessione stabilita con successo!";
} catch (PDOException $e) {
    die("Connessione al database fallita: " . $e->getMessage());
}
