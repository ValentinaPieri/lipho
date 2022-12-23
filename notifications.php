<?php
require_once 'app/DBConnection.php';

use app\DBConnection;

$templateParams["title"] = "Notifications";

$dbconnection = new DBConnection();
$notifications = $dbconnection->getNotifications();

$templateParams["page"] = $notifications[0]->getUsername();

require_once 'templates/base.php';
