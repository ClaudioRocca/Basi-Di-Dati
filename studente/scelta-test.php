<?php
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "studente")){

    header('Location: ../registrazione/login.php');
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <Title>Scelta test</Title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    /* Stile per allineare verticalmente le scelte dei radio button */
    input[type="radio"] {
        display: block;
    }
</style>
    <div class="container mt-5">
        <h2>Scegli un test da svolgere</h2>
            <form action="svolgimento-test.php" method="get" class = "container mt-3">
                <div class="form-group">
                    <?php
                        try {
                            $pdo = new PDO('mysql:host=localhost;dbname=esqldb', 'root', 'ProgettiGiga');
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(PDOException $e) {
                            echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: ".$e->getMessage());
                            exit();
                        }

                        $sql = 'SELECT TITOLO FROM TEST';
                        $res = $pdo->prepare($sql);
                        $res->execute();
                        $result = $res->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($result) && count($result) > 0){
                            foreach($result as $row) {
                                echo '<label for="' . $row['TITOLO'] . '">' . $row['TITOLO'] . '</label>';
                                echo '<input type="radio" id="' . $row['TITOLO'] . '" name="Titolo" value="' . $row['TITOLO'] . '">';
                            }

                            echo '<button type="submit" class="btn btn-primary">Svolgi Test </button>';
                        }
                        else echo 'Nessun test presente';
                    ?>
                </div>
            </form>
        </div>
    </body>
</html>