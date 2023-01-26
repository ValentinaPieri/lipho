<?php

require_once 'app/check_session.php';

$templateParams["title"] = "Search";

$templateParams["scripts"] = "
    <script src=\"js/search.js\"></script>
";

$templateParams["page"] = "search_page.php";

require_once 'templates/base.php';
