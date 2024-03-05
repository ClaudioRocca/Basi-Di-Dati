<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header('Location: login.php');
    }

?>

<?php
    try {
        $pdo=new PDO('mysql:host=localhost;dbname=esqldb','root', 'ProgettiGiga');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
        exit();
    }

    try {
        // Query SQL per l'inserimento dati
       $sql='SELECT TITOLO, DATA_CREAZIONE, VISUALIZZA_RISPOSTE FROM TEST';
       
        $res=$pdo->prepare($sql);
        $res->execute();
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        echo "TEST DISPONIBILI <br>";
        echo "<br>";

        echo "TITOLO    DATA_CREAZIONE    VISUALIZZA_RISPOSTE <br>";
        echo "<br>";

        
        foreach ($result as $row) {
            echo "<tr>
                    <td>{$row['TITOLO']}</td>
                    <td>{$row['DATA_CREAZIONE']}</td>
                    <td>{$row['VISUALIZZA_RISPOSTE']}</td>
                  </tr>";
            echo "<br>";
        }

    } catch (PDOException $e) {
        echo "[ERRORE] Query SQL (Insert) non riuscita. Errore: " . $e->getMessage();
        exit();
    }



?>