<div id="edit-profile" class="edit-profile"></div>
<div id='profile-header' class="profile-header">
    <div id="profile-details" class="profile-details">
        <div id='profile-image' class="profile-image">
            <img id='profile-image' src='resources/images/blank_profile_picture.jpeg' alt='profile image'>
        </div>
        <div id='profile-data' class="profile-data">
            <p id='username' class='username'></p>
            <div class="profile-name">
                <p id='name'></p>
                <p id='surname'></p>
            </div>
        </div>
        <div class="profile-specs">
            <div id='profile-stats' class="profile-stats">
                <p><span id='posts' class="stat"></span> posts</p>
                <p><span id='followers' class="stat"></span> followers</p>
                <p><span id='following' class="stat"></span> following</p>
                <p><button id='follow-unfollow-button' class="text-button"></button>
            </div>
            <div id="profile-insights" class="profile-insights">
                <div class="insight-icon">
                    <span class="fa-regular fa-chart-simple"></span>
                    <span class="insights-header">Insights</span>
                </div>
                <span>Post frequency: <span id='post-frequency'></span></span>
                <span>Average post rating: </span>
                <div class="rating-values">
                    <span>- Exposure: <span id='exposure'></span></span>
                    <span>- Colors: <span id='colors'></span></span>
                    <span>- Composition: <span id='composition'></span></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="display-mode-buttons" class="display-mode-buttons">
    <button id="grid-button" class="icon-button"><span class="fa-solid fa-grid"></span></button>
    <button id="list-button" class="icon-button"><span class="fa-regular fa-bars"></span></button>
</div>
<div id='profile-posts' class="profile-posts grid"></div>
