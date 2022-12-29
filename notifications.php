<?php
require_once 'app/DBConnection.php';
require_once 'app/models/Notification.php';

use app\DBConnection;

$templateParams["title"] = "Notifications";
$templateParams["scripts"] = "
    <script type=\"text/javascript\" src=\"https://code.jquery.com/jquery-3.5.0.js\"></script>
    <script type=\"text/javascript\" src=\"js/notifications.js\"></script>
    ";
$templateParams["page"] = "";

$dbconnection = new DBConnection();

$notifications = $dbconnection->getNotifications();

if (sizeof($notifications) == 0) {
    $templateParams["page"] = "
    <h2>No notifications</h2>
    <i class=\"fa-regular fa-face-frown-slight\"></i>
    ";
} else {
    $templateParams["page"] = "
    <button type=\"button\" id=\"delete-all-notifications-button\" onClick=\"deleteAllNotifications()\" alt=\"Delete all notifications\">
        <i class=\"fa-regular fa-trash-can-list\"></i>
    </button>
    ";
}

$today_shown = false;
$yesterday_shown = false;
$earlier_shown = false;
for ($current = 0; $current < sizeof($notifications); $current++) {
    if (!$today_shown && date("Y-m-d", strtotime($notifications[$current]->getTimestamp())) == date("Y-m-d", strtotime("now"))) {
        $templateParams["page"] .= "
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

    $profile_image = $dbconnection->getUserProfileImage($notifications[$current]->getSender());

    $templateParams["page"] .= "
            <div class=\"notification\" id=\"notification" . $notifications[$current]->getId() . "\">
                <img src=\"data:image/jpeg;base64," . base64_encode($profile_image) . "\" alt=\"" . $notifications[$current]->getSender() . " profile image\">
                <a href=\"profile.php?username=" . $notifications[$current]->getSender() . "\">" . $notifications[$current]->getSender() . "</a>
                <p>
                    " . $notifications[$current]->getText() . "
                </p>
                <button type=\"button\" class=\"notification-delete-button\" onClick=\"deleteNotification(" . $notifications[$current]->getId() . ")\">
                    <i class=\"fa-light fa-trash-can\"></i>
                </button>
            </div>
            ";
}

if (sizeof($notifications) == 0) {
    $templateParams["page"] = "
    <h2>No notifications</h2>
    <i class=\"fa-regular fa-face-frown-slight\"></i>
    ";
}

foreach ($notifications as $notification) {
    $notification->setSeen();
}

require_once 'templates/base.php';
