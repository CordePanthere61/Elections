<?php
    require_once "app/functions.php";

    if (isset($_SESSION['is_logged']) || isset($_COOKIE[REMEMBER_ME])) {
        redirect("app/login.php");
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Élections</title>
    <link rel="stylesheet" href="stylesheets/style.css">
</head>
<body>
    <div class="container w-50 mt-5 pt-5">
        <h1 class="w-75 mx-auto border-bottom border-dark mt-5 mb-3">Sondages BS</h1>
        <form class="bg-light p-5 mx-auto rounded-3 border-white w-75" action="app/login.php" method="post">

            <?php
            if (isset($_SESSION['error'])) {
                ?>
                <div class="alert alert-danger"><?= $_SESSION['error']?></div>
                <?php unset($_SESSION['error']);
            }
            ?>
            <div class="form-group">
                <label for="username"><i class="fa fa-user-circle"></i> Nom d'Utilisateur</label>
                <input name="username" type="text" class="form-control">
                <br>
            </div>

            <div class="form-group">
                <label for="password"><i class="fa fa-lock"></i> Mot de Passe</label>
                <input name="password" type="password" class="form-control">
                <br>
            </div>

            <div class="form-group mb-2 d-flex align-items-center">
                <input name="rememberMe" type="radio" class="form-check d-inline-block">
                <label class="mx-3" for="rememberMe">Se souvenir de moi</label>
            </div>

            <div class="d-flex justify-content-between">
                <span class="text-sm-start">Pas encore de compte ?<br><a class="link" href="app/register.php">S'enregistrer</a></span>
                <button type="submit" class="btn btn-secondary">Connection</button>
            </div>
        </form>
    </div>
</body>
</html>
</html>