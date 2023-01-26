let postsCurrentSlide = [];

function getPostContainer(postId, owner, caption, liked, rated) {
    postsCurrentSlide[postId] = 0;
    let postDiv = document.createElement("div");
    postDiv.className = "post";
    postDiv.id = "post" + postId;

    let postImagesDiv = document.createElement("div");
    postImagesDiv.className = "post-image-container";
    postImagesDiv.id = "post-image-container" + postId;

    let fullScreenButton = document.createElement("button");
    fullScreenButton.className = "icon-button post-button full-screen-button";
    fullScreenButton.id = "full-screen-button" + postId;
    fullScreenButton.type = "button";
    let fullScreenButtonIcon = document.createElement("span");
    fullScreenButtonIcon.className = "fa-regular fa-expand";
    fullScreenButton.appendChild(fullScreenButtonIcon);
    fullScreenButton.onclick = function () {
        fullScreenImage(postId);
    };

    let buttonsDiv = document.createElement("div");
    buttonsDiv.className = "post-buttons-div";
    let likeButton = document.createElement("button");
    likeButton.className = "icon-button post-button like-button";
    likeButton.id = "like-button" + postId;
    likeButton.type = "button";
    let likeButtonIcon = document.createElement("span");
    if (liked) {
        likeButtonIcon.className = "fa-solid fa-heart";
        likeButton.onclick = function () {
            unlikePost(postId, owner);
        };
    } else {
        likeButtonIcon.className = "fa-regular fa-heart";
        likeButton.onclick = function () {
            likePost(postId, owner);
        };
    }
    let likesNumber = document.createElement("span");
    likesNumber.className = "likes-number";
    likesNumber.id = "likes-number" + postId;
    likesNumber.textContent = 0;
    likeButton.appendChild(likeButtonIcon);

    let commentButton = document.createElement("button");
    commentButton.className = "icon-button post-button comment-button";
    commentButton.id = "comment-button" + postId;
    commentButton.type = "button";
    let commentButtonIcon = document.createElement("span");
    commentButtonIcon.className = "fa-regular fa-comment-dots";
    commentButton.appendChild(commentButtonIcon);
    commentButton.onclick = function () {
        showCommentsDiv(postId);
    };
    let ratingButton;
    if (!rated) {
        ratingButton = document.createElement("button");
        ratingButton.className = "icon-button post-button rating-button";
        ratingButton.id = "rating-button" + postId;
        ratingButton.type = "button";
        let ratingButtonIcon = document.createElement("span");
        ratingButtonIcon.className = "fa-regular fa-square-star";
        ratingButton.appendChild(ratingButtonIcon);
        ratingButton.onclick = function () {
            showRatingDiv(postId)
        };
    }
    postImagesDiv.appendChild(fullScreenButton);
    buttonsDiv.appendChild(likeButton);
    buttonsDiv.appendChild(likesNumber);
    buttonsDiv.appendChild(commentButton);
    if (!rated) {
        buttonsDiv.appendChild(ratingButton);
    } else {
        buttonsDiv.classList.add("no-rating-button");
    }
    postImagesDiv.appendChild(buttonsDiv);

    let postInputCommentDiv = document.createElement("div");
    postInputCommentDiv.className = "post-input-comment-div";
    postInputCommentDiv.id = "post-input-comment-div" + postId;
    postInputCommentDiv.hidden = true;
    postInputCommentDiv.style.display = "none";
    let commentInput = document.createElement("input");
    commentInput.className = "post-comment-input";
    commentInput.id = "post-comment-input" + postId;
    commentInput.title = "comment text input area";
    commentInput.ariaLabel = "comment text input area";
    commentInput.type = "text";
    commentInput.placeholder = "Type here your comment";
    let submitCommentButton = document.createElement("button");
    submitCommentButton.className = "icon-button post-button submit-comment-button";
    submitCommentButton.id = "submit-comment-button" + postId;
    submitCommentButton.type = "button";
    let submitCommentButtonIcon = document.createElement("span");
    submitCommentButtonIcon.className = "fa-regular fa-paper-plane-top";
    submitCommentButton.appendChild(submitCommentButtonIcon);
    submitCommentButton.onclick = function () {
        commentPost(postId, owner, document.getElementById("post-comment-input" + postId).value);
    };
    postInputCommentDiv.appendChild(commentInput);
    postInputCommentDiv.appendChild(submitCommentButton);

    let postCommentsDiv = document.createElement("div");
    postCommentsDiv.className = "post-comments";
    postCommentsDiv.id = "post-comments" + postId;


    postInputCommentDiv.hidden = true;
    postCommentsDiv.hidden = true;

    let postRatingDiv;
    if (!rated) {
        postRatingDiv = document.createElement("div");
        postRatingDiv.className = "post-rating";
        postRatingDiv.id = "post-rating" + postId;
        let exposureRatingDiv = document.createElement("div");
        exposureRatingDiv.className = "rating-div";
        let exposureLabel = document.createElement("label");
        exposureLabel.className = "rating-label";
        exposureLabel.htmlFor = "exposure-rating" + postId;
        exposureLabel.textContent = "Exposure";
        let exposureRating = document.createElement("input");
        exposureRating.className = "rating-input";
        exposureRating.id = "exposure-rating" + postId;
        exposureRating.type = "range";
        exposureRating.min = 0;
        exposureRating.max = 5;
        exposureRating.value = 5;
        exposureRatingDiv.appendChild(exposureLabel);
        exposureRatingDiv.appendChild(exposureRating);
        let colorRatingDiv = document.createElement("div");
        colorRatingDiv.className = "rating-div";
        let colorLabel = document.createElement("label");
        colorLabel.className = "rating-label";
        colorLabel.htmlFor = "colors-rating" + postId;
        colorLabel.textContent = "Color";
        let colorRating = document.createElement("input");
        colorRating.className = "rating-input";
        colorRating.id = "colors-rating" + postId;
        colorRating.type = "range";
        colorRating.min = 0;
        colorRating.max = 5;
        colorRating.value = 5;
        colorRatingDiv.appendChild(colorLabel);
        colorRatingDiv.appendChild(colorRating);
        let compositionRatingDiv = document.createElement("div");
        compositionRatingDiv.className = "rating-div";
        let compositionLabel = document.createElement("label");
        compositionLabel.className = "rating-label";
        compositionLabel.htmlFor = "composition-rating" + postId;
        compositionLabel.textContent = "Composition";
        let compositionRating = document.createElement("input");
        compositionRating.className = "rating-input";
        compositionRating.id = "composition-rating" + postId;
        compositionRating.type = "range";
        compositionRating.min = 0;
        compositionRating.max = 5;
        compositionRating.value = 5;
        compositionRatingDiv.appendChild(compositionLabel);
        compositionRatingDiv.appendChild(compositionRating);
        let submitRatingButton = document.createElement("button");
        submitRatingButton.className = "text-button post-button submit-rating-button";
        submitRatingButton.id = "submit-rating-button" + postId;
        submitRatingButton.type = "button";
        submitRatingButton.textContent = "Rate";
        submitRatingButton.onclick = function () {
            ratePost(postId, owner, parseInt(document.getElementById("exposure-rating" + postId).value), parseInt(document.getElementById("colors-rating" + postId).value), parseInt(document.getElementById("composition-rating" + postId).value));
        };
        postRatingDiv.appendChild(exposureRatingDiv);
        postRatingDiv.appendChild(colorRatingDiv);
        postRatingDiv.appendChild(compositionRatingDiv);
        postRatingDiv.appendChild(submitRatingButton);
        postRatingDiv.hidden = true;
        postRatingDiv.style.display = "none";
    }

    let postCaptionDiv = document.createElement("div");
    postCaptionDiv.className = "post-caption";
    postCaptionDiv.id = "post-caption" + postId;
    let captionUsername = document.createElement("a");
    captionUsername.className = "profile-link caption-username";
    captionUsername.id = "caption-username" + postId;
    captionUsername.title = "caption user link";
    captionUsername.href = "profile.php?username=" + owner;
    captionUsername.textContent = owner;
    let captionText = document.createElement("p");
    captionText.className = "caption-text";
    captionText.id = "caption-text" + postId;
    captionText.textContent = caption;
    postCaptionDiv.appendChild(captionUsername);
    postCaptionDiv.appendChild(captionText);

    postDiv.appendChild(postImagesDiv);
    postDiv.appendChild(postInputCommentDiv);
    postDiv.appendChild(postCommentsDiv);
    if (!rated) {
        postDiv.appendChild(postRatingDiv);
    }
    postDiv.appendChild(postCaptionDiv);

    return postDiv;
}

