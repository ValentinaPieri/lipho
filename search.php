<?php
$templateParams["title"] = "Search";

$templateParams["scripts"] = "
    <script src=\"js/search.js\"></script>
";

$templateParams["page"] = "
    <div class=\"search-container\">
        <input type=\"text\" id=\"search-input\" placeholder=\"Search\">
    </div>
    <div id=\"search-results-container\">
    </div>
";

require_once 'templates/base.php';
