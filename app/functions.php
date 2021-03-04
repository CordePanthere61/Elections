<?php

define('PASSWORD_PEPPER', 'yIwShRTKZ3Y5hrh5RNG/05XhrQwGDNd6djQBsqdSXt0=');

require_once "Database.php";
require_once "RegisterValidator.php";

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
    foreach ($_POST as $key => $value) {
        if ($value == "") {
            $_SESSION['missingInputs'] = "Tous les champs sont obligatoires";
            redirect("register.php");
        }
    }
    $validator = new RegisterValidator();
    if (!$validator->areFieldsValid()) {
        redirect("register.php");
    }
}
