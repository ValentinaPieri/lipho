let postImageNum = 0;

function displayPostImages(src, imageIndex) {
    document.getElementById("post-images").innerHTML += "<img class='post-image-slide' id='post image" + imageIndex + "' src='data:image/jpeg;base64," + src + "' alt='Post image " + imageIndex + "'></img>";
    postImageNum++;
}

function displayPostImageNumber(imageIndex, totalImagesNumber) {
    document.getElementById("slide-index").innerHTML = "<p></p><p>" + ++imageIndex + "/" + totalImagesNumber + "</p>";
}

function displayPostImagesButtons() {
    if (postImageNum > 1) {
        document.getElementById("post-images").innerHTML += "<button class='post-button' id='previous-slide-button' type='button'><span class='fa-regular fa-arrow-left'></span></button>";
        document.getElementById("post-images").innerHTML += "<button class='post-button' id='next-slide-button' type='button'><span class='fa-regular fa-arrow-right'></span></button>";
    }
    document.getElementById("post-images").innerHTML += "<button class='post-button' id='full-screen-button' type='button'><span class='fa-regular fa-expand'></span></button>";
    document.getElementById("post-images").innerHTML += "<button class='post-button' id='like-button' type='button'><span class='fa-regular fa-heart'></span></button>";
    document.getElementById("post-images").innerHTML += "<button class='post-button' id='comment-button' type='button'><span class='fa-regular fa-comment-dots'></span></button>";
    document.getElementById("post-images").innerHTML += "<button class='post-button' id='rating-button' type='button'><span class='fa-regular fa-square-star'></span></button>";
}