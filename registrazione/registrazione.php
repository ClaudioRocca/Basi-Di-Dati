<?php ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrazione</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .form-container {
            text-align: center;
            margin-top: 20px;
        }

        .form-text {
            font-size: 24px;
            font-weight: bold;
        }

        .form-input {
            width: 300px;
            margin: 10px;
            padding: 5px;
            font-size: 16px;
        }

        .form-option {
            margin: 10px;
        }

        .form-option label {
            margin-right: 20px; /* Aggiungi spazio tra le etichette e i pulsanti di opzione */
        }

        .form-submit {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <form action='process-registration.php' method="post">
        <div class="form-text">Registrazione Utenti</div>
        <br>
        <div class="form-option">
            <input type="radio" id="studente" name="ruolo" value="studente" required=true>
            <label for="studente">Studente</label>
            <input type="radio" id="docente" name="ruolo" value="docente" required=true>
            <label for="docente">Docente</label>
        </div>
        <label for="mail"><b>Username (mail):</b></label><br>
        <input type='text' name="mail" id="mail" class="form-input" required=true><br>
        <label for="nome"><b>Nome:</b></label><br>
        <input type="text" name="nome" id="nome" class="form-input" required=true><br>
        <label for="cognome"><b>Cognome:</b></label><br>
        <input type="text" name="cognome" id="cognome" class="form-input" required=true><br>
        <label for="pazzword"><b>Password:</b></label><br>
        <input type="password" name="pazzword" id="pazzword" class="form-input" required=true><br>
        <label for="confirm_pazzword"><b>Conferma Password:</b></label><br>
        <input type="password" name="confirm_pazzword" id="confirm_pazzword" class="form-input" required=true><br>
        <label for="recapito"><b>Recapito:</b></label><br>
        <input type="text" name="recapito" id="recapito" class="form-input"><br>
        <div class="form-submit"><input type='submit' value='Continua' class="btn btn-primary"></div>
    </form>
</div>
</body>
</html>