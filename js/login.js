import retrieveData from './retrieve_data.js';
import { showSnackbar } from './utils.js';

//on click on the eye icon, the password will be visible
let visibleButton = document.getElementById("visible");
visibleButton.onclick = function () {
    let span = visibleButton.querySelector("span");
    let passwordInput = document.getElementById("password");
    if (span.className === "fa-solid fa-eye") {
        passwordInput.type = "text";
        span.className = "fa-solid fa-eye-slash";
    } else {
        passwordInput.type = "password";
        span.className = "fa-solid fa-eye";
    }
};

let form = document.getElementById("loginForm");
form.onsubmit = function (e) {
    e.preventDefault();
    let args = retrieveData(new FormData(form));
    searchForm(args.username, args.password);
};

function searchForm(username, password) {
    const inputs = [...document.getElementsByTagName("input")];
    inputs.forEach(input => {
        input.classList.remove("invalid-error-input");
    });
    $.post("./post_requests_handler.php", { login: true, username: username, password: password }, function (result) {
        if (username === "") {
            showInsertError("username");
            showSnackbar("Please insert a username");
        } else if (result.usernameValid === false) {
            showInvalidError("username");
            showSnackbar("Username does not exists");
        } else if (password === "") {
            showInsertError("password");
            showSnackbar("Please insert a password");
        } else if (result.passwordValid === false) {
            showInvalidError("password");
            showSnackbar("Wrong password");
        } else {
            window.location.href = "index.php";
        }
    }, "json");
}

function showInsertError($value) {
    document.getElementById($value).classList.add("invalid-error-input");
    document.getElementById($value).placeholder = "Please insert " + $value;
}

function showInvalidError($value) {
    document.getElementById($value).classList.add("invalid-error-input");
    document.getElementById($value).value = "";
    if ($value === "username") {
        document.getElementById($value).placeholder = "Username does not exists";
    } else {
        document.getElementById($value).placeholder = "Wrong password";
    }
}
