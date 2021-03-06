<?php
    require_once "functions.php";

    validateRegisterInputs();
    $username = sanitize($_POST['username']) ?? '';
    $password = password_hash($_POST['password'] . PASSWORD_PEPPER, PASSWORD_DEFAULT);
    $firstname = sanitize($_POST['firstname']) ?? '';
    $lastname = sanitize($_POST['lastname']) ?? '';
    $email = sanitize($_POST['email']) ?? '';
    $sin = sanitize($_POST['sinNumber'] ?? '');
    $gender = sanitize($_POST['gender'] ?? '');
    $db = buildDataBase();
    $db->query("INSERT INTO users (username, password, firstname, lastname, email, sin, gender, is_admin) VALUES ('$username', '$password', '$firstname', '$lastname', '$email', '$sin', '$gender', 0)");
    $db->close();
    createRegisterLog($username);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validation</title>
    <link rel="stylesheet" href="../stylesheets/style.css">
</head>
<body>

    <div class="container w-50 d-flex align-items-center min-vh-100">
        <div class="validation-box bg-light p-5 w-75 mx-auto">
            <h4 class="d-block text-lg-center">Bienvenue <?= $firstname . " " . $lastname?> !</h4>
            <div class="text-end pt-4">
                <button class="btn btn-secondary"><a class="link text-white" href="../index.php">Retour à l'authentification</a></button>
            </div>
        </div>
    </div>

</body>
</html>