function getCommentsContainer(postId, postCommentsDiv, comments, currentUsername) {
    postCommentsDiv.innerHTML = "";
    for (let i = 0; i < comments.length; i++) {
        let commentDiv = document.createElement("div");
        commentDiv.className = "comment-div";
        commentDiv.id = "comment-div" + comments[i].comment_id;
        let commentUsername = document.createElement("a");
        commentUsername.className = "profile-link comment-username";
        commentUsername.id = "post-comment-username" + comments[i].comment_id;
        commentUsername.title = "comment user link";
        commentUsername.href = "profile.php?username=" + comments[i].username;
        commentUsername.textContent = comments[i].username;
        convertMentionsToLinks(comments);
        let commentText = document.createElement("p");
        commentText.className = "comment-text";
        commentText.id = "post-comment-text" + comments[i].comment_id;
        commentText.innerHTML = comments[i].text;

        let commentButtonsDiv = document.createElement("div");
        commentButtonsDiv.className = "comment-buttons-div";
        let likeCommentButton = document.createElement("button");
        likeCommentButton.className = "icon-button post-button like-comment-button";
        likeCommentButton.id = "like-comment-button" + comments[i].comment_id;
        likeCommentButton.type = "button";
        let likeCommentIcon = document.createElement("span");
        if (comments[i].liked) {
            likeCommentIcon.className = "fa-solid fa-heart";
            likeCommentButton.onclick = function () {
                unlikeComment(comments[i].comment_id, comments[i].username);
            };
        } else {
            likeCommentIcon.className = "fa-regular fa-heart";
            likeCommentButton.onclick = function () {
                likeComment(comments[i].comment_id, comments[i].username);
            };
        }
        likeCommentButton.appendChild(likeCommentIcon);

        let deleteCommentButton = document.createElement("button");
        if (currentUsername == comments[i].username) {
            deleteCommentButton.className = "post-button delete-comment-button";
            deleteCommentButton.id = "icon-button delete-comment-button" + comments[i].comment_id;
            deleteCommentButton.type = "button";
            let deleteCommentIcon = document.createElement("span");
            deleteCommentIcon.className = "fa-regular fa-trash-can";
            deleteCommentButton.appendChild(deleteCommentIcon);
            deleteCommentButton.onclick = function () {
                uncommentPost(comments[i].comment_id);
            };
        }

        let replyButton = document.createElement("button");
        replyButton.className = "post-button reply-button";
        replyButton.id = "icon-button reply-button" + comments[i].comment_id;
        replyButton.type = "button";
        replyButton.textContent = "Reply";
        replyButton.onclick = function () {
            replyToComment(postId, comments[i].comment_id);
        };

        let commentContentDiv = document.createElement("div");
        commentContentDiv.className = "comment-content-div";
        commentContentDiv.appendChild(commentUsername);
        commentContentDiv.appendChild(commentText);

        if (currentUsername == comments[i].username) {
            commentButtonsDiv.appendChild(deleteCommentButton);
        }
        commentButtonsDiv.appendChild(likeCommentButton);
        commentButtonsDiv.appendChild(replyButton);
        commentDiv.appendChild(commentContentDiv);
        commentDiv.appendChild(commentButtonsDiv);
        postCommentsDiv.appendChild(commentDiv);
    }
}

