<?php

define('PASSWORD_PEPPER', getenv('PASSWORD_PEPPER'));
define('REMEMBER_ME', 'REMEMBER_ME');


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
    $pollName = sanitize($_POST['pollName']);
    $pollDescription = sanitize($_POST['pollDescription']);
    $db = buildDataBase();
    $resultPoll = $db->query("SELECT * FROM polls WHERE name = '$pollName'");
    if ($db->contains($resultPoll)) {
        $_SESSION['pollError'] = "Le nom du sondage existe dèjà...";
        return;
    }
    $db->query("INSERT INTO polls (name, description) VALUES ('$pollName', '$pollDescription')");
    $_SESSION['pollSuccess'] = "Sondage créé avec succès !";
    $db->close();
    createNewPollLog($pollName);
}

function validateAndInsertPollChoices()
{
    $db = buildDataBase();
    $pollName = sanitize($_POST['pollName']);
    foreach ($_POST['pollChoices'] as $choice => $value) {
        $key = array_search($value, $_POST['pollChoices']);
        $db->query("INSERT INTO options (value, title, poll_id) VALUES('$key', '$value', (SELECT poll_id FROM polls WHERE name = '$pollName'))");
    }
}

function arePollInputsFilled() : bool
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

function userHasVoted(int $userId, string $pollId): bool
{
    $db = buildDatabase();
    $rows = $db->fetch($db->query("SELECT vote_id FROM votes WHERE poll_id = '$pollId' AND user_id = '$userId'"));
    return !empty($rows);
}

function sanitize(string $userInput)
{
    return addslashes(strip_tags($userInput));
}

function getPollOptions($db, $pollId)
{
    $result = $db->query("SELECT option_id, value, title, poll_id, nb_votes FROM options WHERE poll_id = '$pollId'");
    $rows = array();
    while ($row = $db->fetch($result)) {
        $rows[] = $row;
    }
    if (is_null($rows)) {
        return [];
    }
    return $rows;
}

function getPollName($db, $pollId) {
    $result = $db->query("SELECT name FROM polls WHERE poll_id = '$pollId'");
    $rows = $db->fetch($result);
    if (is_null($rows)) {
        return 0;
    }
    return $rows['name'];
}


function getPollsIds(): array
{
    $db = buildDatabase();
    $result = $db->query("SELECT poll_id FROM polls");
    $rows = array();
    while ($row = $db->fetch($result)) {
        $rows[] = $row['poll_id'][0];
    }
    $db->close();
    if (is_null($rows)) {
        return [];
    }
    return $rows;
}

function updateNbVotesForOptions() {
    $db = buildDataBase();
    $db->query("UPDATE options as O SET nb_votes = (SELECT count(vote_id) from votes WHERE poll_id = O.poll_id AND value = O.value)");
}

function rememberMe() {
    if (isset($_COOKIE[REMEMBER_ME])) {
        return;
    }
    $token = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(64/strlen($x)) )), 1, 64);
    setcookie(REMEMBER_ME, $token, time() + (86400 * 30), '/');
    $userId = $_SESSION['user_id'];
    $db = buildDataBase();
    $db->query("INSERT INTO tokens (user_id, cookie_token) VALUES ('$userId', '$token')");
    $db->close();
}

function unRememberMe() {
    $cookieValue = $_COOKIE[REMEMBER_ME];
    setcookie(REMEMBER_ME, '', 1, '/');
    unset($_COOKIE[REMEMBER_ME]);
    $db = buildDataBase();
    $db->query("DELETE FROM tokens WHERE cookie_token = '$cookieValue'");
    $db->close();
}

function automaticLogin() {
    $cookieValue = $_COOKIE[REMEMBER_ME];
    $db = buildDataBase();
    $row = $db->fetch($db->query("SELECT * FROM tokens WHERE cookie_token = '$cookieValue'"));
    $userId = $row['user_id'];
    $user = $db->fetch($db->query("SELECT user_id, is_admin, username FROM users where user_id = '$userId'"));
    $_SESSION['is_logged'] = true;
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['is_admin'] = $user['is_admin'];
    createLoginLog($user['username']);
    if ($_SESSION['is_admin']) {
        redirect("results.php");
    } else {
        redirect("home.php");
    }
}

function createLoginLog($username) {
    $description = "User logged in : " . $username;
    createLog($description);
}

function createLogoutLog($username) {
    $description = "User logged out : " . $username;
    createLog($description);
}

function createNewPollLog($pollName) {
    $description = "New poll created : " . $pollName;
    createLog($description);
}

function createRegisterLog($username) {
    $description = "New user registered : " . $username;
    createLog($description);
}

function createSubmitVoteLog($voteTitle, $pollName) {
    $username = $_SESSION['username'];
    $description = $username . " voted : " . $voteTitle . " for poll : " .  $pollName;
    createLog($description);
}

function createLog($description) {
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $db = buildDataBase();
    $db->query("INSERT INTO logs (time_stamp, description, ip_address) VALUES (CURRENT_TIME(), '$description', '$ipAddress')");
    $db->close();
}
