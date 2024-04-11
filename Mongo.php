<?php

// Connessione al server MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");

// Selezione del database
$database = $mongoClient->Log_Eventi;

// Selezione della collezione degli eventi
$collection = $database->Log_Eventi;

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

