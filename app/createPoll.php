<?php
require "functions.php";
if (!$_SESSION['is_admin']) {
    redirect("home.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (arePollInputsFilled()) {
        validateAndInsertPoll();
        validateAndInsertPollChoices();
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
    <title>Créer un sondage</title>
    <link rel="stylesheet" href="../stylesheets/style.css">
</head>
<body>

    <?php require_once "shared/navbar.php"?>

    <div class="container w-50 mt-5 py-5">
        <?php
        if (isset($_SESSION['pollSuccess'])) {
            ?>
            <div class="alert alert-success p-4 text-sm-start d-inline-block"><?= $_SESSION['pollSuccess']?></div>
            <?php
            unset($_SESSION['pollSuccess']);
        }
        ?>
        <form class="bg-light p-5 mx-auto rounded-3" action="createPoll.php" method="post">
            <h2 class="border-bottom border-dark">Créer un sondage</h2>
            <?php
            if (isset($_SESSION['pollError'])) {
                ?>
                <div class="alert alert-danger p-1 text-sm-start d-inline-block"><?= $_SESSION['pollError']?></div>
                <?php
                unset($_SESSION['pollError']);
            }
            ?>
            <div class="my-3">
                <label for="pollName">Nom :</label>
                <input name="pollName" class="form-control" type="text">
            </div>
            <div class="my-3">
                <label for="pollDescription">Description :</label>
                <textarea class="form-control" name="pollDescription" cols="30" rows="3"></textarea>
            </div>

            <div class="my-3">
                <?php
                if (isset($_SESSION['choicesError'])) {
                    ?>
                    <div class="alert alert-danger p-1 text-sm-start d-block"><?= $_SESSION['choicesError']?></div>
                    <?php
                    unset($_SESSION['choicesError']);
                }
                ?>
                <label for="pollChoices">Choix de réponses (2 minimum) : </label>
                <div class="options-container"><div class="row row-option py-3">
                        <div class="col-11 input-container">
                            <input class="form-control poll-input" type="text" name="pollChoices[]">
                        </div>
                    </div><div class="row row-option py-3">
                        <div class="col-11 input-container">
                            <input class="form-control poll-input" type="text" name="pollChoices[]">
                        </div>
                        <div class="col-1 add-button-container"><button type="button" class="btn btn-secondary rounded-circle add-choice"><i class="fa fa-plus"></i></button></div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-secondary">Créer un sondage</button>
            </div>

        </form>
    </div>
    <script src="../javascripts/vendor/bootstrap.min.js"></script>
    <script src="../javascripts/app/createPoll.js"></script>
</body>
</html>
