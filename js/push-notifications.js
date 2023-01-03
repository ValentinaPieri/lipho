setInterval(function () {
    $.post("/lipho/post_requests_handler.php", { getNotSeenNotificationsNumber: true }, function (notSeenNotificationsNumber) {
        var notificationsBadgeSpan = document.getElementById("notifications-badge");
        if (notSeenNotificationsNumber > 0) {
            notificationsBadgeSpan.innerText = notSeenNotificationsNumber;
        } else {
            notificationsBadgeSpan.innerText = "";
        }
    }, "json");
}, 1000);
