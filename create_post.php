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
    <input type='file' class='form-control' id='image-input0' name='image' required/>
    <button type='button' id='trash-can0' onclick='deleteButtonClicked(0)'><i class='fa-regular fa-trash-can'></i></button>
    <button type='button' id='right-arrow0'><i class='fa-regular fa-arrow-right'></i></button>
    </div>

    <div id='add-button-form'>
    <button type='button' class='form-control' id='add-button' onclick='addButtonClicked()'><i class='fa-regular fa-circle-plus'></i></button>
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
    let imagesNum = 1;

    function addButtonClicked() {
        if (imagesNum < 4) {
            const div = document.getElementById('images-form');
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input' + imagesNum + '\' name=\'image\'/>';
            div.innerHTML += '<button type=\'button\' id=\'left-arrow' + imagesNum + '\'><i class=\'fa-regular fa-arrow-left\'></i></button>';
            div.innerHTML += '<button type=\'button\' id=\'trash-can' + imagesNum + '\' onclick=\'deleteButtonClicked(' + imagesNum + ')\'><i class=\'fa-regular fa-trash-can\'></i></button>';
            div.innerHTML += '<button type=\'button\' id=\'right-arrow' + imagesNum + '\'><i class=\'fa-regular fa-arrow-right\'></i></button>';
            imagesNum++;
        } else if (imagesNum == 4) {
            const div = document.getElementById('images-form');
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input' + imagesNum + '\' name=\'image\'/>';
            div.innerHTML += '<button type=\'button\' id=\'left-arrow' + imagesNum + '\'><i class=\'fa-regular fa-arrow-left\'></i>';
            div.innerHTML += '<button type=\'button\' id=\'trash-can' + imagesNum + '\' onclick=\'deleteButtonClicked(' + imagesNum + ')\'><i class=\'fa-regular fa-trash-can\'></i></button>';
            var button = document.getElementById("add-button");
            button.remove();
        }
    }

    function deleteButtonClicked(index) {
        if (imagesNum - 1 > 0) {
            let form = document.getElementById('image-input' + index + '');
            form.remove();
            imagesNum--;
            if (index == 0) {
                let button = document.getElementById('trash-can' + index + '');
                button.remove();
                button = document.getElementById('right-arrow' + index + '');
                button.remove();
                reindex(index);

            } else if (index == 4) {
                let button = document.getElementById('left-arrow' + index + '');
                button.remove();
                button = document.getElementById('trash-can' + index + '');
                button.remove();
            } else {
                let button = document.getElementById('left-arrow' + index + '');
                button.remove();
                button = document.getElementById('trash-can' + index + '');
                button.remove();
                button = document.getElementById('right-arrow' + index + '');
                button.remove();
                reindex(index);
            }
            if (imagesNum == 3) {
                const button = document.getElementById('add-button-form');
                button.innerHTML += '<button type=\'button\' class=\'form-control\' id=\'add-button\' onclick=\'addButtonClicked()\'><i class=\'fa-regular fa-circle-plus\'></i></button>';
            }
        }
    }

    function reindex(index) {
        let newIndex = index;
        while ((document.getElementById('image-input' + index + '')) != null || (document.getElementById('image-input' + ++index + '')) != null) {
            for (i = index; i <= imagesNum; i++) {
                let form = document.getElementById('image-input' + i + '');
                form.id = 'image-input' + (newIndex) + '';
                let button = document.getElementById('left-arrow' + i + '');
                button.id = 'left-arrow' + (newIndex) + '';
                button = document.getElementById('trash-can' + i + '');
                button.id = 'trash-can' + (newIndex) + '';
                if (i != imagesNum) {
                    button = document.getElementById('right-arrow' + i + '');
                    button.id = 'right-arrow' + (newIndex) + '';
                }
                newIndex++;
            }
            break;
        }
        for (i = 0; i < imagesNum; i++) {
            console.log(document.getElementById('image-input' + i + ''))
        }
    }
</script>