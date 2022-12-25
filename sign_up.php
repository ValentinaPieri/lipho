<?php

require_once 'app/DBConnection.php';
require_once 'app/models/User.php';

use app\DBConnection;
use app\models\User;

$templateParams["title"] = "Sign-Up";

$dbconnection = new DBConnection();
$conn = $dbconnection->getConnection();

$templateParams["page"] = "<h1>Sign-Up</h1>";

if (isset($_POST['sign-up']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['surname'])) {
    
    if (isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['birth_date'])) {
        $user = new User($_POST['username'], $_POST['password'], $_POST['name'], $_POST['surname'], $conn, $_POST['email'], $_POST['phone'], $_POST['birth_date']);
    }
    $user = new User($_POST['username'], $_POST['password'], $_POST['name'], $_POST['surname'], $conn);
}else{
    $templateParams["page"] = "<br><p> *fill mandatory fields</p>";
}

require_once 'templates/signup.php';

?>