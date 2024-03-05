<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

        header('Location: login.php');
    }

?>

<?php


// Creazione della connessione
try {
    $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Esecuzione della procedura MySQL
    $sql = "CALL VISUALIZZAZIONE_TEST_DISPONIBILI()";


    $res=$pdo->prepare($sql);
    $res->execute();
    $result = $res->fetch(PDO::FETCH_ASSOC);
    
    print_r($result);
    
 }
 catch(PDOException $e) {
    echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
    exit();
 }
?>
