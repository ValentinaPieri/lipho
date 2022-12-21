<?php

use const app\QUERY;

require_once 'models/Notification.php';

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
        $result = $this->conn->query(QUERY['get_user_notifications']);
        $notifications = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $notification = new Notification($row['notification_id'], $row['text'], $row['seen'], $row['timestamp'], $row['username'], $this->conn);
                array_push($notifications, $notification);
            }
        }
        return $notifications;
    }
}
