<?php

namespace app\models;
use const app\QUERY;

require_once('../DBConnection.php');

class Comment 
{
    private int $comment_id;
    private string $text;
    private int $post_id;
    private string $username;

    public function __construct($text, $post_id, $username) {
        $this->text = $text;
        $this->post_id = $post_id;
        $this->username = $username;

        $this->create_new();
    }

    private function create_new(){
        global $conn;
        $stmt = $conn->prepare(QUERY['comment_post']);
        $stmt->bind_param("iss", $this->post_id, $this->text, $this->username);
        $stmt->execute();
        $this->comment_id = $conn->insert_id;
    }

    public function delete() {
        global $conn;
        $stmt = $conn->prepare(QUERY['delete_comment']);
        $stmt->bind_param("i", $this->comment_id);
        $stmt->execute();
    }

    public function like() {
        global $conn;
        $stmt = $conn->prepare(QUERY['like_comment']);
        $stmt->bind_param("is", $this->comment_id, $this->username);
        $stmt->execute();
    }

    public function unliket() {
        global $conn;
        $stmt = $conn->prepare(QUERY['unlike_comment']);
        $stmt->bind_param("is", $this->comment_id, $this->username);
        $stmt->execute();
    }
}
?>