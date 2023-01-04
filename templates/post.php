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
            if ($postImagesNum != 1) {
                echo '<script>showSlide(1)</script>';
            }
            echo '<script>displayPostImagesButtons()</script>';
        }
        ?>
    </div>
    <div class="post-comments" id="post-comments">
        <?php
        if (isset($templateParams["post"])) {
            echo '<script>showPostCommentSection()</script>';
            foreach ($templateParams["post"]["comments"] as $comment) {
                echo "<p class='comment-username'>" . $comment->getUsername() . "</p>";
                echo "<p class='comment-text'>" . $comment->getText() . "</p>";
                echo "<button id='reply-button' type='button'>Reply</button>";
            }
        }
        ?>
    </div>
    <div class="post-rating" id="post-rating">
        <?php echo "<script>showPostRatingSection();</script>"; ?>
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