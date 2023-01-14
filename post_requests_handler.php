<?php
ini_set('display_errors', 1);
session_start();

require_once 'app/DBConnection.php';

use app\DBConnection;

$dbconnection = new DBConnection();

if (isset($_POST['deleteNotification'])) {
    $index = intval($_POST['notificationId']);
    $dbconnection->deleteNotification($index);
}

if (isset($_POST['signup'])) {
    $result["usernameValid"] = $_POST['username'] != "" && $dbconnection->checkUsername($_POST['username']);
    $result["passwordsMatching"] = $_POST['password1'] == $_POST['password2'];
    //check if the password length is at least 8 characters long and if it contains at least one number and one symbol
    $result["passwordValid"] = preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $_POST['password1']) == 1;
    $result["phoneValid"] = $_POST['phone'] == "" || preg_match("/(\+98|0|98|0098)?([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/", $_POST['phone']) == 1;
    $result["nameNotEmpty"] = $_POST['name'] != "";
    $result["surnameNotEmpty"] = $_POST['surname'] != "";
    $result["emailValid"] = $_POST['email'] == "" || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if ($result["usernameValid"] && $result["passwordsMatching"] && $result["passwordValid"] && $result["nameNotEmpty"] && $result["surnameNotEmpty"] && $result["phoneValid"] && $result["emailValid"]) {
        $options = [
            'cost' => 12,
        ];
        $hashed_password = password_hash($_POST['password2'], PASSWORD_BCRYPT, $options);

        $dbconnection->addUser($_POST['username'], $hashed_password, $_POST['name'], $_POST['surname'], $_POST['email'], $_POST['phone'], $_POST['birthdate']);
        $dbconnection->setUserLoggedIn($_POST['username']);
    }
    echo json_encode($result);
}

if (isset($_POST['deleteAllNotifications'])) {
    $dbconnection->deleteAllNotifications();
}

if (isset($_POST['getNotSeenNotificationsNumber'])) {
    echo $dbconnection->getNotSeenNotificationsNumber();
}

