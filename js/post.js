let currentSlide = 0;

function getPostContainer(postId, username, caption, images, likes, comments, average_exposure_rating, average_colors_rating, average_composition_rating, liked) {
    let postDiv = document.createElement("div");
    postDiv.className = "post";
    postDiv.id = "post" + postId;

    let postImagesDiv = document.createElement("div");
    postImagesDiv.className = "post-images";
    postImagesDiv.id = "post-images" + postId;

    if (images.length > 1) {
        let indexDiv = document.createElement("div");
        indexDiv.className = "slide-index";
        indexDiv.id = "slide-index" + postId;
        let indexParagraph = document.createElement("p");
        indexParagraph.className = "slide-index";
        indexParagraph.id = "index" + postId;
        indexParagraph.textContent = "1/" + images.length;
        indexDiv.appendChild(indexParagraph);
        postImagesDiv.appendChild(indexDiv);
    }

    for (let i = 0; i < images.length; i++) {
        let postImageSlide = document.createElement("img");
        postImageSlide.className = "post-image-slide";
        postImageSlide.id = "post-image-slide" + i;
        postImageSlide.src = "data:image/jpeg;base64," + images[i];
        postImageSlide.alt = "Post image " + i;
        postImageSlide.hidden = i != 0;
        postImagesDiv.appendChild(postImageSlide);
    }

    if (images.length > 1) {
        let leftArrowButton = document.createElement("button");
        leftArrowButton.className = "post-button";
        leftArrowButton.id = "previous-slide-button" + postId;
        leftArrowButton.type = "button";
        let leftArrowButtonIcon = document.createElement("span");
        leftArrowButtonIcon.className = "fa-regular fa-arrow-left";
        leftArrowButton.appendChild(leftArrowButtonIcon);
        leftArrowButton.addEventListener("click", function () {
            showSlideLeft(postId);
        });
        let rightArrowButton = document.createElement("button");
        rightArrowButton.className = "post-button";
        rightArrowButton.id = "next-slide-button" + postId;
        rightArrowButton.type = "button";
        let rightArrowButtonIcon = document.createElement("span");
        rightArrowButtonIcon.className = "fa-regular fa-arrow-right";
        rightArrowButton.appendChild(rightArrowButtonIcon);

        rightArrowButton.addEventListener("click", function () {
            showSlideRight(postId);
        });
        postImagesDiv.appendChild(leftArrowButton);
        postImagesDiv.appendChild(rightArrowButton);
    }

    let fullScreenButton = document.createElement("button");
    fullScreenButton.className = "post-button";
    fullScreenButton.id = "full-screen-button" + postId;
    fullScreenButton.type = "button";
    let fullScreenButtonIcon = document.createElement("span");
    fullScreenButtonIcon.className = "fa-regular fa-expand";
    fullScreenButton.appendChild(fullScreenButtonIcon);
    fullScreenButton.addEventListener("click", function () {
        fullScreenImage(postId);
    });

    let likeButton = document.createElement("button");
    likeButton.className = "post-button";
    likeButton.id = "like-button" + postId;
    likeButton.type = "button";
    let likeButtonIcon = document.createElement("span");
    if (liked) {
        likeButtonIcon.className = "fa-solid fa-heart";
        likeButton.addEventListener("click", function () {
            unlikePost(postId);
        });
    } else {
        likeButtonIcon.className = "fa-regular fa-heart";
        likeButton.addEventListener("click", function () {
            likePost(postId);
        });
    }
    likeButton.appendChild(likeButtonIcon);

    let likeNumber = document.createElement("p");
    likeNumber.className = "likes-number";
    likeNumber.id = "likes-number" + postId;
    likeNumber.textContent = likes.length;
    let commentButton = document.createElement("button");
    commentButton.className = "post-button";
    commentButton.id = "comment-button" + postId;
    commentButton.type = "button";
    let commentButtonIcon = document.createElement("span");
    commentButtonIcon.className = "fa-regular fa-comment-dots";
    commentButton.appendChild(commentButtonIcon);
    commentButton.addEventListener("click", function () {
        showCommentsDiv(postId);
    });
    let ratingButton = document.createElement("button");
    ratingButton.className = "post-button";
    ratingButton.id = "rating-button" + postId;
    ratingButton.type = "button";
    let ratingButtonIcon = document.createElement("span");
    ratingButtonIcon.className = "fa-regular fa-square-star";
    ratingButton.appendChild(ratingButtonIcon);
    ratingButton.addEventListener("click", function () {
        showRatingDiv(postId)
    });
    postImagesDiv.appendChild(fullScreenButton);
    postImagesDiv.appendChild(likeButton);
    postImagesDiv.appendChild(likeNumber);
    postImagesDiv.appendChild(commentButton);
    postImagesDiv.appendChild(ratingButton);

    let postInputCommentDiv = document.createElement("div");
    postInputCommentDiv.className = "post-input-comment-div";
    postInputCommentDiv.id = "post-input-comment-div" + postId;
    let commentInput = document.createElement("input");
    commentInput.className = "post-comment-input";
    commentInput.id = "post-comment-input" + postId;
    commentInput.title = "comment text input area";
    commentInput.ariaLabel = "comment text input area";
    commentInput.type = "text";
    commentInput.placeholder = "Type here your comment";
    let submitCommentButton = document.createElement("button");
    submitCommentButton.className = "post-button";
    submitCommentButton.id = "submit-comment-button" + postId;
    submitCommentButton.type = "button";
    let submitCommentButtonIcon = document.createElement("span");
    submitCommentButtonIcon.className = "fa-regular fa-paper-plane-top";
    submitCommentButton.appendChild(submitCommentButtonIcon);
    submitCommentButton.addEventListener("click", function () {
        commentPost(postId, document.getElementById("post-comment-input" + postId).value);
    });
    postInputCommentDiv.appendChild(commentInput);
    postInputCommentDiv.appendChild(submitCommentButton);

    let postCommentsDiv = document.createElement("div");
    postCommentsDiv.className = "post-comments";
    postCommentsDiv.id = "post-comments" + postId;

    getCommentsContainer(postId, postCommentsDiv, comments);

    postInputCommentDiv.hidden = true;
    postCommentsDiv.hidden = true;

    let postRatingDiv = document.createElement("div");
    postRatingDiv.className = "post-rating";
    postRatingDiv.id = "post-rating" + postId;
    let exposureLabel = document.createElement("label");
    exposureLabel.className = "rating-label";
    exposureLabel.for = "exposure-rating" + postId;
    exposureLabel.textContent = "Exposure";
    let exposureRating = document.createElement("input");
    exposureRating.className = "rating-input";
    exposureRating.id = "exposure-rating" + postId;
    exposureRating.type = "range";
    exposureRating.min = 0;
    exposureRating.max = 5;
    exposureRating.value = 5;
    let colorLabel = document.createElement("label");
    colorLabel.className = "rating-label";
    colorLabel.for = "color-rating" + postId;
    colorLabel.textContent = "Color";
    let colorRating = document.createElement("input");
    colorRating.className = "rating-input";
    colorRating.id = "color-rating" + postId;
    colorRating.type = "range";
    colorRating.min = 0;
    colorRating.max = 5;
    colorRating.value = 5;
    let compositionLabel = document.createElement("label");
    compositionLabel.className = "rating-label";
    compositionLabel.for = "composition-rating" + postId;
    compositionLabel.textContent = "Composition";
    let compositionRating = document.createElement("input");
    compositionRating.className = "rating-input";
    compositionRating.id = "composition-rating" + postId;
    compositionRating.type = "range";
    compositionRating.min = 0;
    compositionRating.max = 5;
    compositionRating.value = 5;
    let submitRatingButton = document.createElement("button");
    submitRatingButton.className = "post-button";
    submitRatingButton.id = "submit-rating-button" + postId;
    submitRatingButton.type = "button";
    submitRatingButton.textContent = "Rate";
    submitRatingButton.addEventListener("click", function () {
        ratePost(postId, document.getElementById("exposure-rating" + postId).value, document.getElementById("color-rating" + postId).value, document.getElementById("composition-rating" + postId).value)
    });
    postRatingDiv.appendChild(exposureLabel);
    postRatingDiv.appendChild(exposureRating);
    postRatingDiv.appendChild(colorLabel);
    postRatingDiv.appendChild(colorRating);
    postRatingDiv.appendChild(compositionLabel);
    postRatingDiv.appendChild(compositionRating);
    postRatingDiv.appendChild(submitRatingButton);
    postRatingDiv.hidden = true;

    let postCaptionDiv = document.createElement("div");
    postCaptionDiv.className = "post-caption";
    postCaptionDiv.id = "post-caption" + postId;
    let captionUsername = document.createElement("p");
    captionUsername.className = "caption-username";
    captionUsername.id = "caption-username" + postId;
    captionUsername.textContent = username;
    let captionText = document.createElement("p");
    captionText.className = "caption-text";
    captionText.id = "caption-text" + postId;
    captionText.textContent = caption;
    postCaptionDiv.appendChild(captionUsername);
    postCaptionDiv.appendChild(captionText);

    postDiv.appendChild(postImagesDiv);
    postDiv.appendChild(postInputCommentDiv);
    postDiv.appendChild(postCommentsDiv);
    postDiv.appendChild(postRatingDiv);
    postDiv.appendChild(postCaptionDiv);

    return postDiv;
}

