<?php
require_once 'app/check_session.php';

$templateParams["title"] = "Profile Settings";
$templateParams["scripts"] = "
    <script src='js/profile_settings.js' type='module'></script>
";

$templateParams["page"] = "profile_settings_page.php";

require_once 'templates/base.php';
