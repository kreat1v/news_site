$(document).ready(function() {
    if ($.cookie('subscription') != 'no') {
        setTimeout(function () {
            $('#exampleModal').modal('show');
            $.cookie('subscription', 'no', {expires: 1, path: '/'});
        }, 15000)
    }
});