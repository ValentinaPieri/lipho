<?php

session_start();

$page = basename($_SERVER['PHP_SELF']);

if (isset($_SESSION["loggedin"]) && ($page == "login.php" || $page == "sign_up.php")) {
    header("Location: index.php");
    exit;
} else if (!isset($_SESSION["loggedin"]) && $page != "login.php" && $page != "sign_up.php") {
    header("Location: login.php");
    exit;
}
