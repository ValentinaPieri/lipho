<?php

require_once 'app/DBConnection.php';

use app\DBConnection;

if (isset($_POST['notificationId'])) {
    $index = intval($_POST['notificationId']);
    $dbconnection = new DBConnection();
    $dbconnection->deleteNotification($index);
}

if(isset($_POST['username'])){
    $username = $_POST['username'];
    $dbconnection = new DBConnection();
    $conn = $dbconnection->getConnection();
    $stmt = $conn -> prepare(QUERIES['check_username']);
    $stmt -> bind_param("s", $_POST['username']);
    $stmt -> execute();
    $result -> store_result();
    if(isset($stmt) && $result->num_rows > 0){
        $result->checkUsername($username);
        echo "Username is not available";
    }
}