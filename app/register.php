<?php
    require_once "functions.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>S'enregistrer</title>
    <link rel="stylesheet" href="../stylesheets/style.css">
</head>
<body>
<div class="container w-50 mt-5 pt-5">
    <h1>Créer un compte</h1>
    <form class="bg-light p-5 mx-auto border-white" action="registerValidation.php" method="post">

        <?php
        if (isset($_SESSION['missingInputs'])) {
            ?>
            <div class="alert alert-danger"><?= $_SESSION['missingInputs']?></div>
            <?php
            unset($_SESSION['missingInputs']);
        }
        ?>

        <div class="form-row row mb-4">
            <div class="form-group col-md">
                <label for="firstname"><i class=""></i> Prénom</label>
                <input name="firstname" type="text" class="form-control">
            </div>

            <div class="form-group col-md">
                <label for="lastname">Nom</label>
                <input name="lastname" type="text" class="form-control">
            </div>
        </div>

        <div class="form-row row mb-4">
            <div class="form-group col-md">
                <label for="username"><i class="fa fa-user-circle"></i> Nom d'Utilisateur</label>
                <input name="username" type="text" class="form-control">
            </div>

            <div class="form-group col-md">
                <label for="email"><i class="fa fa-at"></i> Adresse Courriel</label>
                <input name="email" type="email" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="password"><i class="fa fa-lock"></i> Mot de Passe</label>
            <input name="password" type="password" class="form-control">
            <br>
        </div>

        <div class="form-group">
            <label for="confirmPassword"><i class="fa fa-lock"></i> Confirmer le mot de passe</label>
            <input name="confirmPassword" type="password" class="form-control">
            <br>
        </div>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary"><a class="link text-white" href="../index.php"><i class="fa fa-arrow-left"></i> Annuler</a></button>
            <button type="submit" class="btn btn-secondary">Créer un compte</button>
        </div>
    </form>
</div>
</body>
</html>