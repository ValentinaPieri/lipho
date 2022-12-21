<?php

namespace app\models;

require_once 'app/query.php';

class Post
{
    private int $post_id;
    private string $username;
    private string $caption;
    private string $timestamp;
    private $images;
    private $likes;
    private $comments;
    private float $avg_exposure_rating;
    private float $avg_colors_rating;
    private float $avg_composition_rating;
    private $conn;

    public function __construct($username, $caption, $conn, $images = array(), $post_id = 0, $timestamp = "")
    {
        $this->post_id = $post_id;
        $this->caption = $caption;
        $this->username = $username;
        $this->avg_exposure_rating = 0;
        $this->avg_colors_rating = 0;
        $this->avg_composition_rating = 0;
        $this->likes = array();
        $this->comments = array();
        $this->images = $images;
        $this->timestamp = $timestamp;
        $this->conn = $conn;
        if ($post_id == 0) {
            $this->createNew();
        }
    }

    public function createNew()
    {
        $stmt = $this->conn->prepare(QUERIES['add_post']);
        $stmt->bind_param("ss", $this->caption, $this->username);
        $stmt->execute();
        $this->post_id = $this->conn->insert_id;
        $this->addImages();
    }

    private function addImages()
    {
        if (isset($this->images) && !empty($this->images)) {
            $stmt = $this->conn->prepare(QUERIES['add_post_image']);
            for ($i = 0; $i < count($this->images); $i++) {
                $image = $this->images[$i];
                $stmt->bind_param("iis", $this->post_id, $i, $image);
                $stmt->execute();
            }
        }
    }

    public function delete()
    {
        $stmt = $this->conn->prepare(QUERIES['delete_post']);
        $stmt->bind_param("i", $this->post_id);
        $stmt->execute();
    }

    public function like($username)
    {
        array_push($this->likes, $username);
        $stmt = $this->conn->prepare(QUERIES['like_post']);
        $stmt->bind_param("is", $this->post_id, $username);
        $stmt->execute();
    }

    public function unlike($username)
    {
        $stmt = $this->conn->prepare(QUERIES['unlike_post']);
        $stmt->bind_param("is", $this->post_id, $username);
        $stmt->execute();
        $this->likes = array_diff($this->likes, array($username));
    }

    public function comment($text, $username)
    {
        $comment = new Comment($text, $this->post_id, $username, $this->conn);
        array_push($this->comments, $comment);
    }

    public function uncomment($comment)
    {
        $this->comments = array_diff($this->comments, $comment);
        $comment->delete();
    }

    public function rate($username, $exposure, $colors, $composition)
    {
        $stmt = $this->conn->prepare(QUERIES['rate_post']);
        $stmt->bind_param("isiii", $this->post_id, $username, $exposure, $colors, $composition);
        $stmt->execute();
        $stmt = $this->conn->prepare(QUERIES['update_average_post_rating']);
        $stmt->bind_param("iiii", $this->post_id, $this->post_id, $this->post_id, $this->post_id);
        $stmt->execute();
        $stmt = $this->conn->prepare(QUERIES['get_average_post_rating']);
        $stmt->bind_param("i", $this->post_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $this->avg_exposure_rating = $result['exposure'];
        $this->avg_colors_rating = $result['colors'];
        $this->avg_composition_rating = $result['composition'];
    }
}
