<?php
require_once 'app/check_session.php';

$templateParams["title"] = "Home";
$templateParams["scripts"] = "
    <script src='js/feed.js' type='module'></script>
    <script src='js/post.js'></script>
";
$templateParams["page"] = "home_page.php";
require_once 'templates/base.php';
