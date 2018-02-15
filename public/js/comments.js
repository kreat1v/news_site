$(document).ready(function() {
    $('.my-time').each(function () {
        var _this = this;

        var oldTime = $(_this).attr('data-time');
        var difference = time() - oldTime;

        if (difference > 60) {
            $(_this).remove();
        } else {
            setTimeout(function () {
                $(_this).remove();
            }, 60000)
        }
    });
});

function time() {
    return parseInt(new Date().getTime() / 1000);
}
