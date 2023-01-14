<?php
require_once 'app/check_session.php';

$templateParams["title"] = "Profile";
$templateParams["scripts"] = "
    <script src='js/profile.js'></script>
    <script src='js/post.js'></script>
";
$templateParams["page"] = "profile_page.php";

require_once 'templates/base.php';
