let searchInput = document.getElementById("search-input");
searchInput.addEventListener("input", function () {
    getMatchingUsers(searchInput.value);
});

function getMatchingUsers(username) {
    $.post("./post_requests_handler.php", { getMatchingUsers: true, username: username }, function (users) {
        const searchResultsContainer = document.getElementById("search-results-container");
        searchResultsContainer.innerHTML = "";

        if (users != "") {

            const resultsCount = document.createElement("p");
            resultsCount.classList.add("results-count");
            resultsCount.innerText = "Total results: " + users.length;
            searchResultsContainer.appendChild(resultsCount);

            users.forEach(user => {
                const userContainer = document.createElement("div");
                userContainer.classList.add("user-container");

                const userImage = document.createElement("img");
                userImage.classList.add("user-image");
                if (user.profile_image != null) {
                    userImage.src = "data:image/jpeg;base64," + user.profile_image;
                } else {
                    userImage.src = "resources/images/blank_profile_picture.jpeg";
                }

                const userLink = document.createElement("a");
                userLink.classList.add("user-link");
                userLink.href = "profile.php?username=" + user.username;
                userLink.innerText = user.username;

                userContainer.appendChild(userImage);
                userContainer.appendChild(userLink);

                searchResultsContainer.appendChild(userContainer);
            });
        }
    }, "json");
}
