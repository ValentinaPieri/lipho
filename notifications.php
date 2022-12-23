<?php
require_once 'app/DBConnection.php';
require_once 'app/models/Notification.php';

use app\DBConnection;
use app\models\Notification;

$templateParams["title"] = "Notifications";

$dbconnection = new DBConnection();

$notifications = $dbconnection->getNotifications();

$current = 0;
if (sizeof($notifications) > 0) {
    if (date("Y-m-d", strtotime($notifications[0]->getTimestamp())) == date("Y-m-d", strtotime("now"))) {
        $templateParams["page"] = "
        <h2>Today</h2>
        ";
        for ($current = 0; $current < sizeof($notifications); $current++) {
            if (date("Y-m-d", strtotime($notifications[$current]->getTimestamp())) != date("Y-m-d", strtotime("now"))) {
                break;
            }

            $templateParams["page"] .= "
            <div class=\"notification\">
                <p>
                    <a href=\"profile.php?username=" . $notifications[$current]->getUsername() . "\">" . $notifications[$current]->getUsername() . "</a>
                    " . $notifications[$current]->getText() . "
                </p>
            </div>
            ";
        }
    }

    if ($current < sizeof($notifications) && date("Y-m-d", strtotime($notifications[$current]->getTimestamp())) == date("Y-m-d", strtotime("-1 day"))) {
        $templateParams["page"] .= "
        <h2>Yesterday</h2>
        ";
        for ($current = $current; $current < sizeof($notifications); $current++) {
            if (date("Y-m-d", strtotime($notifications[$current]->getTimestamp())) != date("Y-m-d", strtotime("-1 day"))) {
                break;
            }

            $templateParams["page"] .= "
            <div class=\"notification\">
                <p>" . $notifications[$current]->getUsername() . " " . $notifications[$current]->getText() . "</p>
            </div>
            ";
        }
    }

    if ($current < sizeof($notifications) && date("Y-m-d", strtotime($notifications[$current]->getTimestamp())) <= date("Y-m-d", strtotime("-2 day"))) {
        $templateParams["page"] .= "
        <h2>Earlier</h2>
        ";
        for ($current = $current; $current < sizeof($notifications); $current++) {
            $templateParams["page"] .= "
            <div class=\"notification\">
                <p>" . $notifications[$current]->getUsername() . " " . $notifications[$current]->getText() . "</p>
            </div>
            ";
        }
    }
} else {
    $templateParams["page"] = "
    <h2>No notifications</h2>
    <i class=\"fa-regular fa-face-frown-slight\"></i>
    ";
}

require_once 'templates/base.php';
