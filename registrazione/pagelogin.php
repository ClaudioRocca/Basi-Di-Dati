<?php ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px; /* Regola l'altezza a tuo piacimento */
        }

        .logo {
            font-size: 48px;
            font-weight: bold;
            color: #ffffff; /* Testo bianco */
            text-transform: uppercase;
            background-color: #0a0dbf; /* Blu chiaro */
            padding: 10px; /* Spazio intorno al testo */
            border-radius: 5px; /* Bordi arrotondati */
        }

        .logo span {
            color: #ffffff; /* Cambia il colore a tuo piacimento */
        }

        .form-container {
            text-align: center;
            margin-top: 20px;
        }

        .form-text {
            font-size: 18px;
        }

        .register-link {
            font-size: 16px;
            margin-top: 10px;
            color: #0a0dbf; /* Blu chiaro */
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="logo-container">
    <div class="logo">
        G<span>_</span>ESQL
    </div>
</div>

<div class="form-container">
    <form action='login.php' method="post">
        <hr>
        <div class="form-text">LOGIN UTENTI</div>
        <br>
        <table align="center">
            <tr>
                <td><b>Username (mail):</b></td>
                <td><input type='text' name="username" id="username" required=true></td>
            </tr>
            <tr>
                <td><b>Password:</b></td>
                <td><input type="password" name="password" id="password" required=true></td>
            </tr>
        </table>
        <br>
        <div><input type='submit' value='Login' class="btn btn-primary"></div>
    </form>

    <div class="register-text">Non hai un profilo? <a href="registrazione.php" class="register-link">Registrati</a></div>
</div>
</body>
</html>

