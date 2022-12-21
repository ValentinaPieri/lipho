<?php
namespace app\models;

include_once '../query.php';

class Notification
{
    private int $id;
    private string $text;
    private bool $seen;
    private int $timestamp;
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

    public function send()
    {
        $stmt = $this->conn->prepare(QUERIES['send_notification']);
        $stmt->bindParam('siis', $this->text, $this->seen, $this->timestamp, $this->username);
        $stmt->execute();
    }

    public function delete()
    {
        $stmt = $this->conn->prepare(QUERIES['delete_notification']);
        $stmt->bindParam('i', $this->id);
        $stmt->execute();
    }

    public function setSeen()
    {
        $this->seen = true;
        $stmt = $this->conn->prepare(QUERIES['set_notifications_seen']);
        $stmt->bindParam('i', $this->id);
        $stmt->execute();
    }
}
