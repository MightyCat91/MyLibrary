(function ($) {
    /*
    *   подгрузка через аякс и отображение книг
     */
	$('#books-tab').on('click', function (e) {
        var tab = $(this);
        ajaxGetData(tab, e);
    });
    /*
     *   подгрузка через аякс и отображение авторов
     */
    $('#authors-tab').on('click', function (e) {
        var tab = $(this);
        ajaxGetData(tab, e);
    });


    /*
    *   Функция получения данных через аякс
     */
    function ajaxGetData(object, e) {
        e.preventDefault();
        var url = object.attr('href');
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
    }
})(jQuery);