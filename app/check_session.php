<?php

session_start();

$page = basename($_SERVER['PHP_SELF']);

if (isset($_SESSION["loggedin"]) && $page == "signin.php" || $page == "signup.php") {
    header("Location: index.php");
    exit;
} else if (!isset($_SESSION["loggedin"]) && $page != "signin.php" && $page != "signup.php") {
    header("Location: signin.php");
    exit;
}
