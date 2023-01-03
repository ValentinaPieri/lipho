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

if (isset($_POST['getNotSeenNotificationsNumber'])) {
    $dbconnection = new DBConnection();
    echo $dbconnection->getNotSeenNotificationsNumber();
}
