<?php
if (isset($templateParams["post"])) {
    $POST_TEMPLATE = "
        <div class=\"post\">
            <div class=\"post-images\" id=\"post-images\">
                <div class=slide-index id=\"slide-index\"></div>
    ";

    $postImagesNum = count($templateParams["post"]["images"]);
    $POST_TEMPLATE .= "
        <script>
    ";
    for ($i = 0; $i < $postImagesNum; $i++) {
        $src = base64_encode($templateParams["post"]["images"][$i]);
        $POST_TEMPLATE .= "
            displayPostImages(\"" . $src . "\", " . $i . ");
        ";
    }
    if ($postImagesNum != 1) {
        $POST_TEMPLATE .= "
            showSlide(1);
        ";
    }
    $POST_TEMPLATE .= "
        displayPostImagesButtons(" . $templateParams["post"]["post_id"] . ");</script>
    ";

    $POST_TEMPLATE .= " 
        </div>
        <div class=\"post-comments\" id=\"post-comments\">
        </div>
    ";

    $POST_TEMPLATE .= "
        <script>showPostCommentSection(" . $templateParams["post"]["post_id"] . ");</script>
    ";
    foreach ($templateParams["post"]["comments"] as $comment) {
        $POST_TEMPLATE .= "
            <p class=\"comment-username\">" . $comment->getUsername() . "</p>
            <p class=\"comment-text\">" . $comment->getText() . "</p>
            <button id=\"reply-button\" type=\"button\">Reply</button>
        ";
    }

    $POST_TEMPLATE .= "
            <div class=\"post-rating\" id=\"post-rating\">
                <script>showPostRatingSection();</script>
            </div>
            <div class=\"post-caption\">
                <p class=\"caption-username\">" . $templateParams["post"]["username"] . "</p>
                <p class=\"caption-text\">" . $templateParams["post"]["caption"] . "</p>
            </div>
        </div>
    ";
}
