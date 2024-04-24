<?php
session_start();

// Verifica se l'utente è loggato come docente
if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {
    header('Location: ../registrazione/login.php');
    exit();
}

// Connessione al database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Errore di connessione al database: " . $e->getMessage();
    exit();
}

// Verifica se è stato inviato il modulo
/*if(isset($_POST['submit'])) {
    // Recupera il titolo del test selezionato dal menu a tendina
    $titoloTest = $_POST['titolo_test'];

    // Esegui l'aggiornamento sulla tabella TEST per impostare VISUALIZZA_RISPOSTE a TRUE per il test selezionato
    $sql = "UPDATE TEST SET VISUALIZZA_RISPOSTE = 1 WHERE TITOLO_TEST = ?";

    // Esegui la query
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['titoloTest' => $titoloTest]);

    // Messaggio di successo
    echo "Il test $titoloTest è stato chiuso con successo!";
} else {echo "Ciao";}*/
// Query per recuperare i titoli dei test disponibili
$sqlTestDisponibili = "SELECT TITOLO FROM TEST";
$stmtTestDisponibili = $pdo->query($sqlTestDisponibili);
$testDisponibili = $stmtTestDisponibili->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Visualizza Risposte</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Visualizza Risposte</h1>
    <!-- Form per chiudere il test -->
    <!--<form action="" method="post">
        <button type="submit" name="chiudiTest" class="btn btn-primary">Chiudere Test</button>
    </form>-->
    <!-- Form per chiudere il test -->
    <form action="submit-chiusura.php" method="POST">
        <div class="form-group">
            <label for="titolo_test">Seleziona il test da chiudere:</label>
            <select class="form-control" id="titolo_test" name="titolo_test" required>
                <?php foreach($testDisponibili as $test): ?>
                    <option value="<?php echo $test['TITOLO']; ?>"><?php echo $test['TITOLO']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Chiudere Test</button>
    </form>
</div>
</body>
</html>