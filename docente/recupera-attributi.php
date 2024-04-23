<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {
    header('Location: ../registrazione/login.php');
    exit();
}

// Connessione al database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo("[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage());
    exit();
}

$nomeTabella = $_POST['nomeTabella'];
$_SESSION['nomeTabella'] = $nomeTabella;


// Recupera gli attributi della tabella selezionata
$stmt = $pdo->prepare("DESCRIBE $nomeTabella");
$stmt->execute();
$attributi = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserisci Attributi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h1>Inserisci Attributi da inserire in tabella</h1>
        <form action="submit-riga.php" method="post">
            <?php foreach ($attributi as $attributo): ?>
                <div class="form-group">
                    <label for="<?php echo $attributo; ?>"><?php echo $attributo; ?>:</label>
                    <input type="text" class="form-control" id="<?php echo $attributo; ?>" name="<?php echo $attributo; ?>" required>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Inserisci Riga</button>
        </form>
    </div>


    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>

</body>
</html>
