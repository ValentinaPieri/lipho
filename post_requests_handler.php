<?php

require_once 'app/DBConnection.php';

use app\DBConnection;

if (isset($_POST['notificationId'])) {
    $index = intval($_POST['notificationId']);
    $dbconnection = new DBConnection();
    $dbconnection->deleteNotification($index);
}

if (isset($_POST['deleteAllNotifications'])) {
    $dbconnection = new DBConnection();
    $dbconnection->deleteAllNotifications();
}

if (isset($_POST['getMatchingUsers'])) {
    $dbconnection = new DBConnection();
    $users = $dbconnection->getMatchingUsers($_POST['username']);
    echo json_encode($users);
}
