$( "#search" ).autocomplete({
    source: '/search/searchtags',
    search: function(event, ui) {
        var val = $('#search').val();
        $('#searchButton').attr('href', '/search/tags/' + val + '/1');
    },
    close: function (event, ui) {
        var val = $('#search').val();
        $('#searchButton').attr('href', '/search/tags/' + val + '/1');
    }
});