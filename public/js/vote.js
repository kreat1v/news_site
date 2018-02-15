$(document).ready(function() {
    $('.like').click(function() {
        setVote('like', this);
    });

    $('.dislike').click(function() {
        setVote('dislike', this);
    });
});

function setVote(type, obj) {
    var id_comments = $(obj).attr('data-comments');
    var url = $(obj).attr('data-url');

    $.ajax({
        type: "POST",
        url: url,
        data: {
            'type': type,
            'id_comments': id_comments
        },
        dataType: "json",
        success: function(data) {
            if (data.result == 'success') {
                var count = parseInt($(obj).siblings('.rating').text());
                $(obj).hide(100);
                if (type == 'like') {
                    $(obj).siblings('.dislike').hide(100);
                    $(obj).siblings('.rating').before("<span class=\"star\"><i class=\"far fa-star fa-2x\"></i></span>");
                    $(obj).siblings('.rating').text(count+1);
                } else {
                    $(obj).siblings('.like').hide(100);
                    $(obj).siblings('.rating').before("<span class=\"star\"><i class=\"far fa-star fa-2x\"></i></span>");
                    $(obj).siblings('.rating').text(count-1);
                }
            } else {
                $(obj).parent().parent().before("<div class=\"alert alert-warning col-xl-4 col-lg-4 col-md-6 col-12\">" + data.result + ": " + data.msg + "</div>");
            }
        },
        error: function () {
            $(obj).parent().parent().before("<div class=\"alert alert-warning col-xl-4 col-lg-4 col-md-6 col-12\">" + data.result + ": " + data.msg + "</div>");
        }
    });
}