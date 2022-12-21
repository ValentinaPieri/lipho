<?php
namespace app\models;

require_once 'app/query.php';

class Notification
{
    private int $id;
    private string $text;
    private bool $seen;
    private string $timestamp;
    private string $username;
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

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function isSeen()
    {
        return $this->seen;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function send()
    {
        $stmt = $this->conn->prepare(QUERIES['send_notification']);
        $stmt->bind_param('siis', $this->text, $this->seen, $this->timestamp, $this->username);
        $stmt->execute();
    }

    public function delete()
    {
        $stmt = $this->conn->prepare(QUERIES['delete_notification']);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
    }

    public function setSeen()
    {
        $this->seen = true;
        $stmt = $this->conn->prepare(QUERIES['set_notifications_seen']);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
    }
}
