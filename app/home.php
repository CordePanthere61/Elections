<?php

require "functions.php";

if (!isset($_SESSION['is_logged'])) {
    $username = addslashes($_POST['username']) ?? '';
    $password = addslashes($_POST['password']) ?? '';

    $db = buildDataBase();

    $result = $db->query("SELECT user_id, username, password, firstname, lastname, email, is_admin FROM users WHERE username = '$username'");
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
        $_SESSION['user_id'] = $rows['user_id'];
        $_SESSION['username'] = $rows['username'];
        $_SESSION['firstname'] = $rows['firstname'];
        $_SESSION['lastname'] = $rows['lastname'];
        $_SESSION['email'] = $rows['email'];
        $_SESSION['is_admin'] = $rows['is_admin'];
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

    <?php require_once "shared/navbar.php"?>

    <div class="container">
        <br>
        <h1 class="mb-4 border-bottom border-dark">Sondages disponibles</h1>

        <?php
        $db = buildDataBase();
        $result_poll = $db->query("SELECT * FROM polls");
        $result_options = $db->query("SELECT * FROM options");
        $data_polls = array();
        while ($row = $db->fetch($result_poll)) {
            $data_polls[] = $row;
        }
        $data_options = array();
        while ($row = $db->fetch($result_options)) {
            $data_options[] = $row;
        }

        if (mysqli_num_rows($result_poll) < 1) {
            echo "<h3>Aucuns sondages disponibles...</h3>";
        } else {
            ?>
            <div class="d-flex card-container flex-wrap justify-content-around"> <?php
            foreach ($data_polls as $poll) {
                ?>
                <div class="card my-4 p-3  border-0 bg-secondary" style="width: 25rem">
                    <div class="card-header bg-light pt-3 rounded-1 mb-2">
                        <h4 class="fw-bold"><?= $poll['name']?></h4>
                        <p class="card-text mt-2"><?= $poll['description']?></p>
                    </div>
                    <ul class="list-group list-group-flush d-flex justify-content-evenly h-100">
                        <?php
                        foreach ($data_options as $option) {
                            if ($option['poll_id'] == $poll['poll_id']) {
                                ?>
                                <li class="list-group-item bg-light my-1 mx-2 rounded-1"><input class="form-check-inline" name="<?= $poll['name'] ?>" type="radio"><label for="<?= $poll['name'] ?>"><?= $option['title'] ?></label></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            <?php
            }
            ?>
            </div>
        <?php
        }
        $db->close();
        ?>
    </div>

</body>
</html>

