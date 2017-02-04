(function ($) {
	$('#books-tab').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            beforeSend: function() {
                $('.page-content').addClass('spinner');
            },
            success: function(data) {
                $('.main-container').html(data);
                $('.page-content').removeClass('spinner');
                history.pushState(null, null, url);
                $('#books-tab').addClass('active').blur();
                $('#authors-tab').removeClass('active');
            }
        });
    });
    $('#authors-tab').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            beforeSend: function() {
                $('.page-content').addClass('spinner');
            },
            success: function(data) {
                $('.main-container').html(data);
                $('.page-content').removeClass('spinner');
                history.pushState(null, null, url);
                $('#authors-tab').addClass('active').blur();
                $('#books-tab').removeClass('active');
            },
            error: function() {

            }
        });
    });
})(jQuery);