function getCommentsContainer(postId, postCommentsDiv, comments) {
    postCommentsDiv.innerHTML = "";
    for (let i = 0; i < comments.length; i++) {
        let commentUsername = document.createElement("p");
        commentUsername.className = "comment-username";
        commentUsername.id = "post-comment-username" + comments[i].comment_id;
        commentUsername.textContent = comments[i].username;
        let commentText = document.createElement("p");
        commentText.className = "comment-text";
        commentText.id = "post-comment-text" + comments[i].comment_id;
        commentText.textContent = comments[i].text;
        let replyButton = document.createElement("button");
        replyButton.className = "post-button";
        replyButton.id = "reply-button" + comments[i].comment_id;
        replyButton.type = "button";
        replyButton.textContent = "Reply";
        replyButton.addEventListener("click", function () {
            replyToComment(postId, comments[i].comment_id);
        });
        postCommentsDiv.appendChild(commentUsername);
        postCommentsDiv.appendChild(commentText);
        postCommentsDiv.appendChild(replyButton);
    }
}

function displayPostImageNumber(postId, imageIndex, totalImagesNumber) {
    document.getElementById("index" + postId).textContent = "" + ++imageIndex + "/" + totalImagesNumber + "";
}

function showSlideLeft(postId) {
    console.log("left" + postId)
    let slides = document.getElementById("post-images" + postId);
    let slide = slides.getElementsByClassName('post-image-slide');
    if (currentSlide > 0) {
        slide[currentSlide].hidden = true;
        currentSlide--;
        slide[currentSlide].hidden = false;
    } else {
        slide[currentSlide].hidden = true;
        currentSlide = slide.length - 1;
        slide[currentSlide].hidden = false;
    }
    displayPostImageNumber(postId, currentSlide, slide.length)
}

