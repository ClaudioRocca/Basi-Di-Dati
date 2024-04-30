<?php
require_once 'C:/xampp/htdocs/Basi-Di-Dati/vendor/autoload.php';
require_once 'C:/xampp/htdocs/Basi-Di-Dati/vendor/mongodb/mongodb/logger/log_nuovoTest.php';

session_start();
if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {
    header('Location: ../registrazione/login.php');
    exit();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Errore di connessione al database: " . $e->getMessage();
    exit();
}

// Dati ricevuti dal form
$nomeTest = $_POST["nomeTest"];
$foto = $_POST['foto'];

try {
    $sql = 'CALL INSERIMENTO_NUOVO_TEST(?, ?, ?, ?)';

    $date = date('Y/m/d', time());

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(1, $nomeTest, PDO::PARAM_STR);
    $stmt->bindParam(2, $date, PDO::PARAM_STR);
    $stmt->bindParam(3, $foto, PDO::PARAM_STR);
    $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);

    $stmt->execute();

    // Registra il log della creazione del test
    logTestCreation($nomeTest, $_SESSION["username"], $date, $foto);
    $successMessage = 'Test creato con successo';

} catch (PDOException $e) {
$errorMessage = "[ERRORE] Creazione del test non riuscita. Errore: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Crea Nuovo Test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h1>Esito Creazione Nuovo Test:</h1>
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
            <a href="creazione-quesito.php" class="btn btn-primary">Crea quesiti relativi a questo test</a>
            <a href="interfaccia-docente.php" class="btn btn-primary">Torna alla Dashboard</a>

        <?php elseif (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>
</body>
</html>