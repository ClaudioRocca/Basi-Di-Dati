<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {

        header('Location: login.php');
    }

?>

<?php

    echo 'STATISTICHE <br>';

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
       $sql='SELECT * FROM CLASSIFICA_STUDENTI_TEST_COMPLETATI';
       
        $res=$pdo->prepare($sql);
        $res->execute();
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        echo "CLASSIFICA STUDENTI PER TEST COMPLETATI <br>";
        echo "<br>";
        
        foreach ($result as $row) {
            echo "<tr>
                    <td>{$row['CODICE']}</td>
                    <td>{$row['NUMERO_TEST_COMPLETATI']}</td>
                  </tr>";
            echo "<br>";
        }


        $sql ='SELECT * FROM CLASSIFICA_STUDENTI_QUESITI_CORRETTI';
        

        $res=$pdo->prepare($sql);
        $res->execute();
        $result = $res->fetchAll(PDO::FETCH_ASSOC);


        echo "<br>";
        echo "CLASSIFICA STUDENTI PER QUESITI CORRETTI";
        echo "<br>";
        foreach ($result as $row) {
            echo "<tr>
                    <td>{$row['CODICE']}</td>
                    <td>{$row['NUMERO_QUESITI_CORRETTI']}</td>
                  </tr>";
            echo "<br>";
        }

        
        $sql ='SELECT * FROM QUESITI_COMPLETATI_MAGGIORMENTE';
        

        $res=$pdo->prepare($sql);
        $res->execute();
        $result = $res->fetchAll(PDO::FETCH_ASSOC);


        echo "<br>";
        echo "CLASSIFICA QUESITI CON PIU' RISPOSTE";
        echo "<br>";
        foreach ($result as $row) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['NUMERO_RISPOSTE']}</td>
                  </tr>";
            echo "<br>";
        }

      }
     catch(PDOException $e) {
       echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: ".$e->getMessage());
       exit();
     }

     $row=$res->fetch();


?>