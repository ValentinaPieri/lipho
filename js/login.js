import retrieveData from './retrieve_data.js';

//on click on the eye icon, the password will be visible
document.getElementById("visible").addEventListener("click", function () {
    let span = document.getElementById("visible");
    let passwordInput = document.getElementById("password");
    if (span.className === "fa-solid fa-eye") {
        passwordInput.type = "text";
        span.className = "fa-solid fa-eye-slash";
    } else {
        passwordInput.type = "password";
        span.className = "fa-solid fa-eye";
    }
});

let form = document.getElementById("loginForm");
form.addEventListener("submit", function (e) {
    e.preventDefault();
    let args = retrieveData(new FormData(form));
    searchForm(args.username, args.password);
});

function searchForm(username, password) {
    const inputs = [...document.getElementsByTagName("input")];
    inputs.forEach(input => {
        input.style.borderColor = "black";
    });
    $.post("./post_requests_handler.php", { login: true, username: username, password: password }, function (result) {
        if (username === "") {
            showInsertError("username");
        } else if (result.usernameValid === false) {
            showInvalidError("username");
        } else if (password === "") {
            showInsertError("password");
        } else if (result.passwordValid === false) {
            showInvalidError("password");
        } else {
            window.location.href = "index.php";
        }
    }, "json");
}

function showInsertError($value) {
    document.getElementById($value).style.borderColor = "red";
    document.getElementById($value).placeholder = "Please insert " + $value;
}

function showInvalidError($value) {
    document.getElementById($value).style.borderColor = "red";
    document.getElementById($value).value = "";
    if ($value === "username") {
        document.getElementById($value).placeholder = "Username does not exists";
    } else {
        document.getElementById($value).placeholder = "Wrong password";
    }
}
