<?php
require_once 'app/DBConnection.php';
require_once 'app/models/Post.php';
require_once 'app/query.php';

use app\DBConnection;
use app\models\Post;

$templateParams["title"] = "Create Post";
$templateParams["scripts"] = "<script src='js/posts.js'></script>";
$templateParams["page"] = "";
$templateParams["page"] .= "
<form action='post_requests_handler.php' method='post' enctype='multipart/form-data'>

    <div id='images-form'>
    <label for='caption'><h2>Pictures</h2></label>
    <p id='images-counter'><script>imagesCounter()</script></p>
    <script>displayImageForms();</script>
    <button type='button' class='form-control' id='add-button' onclick='addImageForm()'><i class='fa-regular fa-circle-plus'></i></button>
    <script>checkAddButton();</script>
    </div>

    <div id='caption-form'>
    <label for='caption'><h2>Caption</h2></label>
    <textarea class='form-control' id='caption' name='caption'></textarea>
    </div>

    <button type='submit' class='btn' name='post-button'>Post</button>
</form>
";

require_once 'templates/base.php';
