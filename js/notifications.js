showNotifications();

setInterval(function () {
    showNotifications();
}, 1000);

function showNotifications() {
    $.post("./post_requests_handler.php", { getNotifications: true }, function (notifications) {
        let mainTag = document.getElementsByTagName("main")[0];
        mainTag.innerHTML = "";
        if (notifications.length == 0) {
            let noNotificationsFoundDiv = document.createElement("div");
            noNotificationsFoundDiv.className = "no-notifications-found";
            let noNotificationsFoundHeader = document.createElement("h2");
            noNotificationsFoundHeader.textContent = "No notifications";
            let noNotificationsFoundIcon = document.createElement("span");
            noNotificationsFoundIcon.className = "fa-regular fa-face-frown-slight";
            noNotificationsFoundDiv.appendChild(noNotificationsFoundHeader);
            noNotificationsFoundDiv.appendChild(noNotificationsFoundIcon);
            mainTag.appendChild(noNotificationsFoundDiv);
        } else {
            let deleteAllNotificationsButton = document.createElement("button");
            deleteAllNotificationsButton.type = "button";
            deleteAllNotificationsButton.addEventListener("click", deleteAllNotifications);
            let trashIcon = document.createElement("span");
            trashIcon.className = "fa-regular fa-trash-can-list";
            deleteAllNotificationsButton.appendChild(trashIcon);
        }


        let todayShown = false;
        let yesterdayShown = false;
        let earlierShown = false;
        let notificationsDiv;
        for (let current = 0; current < notifications.length; current++) {
            const notification = notifications[current];
            const profileImage = notification.profile_image;

            if (!todayShown && isToday(new Date(notification.timestamp))) {
                notificationsDiv = document.createElement("div");
                notificationsDiv.className = "today-notifications";
                notificationsDiv.id = "today-notifications";
                let todayNotificationsHeader = document.createElement("h2");
                todayNotificationsHeader.textContent = "Today";
                todayShown = true;
            } else if (!yesterdayShown && isYesterday(new Date(notification.timestamp))) {
                notificationsDiv = document.createElement("div");
                notificationsDiv.className = "yesterday-notifications";
                notificationsDiv.id = "yesterday-notifications";
                let yesterdayNotificationsHeader = document.createElement("h2");
                yesterdayNotificationsHeader.textContent = "Yesterday";
                yesterdayShown = true;
            } else if (!earlierShown && isEarlier(new Date(notification.timestamp))) {
                notificationsDiv = document.createElement("div");
                notificationsDiv.className = "earlier-notifications";
                notificationsDiv.id = "earlier-notifications";
                let earlierNotificationsHeader = document.createElement("h2");
                earlierNotificationsHeader.textContent = "Earlier";
                earlierShown = true;
            }

            notificationsDiv.appendChild(getNotificationContainer(notification, profileImage));
            mainTag.appendChild(notificationsDiv);
        }
    }, "json");
}

function getNotificationContainer(notification, profileImage) {
    let notificationDiv = document.createElement("div");
    notificationDiv.className = "notification";
    notificationDiv.id = "notification-" + notification.id;

    let notificationProfileImage = document.createElement("img");
    notificationProfileImage.src = "data:image/jpeg;base64," + profileImage;

    let notificationProfileLink = document.createElement("a");
    notificationProfileLink.href = "profile.php?user=" + notification.sender;
    notificationProfileLink.textContent = notification.sender;

    let notificationText = document.createElement("p");
    notificationText.textContent = notification.text;

    let notificationDeleteButton = document.createElement("button");
    notificationDeleteButton.type = "button";
    notificationDeleteButton.addEventListener("click", function () {
        deleteNotification(notification.notification_id);
    });

    let notificationDeleteIcon = document.createElement("span");
    notificationDeleteIcon.className = "fa-regular fa-trash-can";
    notificationDeleteButton.appendChild(notificationDeleteIcon);

    notificationDiv.appendChild(notificationProfileImage);
    notificationDiv.appendChild(notificationProfileLink);
    notificationDiv.appendChild(notificationText);
    notificationDiv.appendChild(notificationDeleteButton);

    return notificationDiv;
}

function isToday(date) {
    const today = new Date();
    return (
        date.getFullYear() === today.getFullYear() &&
        date.getMonth() === today.getMonth() &&
        date.getDate() === today.getDate()
    );
}

function isYesterday(date) {
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    return (
        date.getFullYear() === yesterday.getFullYear() &&
        date.getMonth() === yesterday.getMonth() &&
        date.getDate() === yesterday.getDate()
    );
}

function isEarlier(date) {
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    return (date < yesterday);
}

function deleteNotification(notificationId) {
    $.post("./post_requests_handler.php", { deleteNotification: true, notificationId: notificationId })
        .done(function (result) {
            location.reload();
        });
}

function deleteAllNotifications() {
    $.post("./post_requests_handler.php", { deleteAllNotifications: true })
        .done(function (result) {
            location.reload();
        });
}
