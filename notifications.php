<?php
require_once 'app/DBConnection.php';
require_once 'app/models/Notification.php';

use app\DBConnection;
use app\models\Notification;

$templateParams["title"] = "Notifications";

$dbconnection = new DBConnection();

$notification = new Notification("test",false, "test", $dbconnection->getConnection());

$notifications = $dbconnection->getNotifications();
$templateParams["page"] = $notifications[0]->getText();

require_once 'templates/base.php';
