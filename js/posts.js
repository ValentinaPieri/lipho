let slideIndex = [1, 1];
let postImageNum = 0;

function displayPostImages(src, imageIndex) {
    document.getElementById("post-images").innerHTML += "<img class='post-image-slide' id='post image" + imageIndex + "' src='data:image/jpeg;base64," + src + "' alt='Post image " + imageIndex + "'></img>";
    postImageNum++;
}

function displayPostImageNumber(imageIndex, totalImagesNumber) {
    document.getElementById("slide-index").innerHTML = "<p>" + ++imageIndex + "/" + totalImagesNumber + "</p>";
}

function displayPostImagesButtons(postId) {
    document.getElementById("post-images").innerHTML += "<form id='post-buttons-form' method='post'></form>";
    if (postImageNum > 1) {
        document.getElementById("post-buttons-form").innerHTML += "<button class='post-button' id='previous-slide-button' type='button' onclick='changeSlide(-1)'><span class='fa-regular fa-arrow-left'></span></button>";
        document.getElementById("post-buttons-form").innerHTML += "<button class='post-button' id='next-slide-button' type='button' onclick='changeSlide(1)'><span class='fa-regular fa-arrow-right'></span></button>";
    }
    document.getElementById("post-buttons-form").innerHTML += "<button class='post-button' id='full-screen-button' type='button'><span class='fa-regular fa-expand'></span></button>";
    document.getElementById("post-buttons-form").innerHTML += "<button class='post-button' id='like-button' type='submit' onclick='likePost(" + postId + ")'><span class='fa-regular fa-heart'></span></button>";
    document.getElementById("post-buttons-form").innerHTML += "<button class='post-button' id='comment-button' type='button'><span class='fa-regular fa-comment-dots'></span></button>";
    document.getElementById("post-buttons-form").innerHTML += "<button class='post-button' id='rating-button' type='button'><span class='fa-regular fa-square-star'></span></button>";
}

function showSlide(step) {
    let i;
    let slide = document.getElementsByClassName('post-image-slide');
    if (step > slide.length) { slideIndex[0] = 1 }
    if (step < 1) { slideIndex[0] = slide.length }
    for (i = 0; i < slide.length; i++) {
        slide[i].hidden = true;
    }
    displayPostImageNumber(slideIndex[0] - 1, slide.length);
    slide[slideIndex[0] - 1].hidden = false;
}

function changeSlide(step) {
    showSlide(slideIndex[0] += step);
}

function showPostCommentSection(postId) {
    document.getElementById("post-comments").innerHTML += "<form method='post' id='comments-form'></form>";
    document.getElementById("comments-form").innerHTML += "<input class='post-comment-input' id='post-comment-input' title='comment text input area' aria-label='comment text input area' type='text' placeholder='Type here your comment'>";
    document.getElementById("comments-form").innerHTML += "<button class='post-button' id='submit-comment-button' type='submit' onclick='commentPost(" + postId + ",document.getElementById(\"post-comment-input\").value)'><span class='fa-regular fa-paper-plane-top'></span></button>";
}

function showPostRatingSection() {
    document.getElementById("post-rating").innerHTML += "<form method='post' id='ratings-form'></form>";
    document.getElementById("ratings-form").innerHTML += "<label for='exposure-rating'>Exposure</label>";
    document.getElementById("ratings-form").innerHTML += "<input class='rating-input' id='exposure-rating' type='range' min='0' max='5' value='5'>";
    document.getElementById("ratings-form").innerHTML += "<label for='color-rating'>Color</label>";
    document.getElementById("ratings-form").innerHTML += "<input class='rating-input' id='color-rating' type='range' min='0' max='5' value='5'>";
    document.getElementById("ratings-form").innerHTML += "<label for='composition-rating'>Color</label>";
    document.getElementById("ratings-form").innerHTML += "<input class='rating-input' id='composition-rating' type='range' min='0' max='5' value='5'>";
    document.getElementById("ratings-form").innerHTML += "<button class='rating-submit-button' id='rating-submit-button' type='submit'>Rate</button>";
}

function likePost(postId) {
    $.post("/lipho/post_requests_handler.php", { postId: postId, likePost: true })
        .done(function () {
            location.reload();
        });
}

function commentPost(postId, text) {
    console.log(text)
    $.post("/lipho/post_requests_handler.php", { postId: postId, text: text, commentPost: true })
        .done(function () {
            location.reload();
        });
}