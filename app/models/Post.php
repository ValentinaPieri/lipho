<?php

namespace app\models;

use DBConnection;
use const app\QUERY;
require_once('../DBConnection.php');
$conn = new DBConnection();

class Post 
{
    private int $post_id;
    private String $username;
    private String $caption;
    private $likes;
    private $comments;
    private $avg_exposure_rating;
    private $avg_colors_rating;
    private $avg_composition_rating;

    public function __construct($caption, $images) {
        $this->caption = $caption;
        $this->username = $_SESSION['username'];
        $this->avg_exposure_rating = 0;
        $this->avg_colors_rating = 0;
        $this->avg_composition_rating = 0;

        $this->create_new_post();
        $this->add_images_to_post(base64_decode($images));
        
        // TODO: add likes and comments
        $this->likes = array();
        $this->comments = array();
    }   

    private function create_new_post() {
        global $conn;
        $stmt = $conn->prepare(QUERY['add_post']);
        $stmt->bind_param("ss", $this->caption, $this->username);
        $stmt->execute();
        //get last inserted id
        $this->post_id = $conn->insert_id;
    }

    private function add_images_to_post($images) {
        global $conn;
        if(isset($images) && !empty($images)) {
            $stmt = $conn->prepare(QUERY['add_post_image']);
            foreach($images as $image) {
                $position = array_search($image, $images);
                $stmt->bind_param("iis", $this->post_id, $position, $image);
                $stmt->execute();
            }
        }
    }
}
 
?>