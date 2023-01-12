import retrieveData from './retrieve_data.js';

//on click on the eye icon, the password will be visible
document.getElementById("visible").addEventListener("click", function () {
    let span = document.getElementById("visible").className;
    if (span === "fa fa-eye") {
        document.getElementById("password").type = "text";
        document.getElementById("visible").className = "fa fa-eye-slash";
    } else {
        document.getElementById("password").type = "password";
        document.getElementById("visible").className = "fa fa-eye";
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
    $.post("/lipho/post_requests_handler.php", { login: true, username: username, password: password }, function (result) {
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