<?php

require_once 'app/DBConnection.php';
require_once 'app/models/User.php';

use app\DBConnection;
use app\models\User;
use app\models\Post;

if (isset($_POST['notificationId'])) {
    $index = intval($_POST['notificationId']);
    $dbconnection = new DBConnection();
    $dbconnection->deleteNotification($index);
}

if (isset($_POST['signup'])) {
    $dbconnection = new DBConnection();
    $result["usernameValid"] = $_POST['username'] != "" && $dbconnection->checkUsername($_POST['username']);
    $result["passwordsMatching"] = $_POST['password1'] == $_POST['password2'];
    //check if the password length is at least 8 characters long and if it contains at least one number and one symbol
    $result["passwordValid"] = preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $_POST['password1']) == 1;
    //phone number validation
    $result["phoneValid"] = preg_match('/^[0-9]{10}$/', $_POST['phone']) == 0;
    //email validation
    $result["emailValid"] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if ($result["usernameValid"] && $result["passwordsMatching"] && $result["passwordValid"] && $result["phoneValid"] && $result["emailValid"]) {
        $user = new User($_POST['username'], $_POST['password2'], $_POST['name'], $_POST['surname'], $dbconnection->getConnection(), $_POST['email'], $_POST['phone'], $_POST['birthdate']);
    }
    echo json_encode($result);
}

if (isset($_POST['deleteAllNotifications'])) {
    $dbconnection = new DBConnection();
    $dbconnection->deleteAllNotifications();
}

if (isset($_POST["post-button"])) {
    $dbconnection = new DBConnection();
    $images = array();
    $username = "test"; //TODO: change this to the current user
    for ($i = 0; $i < 5; $i++) {
        if (isset($_FILES['image-input' . $i])) {
            $fileName = basename($_FILES['image-input' . $i]['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedTypes = array('jpg', 'png', 'jpeg');
            if (in_array($fileType, $allowedTypes)) {
                $image = $_FILES['image-input' . $i]['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));
                array_push($images, $imgContent);
            }
        }
    }
    $post = new Post($username, $_POST["caption"], $dbconnection->getConnection(), $images);
    header("Location: create_post.php");
}

if (isset($_POST['getMatchingUsers'])) {
    $dbconnection = new DBConnection();
    $users = $dbconnection->getMatchingUsers($_POST['username']);
    echo json_encode($users);
}
