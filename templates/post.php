<?php
if (isset($templateParams["post"])) {
    $postImagesNum = count($templateParams["post"]["images"]);
    $POST_TEMPLATE = "
        <div class=\"post\">
            <div class=\"post-images\" id=\"post-images\">
    ";
    if ($postImagesNum > 1) {
        $POST_TEMPLATE .= "
                <div class=\"slide-index\" id=\"slide-index\"><p>1/" . $postImagesNum . "</p></div>
        ";
    }

    $POST_TEMPLATE .= "
        <img class='post-image-slide' id='post-image0' src='data:image/jpeg;base64," . base64_encode($templateParams["post"]["images"][0]) . "' alt='Post image 0'></img>
    ";
    for ($i = 1; $i < $postImagesNum; $i++) {
        $POST_TEMPLATE .= "
            <img class='post-image-slide' id='post-image" . $i . "' src='data:image/jpeg;base64," . base64_encode($templateParams["post"]["images"][$i]) . "' alt='Post image " . $i . "' hidden></img>
        ";
    }

    if ($postImagesNum > 1) {
        $POST_TEMPLATE .= "
            <button class='post-button' id='previous-slide-button' type='button' onclick='showSlideLeft()'><span class='fa-regular fa-arrow-left'></span></button>
            <button class='post-button' id='next-slide-button' type='button' onclick='showSlideRight()'><span class='fa-regular fa-arrow-right'></span></button>
        ";
    }

    $POST_TEMPLATE .= "
            <button class='post-button' id='full-screen-button' type='button'><span class='fa-regular fa-expand'></span></button>
            <button class='post-button' id='like-button' type='button' onclick='likePost(" . $templateParams["post"]["post_id"] . ")'><span class='fa-regular fa-heart'></span></button>
            <button class='post-button' id='comment-button' type='button'><span class='fa-regular fa-comment-dots'></span></button>
            <button class='post-button' id='rating-button' type='button'><span class='fa-regular fa-square-star'></span></button>
        </div>
        <div class=\"post-comments\" id=\"post-comments\">
            <input class='post-comment-input' id='post-comment-input' title='comment text input area' aria-label='comment text input area' type='text' placeholder='Type here your comment'/>
            <button class='post-button' id='submit-comment-button' type='button' onclick='commentPost(" . $templateParams["post"]["post_id"] . ", document.getElementById(\"post-comment-input\").value)'><span class='fa-regular fa-paper-plane-top'></span></button>
        </div>
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
                <label for='exposure-rating'>Exposure</label>
                <input class='rating-input' id='exposure-rating' type='range' min='0' max='5' value='5'>
                <label for='color-rating'>Color</label>
                <input class='rating-input' id='color-rating' type='range' min='0' max='5' value='5'>
                <label for='composition-rating'>Color</label>
                <input class='rating-input' id='composition-rating' type='range' min='0' max='5' value='5'>
                <button class='rating-submit-button' id='rating-submit-button' type='button'>Rate</button>
            </div>
            <div class=\"post-caption\">
                <p class=\"caption-username\">" . $templateParams["post"]["username"] . "</p>
                <p class=\"caption-text\">" . $templateParams["post"]["caption"] . "</p>
            </div>
        </div>
    ";
}
