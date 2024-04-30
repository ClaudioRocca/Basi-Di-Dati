<?php
require 'vendor/autoload.php'; // Carica le librerie Composer

use MongoDB\Client;

function logLoginEvent($username)
{
    // Connessione al server MongoDB
    try {
        $mongoClient = new Client("mongodb://localhost:27017");

        // Selezione del database
        $database = $mongoClient->selectDatabase('Log_Eventi');

        // Selezione della collezione degli eventi
        $collection = $database->selectCollection('Log_Eventi');

        // Creazione del documento da inserire nel log
        $event = [
            "type" => "login",
            "message" => "Utente " . $username . " ha effettuato l'accesso",
            "timestamp" => new MongoDB\BSON\UTCDateTime(time() * 1000) // Timestamp in millisecondi
        ];

        // Inserimento del documento nella collezione
        $result = $collection->insertOne($event);

        if ($result->getInsertedCount() > 0) {
            return "Messaggio di log inserito con successo.";
        } else {
            return "Errore durante l'inserimento del messaggio di log.";
        }

    } catch (Exception $e) {
        // Gestione degli errori in caso di problemi con la connessione o l'inserimento
        return "Errore: " . $e->getMessage();
    }
}

// Codice di test per verificare se il log funziona correttamente
$username = "nomeutente@example.com";
echo logLoginEvent($username); // Test di registrazione del log