function showSlideRight(postId) {
    console.log("right" + postId)
    let slides = document.getElementById("post-images" + postId);
    let slide = slides.getElementsByClassName('post-image-slide');
    if (currentSlide < slide.length - 1) {
        slide[currentSlide].hidden = true;
        currentSlide++;
        slide[currentSlide].hidden = false;
    } else {
        slide[currentSlide].hidden = true;
        currentSlide = 0;
        slide[currentSlide].hidden = false;
    }
    displayPostImageNumber(postId, currentSlide, slide.length)
}

function likePost(postId) {
    $.post("/lipho/post_requests_handler.php", { postId: postId, likePost: true })
        .done(function () {
            let likeButton = document.getElementById("like-button" + postId);
            let likeButtonIcon = likeButton.getElementsByTagName("span")[0];
            likeButtonIcon.className = "fa-solid fa-heart";
            likeButton.removeEventListener("click", likePost);
            likeButton.addEventListener("click", function () {
                unlikePost(postId);
            });
        });
}

function unlikePost(postId) {
    $.post("/lipho/post_requests_handler.php", { postId: postId, unlikePost: true })
        .done(function () {
            let likeButton = document.getElementById("like-button" + postId);
            let likeButtonIcon = likeButton.getElementsByTagName("span")[0];
            likeButtonIcon.className = "fa-regular fa-heart";
            likeButton.removeEventListener("click", unlikePost);
            likeButton.addEventListener("click", function () {
                likePost(postId);
            });
        });
}

