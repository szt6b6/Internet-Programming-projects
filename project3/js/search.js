//when admin user in searched result page, he can update the information of book, this js code is to control the number of books'.
$(document).ready(function () {
    if ($('#totalNumber')[0] == null) return;
    original_totalNumber = $('#totalNumber')[0].value;
    original_leftNumber = $('#leftNumber')[0].value;
    $('#leftNumber').bind('input propertychange', function (event) {
        if ($('#leftNumber')[0].value == "") {

        } else {
            $('#totalNumber')[0].value = parseInt($('#leftNumber')[0].value) - parseInt(original_leftNumber) + parseInt(original_totalNumber);
        }
    });
});