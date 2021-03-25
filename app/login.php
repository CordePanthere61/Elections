<?php
require "functions.php";

if (!isset($_COOKIE[REMEMBER_ME])) {
    if (!isset($_SESSION['is_logged'])) {
        $username = sanitize($_POST['username']) ?? '';
        $password = sanitize($_POST['password']) ?? '';

        $db = buildDataBase();

        $result = $db->query("SELECT user_id, username, password, firstname, lastname, email, is_admin FROM users WHERE username = '$username'");
        $rows = $db->fetch($result);
        $db->close();
        if (is_null($rows)) {
            $_SESSION['error'] = 'Mauvais identifiants';
            sleep(2);
            redirect("../index.php");
        }

        $hashPassword = $rows['password'];
        if (!password_verify($password . PASSWORD_PEPPER, $hashPassword)) {
            $_SESSION['error'] = 'Mauvais identifiants';
            sleep(2);
            redirect("../index.php");
        } else {
            $_SESSION['is_logged'] = true;
            $_SESSION['user_id'] = $rows['user_id'];
            $_SESSION['is_admin'] = $rows['is_admin'];
            $_SESSION['username'] = $rows['username'];

            if (isset($_POST['rememberMe'])) {
                rememberMe();
            }

            createLoginLog($rows['username']);

            if ($_SESSION['is_admin']) {
                redirect("results.php");
            } else {
                redirect("home.php");
            }
        }
    }
} else {
    automaticLogin();
}



