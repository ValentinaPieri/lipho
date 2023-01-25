import { retrieveImages } from "./utils.js";

let offset = 0;
let limit = 10;
getFeedPosts(offset, limit);

function getFeedPosts(offset, limit) {
    $.post("./post_requests_handler.php", { getFeedPosts: true, offset: offset, limit: limit }, function (result) {
        let postDiv;
        const homePageDiv = document.getElementById("home-page");
        result.posts.forEach(post => {
            postDiv = getPostContainer(post.post_id, post.owner, post.caption, post.liked, post.rated);
            homePageDiv.appendChild(postDiv);
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

function retrieveLikesNumber(postId) {
    $.post("./post_requests_handler.php", { getPostLikesNumber: true, postId: postId }, function (likesNumber) {
        let likesNumberTag = document.getElementById("likes-number" + postId);
        likesNumberTag.textContent = likesNumber;
    }, "json");
}

function retrieveComments(postId, currentUsername) {
    let postCommentsDiv = document.getElementById("post-comments" + postId);
    if (!postCommentsDiv.hidden) {
        $.post("./post_requests_handler.php", { getPostComments: true, postId: postId }, function (comments) {
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
