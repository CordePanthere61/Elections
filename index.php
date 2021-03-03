<?php
    require_once "app/functions.php";

    if (isset($_SESSION['is_logged'])) {
        redirect("app/home.php");
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
        <h1>Texte à venir</h1>
        <form class="bg-light p-5 mx-auto border-white w-50" action="app/home.php" method="post">

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

            <div class="d-flex justify-content-between">
                <span class="text-sm-start">Pas encore de compte ?<br><a class="link" href="app/register.php">S'enregistrer</a></span>
                <button type="submit" class="btn btn-secondary">Connection</button>
            </div>
        </form>
    </div>
</body>
</html>
</html>