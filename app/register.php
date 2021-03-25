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

    <form class="bg-light p-5 mx-auto rounded-3" action="registerValidation.php" method="post">
        <h1 class="mb-3">Créer un compte</h1>
        <?php
        if (isset($_SESSION['registerError'])) {
            ?>
            <div class="alert alert-danger p-1 text-sm-start d-inline-block"><?= $_SESSION['registerError']?></div>
            <?php
            unset($_SESSION['registerError']);
        }
        ?>

        <div class="form-row row mb-4">
            <div class="form-group col-md">
                <label for="firstname"><i class="fa fa-font"></i> Prénom</label>
                <input name="firstname" type="text" class="form-control" placeholder="E.g. : Bruce">
                <?php
                if (isset($_SESSION['invalidFirstName'])) {
                    ?>
                    <div class="alert alert-danger p-1 text-sm-start d-block"><?= $_SESSION['invalidFirstName']?></div>
                    <?php
                    unset($_SESSION['invalidFirstName']);
                }
                ?>
            </div>

            <div class="form-group col-md">
                <label for="lastname"><i class="fa fa-font"></i> Nom</label>
                <input name="lastname" type="text" class="form-control" placeholder="E.g. : Wayne">
                <?php
                if (isset($_SESSION['invalidLastName'])) {
                    ?>
                    <div class="alert alert-danger p-1 text-sm-start d-block"><?= $_SESSION['invalidLastName']?></div>
                    <?php
                    unset($_SESSION['invalidLastName']);
                }
                ?>
            </div>
        </div>

        <div class="form-row row mb-4">
            <div class="form-group col-md">
                <label for="username"><i class="fa fa-user-circle"></i> Nom d'Utilisateur</label>
                <input name="username" type="text" class="form-control" placeholder="E.g. : CordePanthere61">
            </div>

            <div class="form-group col-md">
                <label for="email"><i class="fa fa-at"></i> Adresse Courriel</label>
                <input name="email" type="email" class="form-control" placeholder="E.g. : xyz@example.com">
            </div>
        </div>

        <div class="form-row row mb-4">
            <div class="form-group col-md">
                <label for="phoneNumber"><i class="fa fa-phone"></i> Numéro de Téléphone</label>
                <input name="phoneNumber" type="tel" class="form-control" placeholder="E.g. : (XXX) XXX-XXXX">
                <?php
                if (isset($_SESSION['invalidPhoneNumber'])) {
                    ?>
                    <div class="alert alert-danger p-1 text-sm-start d-block"><?= $_SESSION['invalidPhoneNumber']?></div>
                    <?php
                    unset($_SESSION['invalidPhoneNumber']);
                }
                ?>
            </div>

            <div class="form-group col-md">
                <label for="sinNumber"><i class="fa fa-info-circle"></i> Numéro d'assurance sociale</label>
                <input name="sinNumber" type="password" class="form-control" placeholder="E.g. : 123456789">
                <?php
                if (isset($_SESSION['invalidSinNumber'])) {
                    ?>
                    <div class="alert alert-danger p-1 text-sm-start d-block"><?= $_SESSION['invalidSinNumber']?></div>
                    <?php
                    unset($_SESSION['invalidSinNumber']);
                }
                ?>
            </div>
        </div>

        <div class="form-group">
            <label for="password"><i class="fa fa-lock"></i> Mot de Passe</label>
            <input name="password" type="password" class="form-control">
            <br>
        </div>
        <?php
        if (isset($_SESSION['invalidPassword'])) {
            ?>
            <div class="alert alert-danger p-1 text-sm-start d-block"><?= $_SESSION['invalidPassword']?></div>
            <?php
            unset($_SESSION['invalidPassword']);
        }
        ?>
        <div class="form-group">
            <label for="confirmPassword"><i class="fa fa-lock"></i> Confirmer le mot de passe</label>
            <input name="confirmPassword" type="password" class="form-control">
        </div>

        <div class="form-group py-3 d-flex justify-content-around">
            <label for="gender"><i class="fa fa-transgender-alt"></i> Je suis...</label>
            <div class="radio-group">
                <input type="radio" name="gender" value="male">
                <label for="male">un Homme</label>
            </div>
            <div class="radio-group">
                <input type="radio" name="gender" value="female">
                <label for="female">une Femme</label>
            </div>
            <div class="form-group">
                <input type="radio" name="gender" value="other">
                <label for="other">Non-Binaire</label><br>
            </div>
        </div>
        
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary"><a class="link text-white" href="../index.php"><i class="fa fa-arrow-left"></i> Annuler</a></button>
            <button type="submit" class="btn btn-secondary">Créer un compte</button>
        </div>
    </form>
</div>
</body>
</html>