<div class="post">
    <div class="post-image">
        <img src="data:image/jpeg;base64,<?php if (isset($templateParams["post"])) echo $templateParams["post"]["images"][0]; ?>" alt="Post image 0"></img>
        <button id="full-screen-button" type="button"><span class="fa-regular fa-expand"></span></button>
        <button id="like-button" type="button"><span class="fa-regular fa-heart"></span></button>
        <button id="comment-button" type="button"><span class="fa-regular fa-comment-dots"></span></button>
        <button id="rating-button" type="button"><span class="fa-regular fa-square-star"></span></button>
    </div>
    <div class="post-comments">
        <form>
            <input title="comment text input area" aria-label="comment text input area" type="text" placeholder="Type here your comment">
            <button id="submit-comment-button" type="submit"><span class="fa-regular fa-paper-plane-top"></span></button>
        </form>
        <?php
        if (isset($templateParams["post"])) {
            foreach ($templateParams["post"]["comments"] as $comment) {
                echo "<p class='comment-username'>" . $comment["username"] . "</p>";
                echo "<p class='comment-text'>" . $comment["text"] . "</p>";
                echo "<button id='reply-button' type='button'>Reply</button>";
            }
        }
        ?>
    </div>
    <div class="post-rating">
        <form>
            <label for="exposure-rating">Exposure</label>
            <input id="exposure-rating" type="range" min="0" max="5" value="5">
            <label for="color-rating">Color</label>
            <input id="color-rating" type="range" min="0" max="5" value="5">
            <label for="composition-rating">Composition</label>
            <input id="composition-rating" type="range" min="0" max="5" value="5">
            <button type="submit">Rate</button>
        </form>
    </div>
    <div class="post-caption">
        <?php
        if (isset($templateParams["post"])) {
            echo "<p class='caption-username'>" . $templateParams["post"]["username"] . "</p>";
            echo "<p class='caption-text'>" . $templateParams["post"]["caption"] . "</p>";
        }
        ?>
    </div>
</div>