<?php
    session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION["ruolo"] === "docente")){

        header('Location: ../registrazione/login.php');
    }

    echo 'Quesito creato';

?>