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
    <h2>Elenco quesiti</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Livello difficoltà</th>
            <th>Descrizione</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (isset($_GET['titolo_test'])) {
                $titoloTest = $_GET['titolo_test'];

                $sql = 'CALL VISUALIZZAZIONE_QUESITI(?)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $titoloTest);

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {

                    echo "<tr>
                                    <td>{$row['ID']}</td>
                                    <td>{$row['LIVELLO']}</td>
                                    <td>{$row['DESCRIZ']}</td>
                                  </tr>";
                }

            }
            else
                echo "Titolo test non presente";

            if(($_SESSION['ruolo']) == "docente")
                echo "<a href = 'docente/interfaccia-docente.php' class ='btn btn-secondary'>Torna alla dashboard</a>";

            else
                echo "<a href = 'studente/interfaccia-studente.php' class ='btn btn-secondary'>Torna alla dashboard</a>";




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