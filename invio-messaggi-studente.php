<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

        header('Location: login.php');
    }

    // Creazione della connessione
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e){
        echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
        exit();
    }

echo '<h1>Invia messaggio ad un docente</h1>';
echo '<form action="submit-messaggio-studente.php" method="post"<td>
    <label for="destinatario">Docente destinatario</label>
            <input type=\'text\' name="destinatario" id="destinatario" required = true><td>
            <label for="titoloMessaggio">Titolo messaggio</label>
            <input type=\'text\' name="titoloMessaggio" id="titoloMessaggio" required = true><td>
            <label for="testoMessaggio">Testo messaggio</label>
            <input type=\'text\' name="testoMessaggio" id="testoMessaggio" required = true><td>
            <label for="testRelativo">Test relativo al messaggio</label>
            <input type=\'text\' name="testRelativo" id="testRelativo"><td>
            
            <div> <input type=\'submit\' class="btn btn-primary"></div>
          </form>';
?>