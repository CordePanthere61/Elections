<?php

require "functions.php";
if ($_SESSION['is_admin']) {
    redirect("results.php");
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
        <h2 class="mb-4 border-bottom border-dark">Sondages disponibles</h2>
        <?php
        if (isset($_SESSION['invalidVote'])) {
            ?>
            <div class="alert alert-success p-4 text-sm-start d-inline-block"><?= $_SESSION['invalidVote']?></div>
            <?php
            unset($_SESSION['invalidVote']);
        }
        $db = buildDataBase();
        $result_poll = $db->query("SELECT * FROM polls");
        $result_options = $db->query("SELECT * FROM options");
        $result_votes = $db->query("SELECT * FROM votes");

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
                if (!userHasVoted($_SESSION['user_id'], $poll['poll_id'])) {
                    displayPoll($poll, $data_options);
                }
            }
            ?>
            </div>
        <?php
        }
        $db->close();
        ?>
        </form>
    </div>

</body>
</html>

<?php
function displayPoll($poll, $data_options) {
    ?>
    <form id="<?= $poll['name']?>"  action="voteValidation.php" method="post">
        <div class="card my-4 p-3  border-0 bg-secondary" style="width: 25rem">
            <div class="card-header  bg-light pt-3">
                <h4 class="fw-bold"><?= $poll['name']?></h4>
            </div>
            <div class="card-body rounded-bottom bg-light">
                <p class="card-text mt-2"><?= $poll['description']?></p>
            </div>
            <ul class="list-group list-group-flush d-flex justify-content-evenly h-100 my-3">
                <?php
                foreach ($data_options as $option) {
                    if ($option['poll_id'] == $poll['poll_id']) {
                        ?>
                        <li class="list-group-item bg-light my-1 mx-2 rounded-pill"><input class="form-check-inline" value="<?= $option['value']?>" name="<?= $poll['name'] ?>" type="radio"><label for="<?= $poll['name'] ?>"><?= $option['title'] ?></label></li>
                        <?php
                    }
                }
                ?>
            </ul>
            <div class="card-footer bg-transparent d-flex justify-content-end">
                <input class="btn btn-outline-light" type="submit" value="Soumettre">
            </div>
        </div>
    </form>
    <?php
}