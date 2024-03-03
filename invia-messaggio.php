<?php


// Creazione della connessione
try {
    $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Scegliere lo studente a cui inviare il messaggio";
    echo "\n";

    // Esecuzione della procedura MySQL
    $sql = 'SELECT NOME, COGNOME, CODICE FROM STUDENTE';


    $res=$pdo->prepare($sql);
    $res->execute();
    $result = $res->fetch(PDO::FETCH_ASSOC);
    
    print_r($result);
    
 }
 catch(PDOException $e) {
    echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
    exit();
 }
?>