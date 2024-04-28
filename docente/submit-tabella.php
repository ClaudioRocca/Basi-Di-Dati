<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")) {
    header('Location: ../registrazione/login.php');
    exit();
}

$nomeTabella=$_POST["nomeTabella"];
$attributi=$_POST["attributi"];
$vincoli=$_POST["vincoli"];
$username = $_SESSION["username"];


try {
    $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
    exit();
}

try {
    $data = date('Y/m/d', time());
    $attributi_splittati = explode(', ', $attributi);

    if($vincoli == null || empty($vincoli)){
        $sqlCreateTable = "CREATE TABLE $nomeTabella ($attributi)";
    } else {
        $sqlCreateTable = "CREATE TABLE $nomeTabella ($attributi, $vincoli)";
    }

    $stmt = $pdo->prepare($sqlCreateTable);
    $stmt->execute();

    $sql = "INSERT INTO TABELLA(NOME, DATA_CREAZIONE, NUMRIGHE, MAIL_DOCENTE) VALUES (?,?,0,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $nomeTabella, PDO::PARAM_STR);
    $stmt->bindParam(2, $data, PDO::PARAM_STR);
    $stmt->bindParam(3, $username, PDO::PARAM_STR);
    $stmt->execute();

    $sqlTrigger = "CREATE TRIGGER AGGIORNA_NUMRIGHE_" .$nomeTabella . " AFTER INSERT ON " . $nomeTabella . " FOR EACH ROW BEGIN UPDATE TABELLA SET NUMRIGHE = NUMRIGHE + 1 WHERE NOME = ?; END";
    $stmtTrigger = $pdo->prepare($sqlTrigger);
    $stmtTrigger->bindParam(1, $nomeTabella, PDO::PARAM_STR);
    $stmtTrigger->execute();

    $sqlInsertAttributi = 'INSERT INTO ATTRIBUTO(NOME, TIPO, NOME_TABELLA) VALUES (?, ?, ?)';

    foreach ($attributi_splittati as $attributo) {
        $nome_tipo = explode(' ', $attributo);

        $stmt = $pdo->prepare($sqlInsertAttributi);
        $stmt->bindParam(1, $nome_tipo[0], PDO::PARAM_STR);
        $stmt->bindParam(2, $nome_tipo[1], PDO::PARAM_STR);
        $stmt->bindParam(3, $nomeTabella, PDO::PARAM_STR);
        $stmt->execute();
    }

    $messaggio = '<div class="alert alert-success" role="alert">Tabella creata con successo</div>';
} catch (PDOException $e) {
    $messaggio = '<div class="alert alert-danger" role="alert">Errore: ' . $e->getMessage() . '</div>';
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Creazione Tabella</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <?php include '../fragments/header.html'; ?>
    </header>
    <div class="container mt-5">
        <h1>Esito creazione della Tabella:</h1>
        <?php echo $messaggio; ?>
        <br>
        <a href="interfaccia-docente.php" class="btn btn-primary">Torna alla Dashboard</a>
    </div>
    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>
</body>
</html>