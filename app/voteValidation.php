<?php

include "functions.php";

if (empty($_POST)) {
    redirect("home.php");
}
foreach ($_POST as $name => $val)
{
    $pollName = $name;
    $value = sanitize($val);
}
$userId = $_SESSION['user_id'];
$db = buildDataBase();
$pollResult = $db->query("SELECT * FROM polls WHERE name = '$pollName'");
$poll = $db->fetch($pollResult);
$pollId = $poll['poll_id'];
$db->query("INSERT INTO votes (user_id, poll_id, value) VALUES ('$userId', '$pollId', '$value')");
$option = $db->fetch($db->query("SELECT * FROM options WHERE value = '$value'"));
$db->close();
createSubmitVoteLog($option['title'], $pollName);
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
<body style="overflow: hidden">

    <?php require_once "shared/navbar.php"?>
    <div class="container w-50 d-flex align-items-center min-vh-100">
        <div class="validation-box bg-light p-5 w-75 mx-auto">
            <h4 class="d-block text-lg-center">Votre vote pour "<?= $poll['name'] ?>" confirmé !</h4>
            <div class="text-end pt-4">
                <button class="btn btn-secondary"><a class="link text-white" href="home.php">Retour aux sondages</a></button>
            </div>
        </div>
    </div>

</body>
</html>
