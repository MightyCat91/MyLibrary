(function ($) {
    /*
    *   подгрузка через аякс и отображение книг
     */
	$('#books-tab').on('click', function (e) {
        var tab = $(this);
        ajaxGetData(tab, e);
        $('#alphabet-sticky-block').attr('class', 'book');
    });
    /*
     *   подгрузка через аякс и отображение авторов
     */
    $('#authors-tab').on('click', function (e) {
        var tab = $(this);
        ajaxGetData(tab, e);
        $('#alphabet-sticky-block').attr('class', 'author');
    });


    /*
    *   Функция получения данных через аякс
     */
    function ajaxGetData(object, e) {
        e.preventDefault();
        var url = object.attr('data-href');
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                $('.main-container').html(data);
                history.pushState(null, null, url);
                $('.tab-item.active').removeClass('active');
                object.addClass('active').blur();
                $('.letter-filter').removeClass('active');
            },
            error: function() {
            }
        });
    }
})(jQuery);