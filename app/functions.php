<?php

define('PASSWORD_PEPPER', 'yIwShRTKZ3Y5hrh5RNG/05XhrQwGDNd6djQBsqdSXt0=');

require_once "Database.php";
require_once "RegisterValidator.php";


session_set_cookie_params(0, null, null, false, true);
session_start();

function buildDataBase(): Database
{
    $db = new Database();
    $db->connect('localhost', 'etudiant', 'Etudiant1', 'elections');
    return $db;
}

function redirect(string $file)
{
    http_response_code(302);
    header("Location: $file");
    exit;
}

function validateRegisterInputs()
{

    $validator = new RegisterValidator();
    if ($validator->areFieldsEmpty() || !$validator->areFieldsValid()) {
        redirect("register.php");
    }
}

function validateAndInsertPoll()
{
    $pollName = addslashes($_POST['pollName']);
    $pollDescription = addslashes($_POST['pollDescription']);
    $db = buildDataBase();
    $resultPoll = $db->query("SELECT * FROM polls WHERE name = '$pollName'");
    if ($db->contains($resultPoll)) {
        $_SESSION['pollError'] = "Le nom du sondage existe dèjà...";
        return;
    }
    $db->query("INSERT INTO polls (name, description) VALUES ('$pollName', '$pollDescription')");
    $_SESSION['pollSuccess'] = "Sondage créé avec succès !";
    $db->close();
}

function validateAndInsertPollChoices()
{
    $db = buildDataBase();
    $pollName = addslashes($_POST['pollName']);
    foreach ($_POST['pollChoices'] as $choice => $value) {
        $key = array_search($value, $_POST['pollChoices']);
        $db->query("INSERT INTO options (value, title, poll_id) VALUES('$key', '$value', (SELECT poll_id FROM polls WHERE name = '$pollName'))");
    }
}

function areInputsFilled() : bool
{
    foreach ($_POST['pollChoices'] as $choice => $value) {
        if ($value == "") {
            $_SESSION['pollError'] = "Tous les champs sont nécessaires...";
            return false;
        }
    }
    foreach ($_POST as $input => $value) {
        if ($value == "") {
            $_SESSION['pollError'] = "Tous les champs sont nécessaires...";
            return false;
        }
    }
    if (count($_POST['pollChoices']) < 2) {
        $_SESSION['choicesError'] = "Minimum 2 choix de réponses sont requis...";
        return false;
    }
    return true;
}
