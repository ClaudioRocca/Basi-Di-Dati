<?php
require 'vendor/autoload.php'; // Carica le librerie installate tramite Composer

use MongoDB\Client; // Utilizza il namespace corretto per la classe MongoDB\Client

try {
    // Connessione al server MongoDB
    $mongoClient = new Client("mongodb://localhost:27017");

    // Selezione del database
    $database = $mongoClient->selectDatabase('Log_Eventi'); // Modificato per coerenza

    // Selezione della collezione degli eventi
    $collection = $database->selectCollection('Log_Eventi'); // Modificato per coerenza

    // Creazione del documento da inserire nel log degli eventi
    $event = [
        "type" => "nuovo_utente",
        "message" => "Nuovo utente registrato: nomeutente@example.com",
        "timestamp" => new MongoDB\BSON\UTCDateTime(time() * 1000) // Timestamp in millisecondi
    ];

    // Inserimento del documento nella collezione degli eventi
    $result = $collection->insertOne($event);

    // Verifica se l'inserimento è stato eseguito con successo
    if ($result->getInsertedCount() > 0) {
        echo "Messaggio di log inserito con successo.";
    } else {
        echo "Errore durante l'inserimento del messaggio di log.";
    }
} catch (Exception $e) {
    // Gestione degli errori in caso di problemi con la connessione o l'inserimento
    echo "Errore: ", $e->getMessage();
}
