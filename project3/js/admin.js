//in admin.php page, control the totalNumber field, when add book
$(document).ready(function () {
    $('#leftNumber').bind('input propertychange', function (event) {
        $('#totalNumber')[0].value = parseInt($('#leftNumber')[0].value);
    });
});