import retrieveImages from "./utils.js";

const followUnfollowButton = document.getElementById("follow-unfollow-button");
const profileImage = document.getElementById("profile-image").querySelector("img");
const postFrequencyDiv = document.getElementById("post-frequency");
const showPostsGridButton = document.getElementById("grid-button");
const showPostsListButton = document.getElementById("list-button");
const profilePosts = document.getElementById("profile-posts");

let limit = 20;
let offset = 0;
let listActive = false;
let gridActive = true;
let intervalIds = [];
let firstLoad = false;

let url = new URL(window.location.href);
let username = url.searchParams.get("username");
let currentUsername = null;
showProfile();

showPostsGridButton.onclick = function () {
  if (!gridActive) {
    firstLoad = false;
    gridActive = true;
    listActive = false;
    showPostsListButton.querySelector("span").classList.remove("fa-solid");
    showPostsListButton.querySelector("span").classList.add("fa-regular");
    showPostsGridButton.querySelector("span").classList.remove("fa-regular");
    showPostsGridButton.querySelector("span").classList.add("fa-solid");
    profilePosts.classList.remove("list");
    profilePosts.classList.add("grid");
    intervalIds.forEach(id => clearInterval(id));
    intervalIds = [];
    profilePosts.innerHTML = "";
    offset = 0;
    limit = 20;
    showPostsGrid(offset, limit);
  }
};

showPostsListButton.onclick = function () {
  if (!listActive) {
    firstLoad = false;
    listActive = true;
    gridActive = false;
    showPostsGridButton.querySelector("span").classList.remove("fa-solid");
    showPostsGridButton.querySelector("span").classList.add("fa-regular");
    showPostsListButton.querySelector("span").classList.remove("fa-regular");
    showPostsListButton.querySelector("span").classList.add("fa-solid");
    profilePosts.classList.remove("grid");
    profilePosts.classList.add("list");
    profilePosts.innerHTML = "";
    offset = 0;
    limit = 10;
    showPostsList(offset, limit);
  }
};

function showProfile() {
  $.post("./post_requests_handler.php", { getProfileData: true, username: username }, function (result) {
    currentUsername = result.currentUsername;
    if (username === null) {
      username = currentUsername;
    }

    showPostsGrid(offset, limit);

    if (currentUsername === username) {
      followUnfollowButton.remove();
      let editProfileDiv = document.getElementById("edit-profile");
      let editProfileLink = document.createElement("a");
      editProfileLink.className = "profile-link";
      editProfileLink.href = "./profile_settings.php";
      let editProfileButton = document.createElement("span");
      editProfileButton.className = "fa-regular fa-gear";
      editProfileLink.appendChild(editProfileButton);
      editProfileDiv.appendChild(editProfileLink);
    } else {
      if (result.profileData.isFollowing) {
        followUnfollowButton.textContent = "Unfollow";
        followUnfollowButton.onclick = unfollow;
      } else {
        followUnfollowButton.textContent = "Follow";
        followUnfollowButton.onclick = follow;
      }
    }

    if (result.profileData.user.profile_image !== null) {
      profileImage.src = "data:image/jpeg;base64," + result.profileData.user.profile_image;
    }

    let usernameParagrah = document.getElementById("username");
    let namePragraph = document.getElementById("name");
    let surnameParagraph = document.getElementById("surname");
    usernameParagrah.textContent = result.profileData.user.username;
    namePragraph.textContent = result.profileData.user.name;
    surnameParagraph.textContent = result.profileData.user.surname;

    let postsNumber = document.getElementById("posts");
    let followersNumber = document.getElementById("followers");
    let followingNumber = document.getElementById("following");
    postsNumber.textContent = result.profileData.numberPosts;
    followersNumber.textContent = result.profileData.numberFollowers;
    followingNumber.textContent = result.profileData.numberFollowings;

    let exposureValue = document.getElementById("exposure");
    let colorsValue = document.getElementById("colors");
    let compositionValue = document.getElementById("composition");

    showPostFrequencyText(result.profileData.postFrequency);
    exposureValue.textContent = result.profileData.averageRating.average_exposure_rating;
    colorsValue.textContent = result.profileData.averageRating.average_colors_rating;
    compositionValue.textContent = result.profileData.averageRating.average_composition_rating;
  }, "json");
}

function getPostFirstImage(postId) {
  $.post("./post_requests_handler.php", { getPostFirstImage: true, postId: postId }, function (image) {
    console.log(image);
    let postImage = document.getElementById("post-image" + postId);
    postImage.src = "data:image/jpeg;base64," + image;
  }, "json");
}

function follow() {
  $.post("./post_requests_handler.php", { follow: true, username: username });
  followUnfollowButton.textContent = "Unfollow";
  followUnfollowButton.onclick = unfollow;
}

