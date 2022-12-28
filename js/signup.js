
function checkUsername(username) {
    $.post("/lipho/post_requests_handler.php", { username: username })
    .done(function (result) {
        if (result != "") {
            alert(result);
        }
    });
}