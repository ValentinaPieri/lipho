<?php

require_once 'app/DBConnection.php';

use app\DBConnection;
use app\models\Post;

if (isset($_POST['notificationId'])) {
    $index = intval($_POST['notificationId']);
    $dbconnection = new DBConnection();
    $dbconnection->deleteNotification($index);
}

if (isset($_POST['deleteAllNotifications'])) {
    $dbconnection = new DBConnection();
    $dbconnection->deleteAllNotifications();
}

if (isset($_POST["post-button"])) {
    $dbconnection = new DBConnection();
    $conn = $dbconnection->getConnection();
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
    $post = new Post(/*$_SESSION["username"]*/$username, $_POST["caption"], $conn, $images);
    header("Location: create_post.php");
}
