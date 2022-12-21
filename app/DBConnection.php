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
                $notification = new Notification($row['notification_id'], $row['text'], $row['seen'], $row['timestamp'], $row['username'], $this->conn);
                array_push($notifications, $notification);
            }
        }
        return $notifications;
    }

    public function getUserPosts($username)
    {
        $stmt = $this->conn->prepare(QUERIES['get_user_posts']);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $posts = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $post = new Post(username: $row['username'], caption: $row['caption'], conn: $this->conn, post_id: $row['post_id'], timestamp: $row['timestamp']);
                array_push($posts, $post);
            }
        }
    }
}
