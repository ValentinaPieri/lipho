function submitForm(username, password1, password2, name, surname, email, phone, birthdate) {
    $.post("/lipho/post_requests_handler.php", { signup: true, username: username, password1: password1, password2: password2, name: name, surname: surname, email: email, phone: phone, birthdate: birthdate }, function (result) {
        if(username==="" || password1==="" || password2==="" || name==="" || surname==="" ){
        //TODO: to complete
            insert
        }
        if (result.usernameValid === false) {
            notValid("username");
        }
        if (result.passwordsMatching === false) {
            notValid("password2");
        }
        if (result.phoneValid === false) {
            notValid("phone");
        } 
        if (result.emailValid === false) {
            notValid("email");
        }
        //TODO: to complete after doing login.php
        // else{
        //     window.location.href = "/lipho/index.php";
        // }
    }, "json");
}

function insert($value){
    document.getElementById($value).style.borderColor = "red";
    document.getElementById($value).placeholder = "Please insert "+$value;
}

function notValid($value){
    document.getElementById($value).style.borderColor = "red";
    document.getElementById($value).value = "";
    if($value!=="password2" && $value!=="username"){
        document.getElementById($value).placeholder = "Insert a valid "+$value;
    }else if($value==="username"){
        document.getElementById($value).placeholder = "Username already exists";
    }else{
        document.getElementById($value).placeholder = "Passwords don't match";
    }
}
