let oldNotificationsCount = 0;
let userProfileImages = {};
let loadingNotifications = false;

showNotifications();

setInterval(function () {
    showNotifications();
}, 1000);

function showNotifications() {
    if (!loadingNotifications) {
        loadingNotifications = true;
        $.post("./post_requests_handler.php", { getNotifications: true }, function (notifications) {
            showNoNotificationsFound(notifications.length);
            if (notifications.length > oldNotificationsCount) {
                oldNotificationsCount = notifications.length;
                let mainTag = document.querySelector("main");
                mainTag.innerHTML = "";

                let deleteAllNotificationsButton = document.createElement("button");
                deleteAllNotificationsButton.className = "icon-button delete-all-notifications-button";
                deleteAllNotificationsButton.type = "button";
                deleteAllNotificationsButton.onclick = deleteAllNotifications;
                let trashIcon = document.createElement("span");
                trashIcon.className = "fa-regular fa-trash-can-list";
                deleteAllNotificationsButton.appendChild(trashIcon);
                mainTag.appendChild(deleteAllNotificationsButton);


                let todayShown = false;
                let yesterdayShown = false;
                let earlierShown = false;
                let notificationsDiv;
                for (let current = 0; current < notifications.length; current++) {
                    const notification = notifications[current];

                    if (!todayShown && isToday(new Date(notification.timestamp))) {
                        notificationsDiv = document.createElement("div");
                        notificationsDiv.className = "today-notifications";
                        notificationsDiv.id = "today-notifications";
                        let todayNotificationsHeader = document.createElement("h2");
                        todayNotificationsHeader.textContent = "Today";
                        notificationsDiv.appendChild(todayNotificationsHeader);
                        todayShown = true;
                    } else if (!yesterdayShown && isYesterday(new Date(notification.timestamp))) {
                        notificationsDiv = document.createElement("div");
                        notificationsDiv.className = "yesterday-notifications";
                        notificationsDiv.id = "yesterday-notifications";
                        let yesterdayNotificationsHeader = document.createElement("h2");
                        yesterdayNotificationsHeader.textContent = "Yesterday";
                        notificationsDiv.appendChild(yesterdayNotificationsHeader);
                        yesterdayShown = true;
                    } else if (!earlierShown && isEarlier(new Date(notification.timestamp))) {
                        notificationsDiv = document.createElement("div");
                        notificationsDiv.className = "earlier-notifications";
                        notificationsDiv.id = "earlier-notifications";
                        let earlierNotificationsHeader = document.createElement("h2");
                        earlierNotificationsHeader.textContent = "Earlier";
                        notificationsDiv.appendChild(earlierNotificationsHeader);
                        earlierShown = true;
                    }

                    notificationsDiv.appendChild(getNotificationContainer(notification));
                    mainTag.appendChild(notificationsDiv);
                    getUserProfileImage(notification.sender, notification.notification_id);
                }
            }

            loadingNotifications = false;
        }, "json");
    }
}

function getNotificationContainer(notification) {
    let notificationDiv = document.createElement("div");
    notificationDiv.className = "notification";
    notificationDiv.id = "notification-" + notification.notification_id;

    let notificationProfileImage = document.createElement("img");

    let notificationInfoDiv = document.createElement("div");
    notificationInfoDiv.className = "notification-info";

    let notificationProfileLink = document.createElement("a");
    notificationProfileLink.className = "profile-link";
    notificationProfileLink.href = "profile.php?username=" + notification.sender;
    notificationProfileLink.textContent = notification.sender;

    let notificationText = document.createElement("p");
    notificationText.textContent = notification.text;

    let notificationDeleteButton = document.createElement("button");
    notificationDeleteButton.className = "icon-button";
    notificationDeleteButton.type = "button";
    notificationDeleteButton.onclick = function () {
        deleteNotification(notification.notification_id);
    };

    let notificationDeleteIcon = document.createElement("span");
    notificationDeleteIcon.className = "fa-regular fa-trash-can";
    notificationDeleteButton.appendChild(notificationDeleteIcon);

    notificationDiv.appendChild(notificationProfileImage);
    notificationInfoDiv.appendChild(notificationProfileLink);
    notificationInfoDiv.appendChild(notificationText);
    notificationDiv.appendChild(notificationInfoDiv);
    notificationDiv.appendChild(notificationDeleteButton);

    return notificationDiv;
}

function getUserProfileImage(username, notificationId) {
    let notificationProfileImage = document.getElementById("notification-" + notificationId).querySelector("img");
    if (username in userProfileImages) {
        notificationProfileImage.src = "data:image/jpeg;base64," + userProfileImages[username];
    } else {
        $.post("./post_requests_handler.php", { getUserProfileImage: true, username: username }, function (profileImage) {
            notificationProfileImage.src = "data:image/jpeg;base64," + profileImage;
            userProfileImages[username] = profileImage;
        }, "json");
    }
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
    $.post("./post_requests_handler.php", { deleteNotification: true, notificationId: notificationId }, function () {
        let notificationDiv = document.getElementById("notification-" + notificationId);
        notificationDiv.remove();
        oldNotificationsCount--;
        showNoNotificationsFound(oldNotificationsCount);
    });
}

function deleteAllNotifications() {
    $.post("./post_requests_handler.php", { deleteAllNotifications: true }, function () {
        oldNotificationsCount = 0;
        showNoNotificationsFound(oldNotificationsCount);
    });
}

function showNoNotificationsFound(notificationsNumber) {
    if (notificationsNumber === 0) {
        let mainTag = document.querySelector("main");
        mainTag.innerHTML = "";
        let noNotificationsFoundDiv = document.createElement("div");
        noNotificationsFoundDiv.className = "no-matches-found";
        let noNotificationsFoundHeader = document.createElement("h2");
        noNotificationsFoundHeader.textContent = "No notifications";
        let noNotificationsFoundIcon = document.createElement("span");
        noNotificationsFoundIcon.className = "fa-regular fa-face-frown-slight";
        noNotificationsFoundDiv.appendChild(noNotificationsFoundHeader);
        noNotificationsFoundDiv.appendChild(noNotificationsFoundIcon);
        mainTag.appendChild(noNotificationsFoundDiv);
    }
}
