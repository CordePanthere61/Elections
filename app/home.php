<?php

require "functions.php";

if (!isset($_SESSION['is_logged'])) {
    $username = addslashes($_POST['username']) ?? '';
    $password = addslashes($_POST['password']) ?? '';

    $db = buildDataBase();

    $result = $db->query("SELECT id, username, password, firstname, lastname, email FROM users WHERE username = '$username'");
    $rows = $db->fetch($result);
    $db->close();
    if (is_null($rows)) {
        $_SESSION['error'] = 'Mauvais identifiants (username invalid)';
        sleep(2);
        redirect("../index.php");
    }

    $hashPassword = $rows['password'];
    if (!password_verify($password . PASSWORD_PEPPER, $hashPassword)) {
        $_SESSION['error'] = 'Mauvais identifiants (password invalid)';
        sleep(2);
        redirect("../index.php");
    } else {
        $_SESSION['is_logged'] = true;
        $_SESSION['user_id'] = $rows['id'];
        $_SESSION['username'] = $rows['username'];
        $_SESSION['firstname'] = $rows['firstname'];
        $_SESSION['lastname'] = $rows['lastname'];
        $_SESSION['email'] = $rows['email'];
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
    <link rel="stylesheet" href="../stylesheets/style.css">
</head>
<body>

    <div class="container">
        <br>
        <h1>Secure zone</h1>
        <p>Welcome <?= $_SESSION['firstname']?></p>
        <a class="btn btn-sm btn-primary" href="logout.php">Déconnection</a>
    </div>

</body>
</html>

