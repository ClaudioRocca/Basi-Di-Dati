<?php
// Connessione al database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Errore di connessione al database: " . $e->getMessage();
    exit();
}
// Recupera i dati dal modulo di registrazione
if(isset($_POST['username'], $_POST['password'], $_POST['confirm_password'], $_POST['ruolo'], $_POST['nome'], $_POST['cognome']
    , $_POST['codice'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $ruolo = $_POST['ruolo'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $codice = $_POST['codice'];
    $anno_Immatricolazione = $_POST['anno_Immatricolazione'];
    $recapito = isset($_POST['recapito']) ? $_POST['recapito'] : null;


    // Controllo se le password coincidono
    if($password !== $confirm_password) {
        echo "Le password non corrispondono.";
        exit();
    }

    // Hash della password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Inserimento dei dati nella tabella appropriata in base al ruolo
    try {
        if($ruolo === 'docente') {
            $stmt = $pdo->prepare("INSERT INTO Docente (mail, pazzword, nome, cognome, recapito) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$username, $hashed_password, $nome, $cognome, $recapito]);
        } elseif($ruolo === 'studente') {
            $stmt = $pdo->prepare("INSERT INTO Studente (mail, pazzword, nome, cognome, recapito,anno_Immatricolazione,
                      codice) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$username, $hashed_password, $nome, $cognome, $recapito,$anno_Immatricolazione,$codice]);
        } else {
            echo "Ruolo non valido.";
            exit();
        }

        echo "Registrazione avvenuta con successo!";
    } catch(PDOException $e) {
        echo "Errore durante l'inserimento dei dati nel database: " . $e->getMessage();
    }
} else {
    echo "Tutti i campi del modulo di registrazione sono obbligatori.";
}


?>

