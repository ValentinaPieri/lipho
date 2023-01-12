import retrieveData from './retrieve_data.js';

let form = document.getElementById("signinForm");
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
        }
        if (password === "") {
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