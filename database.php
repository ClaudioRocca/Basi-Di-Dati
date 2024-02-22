<?php
// database.php

// Definisci le costanti per le credenziali del database
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'ESQLDB');

// Classe per la gestione del database
class db {
    public $mysqli;

    public function __construct() {
        // Connessione al database
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
            exit();
        }
    }

    public function __destruct() {
        // Chiusura della connessione
        $this->disconnect();
        unset($this->mysqli);
    }

    public function disconnect() {
        // Chiusura della connessione
        $this->mysqli->close();
    }

    public function query($q, $resultset) {
        // Esecuzione della query
        if (!($stmt = $this->mysqli->prepare($q))) {
            echo("Sql Error: " . $q . ' Sql error #: ' . $this->mysqli->errno . ' - ' . $this->mysqli->error);
            return false;
        }

        $stmt->execute();

        if ($stmt->errno) {
            echo("Sql Error: " . $q . ' Sql error #: ' . $stmt->errno . ' - ' . $stmt->error);
            return false;
        }

        if ($resultset) {
            // Ottieni il risultato della query
            $result = $stmt->get_result();
            for ($set = array(); $row = $result->fetch_assoc();) {
                $set[] = $row;
            }
            $stmt->close();
            return $set;
        }
    }
}

// Creazione di un'istanza della classe db
$db = new db();

// Query per mostrare le variabili di timeout prima della modifica
$results = $db->query("SHOW VARIABLES LIKE '%timeout%'", TRUE);
echo "<pre>";
var_dump($results);
echo "</pre>";

// Impostazione del timeout di sessione
$results = $db->query("SET session wait_timeout=28800", FALSE);
// Aggiornamento - è necessario anche questo
$results = $db->query("SET session interactive_timeout=28800", FALSE);

// Query per mostrare le variabili di timeout dopo la modifica
$results = $db->query("SHOW VARIABLES LIKE '%timeout%'", TRUE);
echo "<pre>";
var_dump($results);
echo "</pre>";
?>
