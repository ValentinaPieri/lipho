<?php
require_once 'app/models/Post.php';
require_once 'app/DBConnection.php';

use App\Models\Post;
use App\DBConnection;

$templateParams["title"] = "Home";

$templateParams["scripts"] = "
    <script src=\"https://code.jquery.com/jquery-3.5.0.js\"></script>
    <script src=\"js/posts.js\"></script>
";

$dbconn = new DBConnection();
$conn = $dbconn->getConnection();
$post = new Post($username = "test", $caption = "", $conn = $conn, $images = array(), $post_id = 75, $timestamp = "2023-01-04 18:35:02", $avg_exposure_rating = 0, $avg_colors_rating = 0, $avg_composition_rating = 0);
$templateParams["post"]["username"] = $post->getUsername();
$templateParams["post"]["caption"] = $post->getCaption();
$templateParams["post"]["timestamp"] = $post->getTimestamp();
$templateParams["post"]["images"] = $post->getImages();
$templateParams["post"]["post_id"] = $post->getPostId();
$templateParams["post"]["likes"] = $post->getLikes();
$templateParams["post"]["comments"] = $post->getComments();
$templateParams["post"]["avg_exposure_rating"] = $post->getAvgExposureRating();
$templateParams["post"]["avg_colors_rating"] = $post->getAvgColorsRating();
$templateParams["post"]["avg_composition_rating"] = $post->getAvgCompositionRating();
require_once 'templates/post.php';
$templateParams["page"] = $POST_TEMPLATE;
require_once 'templates/base.php';
