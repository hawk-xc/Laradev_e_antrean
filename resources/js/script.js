$(document).ready(function () {
    var notification = $("#notification");
    var closeButton = $("#close-button");

    setTimeout(function () {
        notification.addClass("opacity-0");
    }, 5000);

    closeButton.on("click", function () {
        notification.addClass("opacity-0");
    });
});
