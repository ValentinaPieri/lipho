<?php

namespace app;

require_once 'query.php';

use mysqli;
use DateTime;

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
                $notification['seen'] = $row['seen'] == 1;
                $notification['receiver'] = $row['receiver'];
                $notification['sender'] = $row['sender'];
                $notification['timestamp'] = $row['timestamp'];
                $notification['profile_image'] = isset($row['profile_image']) ? $row['profile_image'] : base64_encode(file_get_contents("./resources/images/blank_profile_picture.jpeg"));

                array_push($notifications, $notification);
            }
        }

        $this->setNotificationsSeen();
        return $notifications;
    }

    public function sendNotification($receiver, $text)
    {
        if ($receiver != $_SESSION['username']) {
            $stmt = $this->conn->prepare(QUERIES['send_notification']);
            $stmt->bind_param('sss', $text, $receiver, $_SESSION['username']);
            $stmt->execute();
        }
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

    public function setNotificationsSeen()
    {
        $stmt = $this->conn->prepare(QUERIES['set_notifications_seen']);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
    }

    public function setUserLoggedIn($username)
    {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
    }

    public function setUserLoggedOut()
    {
        unset($_SESSION["loggedin"]);
        unset($_SESSION["username"]);
        session_destroy();
    }

    public function deleteUser()
    {
        $stmt = $this->conn->prepare(QUERIES['delete_user']);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();

        $this->setUserLoggedOut();
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
        $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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
                $post = $row;
                $post['images'] = $this->getPostImages($row['post_id']);
                $post['liked'] = isset($row['username']);
                $post['rated'] = isset($row['rated']);
                unset($post['username']);

                array_push($posts, $post);
            }
        }
        return $posts;
    }

    public function getProfilePosts($username, $offset, $limit)
    {
        $stmt = $this->conn->prepare(QUERIES['get_user_posts']);
        $stmt->bind_param('sssii', $_SESSION['username'], $_SESSION['username'], $username, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $posts = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $post = $row;
                $post['images'] = $this->getPostImages($row['post_id']);
                $post['liked'] = isset($row['username']);
                $post['rated'] = isset($row['rated']);

                array_push($posts, $post);
            }
        }
        return $posts;
    }

    public function getUserPostsNumber($username)
    {
        $stmt = $this->conn->prepare(QUERIES['get_user_posts_number']);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['number'];
        }
        return 0;
    }

    public function getUserFollowersNumber($username)
    {
        $stmt = $this->conn->prepare(QUERIES['get_user_followers_number']);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['number'];
        }
        return 0;
    }

    public function getUserFollowingNumber($username)
    {
        $stmt = $this->conn->prepare(QUERIES['get_user_following_number']);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['number'];
        }
        return 0;
    }

    public function getUserPostFrequency($username)
    {
        $stmt = $this->conn->prepare(QUERIES['get_user_post_frequency']);
        $date = new DateTime();
        $date->modify('-1 month');
        $date = $date->format('Y-m-d H:i:s');
        $stmt->bind_param('ss', $username, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['number'];
        }
        return 0;
    }

    public function getUserAverageRating($username)
    {
        $stmt = $this->conn->prepare(QUERIES['get_user_average_post_rating']);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return array('average_exposure_rating' => isset($row['average_exposure_rating']) ? $row['average_exposure_rating'] : 0, 'average_colors_rating' => isset($row['average_colors_rating']) ? $row['average_colors_rating'] : 0, 'average_composition_rating' => isset($row['average_composition_rating']) ? $row['average_composition_rating'] : 0);
        }
    }

    public function getPostImages($postId)
    {
        $stmt = $this->conn->prepare(QUERIES['get_post_images']);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $images = array();
        foreach ($result as $image) {
            array_push($images, $image['image']);
        }

        return $images;
    }

    public function createPost($caption, $images)
    {
        $stmt = $this->conn->prepare(QUERIES['add_post']);
        $stmt->bind_param("ss", $caption, $_SESSION['username']);
        $stmt->execute();
        $this->addPostImages($this->conn->insert_id, $images);
    }

    public function deletePost($postId)
    {
        $stmt = $this->conn->prepare(QUERIES['delete_post']);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
    }

    private function addPostImages($postId, $images)
    {
        if (isset($images) && !empty($images)) {
            $stmt = $this->conn->prepare(QUERIES['add_post_image']);
            for ($i = 0; $i < count($images); $i++) {
                $image = $images[$i];
                $stmt->bind_param("iis", $postId, $i, $image);
                $stmt->execute();
            }
        }
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
        foreach ($result as &$comment) {
            $comment['liked'] = isset($comment['liked']);
        }

        return $result;
    }

    public function ratePost($postId, $owner, $exposure, $colors, $composition)
    {
        $stmt = $this->conn->prepare(QUERIES['rate_post']);
        $stmt->bind_param("isiii", $postId, $_SESSION['username'], $exposure, $colors, $composition);
        $stmt->execute();
        $this->sendNotification($owner, "rated your post");
    }

    public function commentPost($postId, $owner, $text)
    {
        $stmt = $this->conn->prepare(QUERIES['comment_post']);
        $stmt->bind_param("iss", $postId, $text, $_SESSION['username']);
        $stmt->execute();
        $this->sendNotification($owner, "commented on your post");
    }

    public function uncommentPost($commentId)
    {
        $stmt = $this->conn->prepare(QUERIES['delete_comment']);
        $stmt->bind_param("i", $commentId);
        $stmt->execute();
    }

    public function likePost($postId, $owner)
    {
        $stmt = $this->conn->prepare(QUERIES['like_post']);
        $stmt->bind_param("is", $postId, $_SESSION['username']);
        $stmt->execute();
        $this->sendNotification($owner, "liked your post");
    }

    public function unlikePost($postId)
    {
        $stmt = $this->conn->prepare(QUERIES['unlike_post']);
        $stmt->bind_param("is", $postId, $_SESSION['username']);
        $stmt->execute();
    }

    public function likeComment($commentId, $owner)
    {
        $stmt = $this->conn->prepare(QUERIES['like_comment']);
        $stmt->bind_param("is", $commentId, $_SESSION['username']);
        $stmt->execute();
        $this->sendNotification($owner, "liked your comment");
    }

    public function unlikeComment($commentId)
    {
        $stmt = $this->conn->prepare(QUERIES['unlike_comment']);
        $stmt->bind_param("is", $commentId, $_SESSION['username']);
        $stmt->execute();
    }

    public function getUserData($username)
    {
        $stmt = $this->conn->prepare(QUERIES['get_user']);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $user;
        }
    }

    public function updateUserData($username, $password, $name, $surname, $email, $phone, $birthdate, $profileImage)
    {
        if ($profileImage != null) {
            $stmt = $this->conn->prepare(QUERIES['update_user_profile_image']);
            $stmt->bind_param('ss', $profileImage, $_SESSION['username']);
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

    public function addUser($username, $password, $name, $surname, $email, $phone, $birthdate)
    {
        if ($email != "" && $phone != "" && $birthdate != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_email_phone_birthdate']);
            $stmt->bind_param('sssssss', $username, $password, $name, $surname, $email, $phone, $birthdate);
            $stmt->execute();
        } else if ($email != "" && $phone != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_email_phone']);
            $stmt->bind_param('ssssss', $username, $password, $name, $surname, $email, $phone);
            $stmt->execute();
        } else if ($email != "" && $birthdate != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_email_birthdate']);
            $stmt->bind_param('ssssss', $username, $password, $name, $surname, $email, $birthdate);
            $stmt->execute();
        } else if ($phone != "" && $birthdate != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_phone_birthdate']);
            $stmt->bind_param('ssssss', $username, $password, $name, $surname, $phone, $birthdate);
            $stmt->execute();
        } else if ($email != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_email']);
            $stmt->bind_param('sssss', $username, $password, $name, $surname, $email);
            $stmt->execute();
        } else if ($phone != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_phone']);
            $stmt->bind_param('sssss', $username, $password, $name, $surname, $phone);
            $stmt->execute();
        } else if ($birthdate != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_birthdate']);
            $stmt->bind_param('sssss', $username, $password, $name, $surname, $birthdate);
            $stmt->execute();
        } else {
            $stmt = $this->conn->prepare(QUERIES['add_user']);
            $stmt->bind_param('ssss', $username, $password, $name, $surname);
            $stmt->execute();
        }
    }

    public function followUser($username)
    {
        $stmt = $this->conn->prepare(QUERIES['follow_user']);
        $stmt->bind_param('ss', $_SESSION['username'], $username);
        $stmt->execute();
        $this->sendNotification($username, "started following you");
    }

    public function unfollowUser($username)
    {
        $stmt = $this->conn->prepare(QUERIES['unfollow_user']);
        $stmt->bind_param('ss', $_SESSION['username'], $username);
        $stmt->execute();
    }

    public function isFollowing($username)
    {
        $stmt = $this->conn->prepare(QUERIES['is_following']);
        $stmt->bind_param('ss', $_SESSION['username'], $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
