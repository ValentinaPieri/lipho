<?php

namespace app\models;

require_once 'app/query.php';
require_once 'app/models/Comment.php';

use app\models\Comment;
use JsonSerializable;

class Post implements JsonSerializable
{
    private int $post_id;
    private string $username;
    private string $caption;
    private string $timestamp;
    private array $images;
    private array $likes;
    private array $comments;
    private float $avg_exposure_rating;
    private float $avg_colors_rating;
    private float $avg_composition_rating;
    private $conn;

    public function __construct($username, $caption, $conn, $images = array(), $post_id = 0, $timestamp = "", $avg_exposure_rating = 0, $avg_colors_rating = 0, $avg_composition_rating = 0)
    {
        $this->post_id = $post_id;
        $this->caption = $caption;
        $this->username = $username;
        $this->avg_exposure_rating = $avg_exposure_rating;
        $this->avg_colors_rating = $avg_colors_rating;
        $this->avg_composition_rating = $avg_composition_rating;
        $this->likes = array();
        $this->comments = array();
        $this->images = $images;
        $this->timestamp = $timestamp;
        $this->conn = $conn;
        if ($post_id == 0) {
            $this->createNew();
        } else {
            $this->retreiveImages();
            $this->retreiveLikes();
            $this->retreiveComments();
        }
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getCaption()
    {
        return $this->caption;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getLikes()
    {
        return $this->likes;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function getAvgExposureRating()
    {
        return $this->avg_exposure_rating;
    }

    public function getAvgColorsRating()
    {
        return $this->avg_colors_rating;
    }

    public function getAvgCompositionRating()
    {
        return $this->avg_composition_rating;
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

    private function retreiveImages()
    {
        $stmt = $this->conn->prepare(QUERIES['get_post_images']);
        $stmt->bind_param("i", $this->post_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $this->images = array();
        foreach ($result as $image) {
            array_push($this->images, $image['image']);
        }
    }

    private function retreiveLikes()
    {
        $stmt = $this->conn->prepare(QUERIES['get_post_likes']);
        $stmt->bind_param("i", $this->post_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $this->likes = array();
        foreach ($result as $like) {
            array_push($this->likes, $like['username']);
        }
    }

    private function retreiveComments()
    {
        $username = "test"; //TODO: change to actual username
        $stmt = $this->conn->prepare(QUERIES['get_post_comments']);
        $stmt->bind_param("si", $username, $this->post_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $this->comments = array();
        foreach ($result as $comment) {
            array_push($this->comments, array("comment" => new Comment($comment['text'], $comment['post_id'], $comment['username'], $this->conn, $comment['comment_id'], $comment['timestamp']), "liked" => isset($comment['liked'])));
        }
    }

    public function jsonSerialize()
    {
        return [
            'post_id' => $this->post_id,
            'username' => $this->username,
            'caption' => $this->caption,
            'images' => array_map("base64_encode", $this->images),
            'likes' => $this->likes,
            'comments' => $this->comments,
            'timestamp' => $this->timestamp,
            'avg_exposure_rating' => $this->avg_exposure_rating,
            'avg_colors_rating' => $this->avg_colors_rating,
            'avg_composition_rating' => $this->avg_composition_rating
        ];
    }
}
