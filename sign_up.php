<?php

require_once 'app/DBConnection.php';
require_once 'app/models/User.php';

use app\DBConnection;
use app\models\User;

$templateParams["title"] = "Sign-Up";

$dbconnection = new DBConnection();
$conn = $dbconnection->getConnection();

$templateParams["page"] = "<h1>Sign-Up</h1>";

if (isset($_POST["sign-up"])) {

    // Check if username already exists
    $stmt = $conn->prepare(QUERIES['check_username']);
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $result=$stmt->get_result();
    if ($result->num_rows == 0) {
        if(($_POST['password1']) == ($_POST['password2'])){
            $user = new User($_POST['username'], $_POST['password2'], $_POST['name'], $_POST['surname'], $conn, $_POST['email'], $_POST['phone'], $_POST['birthday']);
        }else{
            $templateParams["page"] = "<br><p> *passwords don't match</p>";
        } 
    }else{
        $templateParams["page"] = "<br><p> *username already exists</p>";   
    }
}
require_once 'templates/signup.php';