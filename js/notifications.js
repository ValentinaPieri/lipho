function deleteNotification(notificationId) {
    $.post("/lipho/post_requests_handler.php", { notificationId: notificationId })
        .done(function (result) {
            if (result != "") {
                alert(result);
            }
            location.reload();
        });
}

function deleteAllNotifications() {
    $.post("/lipho/post_requests_handler.php", { deleteAllNotifications: true })
        .done(function (result) {
            if (result != "") {
                alert(result);
            }
            location.reload();
        });
}
