<?php

namespace app\models;

require_once 'app/query.php';

use JsonSerializable;

class Comment implements JsonSerializable
{
    private int $comment_id;
    private string $text;
    private string $timestamp;
    private int $post_id;
    private string $username;
    private $conn;

    public function __construct($text, $post_id, $username, $conn, $comment_id = 0, $timestamp = "")
    {
        $this->comment_id = $comment_id;
        $this->text = $text;
        $this->post_id = $post_id;
        $this->username = $username;
        $this->conn = $conn;
        $this->timestamp = $timestamp;
        if ($comment_id == 0) {
            $this->createNew();
        }
    }

    public function getCommentId()
    {
        return $this->comment_id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    private function createNew()
    {
        $stmt = $this->conn->prepare(QUERIES['comment_post']);
        $stmt->bind_param("iss", $this->post_id, $this->text, $this->username);
        $stmt->execute();
        $this->comment_id = $this->conn->insert_id;
    }

    public function delete()
    {
        $stmt = $this->conn->prepare(QUERIES['delete_comment']);
        $stmt->bind_param("i", $this->comment_id);
        $stmt->execute();
    }

    public function like()
    {
        $stmt = $this->conn->prepare(QUERIES['like_comment']);
        $stmt->bind_param("is", $this->comment_id, $this->username);
        $stmt->execute();
    }

    public function unlike()
    {
        $stmt = $this->conn->prepare(QUERIES['unlike_comment']);
        $stmt->bind_param("is", $this->comment_id, $this->username);
        $stmt->execute();
    }

    public function jsonSerialize()
    {
        return [
            'comment_id' => $this->comment_id,
            'text' => $this->text,
            'timestamp' => $this->timestamp,
            'post_id' => $this->post_id,
            'username' => $this->username
        ];
    }
}
