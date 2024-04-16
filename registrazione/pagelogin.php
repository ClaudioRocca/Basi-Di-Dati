<?php ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <div class="header">
        <?php include '../fragments/header.html'; ?>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">LOGIN UTENTI</h5>
                        <form action="login.php" method="post">
                            <div class="form-group">
                                <label for="username">Username (mail):</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <p class="mt-3 mb-0 text-center">
                            Non hai un profilo? <a href="registrazione.php" class="register-link">Registrati</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php include '../fragments/footer.html'; ?>
    </footer>

</body>
</html>