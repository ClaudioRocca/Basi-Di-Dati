<?php
// Avvia la sessione all'inizio dello script
session_start();

// Controlla se l'utente è già loggato, se sì, reindirizza alla pagina di benvenuto
if (isset($_SESSION['authorized']) && $_SESSION['authorized'] === 1) {
    header("Location: pagewelcome.php");
    exit();
}

// Includi il file di configurazione del database
require 'config.php';

// Messaggio di errore per visualizzare eventuali errori di login
$errore_login = '';

// Controlla se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"], $_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Tentativo di connessione al DB
    try {
        $sql = 'SELECT * FROM LOGIN WHERE USERNAME = :username AND PASSWORDD = :password';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Determina il tipo di utente basandosi sulla presenza di valori nei campi relativi
            if (!empty($row['DOCENTE_EMAIL'])) {
                $_SESSION['user_type'] = 'DOCENTE';
                $_SESSION['email'] = $row['DOCENTE_EMAIL'];
            } elseif (!empty($row['MAIL_STUDENTE'])) {
                $_SESSION['user_type'] = 'STUDENTE';
                $_SESSION['email'] = $row['MAIL_STUDENTE'];
            } else {
                // Gestire il caso in cui non si riconosce il tipo di utente
                $errore_login = 'Errore nel riconoscimento del tipo di utente.';
                // Qui potrebbe essere necessario un ulteriore handling o un messaggio di errore
            }

            if (!empty($_SESSION['user_type'])) {
                // Le credenziali sono corrette, imposta la sessione
                $_SESSION['authorized'] = 1;
                $_SESSION['username'] = $username;
                // Reindirizza alla pagina di benvenuto
                header("Location: pagewelcome.php");
                exit();
            }
        } else {
            $errore_login = 'Username o password non validi.';
        }

    } catch (PDOException $e) {
        die("Connessione al database fallita: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Login</title>
</head>
<body>
<?php if ($errore_login): ?>
<p><?php echo $errore_login; ?></p>
<?php endif; ?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div>LOGIN UTENTI</div>
    <table>
        <tr>
            <td>Username:</td>
            <td><input type='text' name="username" id="username" required></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type='password' name="password" id="password" required></td>
        </tr>
    </table>
    <div><input type='submit' value='Login'></div>
</form>
</body>
</html>
