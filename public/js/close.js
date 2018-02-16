$('a, button').on('click', function(e) {
    $(window).off('beforeunload');
});

$(window).on('beforeunload', function (e)
{
    return 'Close?';
});