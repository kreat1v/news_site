function confirmDelete() {
    return confirm('Are you sure?');
}

// Модальное окно подписки
$(document).ready(function(){
    if ($.cookie('subscription') != 'no') {
        setTimeout(function () {
            $('#exampleModal').modal('show');
            $.cookie('subscription', 'no', {expires: 1, path: '/'});
        }, 5000)
    }
});