function commentPost(postId, text) {
    $.post("/lipho/post_requests_handler.php", { postId: postId, text: text, commentPost: true })
        .done(function () {
            location.reload();
        });
}

function ratePost(postId, exposure, color, composition) {
    $.post("/lipho/post_requests_handler.php", { postId: postId, exposure: exposure, color: color, composition: composition, ratePost: true })
        .done(function () {
            location.reload();
        });
}

function replyToComment(postId, commentId) {
    document.getElementById("post-comment-input" + postId).value = "@" + document.getElementById("post-comment-username" + commentId).textContent + " ";
}

function showCommentsDiv(postId) {
    if (document.getElementById("post-comments" + postId).hidden == false && document.getElementById("post-input-comment-div" + postId).hidden == false) {
        document.getElementById("post-input-comment-div" + postId).hidden = true;
        document.getElementById("post-comments" + postId).hidden = true;
        let commentButton = document.getElementById("comment-button" + postId);
        let commentButtonIcon = commentButton.getElementsByTagName("span")[0];
        commentButtonIcon.className = "fa-regular fa-comment-dots";
    }
    else {
        document.getElementById("post-input-comment-div" + postId).hidden = false;
        document.getElementById("post-comments" + postId).hidden = false;
        document.getElementById("post-rating" + postId).hidden = true;
        let commentButton = document.getElementById("comment-button" + postId);
        let commentButtonIcon = commentButton.getElementsByTagName("span")[0];
        commentButtonIcon.className = "fa-solid fa-comment-dots";
        let ratingButton = document.getElementById("rating-button" + postId);
        let ratingButtonIcon = ratingButton.getElementsByTagName("span")[0];
        ratingButtonIcon.className = "fa-regular fa-square-star";
    }
}

function showRatingDiv(postId) {
    if (document.getElementById("post-rating" + postId).hidden == false) {
        document.getElementById("post-rating" + postId).hidden = true;
        let ratingButton = document.getElementById("rating-button" + postId);
        let ratingButtonIcon = ratingButton.getElementsByTagName("span")[0];
        ratingButtonIcon.className = "fa-regular fa-square-star";
    }
    else {
        document.getElementById("post-rating" + postId).hidden = false;
        document.getElementById("post-input-comment-div" + postId).hidden = true;
        document.getElementById("post-comments" + postId).hidden = true;
        let commentButton = document.getElementById("comment-button" + postId);
        let commentButtonIcon = commentButton.getElementsByTagName("span")[0];
        commentButtonIcon.className = "fa-regular fa-comment-dots";
        let ratingButton = document.getElementById("rating-button" + postId);
        let ratingButtonIcon = ratingButton.getElementsByTagName("span")[0];
        ratingButtonIcon.className = "fa-solid fa-square-star";
    }
}

function fullScreenImage(postId) {
    let postImagesDiv = document.getElementById("post-images" + postId);
    let postSlides = postImagesDiv.getElementsByTagName("img");
    for (let i = 0; i < postSlides.length; i++) {
        if (!postSlides[i].getAttribute("hidden")) {
            let imgAspectRatio = postSlides[i].naturalWidth / postSlides[i].naturalHeight;
            let screenAspectRatio = window.innerWidth / window.innerHeight;
            if (imgAspectRatio > screenAspectRatio) {
                postSlides[i].style.width = "100vw";
                postSlides[i].style.height = "auto";
            } else {
                postSlides[i].style.height = "100vh";
                postSlides[i].style.width = "auto";
            }
        }
    }
    let fullScreenButton = document.getElementById("full-screen-button" + postId);
    let fullScreenButtonIcon = fullScreenButton.getElementsByTagName("span")[0];
    fullScreenButtonIcon.className = "fa-regular fa-compress";

}