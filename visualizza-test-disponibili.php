<?php


// Creazione della connessione
try {
    $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Esecuzione della procedura MySQL
    $sql = "CALL VISUALIZZAZIONE_TEST_DISPONIBILI()";


    $res=$pdo->prepare($sql);
    $res->execute();
    $row=$res->fetch();

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        // Modifica di questa parte a seconda delle colonne restituite dalla procedura
        echo "Titolo test: " . $row['TITOLO'] . " - Data creazione: " . $row['DATA_CREAZIONE'] .  " - Risposte visualizzabili: " . $row['VISUALIZZA_RISPOSTE'] . "<br>";
        echo ("Procedura eseguita con successo");
    
    }


    //echo ("Procedura eseguita con successo");

    
 }
 catch(PDOException $e) {
    echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
    exit();
 }
?>
