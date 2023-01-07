let currentSlide = 0;
let postImageNum = 0;

function displayPostImageNumber(imageIndex, totalImagesNumber) {
    document.getElementById("slide-index").innerHTML = "<p>" + ++imageIndex + "/" + totalImagesNumber + "</p>";
}

function showSlideLeft() {
    let slide = document.getElementsByClassName('post-image-slide');
    if (currentSlide > 0) {
        slide[currentSlide].hidden = true;
        currentSlide--;
        slide[currentSlide].hidden = false;
    } else {
        slide[currentSlide].hidden = true;
        currentSlide = slide.length - 1;
        slide[currentSlide].hidden = false;
    }
}

function showSlideRight() {
    let slide = document.getElementsByClassName('post-image-slide');
    if (currentSlide < slide.length - 1) {
        slide[currentSlide].hidden = true;
        currentSlide++;
        slide[currentSlide].hidden = false;
    } else {
        slide[currentSlide].hidden = true;
        currentSlide = 0;
        slide[currentSlide].hidden = false;
    }
}

function toggleLikePost(postId) {
    $.post("/lipho/post_requests_handler.php", { postId: postId, toggleLikePost: true })
        .done(function () {
            document.getElementById("like-button").innerHTML = "<span class='fa-solid fa-heart'></span>";
        });
}

function commentPost(postId, text) {
    $.post("/lipho/post_requests_handler.php", { postId: postId, text: text, commentPost: true })
        .done(function () {
            location.reload();
        });
}