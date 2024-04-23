<?php
    session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")){

        header('Location: ../registrazione/login.php');
    }

?>

<?php
//TODO togliere roba di gpt
ini_set('display_errors', 1);
error_reporting(E_ALL);

    $nomeTest=$_POST["nomeTest"];
    $risposteVisualizzabili=$_POST["risposteVisualizzabili"];


    try {
       $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
       echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
       exit();
    }

    //cambio il valore "on" che restituisce la checkbox in "1", per poterlo inserire in mysql
    if($risposteVisualizzabili == "on"){
        $risposteVisualizzabili = 1;
    }
    else
        $risposteVisualizzabili = 0;

    $sql = 'CALL INSERIMENTO_NUOVO_TEST(?, ?, ?, ?, ?)';

    $date = date('Y/m/d', time());
    $foto = "Foto di prova";

    $stmt = $pdo->prepare($sql);


    $stmt->bindParam(1, $nomeTest, PDO::PARAM_STR);
    $stmt->bindParam(2, $date, PDO::PARAM_STR);
    $stmt->bindParam(3, $foto, PDO::PARAM_STR);
    $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
    $stmt->bindParam(5, $risposteVisualizzabili, PDO::PARAM_BOOL);

    $stmt->execute();

    echo 'Test creato con successo';
    echo '<a href = "creazione-quesito.php" class="btn btn-primary"> Crea quesiti relativi a questo test</a>'

?>