if (isset($_POST["post-button"])) {
    $images = array();
    for ($i = 0; $i < 5; $i++) {
        if (isset($_FILES['image-input' . $i])) {
            $fileName = basename($_FILES['image-input' . $i]['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedTypes = array('jpg', 'png', 'jpeg');
            if (in_array($fileType, $allowedTypes)) {
                $image = $_FILES['image-input' . $i]['tmp_name'];
                $imgContent = base64_encode(file_get_contents($image));
                array_push($images, $imgContent);
            }
        }
    }
    $dbconnection->createPost($_POST['caption'], $images);
    header("Location: create_post.php");
}

if (isset($_POST['deletePost'])) {
    $dbconnection->deletePost($_POST['postId']);
}

if (isset($_POST['getMatchingUsers'])) {
    $users = $dbconnection->getMatchingUsers($_POST['username']);
    echo json_encode($users);
}

if (isset($_POST['likePost'])) {
    $dbconnection->likePost($_POST['postId'], $_POST['owner']);
}

if (isset($_POST['unlikePost'])) {
    $dbconnection->unlikePost($_POST['postId']);
}

if (isset($_POST['commentPost'])) {
    $dbconnection->commentPost($_POST['postId'], $_POST['owner'], $_POST['text']);
}

if (isset($_POST['uncommentPost'])) {
    $dbconnection->uncommentPost($_POST['commentId']);
}

if (isset($_POST['likeComment'])) {
    $dbconnection->likeComment($_POST['commentId'], $_POST['owner']);
}

if (isset($_POST['unlikeComment'])) {
    $dbconnection->unlikeComment($_POST['commentId']);
}

if (isset($_POST['ratePost'])) {
    $dbconnection->ratePost($_POST['postId'], $_POST['owner'], $_POST['exposure'], $_POST['colors'], $_POST['composition']);
}

if (isset($_POST['getFeedPosts'])) {
    $posts = $dbconnection->getFeedPosts($_POST['offset'], $_POST['limit']);
    echo json_encode(array('posts' => $posts, 'currentUsername' => $_SESSION['username']));
}

if (isset($_POST['getPostLikesNumber'])) {
    $postLikesNumber = $dbconnection->getPostLikesNumber($_POST['post_id']);
    echo json_encode($postLikesNumber);
}

if (isset($_POST['getPostComments'])) {
    $comments = $dbconnection->getPostComments($_POST['post_id']);
    echo json_encode($comments);
}

if (isset($_POST['login'])) {
    $result["usernameValid"] = !$dbconnection->checkUsername($_POST['username']);
    if ($result["usernameValid"]) {
        $result["passwordValid"] = $dbconnection->checkPassword($_POST['username'], $_POST['password']);
        if ($result["passwordValid"]) {
            $dbconnection->setUserLoggedIn($_POST['username']);
        }
    }
    echo json_encode($result);
}

if (isset($_POST['logout'])) {
    $dbconnection->setUserLoggedOut();
}

if (isset($_POST['deleteUser'])) {
    $dbconnection->deleteUser();
}

if (isset($_POST['getNotifications'])) {
    $notifications = $dbconnection->getNotifications();
    echo json_encode($notifications);
}

if (isset($_POST['getProfileData'])) {
    $username = ($_POST['username'] != "") ? $_POST['username'] : $_SESSION['username'];
    $profileData['user'] = $dbconnection->getUserData($username);
    $profileData['numberPosts'] = $dbconnection->getUserPostsNumber($username);
    $profileData['numberFollowers'] = $dbconnection->getUserFollowersNumber($username);
    $profileData['numberFollowings'] = $dbconnection->getUserFollowingNumber($username);
    $profileData['postFrequency'] = $dbconnection->getUserPostFrequency($username);
    $profileData['averageRating'] = $dbconnection->getUserAverageRating($username);
    $profileData['isFollowing'] = $_SESSION['username'] != $username ? $dbconnection->isFollowing($_POST['username']) : false;
    echo json_encode(array("profileData" => $profileData, "currentUsername" => $_SESSION['username']));
}

if (isset($_POST['follow'])) {
    $dbconnection->followUser($_POST['username']);
}

if (isset($_POST['unfollow'])) {
    $dbconnection->unfollowUser($_POST['username']);
}

if (isset($_POST['getProfilePosts'])) {
    $posts = $dbconnection->getProfilePosts($_POST['username'], $_POST['offset'], $_POST['limit']);
    echo json_encode($posts);
}

if (isset($_POST['getUserData'])) {
    $user = $dbconnection->getUserData($_SESSION['username']);
    echo json_encode($user);
}

if (isset($_POST['editProfile'])) {
    $result["usernameValid"] = !isset($_POST['username']) || $_POST['username'] != "" && ($dbconnection->checkUsername($_POST['username']) || $_POST['username'] == $_SESSION['username']);
    $result["passwordValid"] = !isset($_POST['password']) || preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $_POST['password']) == 1;
    $result["nameValid"] = !isset($_POST['name']) || $_POST['name'] != "";
    $result["surnameValid"] = !isset($_POST['surname']) || $_POST['surname'] != "";
    $result["emailValid"] = !isset($_POST['email']) || $_POST['email'] == "" && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $result["phoneValid"] = !isset($_POST['phone']) || $_POST['phone'] == "" || preg_match("/(\+98|0|98|0098)?([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/", $_POST['phone']) == 1;

    if ($result["usernameValid"] && $result["passwordValid"] && $result["nameValid"] && $result["surnameValid"] && $result["emailValid"] && $result["phoneValid"]) {
        if (isset($_POST['password'])) {
            $options = [
                'cost' => 12,
            ];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
        } else {
            $password = null;
        }

        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $surname = isset($_POST['surname']) ? $_POST['surname'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
        $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : null;
        $profileImage = isset($_POST['profileImage']) ? $_POST['profileImage'] : null;

        $dbconnection->updateUserData($username, $password, $name, $surname, $email, $phone, $birthdate, $profileImage);
    }
    echo json_encode($result);
}
