<?php ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrazione</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <div class="header">
        <?php include '../fragments/header.html'; ?>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Registrazione Utenti</h5>
                        <form action='process-registration.php' method="post">

                            <div class="form-group text-center">
                                <label for="ruolo">Ruolo:</label><br>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="studente" name="ruolo" value="studente" class="form-check-input" required>
                                    <label for="studente" class="form-check-label">Studente</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="docente" name="ruolo" value="docente" class="form-check-input" required>
                                    <label for="docente" class="form-check-label">Docente</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username (mail):</label>
                                        <input type='text' name="username" id="username" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nome">Nome:</label>
                                        <input type="text" name="nome" id="nome" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cognome">Cognome:</label>
                                        <input type="text" name="cognome" id="cognome" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Conferma Password:</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="recapito">Recapito:</label>
                                        <input type="text" name="recapito" id="recapito" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Continua</button>
                        </form>
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