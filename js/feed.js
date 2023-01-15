let offset = 0;
let limit = 10;
getFeedPosts(offset, limit);

function getFeedPosts(offset, limit) {
    $.post("./post_requests_handler.php", { getFeedPosts: true, offset: offset, limit: limit }, function (result) {
        let postDiv;
        const mainTag = document.querySelector("main");
        result.posts.forEach(post => {
            postDiv = getPostContainer(post.post_id, post.owner, post.caption, post.liked, post.rated);
            mainTag.appendChild(postDiv);
            retrieveImages(post.post_id);
            retrieveLikesNumber(post.post_id);
            retrieveComments(post.post_id, result.currentUsername);
            setInterval(function () {
                retrieveLikesNumber(post.post_id);
                retrieveComments(post.post_id, result.currentUsername);
            }, 5000);
        });
    }, "json");
}

function retrieveImages(postId) {
    $.post("./post_requests_handler.php", { getPostImages: true, post_id: postId }, function (images) {
        let postImagesDiv = document.getElementById("post-images" + postId);
        images.forEach(image => {
            if (images.length > 1) {
                let indexDiv = document.createElement("div");
                indexDiv.className = "slide-index";
                indexDiv.id = "slide-index" + postId;
                let indexParagraph = document.createElement("p");
                indexParagraph.id = "index" + postId;
                indexParagraph.textContent = "1/" + images.length;
                indexDiv.appendChild(indexParagraph);
                postImagesDiv.appendChild(indexDiv);
            }

            for (let i = 0; i < images.length; i++) {
                let postImageSlide = document.createElement("img");
                postImageSlide.className = "post-image-slide";
                postImageSlide.id = "post-image-slide" + postId + i;
                postImageSlide.src = "data:image/jpeg;base64," + images[i];
                postImageSlide.alt = "Post image " + i;
                postImageSlide.hidden = i != 0;
                postImagesDiv.appendChild(postImageSlide);
            }

            if (images.length > 1) {
                let arrowButtonsDiv = document.createElement("div");
                arrowButtonsDiv.className = "arrow-buttons-div";
                let leftArrowButton = document.createElement("button");
                leftArrowButton.className = "post-button arrow-button";
                leftArrowButton.id = "previous-slide-button" + postId;
                leftArrowButton.type = "button";
                let leftArrowButtonIcon = document.createElement("span");
                leftArrowButtonIcon.className = "fa-regular fa-arrow-left";
                leftArrowButton.appendChild(leftArrowButtonIcon);
                leftArrowButton.onclick = function () {
                    showSlideLeft(postId);
                };
                let rightArrowButton = document.createElement("button");
                rightArrowButton.className = "post-button arrow-button";
                rightArrowButton.id = "next-slide-button" + postId;
                rightArrowButton.type = "button";
                let rightArrowButtonIcon = document.createElement("span");
                rightArrowButtonIcon.className = "fa-regular fa-arrow-right";
                rightArrowButton.appendChild(rightArrowButtonIcon);

                rightArrowButton.onclick = function () {
                    showSlideRight(postId);
                };
                arrowButtonsDiv.appendChild(leftArrowButton);
                arrowButtonsDiv.appendChild(rightArrowButton);
                postImagesDiv.appendChild(arrowButtonsDiv);
            }
        });
    }, "json");
}

function retrieveLikesNumber(postId) {
    $.post("./post_requests_handler.php", { getPostLikesNumber: true, post_id: postId }, function (likesNumber) {
        let likesNumberTag = document.getElementById("likes-number" + postId);
        likesNumberTag.textContent = likesNumber;
    }, "json");
}

function retrieveComments(postId, currentUsername) {
    let postCommentsDiv = document.getElementById("post-comments" + postId);
    if (!postCommentsDiv.hidden) {
        $.post("./post_requests_handler.php", { getPostComments: true, post_id: postId }, function (comments) {
            getCommentsContainer(postId, postCommentsDiv, comments, currentUsername);
        }, "json");
    }
}

window.onscroll = function () {
    if (window.innerHeight + window.pageYOffset >= document.body.offsetHeight) {
        offset += limit;
        getFeedPosts(offset, limit);
    }
};
