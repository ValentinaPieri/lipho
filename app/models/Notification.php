<?php

namespace app\models;

use const app\QUERY;

class Notification
{
    private $id;
    private $text;
    private $seen;
    private $timestamp;
    private $username;
    private $conn;

    public function __construct($id, $text, $seen, $timestamp, $username, $conn)
    {
        $this->id = $id;
        $this->text = $text;
        $this->seen = $seen;
        $this->timestamp = $timestamp;
        $this->username = $username;
        $this->conn = $conn;
    }

    public function send()
    {
        $stmt = $this->conn->prepare(QUERY['send_notification']);
        $stmt->bindParam('siis', $this->text, $this->seen, $this->timestamp, $this->username);
        $stmt->execute();
    }

    public function delete()
    {
        $stmt = $this->conn->prepare(QUERY['delete_notification']);
        $stmt->bindParam('i', $this->id);
        $stmt->execute();
    }

    public function setSeen()
    {
        $stmt = $this->conn->prepare(QUERY['set_notifications_seen']);
        $stmt->bindParam('i', $this->id);
        $stmt->execute();
    }
}
