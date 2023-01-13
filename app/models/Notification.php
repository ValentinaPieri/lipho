<?php

namespace app\models;

use JsonSerializable;

require_once 'app/query.php';

class Notification implements JsonSerializable
{
    private int $id;
    private string $text;
    private bool $seen;
    private string $timestamp;
    private string $receiver;
    private string $sender;
    private $conn;

    public function __construct($text, $seen, $receiver, $sender, $conn, $timestamp = "", $id = 0)
    {
        $this->id = $id;
        $this->text = $text;
        $this->seen = $seen;
        $this->timestamp = $timestamp;
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->conn = $conn;

        if ($id == 0)
            $this->send();
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

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function getSender()
    {
        return $this->sender;
    }

    private function send()
    {
        $stmt = $this->conn->prepare(QUERIES['send_notification']);
        $stmt->bind_param('siss', $this->text, $this->seen, $this->receiver, $this->sender);
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

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