function convertMentionsToLinks(comments) {
    for (let i = 0; i < comments.length; i++) {
        const comment = comments[i];
        comment.text = comment.text.replace(/@([a-zA-Z0-9]+)/g, function (match, username) {
            return `<a title="mentioned user link" href="profile.php?username=${username}">@${username}</a>`;
        });
    }
}

function displayPostImageNumber(postId, imageIndex, totalImagesNumber) {
    document.getElementById("index" + postId).textContent = "" + ++imageIndex + "/" + totalImagesNumber + "";
}

function showSlideLeft(postId) {
    let slides = document.getElementById("post-image-container" + postId);
    let slide = slides.getElementsByClassName("post-image-slide");
    if (postsCurrentSlide[postId] > 0) {
        slide[postsCurrentSlide[postId]].hidden = true;
        postsCurrentSlide[postId]--;
        slide[postsCurrentSlide[postId]].hidden = false;
    } else {
        slide[postsCurrentSlide[postId]].hidden = true;
        postsCurrentSlide[postId] = slide.length - 1;
        slide[postsCurrentSlide[postId]].hidden = false;
    }
    displayPostImageNumber(postId, postsCurrentSlide[postId], slide.length)
}

function showSlideRight(postId) {
    let slides = document.getElementById("post-image-container" + postId);
    let slide = slides.getElementsByClassName("post-image-slide");
    if (postsCurrentSlide[postId] < slide.length - 1) {
        slide[postsCurrentSlide[postId]].hidden = true;
        postsCurrentSlide[postId]++;
        slide[postsCurrentSlide[postId]].hidden = false;
    } else {
        slide[postsCurrentSlide[postId]].hidden = true;
        postsCurrentSlide[postId] = 0;
        slide[postsCurrentSlide[postId]].hidden = false;
    }
    displayPostImageNumber(postId, postsCurrentSlide[postId], slide.length)
}

