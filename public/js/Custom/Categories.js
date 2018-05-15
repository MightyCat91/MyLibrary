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
        $('#list-view-filter-container').children().toggleClass('active');
    });


    /*
    *   Функция получения данных через аякс
     */
    function ajaxGetData(object, e) {
        e.preventDefault();
        var url = object.attr('data-href'),
            mainContainer = $('.main-container');
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                mainContainer.find('#list-view-filter-container').siblings().remove();
                mainContainer.append(data);
                history.pushState(null, null, url);
                $('.tab-item.active').removeClass('active');
                object.addClass('active').blur();
                $('.letter-filter').removeClass('active');
                $('#list-view-filter-container').find('[data-type="grid"]').addClass('active').siblings().removeClass('active');
            },
            error: function() {
            }
        });
    }
})(jQuery);