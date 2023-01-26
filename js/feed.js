import { retrieveImages } from "./utils.js";

let offset = 0;
let limit = 10;
let postsNumber = 0;
getFeedPosts(offset, limit);


function getFeedPosts(offset, limit) {
    $.post("./post_requests_handler.php", { getFeedPosts: true, offset: offset, limit: limit }, function (result) {
        let postDiv;
        const homePageDiv = document.getElementById("home-page");
        if (offset === 0) {
            postsNumber = result.posts.length;
        } else {
            postsNumber += result.posts.length;
        }
        result.posts.forEach(post => {
            postDiv = getPostContainer(post.post_id, post.owner, post.caption, post.liked, post.rated);
            homePageDiv.appendChild(postDiv);
            retrieveImages(post.post_id);
            retrieveLikesNumber(post.post_id);
            retrieveComments(post.post_id, result.currentUsername);
            setInterval(function () {
                retrieveLikesNumber(post.post_id);
            }, 1000);
            setInterval(function () {
                retrieveComments(post.post_id, result.currentUsername);
            }, 1000);
        });

        if (postsNumber === 0) {
            homePageDiv.innerHTML = "";
            let noPostsDiv = document.createElement("div");
            noPostsDiv.className = "no-matches-found";
            let noPostsHeader = document.createElement("h2");
            noPostsHeader.textContent = "Nothing to see here... Follow someone first!";
            noPostsHeader.style.textAlign = "center";
            let noPostsIcon = document.createElement("span");
            noPostsIcon.className = "fa-regular fa-face-frown-slight";
            noPostsDiv.appendChild(noPostsHeader);
            noPostsDiv.appendChild(noPostsIcon);
            homePageDiv.appendChild(noPostsDiv);
        }
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
