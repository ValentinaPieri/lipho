function deleteNotification(notificationId) {
    $.post("/lipho/post_requests_handler.php", { notificationId: notificationId })
        .done(function (result) {
            if (result != "") {
                alert(result);
            }
            let div_id = "notification" + notificationId;
            document.getElementById(div_id).remove();
            location.reload();
        });
}