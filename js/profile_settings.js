import retrieveData from "./retrieve_data.js";
import { showSnackbar } from "./utils.js";

const editProfileForm = document.getElementById("edit-profile-form");
const changeProfileImage = document.getElementById("change-profile-image");
const imageContainer = document.getElementById("image-container");
const editUsername = document.getElementById("edit-username");
const editPassword = document.getElementById("edit-password");
const editName = document.getElementById("edit-name");
const editSurname = document.getElementById("edit-surname");
const editEmail = document.getElementById("edit-email");
const editPhoneNumber = document.getElementById("edit-phone-number");
const editBirthdate = document.getElementById("edit-birthdate");
const logoutButton = document.getElementById("logout-button");
const deleteAccountButton = document.getElementById("delete-account-button");

let originalUsername;
let originalName;
let originalSurname;
let originalEmail;
let originalPhoneNumber;
let originalBirthdate;

let profileImageEdited = false;

getUserData();

editProfileForm.onsubmit = function (e) {
    e.preventDefault();
    let args = retrieveData(new FormData(editProfileForm));
    submitForm(args.username, args.password, args.name, args.surname, args.email, args.phone, args.birthdate);
}

imageContainer.onmouseover = addChangeProfleImageIcon;

imageContainer.onmouseout = removeChangeProfileImageIcon;

imageContainer.onclick = function () {
    removeChangeProfileImageIcon();
    let fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.id = "file-input";
    fileInput.accept = "image/*";
    fileInput.onchange = function () {
        let file = fileInput.files[0];
        let reader = new FileReader();
        reader.onload = function () {
            changeProfileImage.src = reader.result;
            profileImageEdited = true;
        }
        reader.readAsDataURL(file);
    }
    fileInput.click();
}

logoutButton.onclick = function () {
    $.post("./post_requests_handler.php", { logout: true }, function () {
        window.location.href = "./login.php";
    });
}

deleteAccountButton.onclick = function () {
    $.post("./post_requests_handler.php", { deleteUser: true }, function () {
        window.location.href = "./login.php";
    });
}

function getUserData() {
    $.post("./post_requests_handler.php", { getUserData: true }, function (user) {
        if (user.profile_image != null) {
            changeProfileImage.src = "data:image/jpeg;base64," + user.profile_image;
        }

        editUsername.value = user.username;
        originalUsername = user.username;
        editName.value = user.name;
        originalName = user.name;
        editSurname.value = user.surname;
        originalSurname = user.surname;
        editEmail.value = user.email;
        originalEmail = user.email;
        editPhoneNumber.value = user.phone;
        originalPhoneNumber = user.phone;
        editBirthdate.value = user.birthdate;
        originalBirthdate = user.birthdate;
    }, "json");
}

function submitForm(username, password, name, surname, email, phone, birthdate) {
    editUsername.classList.remove("invalid-error-input");
    editPassword.classList.remove("invalid-error-input");
    editName.classList.remove("invalid-error-input");
    editSurname.classList.remove("invalid-error-input");
    editEmail.classList.remove("invalid-error-input");
    editPhoneNumber.classList.remove("invalid-error-input");
    editBirthdate.classList.remove("invalid-error-input");

    let args = { editProfile: true };
    if (profileImageEdited) {
        args.profileImage = changeProfileImage.src.substring(changeProfileImage.src.indexOf(",") + 1);
    }
    if (username !== originalUsername) {
        args.username = username;
    }
    if (password !== "") {
        args.password = password;
    }
    if (name !== originalName) {
        args.name = name;
    }
    if (surname !== originalSurname) {
        args.surname = surname;
    }
    if (email !== originalEmail) {
        args.email = email;
    }
    if (phone !== originalPhoneNumber) {
        args.phone = phone;
    }
    if (birthdate !== originalBirthdate) {
        args.birthdate = birthdate;
    }

    $.post("./post_requests_handler.php", args, function (result) {
        if (result.usernameValid === false) {
            editUsername.classList.add("invalid-error-input");
        }

        if (result.passwordValid === false) {
            editPassword.classList.add("invalid-error-input");
        }

        if (result.nameValid === false) {
            editName.classList.add("invalid-error-input");
        }

        if (result.surnameValid === false) {
            editSurname.classList.add("invalid-error-input");
        }

        if (result.emailValid === false) {
            editEmail.classList.add("invalid-error-input");
        }

        if (result.phoneValid === false) {
            editPhoneNumber.classList.add("invalid-error-input");
        }

        if (result.usernameValid && result.passwordValid && result.nameValid && result.surnameValid && result.emailValid && result.phoneValid) {
            location.href = "./profile.php";
        } else {
            showSnackbar("Invalid input");
        }
    }, "json");
}

function addChangeProfleImageIcon() {
    changeProfileImage.style.opacity = "0.5";
    let changeProfileImageIcon = document.createElement("span");
    changeProfileImageIcon.className = "fa-regular fa-pencil change-profile-image-icon";
    changeProfileImageIcon.id = "change-profile-image-icon";
    imageContainer.appendChild(changeProfileImageIcon);
}

function removeChangeProfileImageIcon() {
    changeProfileImage.style.opacity = "1";
    let changeProfileImageIcon = document.getElementById("change-profile-image-icon");
    if (changeProfileImageIcon != null) {
        changeProfileImageIcon.remove();
    }
}
