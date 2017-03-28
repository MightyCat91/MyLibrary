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
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });
        $.ajax({
            type: "GET",
            url: url,
            beforeSend: function() {
                $('.page-content').addClass('spinner');
            },
            success: function(data) {
                $('#main-container').html(data);
                $('.page-content').removeClass('spinner');
                history.pushState(null, null, url);
                $('.tab-item.active').removeClass('active');
                object.parent().addClass('active').blur();

            },
            error: function() {

            }
        });
    }
})(jQuery);