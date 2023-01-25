getNotSeenNotificationsNumber();

setInterval(getNotSeenNotificationsNumber, 2000);

function getNotSeenNotificationsNumber() {
    $.post("./post_requests_handler.php", { getNotSeenNotificationsNumber: true }, function (notSeenNotificationsNumber) {
        var notificationsBadgeSpan = document.getElementById("notifications-badge");
        if (notSeenNotificationsNumber > 0) {
            notificationsBadgeSpan.innerText = notSeenNotificationsNumber;
        } else {
            notificationsBadgeSpan.innerText = "";
        }
    }, "json");
}
