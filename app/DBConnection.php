<?php

namespace app;

require_once 'query.php';
require_once 'models/Post.php';
require_once 'models/User.php';

use mysqli;
use app\models\Comment;
use app\models\Post;
use app\models\User;

const host = 'detu.ddns.net';
const user = 'lipho';
const passw = 'RV4^yKIoyD4E#$';
const db = 'lipho';
const port = 3306;

class DBConnection
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(host, user, passw, db, port);
        if ($this->conn->connect_error) {
            echo "Connection failed: " . $this->conn->connect_error;
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function getNotifications()
    {
        $stmt = $this->conn->prepare(QUERIES['get_user_notifications']);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $notifications = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $notification['notification_id'] = $row['notification_id'];
                $notification['text'] = $row['text'];
                $notification['seen'] = $row['seen'];
                $notification['receiver'] = $row['receiver'];
                $notification['sender'] = $row['sender'];
                $notification['timestamp'] = $row['timestamp'];

                array_push($notifications, array("notification" => $notification, "profileImage" => base64_encode(isset($row['profile_image']) ? $row['profile_image'] : file_get_contents(("/resources/images/blank_profile.jpeg")))));
            }
        }
        return $notifications;
    }

    public function deleteNotification($notificationId)
    {
        $stmt = $this->conn->prepare(QUERIES['delete_notification']);
        $stmt->bind_param('i', $notificationId);
        $stmt->execute();
    }

    public function checkUsername($username)
    {
        $stmt = $this->conn->prepare(QUERIES['check_username']);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return false;
        }
        return true;
    }

    public function checkPassword($username, $password)
    {
        $stmt = $this->conn->prepare(QUERIES['get_username_password']);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                return true;
            }
        }
        return false;
    }

    public function deleteAllNotifications()
    {
        $stmt = $this->conn->prepare(QUERIES['delete_user_notifications']);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
    }

    public function getNotSeenNotificationsNumber()
    {
        $stmt = $this->conn->prepare(QUERIES['get_not_seen_notifications_number']);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['number'];
        }
    }

    public function setUserLoggedIn($username)
    {
        session_start();

        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
    }

    public function getMatchingUsers($username)
    {
        if ($username == '') {
            return array();
        }
        $username .= '%';
        $stmt = $this->conn->prepare(QUERIES['get_matching_users']);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = array('username' => $row['username'], 'profile_image' => base64_encode($row['profile_image']));
                array_push($users, $user);
            }
        }

        return $users;
    }

    public function getFeedPosts($offset, $limit)
    {
        $stmt = $this->conn->prepare(QUERIES['get_feed_posts']);
        $stmt->bind_param('sssii', $_SESSION['username'], $_SESSION['username'], $_SESSION['username'], $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $posts = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $post = new Post($username = $row['owner'], $caption = $row['caption'], $conn = $this->conn, $images = array(), $post_id = $row['post_id'], $timestamp = $row['timestamp'], $avg_exposure_rating = $row['average_exposure_rating'], $avg_colors_rating = $row['average_colors_rating'], $avg_composition_rating = $row['average_composition_rating']);

                array_push($posts, array("post" => $post, "liked" => isset($row['username']), "rated" => isset($row['rated'])));
            }
        }
        return $posts;
    }

    public function getPostLikesNumber($postId)
    {
        $stmt = $this->conn->prepare(QUERIES['get_post_likes_number']);
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['likes_number'];
        }
    }

    public function getPostComments($postId)
    {
        $stmt = $this->conn->prepare(QUERIES['get_post_comments']);
        $stmt->bind_param("si", $_SESSION['username'], $postId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $comments = array();
        foreach ($result as $comment) {
            array_push($comments, array("comment" => new Comment($comment['text'], $comment['post_id'], $comment['username'], $this->conn, $comment['comment_id'], $comment['timestamp']), "liked" => isset($comment['liked'])));
        }
        return $comments;
    }

    public function ratePost($postId, $owner, $exposure, $colors, $composition)
    {
        $stmt = $this->conn->prepare(QUERIES['rate_post']);
        $stmt->bind_param("isiii", $postId, $_SESSION['username'], $exposure, $colors, $composition);
        $stmt->execute();
        if ($owner != $_SESSION['username']) {
            $stmt = $this->conn->prepare(QUERIES['send_notification']);
            $text = "rated your post";
            $stmt->bind_param('sss', $text, $owner, $_SESSION['username']);
            $stmt->execute();
        }
    }

    public function commentPost($postId, $owner, $text)
    {
        new Comment($text, $postId, $_SESSION['username'], $this->conn);
        if ($owner != $_SESSION['username']) {
            $stmt = $this->conn->prepare(QUERIES['send_notification']);
            $text = "commented on your post";
            $stmt->bind_param('sss', $text, $owner, $_SESSION['username']);
            $stmt->execute();
        }
    }

    public function uncommentPost($commentId)
    {
        $comment = new Comment("", 0, "", $this->conn, $commentId);
        $comment->delete();
    }

    public function likePost($postId, $owner)
    {
        $stmt = $this->conn->prepare(QUERIES['like_post']);
        $stmt->bind_param("is", $postId, $_SESSION['username']);
        $stmt->execute();
        if ($owner != $_SESSION['username']) {
            $stmt = $this->conn->prepare(QUERIES['send_notification']);
            $text = "liked your post";
            $stmt->bind_param('sss', $text, $owner, $_SESSION['username']);
            $stmt->execute();
        }
    }

    public function unlikePost($postId)
    {
        $stmt = $this->conn->prepare(QUERIES['unlike_post']);
        $stmt->bind_param("is", $postId, $_SESSION['username']);
        $stmt->execute();
    }

    public function likeComment($commentId, $owner)
    {
        $comment = new Comment("", 0, $owner, $this->conn, $commentId);
        $comment->like();
        if ($owner != $_SESSION['username']) {
            $stmt = $this->conn->prepare(QUERIES['send_notification']);
            $text = "liked your comment";
            $stmt->bind_param('sss', $text, $owner, $_SESSION['username']);
            $stmt->execute();
        }
    }

    public function unlikeComment($commentId, $username)
    {
        $comment = new Comment("", 0, $username, $this->conn, $commentId);
        $comment->unlike();
    }

    public function getUserData()
    {
        $stmt = $this->conn->prepare(QUERIES['get_user']);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user = new User($row['username'], $row['password'], $row['name'], $row['surname'], $this->conn, $row['email'], $row['phone'], $row['birthdate'], base64_encode($row['profile_image']));
            return $user;
        }
    }

    public function updateUserData($username, $password, $name, $surname, $email, $phone, $birthdate, $profileImage)
    {
        if ($profileImage != null) {
            $stmt = $this->conn->prepare(QUERIES['update_user_profile_image']);
            $stmt->bind_param('bs', $profileImage, $_SESSION['username']);
            $stmt->execute();
        }
        if ($username != null) {
            $stmt = $this->conn->prepare(QUERIES['update_user_username']);
            $stmt->bind_param('ss', $username, $_SESSION['username']);
            $stmt->execute();
            $_SESSION['username'] = $username;
        }
        if ($password != null) {
            $stmt = $this->conn->prepare(QUERIES['update_user_password']);
            $stmt->bind_param('ss', $password, $_SESSION['username']);
            $stmt->execute();
        }
        if ($name != null) {
            $stmt = $this->conn->prepare(QUERIES['update_user_name']);
            $stmt->bind_param('ss', $name, $_SESSION['username']);
            $stmt->execute();
        }
        if ($surname != null) {
            $stmt = $this->conn->prepare(QUERIES['update_user_surname']);
            $stmt->bind_param('ss', $surname, $_SESSION['username']);
            $stmt->execute();
        }
        if ($email != null) {
            $stmt = $this->conn->prepare(QUERIES['update_user_email']);
            $stmt->bind_param('ss', $email, $_SESSION['username']);
            $stmt->execute();
        }
        if ($phone != null) {
            $stmt = $this->conn->prepare(QUERIES['update_user_phone']);
            $stmt->bind_param('ss', $phone, $_SESSION['username']);
            $stmt->execute();
        }
        if ($birthdate != null) {
            $stmt = $this->conn->prepare(QUERIES['update_user_birthdate']);
            $stmt->bind_param('ss', $birthdate, $_SESSION['username']);
            $stmt->execute();
        }
    }
}
