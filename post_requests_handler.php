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
    $images = array();
    $username = "test"; //TODO: change this to the current user
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
    $post = new Post($username, $_POST["caption"], $dbconnection->getConnection(), $images);
    header("Location: create_post.php");
}

if (isset($_POST['getMatchingUsers'])) {
    $dbconnection = new DBConnection();
    $users = $dbconnection->getMatchingUsers($_POST['username']);
    echo json_encode($users);
}

if (isset($_POST['likePost'])) {
    $dbconnection = new DBConnection();
    $username = "test"; //TODO: change this to the current user
    $post = new Post($username, "", $dbconnection->getConnection(), array(), $_POST['postId']);
    $post->like($username);
}

if (isset($_POST['unlikePost'])) {
    $dbconnection = new DBConnection();
    $username = "test"; //TODO: change this to the current user
    $post = new Post($username, "", $dbconnection->getConnection(), array(), $_POST['postId']);
    $post->unlike($username);
}

if (isset($_POST['commentPost'])) {
    $dbconnection = new DBConnection();
    $username = "test"; //TODO: change this to the current user
    $post = new Post($username, "", $dbconnection->getConnection(), array(), $_POST['postId']);
    $post->comment($_POST["text"], $username);
}

if (isset($_POST['ratePost'])) {
    $dbconnection = new DBConnection();
    $username = "test"; //TODO: change this to the current user
    $post = new Post($username, "", $dbconnection->getConnection(), array(), $_POST['postId']);
    $post->rate($username, $_POST['exposure'], $_POST['colors'], $_POST['composition']);
}

if (isset($_POST['getFeedPosts'])) {
    $dbconnection = new DBConnection();
    $posts = $dbconnection->getFeedPosts($_POST['offset'], $_POST['limit']);
    echo json_encode($posts);
}

if (isset($_POST['getPostLikesNumber'])){
    $dbconnection = new DBConnection();
    $postLikesNumber = $dbconnection->getPostLikesNumber($_POST['post_id']);
    echo json_encode($postLikesNumber);
}

if (isset($_POST['getPostComments'])){
    $dbconnection = new DBConnection();
    $comments = $dbconnection->getPostComments($_POST['post_id']);
    echo json_encode($comments);
}