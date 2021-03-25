<?php

require "functions.php";

if (isset($_COOKIE[REMEMBER_ME])) {
    unRememberMe();
}
createLogoutLog($_SESSION['username']);
session_destroy();
redirect("../index.php");