function likePost(postId, owner) {
    $.post("./post_requests_handler.php", { postId: postId, owner: owner, likePost: true })
        .done(function () {
            let likeButton = document.getElementById("like-button" + postId);
            let likeButtonIcon = likeButton.getElementsByTagName("span")[0];
            likeButtonIcon.className = "fa-solid fa-heart";
            likeButton.onclick = function () {
                unlikePost(postId, owner);
            };
        });
}

function unlikePost(postId, owner) {
    $.post("./post_requests_handler.php", { postId: postId, unlikePost: true })
        .done(function () {
            let likeButton = document.getElementById("like-button" + postId);
            let likeButtonIcon = likeButton.getElementsByTagName("span")[0];
            likeButtonIcon.className = "fa-regular fa-heart";
            likeButton.onclick = function () {
                likePost(postId, owner);
            };
        });
}

function commentPost(postId, owner, text) {
    $.post("./post_requests_handler.php", { postId: postId, owner: owner, text: text, commentPost: true })
        .done(function () {
            document.getElementById("post-comment-input" + postId).value = "";
        });
}

function uncommentPost(commentId) {
    $.post("./post_requests_handler.php", { commentId: commentId, uncommentPost: true });
}

function likeComment(commentId, owner) {
    $.post("./post_requests_handler.php", { commentId: commentId, owner: owner, likeComment: true })
        .done(function () {
            let likeButton = document.getElementById("like-comment-button" + commentId);
            let likeButtonIcon = likeButton.getElementsByTagName("span")[0];
            likeButtonIcon.className = "fa-solid fa-heart";
            likeButton.onclick = function () {
                unlikeComment(commentId, owner);
            };
        });
}

