<?php
require_once 'app/models/Post.php';
require_once 'app/DBConnection.php';

use App\Models\Post;
use App\DBConnection;

$templateParams["title"] = "Home";

$templateParams["scripts"] = "
    <script src=\"https://code.jquery.com/jquery-3.5.0.js\"></script>
    <script src=\"js/feed.js\"></script>
    <script src=\"js/post.js\"></script>
";

$templateParams["page"] = "";

require_once 'templates/base.php';
