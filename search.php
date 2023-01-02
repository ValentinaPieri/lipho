<?php
$templateParams["title"] = "Search";

$templateParams["scripts"] = "
    <script src=\"https://code.jquery.com/jquery-3.5.0.js\"></script>
    <script src=\"js/search.js\"></script>
";

$templateParams["page"] = "
    <div class=\"search-container\">
        <input type=\"text\" id=\"search-input\" placeholder=\"Search\">
        <button type=\"button\" id=\"search-button\" onClick=\"getMatchingUsers(document.getElementById('search-input').value)\">
            <span class=\"fa-regular fa-magnifying-glass\"></span>
        </button>
    </div>
    <div id=\"search-results-container\">
    </div>
";

require_once 'templates/base.php';
