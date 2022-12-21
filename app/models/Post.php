<?php

namespace app\models;
use const app\QUERY;

require_once('../DBConnection.php');

class Post 
{
    private int $post_id;
    private string $username;
    private string $caption;
    private $images;
    private $likes;
    private $comments;
    private float $avg_exposure_rating;
    private float $avg_colors_rating;
    private float $avg_composition_rating;

    public function __construct($username, $caption, $images) {
        $this->caption = $caption;
        $this->username = $username;
        $this->avg_exposure_rating = 0;
        $this->avg_colors_rating = 0;
        $this->avg_composition_rating = 0;
        $this->likes = array();
        $this->comments = array();
        $this->images = $images;
    }   

    public function create_new() {
        global $conn;
        $stmt = $conn->prepare(QUERY['add_post']);
        $stmt->bind_param("ss", $this->caption, $this->username);
        $stmt->execute();
        $this->post_id = $conn->insert_id;
    }

    public function add_images($images) {
        global $conn;
        if(isset($images) && !empty($images)) {
            $stmt = $conn->prepare(QUERY['add_post_image']);
            for ($i = 0; $i < count($images); $i++) {
                $image = base64_encode($images[$i]);
                $stmt->bind_param("iis", $this->post_id, $i, $image);
                $stmt->execute();
            }
        }
    }

    public function delete() {
        global $conn;
        $stmt = $conn->prepare(QUERY['delete_post']);
        $stmt->bind_param("i", $this->post_id);
        $stmt->execute();
    }

    public function like($username) {
        global $conn;
        $stmt = $conn->prepare(QUERY['like_post']);
        $stmt->bind_param("is", $this->post_id, $username);
        $stmt->execute();
        $this->likes[] = $username;
    }

    public function unlike($username) {
        global $conn;
        $stmt = $conn->prepare(QUERY['unlike_post']);
        $stmt->bind_param("is", $this->post_id, $username);
        $stmt->execute();
        $this->likes = array_diff($this->likes, array($username));
    }

    public function comment($text, $username) {
        $comment = new Comment($text, $this->post_id, $username);
        $this->comments[] = $comment;
    }

    public function uncomment($comment) {
        $this->comments = array_diff($this->comments, $comment);
        $comment->delete();
    }

    public function rate($username, $exposure, $colors, $composition) {
        global $conn;
        $stmt = $conn->prepare(QUERY['rate_post']);
        $stmt->bind_param("isiii", $this->post_id, $username, $exposure, $colors, $composition);
        $stmt->execute();
        $stmt = $conn->prepare(QUERY['update_average_post_rating']);
        $stmt->bind_param("i", $this->post_id);
        $stmt->execute();
        $stmt = $conn->prepare(QUERY['get_average_post_rating']);
        $stmt->bind_param("i", $this->post_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $this->avg_exposure_rating = $result['exposure'];
        $this->avg_colors_rating = $result['colors'];
        $this->avg_composition_rating = $result['composition'];
    }
}
?>