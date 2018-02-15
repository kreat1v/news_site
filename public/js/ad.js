var text;

$('.my-ad').hover(function () {
    $(this).children('.popover').show('drop', 200);

    text = $(this).find('.price').text();
    var price = text.replace(/[A-Za-zА-Яа-яЁё.]/g, "");
    var newPrice = price - (price * 10 / 100);

    $(this).find('.price').text(newPrice + ' грн.');
    $(this).find('.price').animate({'fontSize': '30px', 'color': 'red'}, 300);
}, function () {
    $(this).children('.popover').hide('drop', 500);
    $(this).find('.price').text(text);
    $(this).find('.price').removeAttr('style');
});
