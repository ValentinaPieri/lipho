import retrieveData from './retrieve_data.js';

let form = document.getElementById("signupForm");
form.addEventListener("submit", function (e) {
    e.preventDefault();
    let args=retrieveData(new FormData(form));
    submitForm(args.username, args.password1, args.password2, args.name, args.surname, args.email, args.phone, args.birthdate);
});

function submitForm(username, password1, password2, name, surname, email, phone, birthdate) {
    const inputs = [...document.getElementsByTagName("input")];
    inputs.forEach(input => {
        input.style.borderColor = "black";
    });
    $.post("/lipho/post_requests_handler.php", { signup: true, username: username, password1: password1, password2: password2, name: name, surname: surname, email: email, phone: phone, birthdate: birthdate }, function (result) {
        if (username === "") {
            showInsertError("username");
        } else if (result.usernameValid === false) {
            showInvalidError("username");
        }
        if (password1 === "") {
            showInsertError("password1");
        } else if (result.passwordValid === false) {
            showInvalidError("password1");
        }
        if (password2 === "") {
            showInsertError("password2");
        } else if (result.passwordsMatching === false) {
            showInvalidError("password2");
        }
        if (name === "") {
            showInsertError("name");
        }
        if (surname === "") {
            showInsertError("surname");
        }
        if (result.phoneValid === false) {
            showInvalidError("phone");
        }
        if (result.emailValid === false) {
            showInvalidError("email");
        }
        //TODO: to complete after doing login.php
        // else{
        //     window.location.href = "/lipho/index.php";
        // }
    }, "json");
}

function showInsertError($value) {
    document.getElementById($value).style.borderColor = "red";
    if($value==="password2"){
        document.getElementById($value).placeholder = "Please insert password again";
    }else if($value==="password1"){
        document.getElementById($value).placeholder = "Please insert password";
    }else{
        document.getElementById($value).placeholder = "Please insert " + $value;
    }
}

function showInvalidError($value) {
    document.getElementById($value).style.borderColor = "red";
    document.getElementById($value).value = "";
    if ($value !== "password2" && $value !== "username") {
        document.getElementById($value).placeholder = "Insert a valid " + $value;
    } else if ($value === "username") {
        document.getElementById($value).placeholder = "Username already exists";
    } else {
        document.getElementById($value).placeholder = "Passwords don't match";
    }
}