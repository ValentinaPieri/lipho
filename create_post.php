<?php
require_once "app/check_session.php";
$templateParams["title"] = "Create Post";
$templateParams["scripts"] = "<script src='js/create_post.js' type='module'></script>";
$templateParams["page"] = "create_post_page.php";

require_once 'templates/base.php';
