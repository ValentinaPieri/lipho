<script src="js/posts.js"></script>

<div class="post">
    <div class="post-images" id="post-images">
        <div class=slide-index id="slide-index"></div>
        <?php
        if (isset($templateParams["post"]["images"])) {
            $postImagesNum = count($templateParams["post"]["images"]);
            for ($i = 0; $i < $postImagesNum; $i++) {
                echo '<script>';
                echo 'i = "' . $i . '";';
                echo '</script>';
                $src = base64_encode($templateParams['post']['images'][$i]);
                echo '<script>';
                echo 'src = "' . $src . '";';
                echo 'displayPostImages(src, i);';
                echo '</script>';
            }
            echo '<script>displayPostImagesButtons()</script>';
        }
        ?>
    </div>
    <div class="post-comments">
        <form>
            <input class="post-comment-input" title="comment text input area" aria-label="comment text input area" type="text" placeholder="Type here your comment">
            <button class="post-button" id="submit-comment-button" type="submit"><span class="fa-regular fa-paper-plane-top"></span></button>
        </form>
        <?php
        if (isset($templateParams["post"])) {
            foreach ($templateParams["post"]["comments"] as $comment) {
                echo "<p class='comment-username'>" . $comment->getUsername() . "</p>";
                echo "<p class='comment-text'>" . $comment->getText() . "</p>";
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