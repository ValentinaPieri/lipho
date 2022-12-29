function submitForm(username, password1, password2, name, surname, email, phone, birthdate) {
    $.post("/lipho/post_requests_handler.php", { signup: true, username: username, password1: password1, password2: password2, name: name, surname: surname, email: email, phone: phone, birthdate: birthdate }, function (result) {
        if (result.usernameValid === false) {
            document.getElementById("username").style.borderColor = "red";
        }
        if (password1 !== password2) {
            document.getElementById("password2").style.borderColor = "red";
        }
    }, "json");
    console.log(username);
}