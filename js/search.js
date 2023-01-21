let searchInput = document.getElementById("search-input");
searchInput.oninput = function () {
    getMatchingUsers(searchInput.value);
};

function getMatchingUsers(username) {
    $.post("./post_requests_handler.php", { getMatchingUsers: true, username: username }, function (users) {
        const searchResultsContainer = document.getElementById("search-results-container");
        searchResultsContainer.innerHTML = "";

        if (users.length > 0) {

            const resultsCount = document.createElement("p");
            resultsCount.classList.add("results-count");
            resultsCount.innerText = "Total results: " + users.length;
            searchResultsContainer.appendChild(resultsCount);

            users.forEach(user => {
                const userContainer = document.createElement("div");
                userContainer.classList.add("user-container");

                const userImage = document.createElement("img");
                userImage.classList.add("user-image");
                userImage.alt = user.username + " profile picture";
                if (user.profile_image != null) {
                    userImage.src = "data:image/jpeg;base64," + user.profile_image;
                } else {
                    userImage.src = "resources/images/blank_profile_picture.jpeg";
                }

                const userLink = document.createElement("a");
                userLink.className = "profile-link";
                userLink.href = "profile.php?username=" + user.username;
                userLink.innerText = user.username;

                userContainer.appendChild(userImage);
                userContainer.appendChild(userLink);

                searchResultsContainer.appendChild(userContainer);
            });
        } else {
            let noMatchesDiv = document.createElement("div");
            noMatchesDiv.className = "no-matches-found";
            let noMatchesHeader = document.createElement("h2");
            noMatchesHeader.textContent = "No matches found";
            let noMatchesIcon = document.createElement("span");
            noMatchesIcon.className = "fa-regular fa-face-frown-slight";
            noMatchesDiv.appendChild(noMatchesHeader);
            noMatchesDiv.appendChild(noMatchesIcon);
            searchResultsContainer.appendChild(noMatchesDiv);
        }
    }, "json");
}