function unlikeComment(commentId, owner) {
    $.post("./post_requests_handler.php", { commentId: commentId, owner: owner, unlikeComment: true })
        .done(function () {
            let likeButton = document.getElementById("like-comment-button" + commentId);
            let likeButtonIcon = likeButton.getElementsByTagName("span")[0];
            likeButtonIcon.className = "fa-regular fa-heart";
            likeButton.onclick = function () {
                likeComment(commentId, owner);
            };
        });
}

function ratePost(postId, owner, exposure, colors, composition) {
    $.post("./post_requests_handler.php", { postId: postId, owner: owner, exposure: exposure, colors: colors, composition: composition, ratePost: true }).done(function () {
        document.getElementById("post-rating" + postId).remove();
        document.getElementById("rating-button" + postId).remove();
    });
}

function replyToComment(postId, commentId) {
    document.getElementById("post-comment-input" + postId).value = "@" + document.getElementById("post-comment-username" + commentId).textContent + " ";
}

function showCommentsDiv(postId) {
    if (document.getElementById("post-comments" + postId).hidden == false && document.getElementById("post-input-comment-div" + postId).hidden == false) {
        document.getElementById("post-input-comment-div" + postId).hidden = true;
        document.getElementById("post-comments" + postId).hidden = true;
        document.getElementById("post-input-comment-div" + postId).style.display = 'none';
        document.getElementById("post-comments" + postId).style.display = 'none';
        let commentButton = document.getElementById("comment-button" + postId);
        let commentButtonIcon = commentButton.getElementsByTagName("span")[0];
        commentButtonIcon.className = "fa-regular fa-comment-dots";
    }
    else {
        let ratingDiv = document.getElementById("post-rating" + postId);
        document.getElementById("post-input-comment-div" + postId).hidden = false;
        document.getElementById("post-comments" + postId).hidden = false;
        document.getElementById("post-input-comment-div" + postId).style.display = 'flex';
        document.getElementById("post-comments" + postId).style.display = 'grid';
        if (ratingDiv != null) {
            ratingDiv.hidden = true;
            ratingDiv.style.display = 'none';
            let ratingButton = document.getElementById("rating-button" + postId);
            let ratingButtonIcon = ratingButton.getElementsByTagName("span")[0];
            ratingButtonIcon.className = "fa-regular fa-square-star";
        }
        let commentButton = document.getElementById("comment-button" + postId);
        let commentButtonIcon = commentButton.getElementsByTagName("span")[0];
        commentButtonIcon.className = "fa-solid fa-comment-dots";
    }
}

function showRatingDiv(postId) {
    if (document.getElementById("post-rating" + postId).hidden == false) {
        document.getElementById("post-rating" + postId).hidden = true;
        document.getElementById("post-rating" + postId).style.display = 'none';
        let ratingButton = document.getElementById("rating-button" + postId);
        let ratingButtonIcon = ratingButton.getElementsByTagName("span")[0];
        ratingButtonIcon.className = "fa-regular fa-square-star";
    }
    else {
        document.getElementById("post-input-comment-div" + postId).style.display = 'none';
        document.getElementById("post-comments" + postId).style.display = 'none';
        document.getElementById("post-rating" + postId).style.display = 'grid';
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
    let postImagesDiv = document.getElementById("post-image-container" + postId);
    let postSlides = postImagesDiv.getElementsByClassName("post-image-slide");
    for (let i = 0; i < postSlides.length; i++) {
        if (!postSlides[i].style.display == 'none' || !postSlides[i].hidden) {
            if (postSlides[i].requestFullscreen) {
                postSlides[i].requestFullscreen();
            } else if (postSlides[i].mozRequestFullScreen) {
                /* Firefox */
                postSlides[i].mozRequestFullScreen();
            } else if (postSlides[i].webkitRequestFullscreen) {
                /* Chrome, Safari and Opera */
                postSlides[i].webkitRequestFullscreen();
            } else if (postSlides[i].msRequestFullscreen) {
                /* IE/Edge */
                postSlides[i].msRequestFullscreen();
            }
            break;
        }
    }
}
