(function ($) {
	$('#books-tab').on('submit', function (e) {
        e.preventDefault();
        var body = $('#body').val();
        $.ajax({
            type: "POST",
            url: host + '/articles/create',
            data: {title: title, body: body, published_at: published_at},
            success: function( msg ) {
                $("#ajaxResponse").append("<div>"+msg+"</div>");
            }
        });
    });
})(jQuery)