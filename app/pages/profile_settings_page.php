<form id="edit-profile-form" action="">
    <div class="save-button">
        <button id="save-button" type="submit">Save</button>
    </div>
    <div class="image-settings" id="image-settings">
        <label for="change-profile-image">Edit profile image</label>
        <div id="image-container">
            <img id="change-profile-image" src="./resources/images/blank_profile_picture.jpeg" alt="Current profile image" />
        </div>
        <p class="image-size-disclaimer">max image size:<br />15 MB</p>
    </div>
    <div class="form-settings">
        <div class="input-field">
            <label for="edit-username">Edit username</label>
            <input id="edit-username" name="username" type="text" />
        </div>
        <div class="input-field">
            <label for="edit-password">Edit password</label>
            <input id="edit-password" name="password" type="password" />
        </div>
        <div class="input-field">
            <label for="edit-name">Edit name</label>
            <input id="edit-name" name="name" type="text" />
        </div>
        <div class="input-field">
            <label for="edit-surname">Edit surname</label>
            <input id="edit-surname" name="surname" type="text" />
        </div>
        <div class="input-field">
            <label for="edit-email">Edit email</label>
            <input id="edit-email" name="email" type="email" />
        </div>
        <div class="input-field">
            <label for="edit-phone-number">Edit phone number</label>
            <input id="edit-phone-number" name="phone" type="tel" />
        </div>
        <div class="input-field">
            <label for="edit-birthdate">Edit birthdate</label>
            <input id="edit-birthdate" name="birthdate" type="date" />
        </div>
        <div class="input-field logout-delete">
            <button type="button" id="logout-button" class="text-button">Log out</button>
            <span class="fa-regular fa-arrow-right-from-bracket"></span>
        </div>
        <div class="input-field logout-delete">
            <button type="button" class="text-button delete-account" id="delete-account-button">Delete account</button>
            <span class="fa-regular fa-trash-xmark"></span>
        </div>
    </div>
</form>
