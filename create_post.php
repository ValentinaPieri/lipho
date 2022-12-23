<?php
require_once 'app/DBConnection.php';
require_once 'app/models/Post.php';
require_once 'app/query.php';

use app\DBConnection;
use app\models\Post;

$templateParams["title"] = "Create Post";

$dbconnection = new DBConnection();
$conn = $dbconnection->getConnection();

$templateParams["page"] = "<h2>Pictures</h2>";

$templateParams["page"] .= "
<form method='post' enctype='multipart/form-data'>
    <div id='images-form'>
    <input type='file' class='form-control' id='image-input' name='image' required/>
    <i class='fa-regular fa-trash-can'></i>
    <i class='fa-regular fa-arrow-right'></i>
    </div>

    <button type='button' class='form-control' id='add-button-form' onclick='addButtonClicked()'><i class='fa-regular fa-circle-plus'></i></button>

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

    foreach ($_FILES['image']['name'] as $i => $name) {
        $fileName = basename($name);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowedTypes)) {
            $image = $_FILES['image']['tmp_name'][$i];
            $imgContent = addslashes(file_get_contents($image));
            array_push($images, $imgContent);
            $post = new Post(/*$_SESSION["username"]*/$username, $_POST["caption"], $conn, $images);
        }
    }
}

require_once 'templates/base.php';
?>

<script>
    let images = 1;

    function addButtonClicked() {
        if (images < 4) {
            const div = document.getElementById('images-form');
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input\' name=\'image\' required/>';
            div.innerHTML += '<i class=\'fa-regular fa-arrow-left\'></i>';
            div.innerHTML += '<i class=\'fa-regular fa-trash-can\'></i>';
            div.innerHTML += '<i class=\'fa-regular fa-arrow-right\'></i>';
            images++;
        } else if (images == 4) {
            const div = document.getElementById('images-form');
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input\' name=\'image\' required/>';
            div.innerHTML += '<i class=\'fa-regular fa-arrow-left\'></i>';
            div.innerHTML += '<i class=\'fa-regular fa-trash-can\'></i>';
            var button = document.getElementById("add-button-form");
            button.remove();
        }
    }
</script>