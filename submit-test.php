<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

        header('Location: login.php');
    }

?>

<?php
    $nomeTest=$_POST["nomeTest"];
    $risposteVisualizzabili=$_POST["risposteVisualizzabili"];

    
 
    // Connessione al DB
    try {
       $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
       echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
       exit();
    }

    $sql = 'INSERT INTO TEST(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE)
            VALUES(?,?,?,?,?)';

    $date = date('Y/m/d', time());
    $foto = "Foto di prova";

    $stmt = $pdo->prepare($sql);


    if($risposteVisualizzabili == "on"){
        $risposteVisualizzabili = 1;
    }
    else
        $risposteVisualizzabili = 0;

    $stmt->bindParam(1, $nomeTest, PDO::PARAM_STR);
    $stmt->bindParam(2, $date, PDO::PARAM_STR);
    $stmt->bindParam(3, $foto, PDO::PARAM_STR);
    $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
    $stmt->bindParam(5, $risposteVisualizzabili, PDO::PARAM_STR);

    $stmt->execute();

    echo 'Test creato con successo';
    echo '<a href = "creazione-quesito.php" class="btn btn-primary"> Crea quesiti relativi a questo test</a>'



            


?>

