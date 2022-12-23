<?php
require_once 'app/DBConnection.php';
require_once 'app/models/Notification.php';

use app\DBConnection;
use app\models\Notification;

$templateParams["title"] = "Notifications";

$dbconnection = new DBConnection();

$notifications = $dbconnection->getNotifications();

$today_shown = false;
$yesterday_shown = false;
$earlier_shown = false;
for ($current = 0; $current < sizeof($notifications); $current++) {
    if (!$today_shown && date("Y-m-d", strtotime($notifications[$current]->getTimestamp())) == date("Y-m-d", strtotime("now"))) {
        $templateParams["page"] = "
        <h2>Today</h2>
        ";
        $today_shown = true;
    } else if (!$yesterday_shown && date("Y-m-d", strtotime($notifications[$current]->getTimestamp())) == date("Y-m-d", strtotime("-1 day"))) {
        $templateParams["page"] .= "
        <h2>Yesterday</h2>
        ";
        $yesterday_shown = true;
    } else if (!$earlier_shown && date("Y-m-d", strtotime($notifications[$current]->getTimestamp())) <= date("Y-m-d", strtotime("-2 day"))) {
        $templateParams["page"] .= "
        <h2>Earlier</h2>
        ";
        $earlier_shown = true;
    }

    $profile_image = $dbconnection->getUserProfileImage($notifications[$current]->getUsername());

    $templateParams["page"] .= "
            <div class=\"notification\">
                <img src=\"data:image/jpeg;base64," . base64_encode($profile_image) . "\" alt=\"" . $notifications[$current]->getUsername() . " profile image\">
                <a href=\"profile.php?username=" . $notifications[$current]->getUsername() . "\">" . $notifications[$current]->getUsername() . "</a>
                <p>
                    " . $notifications[$current]->getText() . "
                </p>
            </div>
            ";
}

if (sizeof($notifications) == 0) {
    $templateParams["page"] = "
    <h2>No notifications</h2>
    <i class=\"fa-regular fa-face-frown-slight\"></i>
    ";
}

require_once 'templates/base.php';
