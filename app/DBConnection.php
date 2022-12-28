<?php

namespace app;

require_once 'query.php';
require_once 'models/Notification.php';

use mysqli;
use app\models\Notification;


const host = 'detu.ddns.net';
const user = 'lipho';
const passw = 'Lipho@';
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
                array_push($notifications, $notification);
            }
        }
        return $notifications;
    }

    public function getUserProfileImage($username)
    {
        $stmt = $this->conn->prepare(QUERIES['get_user_profile_image']);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['profile_image'];
        }
        return null;
    }

    public function deleteNotification($notificationId)
    {
        $stmt = $this->conn->prepare(QUERIES['delete_notification']);
        $stmt->bind_param('i', $notificationId);
        $stmt->execute();
    }

    public function deleteAllNotifications()
    {
        $stmt = $this->conn->prepare(QUERIES['delete_user_notifications']);
        $username = 'test'; //TODO: change this to the current user
        $stmt->bind_param('s', $username);
        $stmt->execute();
    }
}
