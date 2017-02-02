(function ($) {
	$('#books-tab').on('click', function (e) {
        e.preventDefault();
        var category_id = $("#category").data('id');
        console.log(category_id);
        $.ajax({
            type: "GET",
            url: category_id,
            data: '',
            //headers: {
            //    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //},
            success: function(data) {
                $('.main-container').replaceWith(data);
            }
        });
    });
    $('#authors-tab').on('click', function (e) {
        e.preventDefault();
        var category_id = $("#category").data('id');
        $.ajax({
            type: "GET",
            url: category_id,
            data: '',
            //headers: {
            //    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //},
            success: function(data) {
                $('.main-container').replaceWith(data);
            }
        });
    });
})(jQuery);