<?php

require_once 'app/DBConnection.php';
require_once 'app/models/User.php';

use app\DBConnection;
use app\models\User;
use app\models\Post;

if (isset($_POST['deleteNotification'])) {
    $index = intval($_POST['notificationId']);
    $dbconnection = new DBConnection();
    $dbconnection->deleteNotification($index);
}

if (isset($_POST['signup'])) {
    $dbconnection = new DBConnection();
    $result["usernameValid"] = $_POST['username'] != "" && $dbconnection->checkUsername($_POST['username']);
    $result["passwordsMatching"] = $_POST['password1'] == $_POST['password2'];
    //check if the password length is at least 8 characters long and if it contains at least one number and one symbol
    $result["passwordValid"] = preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $_POST['password1']) == 1;
    $result["phoneValid"] = $_POST['phone'] == "" || preg_match("/(\+98|0|98|0098)?([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/", $_POST['phone']) == 1;
    $result["nameNotEmpty"] = $_POST['name'] != "";
    $result["surnameNotEmpty"] = $_POST['surname'] != "";
    $result["emailValid"] = $_POST['email'] == "" || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if ($result["usernameValid"] && $result["passwordsMatching"] && $result["passwordValid"] && $result["nameNotEmpty"] && $result["surnameNotEmpty"] && $result["phoneValid"] && $result["emailValid"]) {
        $options = [
            'cost' => 12,
        ];
        $hashed_password = password_hash($_POST['password2'], PASSWORD_BCRYPT, $options);
        $user = new User($_POST['username'], $hashed_password, $_POST['name'], $_POST['surname'], $dbconnection->getConnection(), $_POST['email'], $_POST['phone'], $_POST['birthdate'], true);
        $dbconnection->setUserLoggedIn($_POST['username']);
    }
    echo json_encode($result);
}

if (isset($_POST['deleteAllNotifications'])) {
    $dbconnection = new DBConnection();
    $dbconnection->deleteAllNotifications();
}

if (isset($_POST['getNotSeenNotificationsNumber'])) {
    $dbconnection = new DBConnection();
    echo $dbconnection->getNotSeenNotificationsNumber();
}

if (isset($_POST["post-button"])) {
    $dbconnection = new DBConnection();
    $images = array();
    for ($i = 0; $i < 5; $i++) {
        if (isset($_FILES['image-input' . $i])) {
            $fileName = basename($_FILES['image-input' . $i]['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedTypes = array('jpg', 'png', 'jpeg');
            if (in_array($fileType, $allowedTypes)) {
                $image = $_FILES['image-input' . $i]['tmp_name'];
                $imgContent = file_get_contents($image);
                array_push($images, $imgContent);
            }
        }
    }
    $post = new Post($_SESSION['username'], $_POST["caption"], $dbconnection->getConnection(), $images);
    header("Location: create_post.php");
}

if (isset($_POST['getMatchingUsers'])) {
    $dbconnection = new DBConnection();
    $users = $dbconnection->getMatchingUsers($_POST['username']);
    echo json_encode($users);
}

if (isset($_POST['likePost'])) {
    $dbconnection = new DBConnection();
    $dbconnection->likePost($_POST['postId'], $_POST['owner']);
}

if (isset($_POST['unlikePost'])) {
    $dbconnection = new DBConnection();
    $dbconnection->unlikePost($_POST['postId']);
}

if (isset($_POST['commentPost'])) {
    $dbconnection = new DBConnection();
    $dbconnection->commentPost($_POST['postId'], $_POST['owner'], $_POST['text']);
}

if (isset($_POST['uncommentPost'])) {
    $dbconnection = new DBConnection();
    $dbconnection->uncommentPost($_POST['commentId']);
}

if (isset($_POST['likeComment'])) {
    $dbconnection = new DBConnection();
    $dbconnection->likeComment($_POST['commentId'], $_POST['owner']);
}

if (isset($_POST['unlikeComment'])) {
    $dbconnection = new DBConnection();
    $dbconnection->unlikeComment($_POST['commentId'], $_POST['owner']);
}

if (isset($_POST['ratePost'])) {
    $dbconnection = new DBConnection();
    $dbconnection->ratePost($_POST['postId'], $_POST['owner'], $_POST['exposure'], $_POST['colors'], $_POST['composition']);
}

if (isset($_POST['getFeedPosts'])) {
    $dbconnection = new DBConnection();
    $posts = $dbconnection->getFeedPosts($_POST['offset'], $_POST['limit']);
    echo json_encode(array('posts' => $posts, 'currentUsername' => $_SESSION['username']));
}

if (isset($_POST['getPostLikesNumber'])) {
    $dbconnection = new DBConnection();
    $postLikesNumber = $dbconnection->getPostLikesNumber($_POST['post_id']);
    echo json_encode($postLikesNumber);
}

if (isset($_POST['getPostComments'])) {
    $dbconnection = new DBConnection();
    $comments = $dbconnection->getPostComments($_POST['post_id']);
    echo json_encode($comments);
}

if (isset($_POST['login'])) {
    $dbconnection = new DBConnection();
    $result["usernameValid"] = !$dbconnection->checkUsername($_POST['username']);
    if ($result["usernameValid"]) {
        $result["passwordValid"] = $dbconnection->checkPassword($_POST['username'], $_POST['password']);
        if ($result["passwordValid"]) {
            $dbconnection->setUserLoggedIn($_POST['username']);
        }
    }
    echo json_encode($result);
}

if (isset($_POST['getNotifications'])) {
    $dbconnection = new DBConnection();
    $notifications = $dbconnection->getNotifications();
    echo json_encode($notifications);
}
