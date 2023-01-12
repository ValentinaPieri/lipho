let offset = 0;
let limit = 10;
getFeedPosts(offset, limit);

function getFeedPosts(offset, limit) {
    $.post("/lipho/post_requests_handler.php", { getFeedPosts: true, offset: offset, limit: limit }, function (posts) {
        let postDiv;
        const mainTag = document.querySelector("main");
        posts.forEach(post => {
            postDiv = getPostContainer(post.post.post_id, post.post.username, post.post.caption, post.post.images, post.post.likes, post.post.comments, post.post.avg_exposure_rating, post.post.avg_colors_rating, post.post.avg_composition_rating, post.liked);
            mainTag.appendChild(postDiv);
            setInterval(function () {
                $.post("/lipho/post_requests_handler.php", { getPostLikesNumber: true, post_id: post.post.post_id }, function (likesNumber) {
                    let likesNumberTag = document.getElementById("likes-number" + post.post.post_id);
                    likesNumberTag.textContent = likesNumber;
                }, "json");

                let postCommentsDiv = document.getElementById("post-comments" + post.post.post_id);
                if (!postCommentsDiv.hidden) {
                    $.post("/lipho/post_requests_handler.php", { getPostComments: true, post_id: post.post.post_id }, function (comments) {
                        getCommentsContainer(postCommentsDiv, comments);
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