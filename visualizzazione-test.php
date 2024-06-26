<?php
    session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']))){
        header('Location: ../registrazione/login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizzazione Test</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <?php include 'fragments/header.html'; ?>
    </header>

    <div class="container mt-5">
        <h2>Test Disponibili</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Titolo</th>
                <th>Data Creazione</th>
                <th>Visualizza Risposte</th>
            </tr>
            </thead>
            <tbody>
            <?php
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = 'CALL VISUALIZZAZIONE_TEST_DISPONIBILI';
                $res = $pdo->prepare($sql);
                $res->execute();
                $result = $res->fetchAll(PDO::FETCH_ASSOC);


                foreach ($result as $row) {
                    $visualizzaRisposte = ($row['VISUALIZZA_RISPOSTE'] == 0) ? 'No' : 'Si';

                    $titolo = $row['TITOLO'];

                    echo "<tr>
                                    <td>$titolo</td>
                                    <td>{$row['DATA_CREAZIONE']}</td>
                                    <td>$visualizzaRisposte</td>
                                    <td><a href='visualizzazione-quesiti.php?titolo_test=$titolo' class='btn btn-primary'>Visualizza quesiti</a></td>
                                  </tr>";
                }

            } catch (PDOException $e) {
                echo "<tr><td colspan='3'>[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage() . "</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <footer>
        <?php include 'fragments/footer.html'; ?>
    </footer>

</body>
</html>