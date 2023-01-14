<div id="edit-profile" class="edit-profile"></div>
<div id='profile-header' class="profile-header">
    <div id="profile-details" class="profile-details">
        <div id='profile-image' class="profile-image">
            <img id='profile-image' src='resources/images/blank_profile_picture.jpeg' alt='profile image'>
        </div>
        <div id='profile-data' class="profile-data">
            <p id='username' class='username'></p>
            <p id='name'></p>
            <p id='surname'></p>
        </div>
        <div id='profile-stats' class="profile-stats">
            <p><span id='posts' class="stat"></span> posts</p>
            <p><span id='followers' class="stat"></span> followers</p>
            <p><span id='following' class="stat"></span> following</p>
            <p><button id='follow-unfollow-button'></button>
        </div>
    </div>
    <div id="profile-insights" class="profile-insights">
        <span class="fa-regular fa-chart-simple"></span>
        <p> - Insight</p>
        <p>Post frequency: <span id='post-frequency'></span></p>
        <p>Average post rating: </p>
        <div class="rating-values">
            <p>- Exposure: <span id='exposure'></span></p>
            <p>- Colors: <span id='colors'></span></p>
            <p>- Composition: <span id='composition'></span></p>
        </div>
    </div>
</div>
<div id="display-mode-buttons" class="display-mode-buttons">
    <button id="grid-button" class="grid-button"><span class="fa-solid fa-grid"></span></button>
    <button id="list-button" class="list-button"><span class="fa-regular fa-bars"></span></button>
</div>
<div id='profile-posts' class="profile-posts list"></div>
