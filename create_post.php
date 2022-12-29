<?php
require_once 'app/DBConnection.php';
require_once 'app/models/Post.php';
require_once 'app/query.php';

use app\DBConnection;
use app\models\Post;

$templateParams["title"] = "Create Post";
$templateParams["scripts"] = "<script src='js/posts.js'></script>";

$dbconnection = new DBConnection();
$conn = $dbconnection->getConnection();

$templateParams["page"] = "";

$templateParams["page"] .= "
<form method='post' enctype='multipart/form-data'>

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

if (isset($_POST["post-button"])) {
    $images = array();
    $username = "test";

    for ($i = 0; $i < 5; $i++) {
        if (isset($_FILES['image-input' . $i])) {
            $fileName = basename($_FILES['image-input' . $i]['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedTypes = array('jpg', 'png', 'jpeg');
            if (in_array($fileType, $allowedTypes)) {
                $image = $_FILES['image-input' . $i]['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));
                array_push($images, $imgContent);
            }
        }
    }
    $post = new Post(/*$_SESSION["username"]*/$username, $_POST["caption"], $conn, $images);
}

require_once 'templates/base.php';
