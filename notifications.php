<?php

require_once "app/check_session.php";

$templateParams["title"] = "Notifications";
$templateParams["scripts"] = "
    <script src=\"js/notifications.js\"></script>
    ";

require_once "templates/base.php";
