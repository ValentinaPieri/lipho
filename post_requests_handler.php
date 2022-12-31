<?php

require_once 'app/DBConnection.php';
require_once 'app/models/User.php';

use app\DBConnection;
use app\models\User;

if (isset($_POST['notificationId'])) {
    $index = intval($_POST['notificationId']);
    $dbconnection = new DBConnection();
    $dbconnection->deleteNotification($index);
}

if (isset($_POST['signup'])) {
    $dbconnection = new DBConnection();
    $result["usernameValid"] = $dbconnection->checkUsername($_POST['username']);
    $result["passwordsMatching"] = $_POST['password1'] == $_POST['password2'];
    //check if the password length is at least 8 characters long and if it contains at least one number and one symbol
    $result["passwordValid"] = preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $_POST['password1']) == 0;
    if ($result["usernameValid"] && $result["passwordsMatching"] && $result["passwordValid"]) {
        $user = new User($_POST['username'], $_POST['password2'], $_POST['name'], $_POST['surname'], $dbconnection->getConnection(), $_POST['email'], $_POST['phone'], $_POST['birthdate']);
    }
    echo json_encode($result);
}