function unfollow() {
  $.post("./post_requests_handler.php", { unfollow: true, username: username });
  followUnfollowButton.textContent = "Follow";
  followUnfollowButton.onclick = follow;
}

function showPostFrequencyText(postFrequency) {
  if (postFrequency >= 30) {
    postFrequencyDiv.textContent = "daily";
  } else if (postFrequency >= 4) {
    postFrequencyDiv.textContent = "weekly";
  } else if (postFrequency >= 1) {
    postFrequencyDiv.textContent = "monthly";
  } else if (postFrequency === 0) {
    postFrequencyDiv.textContent = "rarely";
  }
}

function showPostsList(offset, limit) {
  $.post("./post_requests_handler.php", { getProfilePosts: true, username: username, offset: offset, limit: limit }, function (posts) {
    posts.forEach(post => {
      profilePosts.appendChild(getPostContainer(post.post_id, post.owner, post.caption, post.liked, post.rated));
      retrieveImages(post.post_id);

      intervalIds.push(setInterval(function () {
        $.post("./post_requests_handler.php", { getPostLikesNumber: true, postId: post.post_id }, function (likesNumber) {
          let likesNumberTag = document.getElementById("likes-number" + post.post_id);
          if (likesNumberTag !== null) {
            likesNumberTag.textContent = likesNumber;
          }
        }, "json");

        let postCommentsDiv = document.getElementById("post-comments" + post.post_id);
        if (!postCommentsDiv.hidden) {
          $.post("./post_requests_handler.php", { getPostComments: true, postId: post.post_id }, function (comments) {
            getCommentsContainer(post.post_id, postCommentsDiv, comments, currentUsername);
          }, "json");
        }
      }, 5000));
    });
    firstLoad = true;
  }, "json");
}

function showPostsGrid(offset, limit) {
  $.post("./post_requests_handler.php", { getProfilePosts: true, username: username, offset: offset, limit: limit }, function (posts) {
    posts.forEach(post => {
      profilePosts.appendChild(getGridViewPostContainer(post.post_id, post.owner));
      getPostFirstImage(post.post_id);
    });
    firstLoad = true;
  }, "json");
}

function getGridViewPostContainer(postId, owner, images) {
  let postContainer = document.createElement("div");
  postContainer.className = "grid-post";
  postContainer.id = "grid-post" + postId;

  let imageDiv = document.createElement("div");
  imageDiv.className = "post-image";
  let postImage = document.createElement("img");
  postImage.id = "post-image" + postId;

  let postOwner = document.createElement("a");
  postOwner.className = "post-owner";
  postOwner.href = "./profile.php?username=" + owner;
  postOwner.textContent = owner;

  let fullScreenButton = document.createElement("button");
  fullScreenButton.className = "icon-button post-button";
  fullScreenButton.id = "full-screen-button" + postId;
  fullScreenButton.type = "button";
  let fullScreenButtonIcon = document.createElement("span");
  fullScreenButtonIcon.className = "fa-regular fa-expand";
  fullScreenButton.appendChild(fullScreenButtonIcon);
  fullScreenButton.onclick = function () {
    fullScreenImageGrid(postId);
  };

  if (owner === currentUsername) {
    let deleteButton = document.createElement("button");
    deleteButton.className = "icon-button post-button";
    deleteButton.id = "delete-button" + postId;
    deleteButton.type = "button";
    let deleteButtonIcon = document.createElement("span");
    deleteButtonIcon.className = "fa-regular fa-trash-alt";
    deleteButton.appendChild(deleteButtonIcon);
    deleteButton.onclick = function () {
      deletePost(postId);
    };
    postContainer.appendChild(deleteButton);
  }

  imageDiv.appendChild(postImage);
  postContainer.appendChild(imageDiv);
  postContainer.appendChild(postOwner);
  postContainer.appendChild(fullScreenButton);

  return postContainer;
}

function fullScreenImageGrid(postId) {
  let image = document.getElementById("post-image" + postId);
  if (image.requestFullscreen) {
    image.requestFullscreen();
  } else if (image.mozRequestFullScreen) {
    /* Firefox */
    image.mozRequestFullScreen();
  } else if (image.webkitRequestFullscreen) {
    /* Chrome, Safari and Opera */
    image.webkitRequestFullscreen();
  } else if (image.msRequestFullscreen) {
    /* IE/Edge */
    image.msRequestFullscreen();
  }
}

function deletePost(postId) {
  $.post("./post_requests_handler.php", { deletePost: true, postId: postId }, function () {
    let postContainer = document.getElementById("grid-post-container" + postId);
    postContainer.remove();
  });
}

window.onscroll = function () {
  if (firstLoad && window.innerHeight + window.pageYOffset >= document.body.offsetHeight) {
    offset += limit;
    if (gridActive) {
      showPostsGrid(offset, limit);
    } else {
      showPostsList(offset, limit);
    }
  }
};
