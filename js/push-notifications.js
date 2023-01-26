let loading = false;

getNotSeenNotificationsNumber();

setInterval(getNotSeenNotificationsNumber, 1000);

function getNotSeenNotificationsNumber() {
    if (!loading) {
        loading = true;
        $.post("./post_requests_handler.php", { getNotSeenNotificationsNumber: true }, function (notSeenNotificationsNumber) {
            var notificationsBadgeSpan = document.getElementById("notifications-badge");
            if (notSeenNotificationsNumber > 0) {
                notificationsBadgeSpan.innerText = notSeenNotificationsNumber;
            } else {
                notificationsBadgeSpan.innerText = "";
            }
            loading = false;
        }, "json");
    }
}
