<?php

namespace app;

require_once 'query.php';
require_once 'models/Notification.php';
require_once 'models/Post.php';

use mysqli;
use app\models\Notification;
use app\models\Post;

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
        $username = 'test'; //TODO: change this to the current user
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $notifications = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $notification = new Notification($row['text'], $row['seen'], $row['receiver'], $row['sender'], $this->conn, $row['timestamp'], $row['notification_id']);

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
        $username = 'test'; //TODO: change this to the current user
        $stmt->bind_param('s', $username);
        $stmt->execute();
    }

    public function getNotSeenNotificationsNumber()
    {
        $stmt = $this->conn->prepare(QUERIES['get_not_seen_notifications_number']);
        $username = 'test'; //TODO: change this to the current user
        $stmt->bind_param('s', $username);
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
}
