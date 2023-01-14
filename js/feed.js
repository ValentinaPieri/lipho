let offset = 0;
let limit = 10;
getFeedPosts(offset, limit);

function getFeedPosts(offset, limit) {
    $.post("./post_requests_handler.php", { getFeedPosts: true, offset: offset, limit: limit }, function (result) {
        let postDiv;
        const mainTag = document.querySelector("main");
        result.posts.forEach(post => {
            postDiv = getPostContainer(post.post_id, post.username, post.caption, post.images, post.comments, post.liked, post.rated, result.currentUsername);
            mainTag.appendChild(postDiv);
            setInterval(function () {
                $.post("./post_requests_handler.php", { getPostLikesNumber: true, post_id: post.post_id }, function (likesNumber) {
                    let likesNumberTag = document.getElementById("likes-number" + post.post_id);
                    likesNumberTag.textContent = likesNumber;
                }, "json");

                let postCommentsDiv = document.getElementById("post-comments" + post.post_id);
                if (!postCommentsDiv.hidden) {
                    $.post("./post_requests_handler.php", { getPostComments: true, post_id: post.post_id }, function (comments) {
                        getCommentsContainer(post.post_id, postCommentsDiv, comments, result.currentUsername);
                    }, "json");
                }
            }, 1000);
        });
    }, "json");
}

window.addEventListener("scroll", function () {
    if (window.innerHeight + window.pageYOffset >= document.body.offsetHeight) {
        offset += limit;
        getFeedPosts(offset, limit);
    }
});
