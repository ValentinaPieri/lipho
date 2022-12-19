<?php

namespace app\models;
use const app\QUERY;

require_once '../DBConnection.php';

class Post 
{
    private int $post_id;
    private string $username;
    private string $caption;
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

        $this->create_new_post();
        $this->add_images_to_post($images);
        
        // TODO: add likes and comments
        $this->likes = array();
        $this->comments = array();
    }   

    private function create_new_post() {
        global $conn;
        $stmt = $conn->prepare(QUERY['add_post']);
        $stmt->bind_param("ss", $this->caption, $this->username);
        $stmt->execute();
        $this->post_id = $conn->insert_id;
    }

    private function add_images_to_post($images) {
        global $conn;
        if(isset($images) && !empty($images)) {
            $stmt = $conn->prepare(QUERY['add_post_image']);
            for ($i = 0; $i < count($images); $i++) {
                $stmt->bind_param("iis", $this->post_id, $i, base64_encode($images[$i]));
                $stmt->execute();
            }
        }
    }
}
?>