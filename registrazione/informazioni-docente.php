<?php
session_start();


?>

<!--<!DOCTYPE html>
<html>
<head>
    <title>Informazioni Docente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Informazioni Aggiuntive Docente</h2>
    <form action="submit-registrazione.php" method="post">
         Campi per le informazioni aggiuntive del docente
     <div class="form-group">
     <label for="dipartimento">Dipartimento:</label>
     <input type="text" class="form-control" id="dipartimento" name="dipartimento" required>
 </div>
 <div class="form-group">
     <label for="corso">Corso:</label>
     <input type="text" class="form-control" id="corso" name="corso" required>
 </div>
 <button type="submit" class="btn btn-primary">Registrati</button>
</form>
</div>
</body>
</html>-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informazioni Docente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

<header>
    <?php include '../fragments/header.html'; ?>
</header>

<div class="container mt-5">
    <h2 class="text-center">Informazioni Aggiuntive Docente</h2>
    <form action="submit-registrazione.php" method="post">
        <!-- Campi per le informazioni aggiuntive del docente -->
        <div class="form-group">
            <label for="dipartimento">Dipartimento:</label>
            <input type="text" class="form-control" id="dipartimento" name="dipartimento" required>
        </div>
        <div class="form-group">
            <label for="corso">Corso:</label>
            <input type="text" class="form-control" id="corso" name="corso" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Registrati</button>
    </form>
</div>

<footer>
    <?php include '../fragments/footer.html'; ?>
</footer>

</body>
</html>